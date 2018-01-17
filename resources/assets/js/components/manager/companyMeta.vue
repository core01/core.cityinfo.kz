<template>
    <div class="columns">
        <div class="column is-10 is-offset-1">
            <form action="">
                <div class="field">
                    <label class="label">ID карточки фирмы:</label>
                </div>
                <div class="field has-addons">
                    <div class="control is-expanded">
                        <input class="input" type="number" placeholder="Например: 1402" v-model.number="company_id"
                               :class="{'is-danger': errorsArray.company_id.length > 0 }">
                        <p class="help is-danger" v-if="errorsArray.company_id.length > 0">{{ errorsArray.company_id }}
                        </p>
                    </div>
                    <div class="control">
                        <button class="button is-info" @click.prevent="findCompany">
                            Найти
                        </button>
                    </div>
                </div>

                <div class="field">
                    <label class="label">Описание</label>
                    <div class="control">
                        <textarea class="textarea" placeholder="Где-то 150-160 символов" v-model="description"
                                  :class="{'is-danger': errorsArray.description.length > 0 }"></textarea>
                    </div>
                    <p class="help is-danger" v-if="errorsArray.description.length > 0">{{ errorsArray.description }}
                    </p>
                </div>
                <div class="field" v-if="images.length > 0">
                    <label class="label">Загруженные изображения:</label>
                    <div class="control">
                        <div class="columns is-multiline">
                            <div class="column is-3" v-for="(image,index) in images">
                                <div class="preview">
                                    <a class="delete" title="Удалить"
                                       @click.prevent="deleteImage(index, true)"></a>
                                    <img :src="image.src"
                                         v-img:uploaded>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="field" v-if="files.length > 0">
                    <label class="label">Новые изображения</label>
                    <div class="control">
                        <div class="columns is-multiline">
                            <div class="column is-3" v-for="(file,index) in files">
                                <div class="preview">
                                    <a class="delete" title="Удалить"
                                       @click.prevent="deleteImage(index)"></a>
                                    <img v-img:new :src="file.blob">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="field is-grouped">
                    <div class="control">
                        <file-upload ref="upload" v-model="files" :post-action="routes.route('image.upload')"
                                     @input-file="inputFile" @input-filter="inputFilter"
                                     :headers="{'X-CSRF-TOKEN': token}" accept="image/*" :multiple="true"
                                     :extensions="['jpg', 'gif', 'png', 'webp']"
                                     :drop="true" :class="'button is-primary'" :disabled="saveDisabled">
                            Выбрать изображения
                        </file-upload>
                    </div>
                    <div class="control" v-if="!$refs.upload || !$refs.upload.active">
                        <button @click.prevent="$refs.upload.active = true"
                                type="button" class="button is-link" :disabled="saveDisabled">
                            Начать загрузку
                        </button>

                    </div>
                    <div class="control" v-if="$refs.upload && $refs.upload.active">
                        <button @click.prevent="$refs.upload.active = false"
                                type="button" class="button is-warning">
                            Stop upload
                        </button>
                    </div>

                </div>
                <div class="field is-grouped">
                    <div class="control">
                        <button class="button is-info" :disabled="saveDisabled" @click.prevent="save">Сохранить</button>
                    </div>
                    <div class="control">
                        <button class="button" type="reset" @click="clean">Очистить</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
import routes from '../../routes'
import VueUploadComponent from 'vue-upload-component'

export default {
  data() {
    return {
      company_id: '',
      description: '',
      saveDisabled: true,
      errorsArray: {
        company_id: '',
        description: ''
      },
      routes: routes,
      images: [],
      files: [],
      token: document.querySelector('[name=csrf-token]').content
    }
  },
  components: {
    'file-upload': VueUploadComponent
  },
  props: [],
  methods: {
    /**
     * Has changed
     * @param  Object|undefined   newFile   Read only
     * @param  Object|undefined   oldFile   Read only
     * @return undefined
     */
    inputFile(newFile, oldFile) {
      let vm = this
      if (newFile && oldFile && !newFile.active && oldFile.active) {
        if (newFile.xhr.status === 200) {
          //  Get the response status code
          let id = oldFile.id
          for (let file in vm.files) {
            if (vm.files.hasOwnProperty(file)) {
              if (vm.files[file].id === id) {
                vm.images.push({ src: newFile.response })
                vm.files.splice(file, 1)
              }
            }
          }

          //console.log('status', newFile.xhr);
        }
      }
    },
    /**
     * Pretreatment
     * @param  Object|undefined   newFile   Read and write
     * @param  Object|undefined   oldFile   Read only
     * @param  Function           prevent   Prevent changing
     * @return undefined
     */
    inputFilter: function(newFile, oldFile, prevent) {
      if (newFile && !oldFile) {
        // Filter non-image file
        if (!/\.(jpeg|jpe|jpg|gif|png|webp)$/i.test(newFile.name)) {
          return prevent()
        }
      }

      // Create a blob field
      newFile.blob = ''
      let URL = window.URL || window.webkitURL
      if (URL && URL.createObjectURL) {
        newFile.blob = URL.createObjectURL(newFile.file)
      }
    },

    save() {
      let vm = this
      axios
        .post(routes.route('manager.save.company.meta'), {
          company_id: this.company_id,
          description: this.description,
          images: this.images
        })
        .then(function(response) {
          if (response.data.success) {
            vm.$notify.success('Данные успешно сохранены')
          } else {
            vm.$notify.success(
              'Ошибка при сохранении, обратитесь к администратору'
            )
            console.log(response.data)
          }
          vm.company_id = ''
          vm.description = ''
          vm.saveDisabled = true
          vm.images = []
        })
        .catch(function(error) {
          let errors = error.response.data.errors
          if (errors) {
            for (let prop in errors) {
              vm.errorsArray[prop] = errors[prop][0]
            }
          }
        })
    },
    clean() {
      this.company_id = ''
      this.description = ''
      this.images = []
      this.saveDisabled = true
    },
    findCompany() {
      let vm = this
      vm.description = ''
      axios
        .get(routes.route('manager.get.company.meta'), {
          params: {
            company_id: this.company_id
          }
        })
        .then(function(response) {
          if (response.data.success) {
            vm.saveDisabled = false

            if (response.data.data) {
              vm.$notify.info('Данные о компании загружены!')
              vm.description = response.data.data.description
              if (response.data.data.images !== null) {
                vm.images = JSON.parse(response.data.data.images)
              }
            } else {
              vm.$notify.info('Данных о компании нет, создайте их!')
              vm.images = []
              vm.files = []
            }
          }
        })
        .catch(function(error) {
          console.log(error)
        })
    },
    deleteImage(index, uploaded = false) {
      if (uploaded === false) {
        this.files.splice(index, 1)
      } else {
        let vm = this
        axios
          .delete(this.routes.route('image.delete'), {
            params: vm.images[index]
          })
          .then(function(response) {
            vm.images.splice(index, 1)
            vm.$notify.success('Изображение удалено!')
          })
          .catch(function(error) {
            console.log(error.response)
            vm.$notify.danger('Ошибка при удалении изображения')
          })
      }
    }
  },
  computed: {},
  mounted() {},
  created() {},
  destroyed() {}
}
</script>

<style lang="sass" scoped>
    .preview
        border-radius: 3px
        display: flex
        border: 1px solid #c7e0ff
        flex-direction: column
        position: relative
        height: 150px
        justify-content: center
        align-items: center
        img
            display: flex
            align-items: center
            justify-content: center
            max-height: 125px
            height: auto
            width: auto
            max-width: 125px

        .preview > .delete
            position: absolute
            right: 0.5em
            top: 0.5em
</style>
