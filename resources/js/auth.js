import '@js/bootstrap'

import Vue from 'vue'
import { axios } from '@js/axios-config'
import BootstrapVue from 'bootstrap-vue'
import BaseComponents from '@components/bootstraps/base'
import InvalidFeedback from '@js/components/bootstraps/base/InvalidFeedback'
import { ValidationObserver, ValidationProvider } from 'vee-validate'
import VueMask from 'v-mask'
import ReadMore from 'vue-read-more';
import VueScreen from 'vue-screen';

import '@js/vendor/vee-validate'
import '@js/vendor/sweet-alert'
import './filter'

Vue.use(InvalidFeedback)
Vue.use(BootstrapVue)
Vue.use(BaseComponents)
Vue.component("ValidationProvider", ValidationProvider)
Vue.component("ValidationObserver", ValidationObserver)
Vue.use(VueMask);
Vue.use(ReadMore);
Vue.use(VueScreen, 'bootstrap');

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('LoginApp', require('./LoginApp.vue').default);
Vue.component('FormReset', require('./frontend/FormResetPassword.vue').default);

Vue.prototype.$app = window.settings
Vue.prototype.$http = axios
Vue.prototype.$app.route = window.route

Vue.prototype.$app.alert = window.swal
Vue.prototype.$app.toast = window.toast
Vue.prototype.$app.success = window.successAlert
Vue.prototype.$app.confirm = window.confirmAlert
Vue.prototype.$app.error = window.errorAlert

const app = new Vue({
  el: '#loginapp',
});
