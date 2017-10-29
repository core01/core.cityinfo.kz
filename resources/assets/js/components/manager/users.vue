<template>
    <div>
        <div class="tabs is-toggle">
            <ul>
                <li :class="{'is-active': type === 'users' }">
                    <a @click.prevent="setType('users')">
                        <span class="icon is-small"><i class="fa fa-users"></i></span>
                        <span>Пользователи</span>
                    </a>
                </li>
                <li :class="{'is-active': type === 'roles' }">
                    <a @click.prevent="setType('roles')">
                        <span class="icon is-small"><i class="fa fa-user-secret"></i></span>
                        <span>Роли</span>
                    </a>
                </li>
                <li :class="{'is-active': type === 'permissions' }">
                    <a @click.prevent="setType('permissions')">
                        <span class="icon is-small"><i class="fa fa-check-square-o"></i></span>
                        <span>Права</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="content">
            <table class="table" v-if="type === 'users'">
                <thead>
                <tr>
                    <td>№</td>
                    <td>Имя</td>
                    <td>Email</td>
                    <td>Роль</td>
                    <td>Последняя активность</td>
                    <td></td>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(user, index) in users">
                    <td>{{index + 1}}</td>
                    <td>{{user.name}}</td>
                    <td>{{user.email}}</td>
                    <td><template v-if="user.roles.length > 0">{{user.roles[0].name}}</template></td>
                    <td>{{ user.attributes.last_seen_at }}</td>
                    <td><a @click.prevent="showUserEditForm(user)">Редактировать</a></td>
                </tr>
                </tbody>
            </table>
            <user-edit v-if="type === 'user-edit'" :user="user" :roles="roles"></user-edit>
            <div v-if="type==='roles'">
                <div class="field has-addons">
                    <div class="control">
                        <input class="input" type="text" placeholder="Имя новой роли..." v-model="newRoleName">
                        <p class="help"
                           v-if="statuses.newRole.message.length > 0"
                           :class="statuses.newRole.className">
                            {{ statuses.newRole.message }}
                        </p>
                    </div>
                    <div class="control">
                        <button class="button is-info" @click.prevent="createRole">
                            Создать роль
                        </button>
                    </div>
                </div>
                <table class="table">
                    <thead>
                    <tr>
                        <td>Роль</td>
                        <td>Права</td>
                        <td></td>
                        <td></td>
                    </tr>
                    </thead>
                    <tr v-for="(role, index) in roles">
                        <td>{{ role.name }}</td>
                        <td><b v-for="permission in role.permissions"> {{ permission.name }}</b></td>
                        <td><a class="button" @click.prevent="editRole(role)">Изменить</a></td>
                        <td>
                            <button class="button is-danger" @click.prevent="deleteRole(index, role)">Удалить</button>
                        </td>
                    </tr>
                </table>
            </div>
            <role-edit v-if="type === 'edit-role'" :role="role" :permissions="permissions"></role-edit>
            <permissions v-if="type === 'permissions'"></permissions>
        </div>
    </div>
</template>

<script>
  import axios from 'axios';
  import roleEdit from './roles/roleEdit.vue';
  import userEdit from './users/userEdit.vue';
  import permissions from './permissions.vue';

  export default {
    data () {
      return {
        type: 'users',
        user: {},
        role: {},
        roles: {},
        newRoleName: '',
        statuses: {
          newRole: {
            message: '',
            className: '',
          }
        }

      };
    },
    props: [
      'users', 'allRoles', 'permissions'
    ],
    methods: {
      setType (type) {
        this.type = type;
      },
      showUserEditForm (user) {
        this.type = 'user-edit';
        this.user = user;
      },
      createRole () {
        let vm = this;
        axios.post(routes.route('manager.role.create'), {
          role_name: this.newRoleName
        })
          .then(function (response) {
            vm.roles.push(response.data);
            vm.statuses.newRole.message = 'Роль добавлена';
            vm.statuses.newRole.className = 'is-success';
          })
          .catch(function (error) {
            if (error.response.data) {
              vm.statuses.newRole.message = error.response.data.errors.role_name[0];
              vm.statuses.newRole.className = 'is-danger';
            }
          });

      },
      deleteRole (index, role) {
        let vm = this;
        axios.post(routes.route('manager.role.delete'), role)
          .then(function (response) {
            vm.roles.splice(index, 1);
          })
          .catch(function (error) {
            if (error.response) {
              vm.statuses.newRole.message = error.response.data.errors.role_name[0];
              vm.statuses.newRole.className = 'is-danger';
            }
          });
      },
      editRole (role) {
        this.type = 'edit-role';
        this.role = role;
      }
    },
    computed: {},
    mounted () {
      this.roles = this.allRoles;
    },
    created () {

    },
    destroyed () {

    },
    components: {
      userEdit, roleEdit, permissions
    }
  };
</script>
