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
                        <silentbox-group>
                            <div class="columns is-multiline">
                                <div class="column is-6" v-for="(image,index) in images">
                                    <article class="message is-success">
                                        <div class="message-header">
                                            <p></p>
                                            <button class="delete" @click.prevent="deleteUploadedImage(index)"></button>
                                        </div>
                                        <div class="message-body">
                                            <silentbox-item :src="image.src">
                                                <img :src="image.src"
                                                     style="width: 100%; max-height: 200px; background-repeat: no-repeat;background-position: center center;">
                                            </silentbox-item>
                                        </div>
                                    </article>
                                </div>
                            </div>
                        </silentbox-group>
                    </div>
                </div>
                <div class="field" v-if="files.length > 0">
                    <label class="label">Новые изображения</label>
                    <div class="control">
                        <silentbox-group>
                            <div class="columns is-multiline">
                                <div class="column is-6" v-for="(file,index) in files">
                                    <article class="message is-info">
                                        <div class="message-header">
                                            {{ file.name }}
                                            <button class="delete" @click.prevent="deleteImage(index)"></button>
                                        </div>
                                        <div class="message-body">
                                            <silentbox-item :src="file.blob" :description="file.name">
                                                <img :src="file.blob"
                                                     style="width: 100%; max-height: 200px; background-repeat: no-repeat;background-position: center center;">

                                            </silentbox-item>
                                        </div>
                                    </article>
                                </div>
                            </div>
                        </silentbox-group>
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
  import axios from 'axios';
  import routes from '../../routes';
  import VueUploadComponent from 'vue-upload-component';
  import SilentboxGroup from '../../../../../node_modules/vue-silentbox/components/group.vue';

  export default {
    data () {
      return {
        company_id: '',
        description: '',
        saveDisabled: true,
        errorsArray: {
          company_id: '',
          description: '',
        },
        routes: routes,
        images: [],
        files: [],
        token: document.querySelector('[name=csrf-token]').content
      };
    },
    components: {
      SilentboxGroup,
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
      inputFile (newFile, oldFile) {
        let vm = this;
        if (newFile && oldFile && !newFile.active && oldFile.active) {
          if (newFile.xhr.status === 200) {
            //  Get the response status code
            let id = oldFile.id;
            for (let file in vm.files) {
              if (vm.files.hasOwnProperty(file)) {
                if (vm.files[file].id === id) {
                  vm.images.push({'src': newFile.response});
                  vm.files.splice(file, 1);
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
      inputFilter: function (newFile, oldFile, prevent) {
        if (newFile && !oldFile) {
          // Filter non-image file
          if (!/\.(jpeg|jpe|jpg|gif|png|webp)$/i.test(newFile.name)) {
            return prevent();
          }
        }

        // Create a blob field
        newFile.blob = '';
        let URL = window.URL || window.webkitURL;
        if (URL && URL.createObjectURL) {
          newFile.blob = URL.createObjectURL(newFile.file);
        }
      },

      save () {
        let vm = this;
        axios.post(routes.route('manager.save.company.meta'), {
          company_id: this.company_id,
          description: this.description,
          images: this.images,
        }).then(function (response) {
          if (response.data.success) {
            vm.$notify.success('Данные успешно сохранены');
          } else {
            vm.$notify.success('Ошибка при сохранении, обратитесь к администратору');
            console.log(response.data);
          }
          vm.company_id = '';
          vm.description = '';
          vm.saveDisabled = true;
          vm.images = [];
        })
          .catch(function (error) {
            let errors = error.response.data.errors;
            if (errors) {
              for (let prop in errors) {
                vm.errorsArray[prop] = errors[prop][0];
              }
            }
          });
      },
      clean () {
        this.company_id = '';
        this.description = '';
        this.images = [];
        this.saveDisabled = true;
      },
      findCompany () {
        let vm = this;
        vm.description = '';
        axios.get(routes.route('manager.get.company.meta'), {
          params: {
            company_id: this.company_id
          }
        }).then(function (response) {
          if (response.data.success) {
            vm.saveDisabled = false;

            if (response.data.data) {
              vm.$notify.info('Данные о компании загружены!');
              vm.description = response.data.data.description;
              if (response.data.data.images !== null) {
                vm.images = JSON.parse(response.data.data.images);
              }
            } else {
              vm.$notify.info('Данных о компании нет, создайте их!');
            }
          }
        })
          .catch(function (error) {
            console.log(error);
          });
      },
      deleteImage (index) {
        this.files.splice(index, 1);
      },
      deleteUploadedImage (index) {
        let vm = this;
        axios.delete(this.routes.route('image.delete'), {
          params: vm.images[index]

        }).then(function (response) {
          vm.images.splice(index, 1);
          vm.$notify.success('Изображение удалено!');
        })
          .catch(function (error) {
            console.log(error.response);
          });
      }
    },
    computed: {},
    mounted () {

    },
    created () {

    },
    destroyed () {

    }
  };
</script>
