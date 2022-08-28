import Vue from 'vue'
import Router from 'vue-router'

import { moduleRoutes } from './routes'

Vue.use(Router)

export const createRouter = (app, i18n) => {
  const mainRoutes = moduleRoutes(app, i18n)
  const router = new Router({
    mode: 'history',
    base: '',
    scrollBehavior: () => ({ y: 0, x: 0 }),
    routes: mainRoutes
  })

  router.beforeEach((to, from, next) => {
    document.title = to.meta.label
      ? `${to.meta.label} | ${Vue.prototype.$app.appname}`
      : Vue.prototype.$app.appname

    const destination = [to].find(route => route.path == to.path)
    const hasAccess = destination.meta.access
    if (!hasAccess) {
      next({ name: 'forbidden' })
    } else {
      next()
    }
    // next()
  })
  return router
}



