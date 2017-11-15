/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import Vue from 'vue';
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import AuthLogout from './components/auth/logout.vue';
import users from './components/manager/users.vue';
import companyMeta from './components/manager/companyMeta.vue';

import { config } from './validate.config.js';
import VeeValidate, { Validator } from 'vee-validate';
import ru from 'vee-validate/dist/locale/ru';
import notify from 'vue2-notify';
import VueImg from 'v-img'

const vueImgConfig = {
  // Use `alt` attribute as gallery slide title
  altAsTitle: false,
  // Display 'download' button near 'close' that opens source image in new tab
  sourceButton: false,
  // Event listener to open gallery will be applied to <img> element
  openOn: 'click',
}
Vue.use(VueImg, vueImgConfig)

Vue.use(notify, {
  itemClass: 'notification',
  position: 'bottom-right',
  visibility: 5000,
  enter: 'fadeIn',
  leave: 'fadeOut',
  duration: 500,
  width: 'auto',
  permanent: false,
  mode: 'text',
  closeButton: 'bulma'
});
const types = {
  info: {
    itemClass: 'is-info'
  },
  error: {
    itemClass: 'is-danger'
  },
  warning: {
    itemClass: 'is-warning'
  },
  success: {
    itemClass: 'is-success'
  }

};

Vue.$notify.setTypes(types);
//Vue.$notify.setTypes(types);

Validator.localize('ru', ru);

Vue.use(VeeValidate, config);

const app = new Vue({
  el: '#app',
  data () {
    return {};
  },
  components: {
    AuthLogout,
    users,
    companyMeta,
  }
});
