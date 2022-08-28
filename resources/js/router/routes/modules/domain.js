import { RouteGenerator, LoadComponent } from "@js/helpers/commons"

const files = require.context('@components/modules/domain', true, /\.vue$/i)
const filesDomainLayanan = require.context('@components/modules/domain/_domainLayanan', true, /\.vue$/i)
const filesDomainInfraServer = require.context('@components/modules/domain/_domainInfraServer', true, /\.vue$/i)
const filesDomainInfraSoftware = require.context('@components/modules/domain/_domainInfraSoftware', true, /\.vue$/i)
const filesDomainAplikasi = require.context('@components/modules/domain/_domainAplikasi', true, /\.vue$/i)

const route = new RouteGenerator('domain')
const components = new LoadComponent(files)
const componentsDomainLayanan = new LoadComponent(filesDomainLayanan)
const componentsDomainInfraServer = new LoadComponent(filesDomainInfraServer)
const componentsDomainInfraSoftware = new LoadComponent(filesDomainInfraSoftware)
const componentsDomainAplikasi = new LoadComponent(filesDomainAplikasi)

export function domain(app, i18n){
	return [
		{
			path: route.path('domain-layanan/:opd_id?'),
			name: route.name('domain-layanan'),
			component: components.get('domain-layanan'),
			meta: {
				label: i18n.t('domain.meta.label_layanan'),
				icon: 'fal fa-address-card',
				access:app.user.can('domain-layanan')
				//access: app.user.can('profile-nrk')
			}
		},
		{
			path: route.path('tambah-domain-layanan/:opd_id'),
			name: route.name('tambah-domain-layanan'),
			component: componentsDomainLayanan.get('tambah-domain-layanan-form'),
			meta: {
				label: i18n.t('domain.meta.label_layanan_tambah'),
				icon: 'fal fa-address-card',
				access:app.user.can('tambah-layanan')
			}
		},
		{
			path: route.path('ubah-domain-layanan/:id/:status'),
			name: route.name('ubah-domain-layanan'),
			component: componentsDomainLayanan.get('domain-layanan-form'),
			meta: {
				label: i18n.t('domain.meta.label_layanan_ubah'),
				icon: 'fal fa-address-card',
				access:app.user.can('edit-layanan')
			}
		},
		{
			path: route.path('detil-domain-layanan/:id/:status'),
			name: route.name('detil-domain-layanan'),
			component: componentsDomainLayanan.get('domain-layanan-form'),
			meta: {
				label: i18n.t('domain.meta.label_layanan_detil'),
				icon: 'fal fa-address-card',
				access:app.user.can('lihat-daftar-layanan')
			}
		},
		{
			path: route.path('proses-bisnis/:opd_id?'),
			name: 'domainprosesbisnis',
			component: components.get('domain-proses-bisnis'),
			meta: {
				label: 'Domain Proses Bisnis',
				icon: 'fal fa-book',
				access: app.user.can('domain-probis')
			},
		},
		{
			path: route.path('proses-bisnis-add/:opd_id'),
			name: 'proses-bisnis-add',
     		component: components.get('domain-proses-bisnis-form'),
			meta: {
				label: 'Tambah Domain Proses Bisnis',
				icon: 'fal fa-book',
				access: app.user.can('tambah-proses-bisnis')
			},
		},
		{
      path: route.path('proses-bisnis-detil/:proses_id/:opd_id/:status'),
		name: 'proses-bisnis-detil',
		props: true,
		component: components.get('domain-proses-bisnis-detil'),
		meta: {
			label: 'Detil Domain Proses Bisnis',
			icon: 'fal fa-book',
			access: app.user.can('lihat-daftar-proses-bisnis')
		},
		},
		{
		path: route.path('proses-bisnis-update/:proses_id/:opd_id/:status'),
		name: 'proses-bisnis-update',
		props: true,
		component: components.get('domain-proses-bisnis-form'),
		meta: {
			label: 'Ubah Domain Proses Bisnis',
			icon: 'fal fa-book',
			access: app.user.can('edit-proses-bisnis')
		},
		},
		{
			path: route.path('infra-server/:opd_id?'),
			name: 'domain-infra-server',
			component: componentsDomainInfraServer.get('infra-server'),
			meta: {
				label: 'Domain Infra Server',
				icon: 'fal fa-book',
				access: true
			},
		},
		{
			path: route.path('infra-server/add/:opd_id?'),
			name: 'infra-server-add',
			component: componentsDomainInfraServer.get('infra-server-form'),
			meta: {
				label: 'Tambah Domain Infra Server',
				icon: 'fal fa-book',
				access: true
			},
		},
		{
			path: route.path('infra-server/edit/:id'),
			name: 'infra-server-edit',
			component: componentsDomainInfraServer.get('infra-server-form'),
			meta: {
				label: 'Edit Domain Infra Server',
				icon: 'fal fa-book',
				access: true
			},
		},
		{
			path: route.path('infra-server/detail/:id'),
			name: 'infra-server-detail',
			component: componentsDomainInfraServer.get('infra-server-form'),
			meta: {
				label: 'Detail Domain Infra Server',
				icon: 'fal fa-book',
				access: true
			},
		},
		{
			path: route.path('infra-software/:opd_id?'),
			name: 'domain-infra-software',
			component: componentsDomainInfraSoftware.get('infra-software'),
			meta: {
				label: 'Domain Infra Software',
				icon: 'fal fa-book',
				access: true
			},
		},
		{
			path: route.path('infra-software/add/:opd_id?'),
			name: 'infra-software-add',
			component: componentsDomainInfraSoftware.get('infra-software-form'),
			meta: {
				label: 'Tambah Domain Infra Software',
				icon: 'fal fa-book',
				access: true
			},
		},
		{
			path: route.path('infra-software/edit/:id'),
			name: 'infra-software-edit',
			component: componentsDomainInfraSoftware.get('infra-software-form'),
			meta: {
				label: 'Edit Domain Infra Software',
				icon: 'fal fa-book',
				access: true
			},
		},
		{
			path: route.path('infra-software/detail/:id'),
			name: 'infra-software-detail',
			component: componentsDomainInfraSoftware.get('infra-software-form'),
			meta: {
				label: 'Detail Domain Infra Software',
				icon: 'fal fa-book',
				access: true
			},
		},
    {
      path: route.path('infrastruktur-cloud/:opd_id?'),
      name: 'domaininfrastrukturcloud',
      props: true,
      component: components.get('domain-infrastruktur-cloud'),
      meta: {
        label: i18n.t('domain.meta.label_infrastruktur_cloud'),
        icon: 'fal fa-book',
        access: true
      },
    },
    {
      path: route.path('infrastruktur-cloud-add/:opd_id?'),
      name: 'infrastruktur-cloud-add',
      component: components.get('domain-infrastruktur-cloud-form'),
      meta: {
        label: i18n.t('domain.meta.label_infrastruktur_cloud_add'),
        icon: 'fal fa-book',
        access: true
      },
    },
    {
      path: route.path('infrastruktur-cloud-detil/:id/:opd_id/:status'),
      name: 'infrastruktur-cloud-detil',
      props: true,
      component: components.get('infrastruktur-cloud-detil'),
      meta: {
        label: 'Detil Infrastruktur Cloud',
        icon: 'fal fa-book',
        access: true
      },
    },
    {
      path: route.path('infrastruktur-cloud-update/:id/:opd_id/:status'),
      name: 'infrastruktur-cloud-update',
      props: true,
      component: components.get('domain-infrastruktur-cloud-form'),
      meta: {
        label: i18n.t('domain.meta.label_infrastruktur_cloud_update'),
        icon: 'fal fa-book',
        access: true
      },
    },
    {
      path: route.path('data-informasi'),
      name: 'domain-data-informasi',
      props: true,
      component: components.get('domain-data-informasi'),
      meta: {
        label: 'Domain Data dan Informasi',
        icon: 'fal fa-book',
        access: app.user.can('domain-data-informasi')
      },
    },
    {
      path: route.path('data-informasi-add/:opd_id'),
      name: 'domain-data-informasi-add',
      props: true,
      component: components.get('domain-data-informasi-form'),
      meta: {
        label: 'Tambah Domain Data dan Informasi',
        icon: 'fal fa-book',
        access: app.user.can('tambah-data-dan-informasi')
      },
    },
    {
      path: route.path('data-informasi-detil/:opd_id/:info_id/:status'),
      name: 'data-informasi-detil',
      props: true,
      component: components.get('domain-data-informasi-detil'),
      meta: {
        label: 'Detil Domain Data Informasi',
        icon: 'fal fa-book',
        access: app.user.can('lihat-daftar-data-dan-informasi')
      },
    },
    {
      path: route.path('data-informasi-update/:opd_id/:info_id/:status'),
      name: 'data-informasi-update',
      props: true,
      component: components.get('domain-data-informasi-form'),
      meta: {
        label: 'Update Domain Data Informasi',
        icon: 'fal fa-book',
        access: app.user.can('edit-data-dan-informasi')
      },
    },
    {
      path: route.path('domain-data-informasi-detail-add/:opd_id/:info_id'),
      name: 'domain-data-informasi-detail-add',
      props: true,
      component: components.get('domain-data-informasi-detail-form'),
      meta: {
        label: 'Tambah Detail Domain Data dan Informasi',
        icon: 'fal fa-book',
        access: app.user.can('lihat-daftar-data-dan-informasi')
      },
    },
    {
      path: route.path('domain-data-informasi-detail-update/:opd_id/:info_id/:id/:status'),
      name: 'domain-data-informasi-detail-update',
      props: true,
      component: components.get('domain-data-informasi-detail-form'),
      meta: {
        label: 'Ubah Detail Domain Data dan Informasi',
        icon: 'fal fa-book',
        access: app.user.can('lihat-daftar-data-dan-informasi')
      },
    },
    {
      path: route.path('domain-data-informasi-detail-detail/:opd_id/:info_id/:id/:status'),
      name: 'domain-data-informasi-detail-detail',
      props: true,
      component: components.get('domain-detail-data-informasi-detail'),
      meta: {
        label: 'Detail Detail Domain Data dan Informasi',
        icon: 'fal fa-book',
        access: app.user.can('lihat-daftar-data-dan-informasi')
      },
    },
		{
			path: route.path('aplikasi'),
			name: 'aplikasi',
			component: componentsDomainAplikasi.get('aplikasi'),
			meta: {
				label: 'Domain Aplikasi',
				icon: 'fal fa-book',
				access: app.user.can('domain-aplikasi')
			},
		},
		{
			path: route.path('aplikasi/:opd_id/add'),
			name: 'aplikasi-add',
			component: componentsDomainAplikasi.get('aplikasi-form'),
			meta: {
				label: 'Tambah Domain Aplikasi',
				icon: 'fal fa-book',
				access: app.user.can('tambah-aplikasi')
			},
		},
		{
			path: route.path('aplikasi/:opd_id/edit/:id'),
			name: 'aplikasi-edit',
			component: componentsDomainAplikasi.get('aplikasi-form'),
			meta: {
				label: 'Edit Domain Aplikasi',
				icon: 'fal fa-book',
				access: app.user.can('edit-aplikasi')
			},
		},
		{
			path: route.path('aplikasi/:opd_id/detail/:id'),
			name: 'aplikasi-detail',
			component: componentsDomainAplikasi.get('aplikasi-form'),
			meta: {
				label: 'Detail Domain Aplikasi',
				icon: 'fal fa-book',
				access: app.user.can('lihat-daftar-aplikasi')
			},
		},
	]
}
