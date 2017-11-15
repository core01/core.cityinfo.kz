<template>
    <div>
        <p class="has-text-centered">
            Добавить новое
        </p>
        <form data-vv-scope="new">
            <div class="columns">
                <div class="column">
                    <div class="field">
                        <p class="control is-expanded">
                            <input class="input" type="text" placeholder="Название" name="name"
                                   v-model="permission"
                                   v-validate:permission="'required|max:190'"
                                   :class="{'is-danger': errors.has('new.name') }">
                            <span v-show="errors.has('new.name')" class="help is-danger">
                                {{ errors.first('new.name') }}
                            </span>
                        </p>
                    </div>
                </div>
                <div class="column">
                    <div class="field">
                        <p class="control is-expanded">
                            <input class="input" type="text" placeholder="guard" name="guard"
                                   v-model="guard"
                                   v-validate:guard="'required|max:31'"
                                   :class="{'is-danger': errors.has('new.guard') }">
                            <span v-show="errors.has('new.guard')" class="help is-danger">
                                {{ errors.first('new.guard') }}
                            </span>
                        </p>
                    </div>
                </div>
                <div class="column">

                    <div class="field">
                        <p class="control has-text-centered">
                        <span class="icon is-medium save" @click.prevent="add" title="Добавить">
                    <i class="fa fa-lg fa-floppy-o" aria-hidden="true"></i>
                </span>
                            <span class="icon is-medium clear" @click.prevent="clear" title="Очистить">
                 <i class="fa fa-lg fa-eraser" aria-hidden="true"></i>

                </span>
                        </p>
                    </div>

                </div>
            </div>
        </form>
        <hr>
        <div class="columns">
            <div class="column">
                <div class="field">
                    <p class="control is-expanded has-text-centered">
                        <label class="label">Permission</label>
                    </p>
                </div>
            </div>
            <div class="column">
                <div class="field">
                    <p class="control is-expanded has-text-centered">
                        <label class="label">Guard</label>
                    </p>
                </div>
            </div>
            <div class="column">
                <div class="field">

                </div>
            </div>
        </div>
        <form v-for="(permission,index) in permissions" :data-vv-scope="'permission' + index">
            <div class="columns">
                <div class="column">
                    <div class="field">
                        <p class="control">
                            <input class="input" type="text" :name="'name'"
                                   v-validate="'required|max:190'"
                                   v-model="permission.name"
                                   :class="{'is-danger': errors.has('permission' + index+'.name') }">
                            <span v-show="errors.has('permission' + index+'.name')" class="help is-danger">
                                {{ errors.first('permission' + index + '.name') }}
                            </span>
                        </p>
                    </div>
                </div>
                <div class="column">
                    <div class="field">
                        <p class="control">
                            <input class="input" type="text" :name="'guard_name'"
                                   v-model="permission.guard_name"
                                   v-validate="'required|max:30'"
                                   :class="{'is-danger': errors.has('permission' + index+'.guard_name') }">
                            <span v-show="errors.has('permission' + index+'.guard_name')"
                                  class="help is-danger">
                                {{ errors.first('permission' + index + '.guard_name') }}
                            </span>
                        </p>
                    </div>
                </div>
                <div class="column">
                    <div class="field">
                        <p class="control has-text-centered">
                        <span class="icon is-medium save" @click.prevent="save(permission, 'permission' + index)"
                              title="Сохранить">
                    <i class="fa fa-lg fa-floppy-o" aria-hidden="true"></i>
                </span>
                            <span class="icon is-medium del" @click.prevent="deletePermission(permission)"
                                  title="Удалить">
                 <i class="fa fa-lg fa-trash-o" aria-hidden="true"></i>

                </span>
                        </p>
                    </div>
                </div>
            </div>
        </form>
    </div>

</template>

<script>
  import axios from 'axios';
  import routes from '../../routes';

  export default {
    data () {
      return {
        permissions: {},
        permission: '',
        guard: '',
        messages: {
          permission: {
            message: '',
            className: '',
          },
          guard: {
            message: '',
            className: '',
          }
        }
      };
    },
    props: [],
    methods: {
      add () {
        let vm = this;
        this.$validator.validateAll('new').then((result) => {
          if (result) {
            axios.put(routes.route('add.permission'), {
              guard_name: vm.guard,
              name: vm.permission,
            })
              .then(function (response) {
                vm.permissions.push(response.data);
                vm.$notify.success('Успешно добавлено!');
              })
              .catch(function (error) {
                vm.$notify.danger(error.response.data.message);
              });
          } else {
            vm.$notify.danger('Ошибка при заполнении формы')
          }
        });
      },
      save (permission, scope) {
        let vm = this;
        this.$validator.validateAll(scope).then((result) => {
          if (result) {
            axios.post(routes.route('save.permission', {id: permission.id}), {
              name: permission.name,
              guard_name: permission.guard_name,
            }).then(function (response) {
              vm.$notify.success('Данные успешно сохранены!');
            })
              .catch(function (error) {
                vm.$notify.danger(error.response.data.message);
              });
          } else {
            vm.$notify.danger('Ошибка при заполнении формы');
          }
        });
      },
      clear () {
        this.permission = '';
        this.guard = '';
      },
      deletePermission (permission, index) {
        let vm = this;
        axios.delete(routes.route('delete.permission', {id: permission.id}))
          .then(function (response) {
            vm.permissions = response.data.permissions;
            vm.$notify.success('Удалено успешно!');
          })
          .catch(function (error) {
            vm.$notify.danger(error.response.data.message);
          });
      }
    },
    computed: {},
    mounted () {
      let vm = this;
      axios.get(routes.route('get.all.permissions'))
        .then(function (response) {
          vm.permissions = response.data.permissions;
        })
        .catch(function (error) {
          this.$notify.danger('Ошибка при запросе на сервер');
          console.log(error);
        });
    },
    created () {

    },
    destroyed () {

    },
    components: {},
  };
</script>
<style scoped>
    .icon.save {
        color: #23d160
    }

    .icon.clear {
        color: #ffdd57
    }

    .icon.del {
        color: #ff3860
    }

    .icon.save:hover,
    .icon.del:hover,
    .icon.clear:hover {
        color: blue;
    }


</style>
