<template>
    <div class="columns">
        <div class="column is-6 is-offset-3">
            <form action="">
                <div class="notification" v-if="message.show" :class="message.className">{{ message.message }}</div>
                <div class="field">
                    <label class="label">ID карточки фирмы:</label>
                </div>
                <div class="field has-addons">
                    <div class="control is-expanded">
                        <input class="input" type="number" placeholder="Например: 1402" v-model.number="company_id"
                               :class="{'is-danger': errors.company_id.length > 0 }">
                        <p class="help is-danger" v-if="errors.company_id.length > 0">{{ errors.company_id }}</p>
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
                        <textarea class="textarea" placeholder="Где-то 150-160 символов"
                                  v-model="description"
                                  :class="{'is-danger': errors.description.length > 0 }"></textarea>
                    </div>
                    <p class="help is-danger" v-if="errors.description.length > 0">{{ errors.description }}</p>
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

  export default {
    data () {
      return {
        company_id: '',
        description: '',
        saveDisabled: true,
        message: {
          show: false,
          message: '',
          className: '',
        },
        errors: {
          company_id: '',
          description: '',
        }
      };
    },
    props: [],
    methods: {
      save () {
        let vm = this;
        axios.post(routes.route('manager.save.company.meta'), {
          company_id: this.company_id,
          description: this.description,
        }).then(function (response) {
          if (response.data.success) {
            vm.message.message = 'Данные успешно сохранены';
            vm.message.show = true;
            vm.message.className = 'is-success';
          } else {
            vm.message.message = 'Ошибка при сохранении, обратитесь к администратору';
            vm.message.show = true;
            vm.message.className = 'is-danger';
            console.log(response.data);
          }
          vm.saveDisabled = true;
        })
          .catch(function (error) {
            let errors = error.response.data.errors;
            if (errors) {
              for (let prop in errors) {
                vm.errors[prop] = errors[prop][0];
              }
            }
          });
      },
      clean () {
        this.company_id = '';
        this.description = '';
      },
      findCompany () {
        let vm = this;
        axios.get(routes.route('manager.get.company.meta'), {
          params: {
            company_id: this.company_id
          }
        }).then(function (response) {
          if (response.data.success) {
            vm.saveDisabled = false;
            if (response.data.data) {
              vm.description = response.data.data.description;
            }
          }
        })
          .catch(function (error) {
            console.log(error);
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
