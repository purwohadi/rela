import '@js/bootstrap'
import Vue from 'vue'
import App from '@js/MainApp'
import store from '@js/store'
import BootstrapVue from 'bootstrap-vue'
import BaseComponents from '@components/bootstraps/base'
import { TreeViewPlugin } from "@syncfusion/ej2-vue-navigations"
import ZkTable from 'vue-table-with-tree-grid'
import VueScreen from 'vue-screen';
import VueMask from 'v-mask'

import { ValidationObserver, ValidationProvider } from 'vee-validate'
import '@js/vendor/vee-validate'
import '@js/vendor/sweet-alert'
import './filter'
import InvalidFeedback from '@js/components/bootstraps/base/InvalidFeedback'
import LoadingSkeleton from '@components/bootstraps/base/LoadingSkeleton.vue'
import numeral from 'numeral'

import Multiselect from 'vue-multiselect'

// temporary use, later fetch from db
// if not use again plese remove wkwkwk
import VirtualMenu from '@js/helpers/menu.json'

import { axios } from '@js/axios-config'
import { createRouter } from '@js/router'
import { createLocales } from '@js/vendor/vue-i18n-config'

numeral.register('locale', 'id', {
  delimiters: {
    thousands: '.',
    decimal: ','
  },
  abbreviations: {
    thousand: ' Ribu',
    million: ' Juta',
    billion: ' Milyar',
    trillion: ' Trilyun'
  },
  ordinal: function(number) {
    return number === 1 ? '' : ''
  },
  currency: {
    symbol: 'Rp. '
  }
})

window._token = document.head.querySelector('meta[name="csrf-token"]').content

Vue.use(InvalidFeedback)
Vue.use(LoadingSkeleton)
Vue.use(BootstrapVue)
Vue.use(BaseComponents)
Vue.use(TreeViewPlugin);
Vue.use(ZkTable)
Vue.use(VueScreen, 'bootstrap');
Vue.use(VueMask);

Vue.component('MSelect', Multiselect)
Vue.component('LoadingSkeleton', LoadingSkeleton)
Vue.component("ValidationProvider", ValidationProvider)
Vue.component("ValidationObserver", ValidationObserver)

export const createApp = () => {
  const i18n = createLocales(window.settings.locale)
  Vue.prototype.$app = window.settings
  Vue.prototype.$http = axios
  Vue.prototype.$app.route = window.route
  Vue.prototype.$app.i18n = i18n

  Vue.prototype.$app.alert = window.swal
  Vue.prototype.$app.toast = window.toast
  Vue.prototype.$app.success = window.successAlert
  Vue.prototype.$app.confirm = window.confirmAlert
  Vue.prototype.$app.error = window.errorAlert
  /**
   * Object to FormData converter
   */
  let objectToFormData = (obj, form, namespace) => {
    let fd = form || new FormData()

    for (let property in obj) {
      if (!obj.hasOwnProperty(property)) {
        continue
      }

      let formKey = namespace ? `${namespace}[${property}]` : property

      if (obj[property] === null) {
        fd.append(formKey, '')
        continue
      }
      if (typeof obj[property] === 'boolean') {
        fd.append(formKey, obj[property] ? '1' : '0')
        continue
      }
      if (obj[property] instanceof Date) {
        fd.append(formKey, obj[property].toISOString())
        continue
      }
      if (
        typeof obj[property] === 'object' &&
        !(obj[property] instanceof File)
      ) {
        objectToFormData(obj[property], fd, formKey)
        continue
      }
      fd.append(formKey, obj[property])
    }

    return fd
  }

  Vue.prototype.$app.objectToFormData = objectToFormData

  Vue.prototype.$moment = moment
  Vue.prototype.$moment.locale(Vue.prototype.$app.locale)

  if (Vue.prototype.$app) {
    Vue.prototype.$app.getCurrentDate = (format = 'dddd, D MMMM YYYY') => {
      return Vue.prototype.$moment(Vue.prototype.$app.current_date).format(format)
    }

    Vue.prototype.$app.getCurrentDateByMonthYear = (format = 'MMMM YYYY') => {
      return Vue.prototype.$moment(Vue.prototype.$app.current_date).format(format)
    }

    Vue.prototype.$app.getSortMonth = (format = 'MM') => {
      return Vue.prototype.$moment(Vue.prototype.$app.current_date).format(format)
    }

    Vue.prototype.$app.getYear = (format = 'YYYY') => {
      return Vue.prototype.$moment(Vue.prototype.$app.current_date).format(format)
    }

    Vue.prototype.$app.getCurrentDateFull = (format = 'YYYY-MM-DD') => {
      return Vue.prototype.$moment(Vue.prototype.$app.current_date).format(format)
    }

    Vue.prototype.$app.getInitialName = name => {
      let convertStr = _.startCase(name)
      return convertStr.split(' ', 2).filter(n => !n.includes('.')).map(n => n.trim().charAt(0)).join('').toUpperCase()
    }
  }

  if (Vue.prototype.$app.user) {
    Vue.prototype.$app.user.menu = VirtualMenu
  }

  Vue.prototype.$app.user.can = permission => {
    if (Vue.prototype.$app.user.is_admin) return true
    return Vue.prototype.$app.permissions.includes(permission)
  }

  const router = createRouter(Vue.prototype.$app, i18n)
  const app = new Vue({
    router,
    store,
    i18n,
    render: h => h(App)
  })

  return { app, store, router }
}

if (document.getElementById('app')) {
  const { app } = createApp()
  app.$mount('#app')
}


