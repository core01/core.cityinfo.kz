<template>
    <form action="">
        <p class="notification" v-if="message.message.length > 0" :class="message.className">{{ message.message }}</p>
        <div class="field">
            <label class="label">Название</label>
            <div class="control">
                <input class="input" type="text" placeholder="Название роли" v-model="role.name">
            </div>
        </div>
        <div class="field">
            <label class="label">Права</label>
            <div class="control" v-for="permission in rolePermissions">
                <label class="checkbox">
                    <input type="checkbox"
                           :checked="permission.roleHasThis === true" v-model="permission.roleHasThis">
                    {{ permission.name }}
                </label>
            </div>
        </div>
        <div class="field">
            <div class="control">
                <button class="button is-link" @click.prevent="save">Сохранить</button>
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
          className: 'is-success',
          message: '',
        },
        rolePermissions: {},
      };
    },
    props: ['role', 'permissions', 'type'],
    methods: {
      save () {
        let vm = this;
        axios.post(routes.route('manager.role.save'), {
          role: this.role,
          permissions: this.rolePermissions,
        })
          .then(function (response) {
            vm.message.message = 'Данные сохранены';
            vm.message.className = 'is-success';
          })
          .catch(function (error) {
            vm.message.message = 'Ошибка при сохранении данных';
            vm.message.className = 'is-danger';
          });
      }
    },
    computed: {},
    mounted () {
      let vm = this;
      axios.get(routes.route('get.role.permissions'), {
        params: {
          name: this.role.name
        }
      })
        .then(function (response) {
          vm.rolePermissions = response.data.permissions;
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    created () {

    },
    destroyed () {

    }
  };
</script>
