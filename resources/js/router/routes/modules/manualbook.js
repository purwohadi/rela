import { LoadComponent } from '@js/helpers/commons'

const files = require.context('@components/modules/manualbook', true, /\.vue$/i)
const components = new LoadComponent(files)

export function manualbook(app, i18n) {
  return [
    {
      path: 'manualbook',
      name: 'manualbook',
      component: components.get('manual-book'),
      meta: {
        label: i18n.t('manualbook.meta.label'),
        icon: 'fal fa-book',
        access: app.user.can('manage-manualbook')
      },
    },
    {
      path: 'manualbook/list',
      name: 'manualbook.list',
      component: components.get('manual-book-list'),
      meta: {
        label: i18n.t('manualbook.meta.label'),
        icon: 'fal fa-book',
        access: true
      },
    },
  ]
}
