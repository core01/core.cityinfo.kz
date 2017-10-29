<template>
    <form id="form">
        <p class="notification" v-if="message.message.length > 0" :class="message.className">{{ message.message }}</p>
        <div class="field">
            <label class="label">Имя пользователя</label>
            <div class="control">
                <input type="text" v-model="user.name" class="input"
                       :class="{'is-danger': errors['user.name'].length > 0 }">
            </div>
            <p class="help is-danger" v-if="errors['user.name'].length > 0">{{ errors['user.name'] }}</p>
        </div>

        <div class="field">
            <label class="label">Email</label>
            <div class="control">
                <input type="text" v-model="user.email" class="input"
                       :class="{'is-danger': errors['user.email'].length > 0 }">
            </div>
            <p class="help is-danger" v-if="errors['user.email'].length > 0">{{ errors['user.email'] }}</p>
        </div>
        <div class="field">
            <label class="label">Последняя активность</label>
            <div class="control">
                <input type="text" v-model="user.attributes.last_seen_at" class="input" disabled>
            </div>
        </div>
        <div class="field">
            <label class="label">Главная роль</label>
            <div class="control">
                <div class="select" :class="{'is-danger': errors['role.id'].length > 0 }">
                    <select @change="setRole">
                        <option v-for="role in roles" :value="role.id"
                                :selected="role.id == selectedRole.id">{{ role.name }}
                        </option>
                    </select>
                </div>
            </div>
        </div>
        <div class="field">
            <div class="control">
                <button type="button" class="button is-link" @click.prevent="saveUser">Сохранить</button>
            </div>
        </div>
    </form>
</template>

<script>
  import axios from 'axios';

  export default {
    data () {
      return {
        message: {
          message: '',
          className: 'is-danger',
        },
        selectedRole: {
          id: '',
          name: '',
        },
        errors: {
          'user.name': '',
          'user.email': '',
          'role.name': '',
          'role.id': '',
        },
      };
    },
    props: ['user', 'roles'],
    methods: {
      saveUser () {
        let vm = this;
        axios.post(routes.route('manager.user.save'), {
          user: this.user,
          role: this.selectedRole,
        }).then(function (response) {
          vm.message.message = 'Данные успешно сохранены';
          vm.message.className = 'is-success';
          vm.user.roles[0].name = vm.selectedRole.name;
        })
          .catch(function (error) {
            let errors = error.response.data.errors;
            if (errors) {
              for (let error in errors) {
                if (vm.errors.hasOwnProperty(error)) {
                  vm.errors[error] = errors[error][0];
                }
              }
            }
            vm.message.message = 'Ошибка';
            vm.message.className = 'is-danger';
          });
      },
      setRole (e) {
        let newRole;
        for (let role in this.roles) {
          if (this.roles.hasOwnProperty(role)) {
            if (this.roles[role].id === +e.target.value) {
              newRole = this.roles[role];
            }
          }
        }
        if (newRole) {
          this.selectedRole.name = newRole.name;
          this.selectedRole.id = newRole.id;
        }
      }
    },
    computed: {},
    mounted () {
      this.selectedRole.id = this.user.roles[0].id;
      this.selectedRole.name = this.user.roles[0].name;
    },
    created () {

    },
    destroyed () {

    }
  };
</script>
