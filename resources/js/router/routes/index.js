import Container from '@components/bootstraps/Container'
import Home from '@components/modules/beranda/Home'
import Profile from '@components/modules/Profile'
import Forbidden from '@components/modules/Forbidden'
import UbahPassword from '@components/modules/UbahPassword'

export function moduleRoutes(app, i18n) {
  let routes = []
  let files = require.context('./modules', true, /\.js$/i)
  files.keys().forEach(key => {
    let funcName = key.split('/').pop().slice(0, -3)
    let module = files(key)

    // load all valid function
    if (module[funcName]) {
      module[funcName](app, i18n).forEach(route => {
        routes.unshift(route)
      })
    }
  })

  const mainRoutes = [
    {
      path: '/',
      redirect: '/',
      component: Container,
      children: [
        {
          path: '/',
          name: 'home',
          component: Home,
          meta: {
            label: i18n.t('general.page.title.home'),
            icon: 'fal fa-home',
            access: app.user.can('home')
          }
        },
        {
          path: '/profile',
          name: 'profile',
          component: Profile,
          meta: {
            label: i18n.t('profil.route.title'),
            icon: 'fal fa-address-card',
            access: true
          }
        },
        {
          path: '/#',
          name: 'forbidden',
          component: Forbidden,
          meta: {
            label: i18n.t('general.page.title.forbidden'),
            icon: 'fal fa-lock-alt',
            access: true
          }
        },
        {
          path: '/ubah-password',
          name: 'ubah-password',
          component: UbahPassword,
          meta: {
            label: i18n.t('profil.route.ubahPassword'),
            icon: 'fal fa-address-card',
            access: true
          }
        },
        // load all module route
        ...routes
      ],
    },
  ]
  return mainRoutes
}
