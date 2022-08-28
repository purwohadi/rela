import { RouteGenerator, LoadComponent } from '@js/helpers/commons'

const files = require.context('@components/modules/settings', true, /\.vue$/i)
const route = new RouteGenerator('settings')
const components = new LoadComponent(files)

export function setting(app, i18n) {
	return [
		{
			path: route.path('group'),
			name: route.name('group'),
			component: components.get('group'),
			meta: {
				label: i18n.t('group.meta.label'),
				icon: 'fal fa-user-secret',
				access: app.user.can('group')
			}
		},
		{
			path: route.path('group-form'),
			name: 'group-form',
			component: components.get('group-form'),
			meta: {
				label: 'Tambah Group',
				icon: 'fal fa-qrcode',
				access: app.user.can('group')
			},
		},
		{
			path: 'group/:id/edit',
			name: 'group-edit',
			component: components.get('group-form'),
			props: true,
			meta: {
				label: 'Edit Group',
				icon: 'fal fa-qrcode',
				access: app.user.can('group')
			},
		},
		{
			path: route.path('user'),
			name: route.name('user'),
			component: components.get('user'),
			meta: {
				label: i18n.t('user.meta.label'),
				icon: 'fal fa-user',
				access: app.user.can('user')
			}
		},
		{
			path: route.path('user-add'),
			name: 'user-add',
			component: components.get('user-form'),
			meta: {
				label: 'Tambah Data Pengguna',
				icon: 'fal fa-user',
				access: app.user.can('user')
			},
		},
		{
			path: 'user/:id/edit',
			name: 'user-edit',
			component: components.get('user-form'),
			props: true,
			meta: {
				label: 'Edit Data Pengguna',
				icon: 'fal fa-user',
				access: app.user.can('user')
			},
		},
		{
			path: 'user/:id/detail',
			name: 'user-detail',
			component: components.get('user-form-detail'),
			props: true,
			meta: {
				label: 'Detil Data Pengguna',
				icon: 'fal fa-user',
				access: app.user.can('user')
			},
		},
		{
			path: 'group/:id/hak-akses',
			name: 'group-hak-akses',
			component: components.get('group-form'),
			props: true,
			meta: {
				label: 'Edit Hak Akses',
				icon: 'fal fa-qrcode',
				access: app.user.can('Manage Roles')
			},
		},
		{
			path: route.path('feature-access'),
			name: route.name('feature-access'),
			component: components.get('feature-access'),
			meta: {
				label: i18n.t('featureaccess.meta.label'),
				icon: 'fal fa-shield-check',
				access: app.user.can('Manage Feature Access')
			}
		},
		{
			path: route.path('feature-access-add'),
			name: 'feature-access-add',
			component: components.get('feature-access-form'),
			meta: {
				label: 'Tambah Data Akses Fitur',
				icon: 'fal fa-shield-check',
				access: app.user.can('Manage Feature Access')
			},
		},
		{
			path: 'feature-access/:id/edit',
			name: 'feature-access-edit',
			component: components.get('feature-access-form'),
			props: true,
			meta: {
				label: 'Edit Data Akses Fitur',
				icon: 'fal fa-shield-check',
				access: app.user.can('Manage Feature Access')
			},
		},
		{
			path: route.path('roles'),
			name: route.name('roles'),
			component: components.get('roles'),
			meta: {
				label: i18n.t('roles.meta.label'),
				icon: 'fal fa-user-secret',
				access: app.user.can('Manage Roles')
			}
		},
		{
			path: route.path('permissions'),
			name: route.name('permissions'),
			component: components.get('permissions'),
			meta: {
				label: i18n.t('permissions.meta.label'),
				icon: 'fal fa-lock-alt',
				access: app.user.can('Manage Permissions')
			}
		},
		{
			path: route.path('reference'),
			name: route.name('reference'),
			component: components.get('reference'),
			meta: {
				label: i18n.t('reference.meta.label'),
				icon: 'fal fa-book',
				access: app.user.can('Manage References')
			}
		},
		{
			path: route.path('menu'),
			name: route.name('menu'),
			component: components.get('menu'),
			meta: {
				label: i18n.t('menu.meta.label'),
				icon: 'fal fa-list-alt',
				access: app.user.can('Manage Permissions')
			}
		}
	]
}
