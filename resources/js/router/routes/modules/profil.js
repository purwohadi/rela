import { RouteGenerator, LoadComponent } from '@js/helpers/commons'

const files = require.context('@components/modules/profil', true, /\.vue$/i)
const route = new RouteGenerator('profil')
const components = new LoadComponent(files)

export function profil(app, i18n) {
  return [
    {
      path: route.path('profil'),
      name: route.name('profil'),
      component: components.get('profil'),
      meta: {
        label: i18n.t('profil.meta.label'),
        icon: 'fal fa-address-card',
        access:true
        //access: app.user.can('profile-nrk')
      }
    },
  ]
}
