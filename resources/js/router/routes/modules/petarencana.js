import { LoadComponent } from '@js/helpers/commons'

const files = require.context('@components/modules/petarencana', true, /\.vue$/i)
const components = new LoadComponent(files)

export function petarencana(app, i18n) {
  return [
    {
      path: 'peta-rencana',
      name: 'petarencana',
      component: components.get('peta-rencana'),
      meta: {
        label: i18n.t('petarencana.meta.label'),
        icon: 'fal fa-map',
        access: true
      },
    }
  ]
}
