import ExampleComponent from '@components/modules/ExampleComponent'

export function example(app, i18n) {
  return [
    {
      path: '/example',
      name: 'example',
      component: ExampleComponent,
      meta: {
        label: 'Pengaturan Peran',
        icon: 'fal fa-user-secret',
        // access: app.user.can('mengatur-peran')
        access: true
      }
    },
  ]
}
