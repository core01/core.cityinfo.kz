<template>
    <div v-on-clickaway="away" class="navbar-item has-dropdown" :class="{'is-active': active}">
        <a class="navbar-link dropdown-trigger" @click="showDropdown">
            {{ name }}
        </a>

        <div class="navbar-dropdown">
            <a class="navbar-item" :href="profileUrl" :class="{'is-active': url === profileUrl }">
                Профиль
            </a>
            <a class="navbar-item" @click="logout">
                Logout
            </a>
        </div>
    </div>
</template>

<script>
import connection from '../../axios/connection'
import { mixin as clickaway } from 'vue-clickaway'

export default {
  mixins: [clickaway],
  data() {
    return {
      active: false,
      url: location.href
    }
  },
  props: ['name', 'logoutUrl', 'profileUrl'],
  methods: {
    showDropdown() {
      this.active = !this.active
    },
    away: function() {
      this.active = false
    },
    logout: function() {
      let token = document.querySelector('[name=csrf-token]')
      connection()
        .post(this.logoutUrl, {
          _token: token.content
        })
        .then(function(response) {
          location.href = response.data.redirect
        })
        .catch(function(error) {
          console.log(error)
        })
    },
    isActive: url => {
      return url === this.url
    }
  },
  computed: {},
  mounted() {},
  created() {},
  destroyed() {}
}
</script>
