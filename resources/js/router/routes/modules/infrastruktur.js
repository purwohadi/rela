import { RouteGenerator, LoadComponent } from "@js/helpers/commons"

const files= require.context('@components/modules/infrastruktur', true, /\.vue$/i)
const route = new RouteGenerator('infrastruktur')
const components = new LoadComponent(files)

const filesJaringanIntraPemerintah= require.context('@components/modules/infrastruktur/_jaringanIntraPemerintah', true, /\.vue$/i)
const componentsJaringanIntraPemerintah = new LoadComponent(filesJaringanIntraPemerintah)

const filesPeriferal = require.context('@components/modules/infrastruktur/_periferal', true, /\.vue$/i)
const componentsPeriferal = new LoadComponent(filesPeriferal)

const filesMediaPenyimpanan = require.context('@components/modules/infrastruktur/_mediaPenyimpanan', true, /\.vue$/i)
const componentsMediaPenyimpanan = new LoadComponent(filesMediaPenyimpanan)

const filesPerangkatJaringan = require.context('@components/modules/infrastruktur/_perangkatJaringan', true, /\.vue$/i)
const componentsPerangkatJaringan = new LoadComponent(filesPerangkatJaringan)

const filesFasilitasKomputasi = require.context('@components/modules/infrastruktur/_fasilitasKomputasi', true, /\.vue$/i)
const componentsFasilitasKomputasi = new LoadComponent(filesFasilitasKomputasi)

export function infrastruktur(app, i18n){
	return [
		/**Jaringan intra pemerintah */
		{
			path: route.path('jaringan-intra-pemerintah'),
			name: route.name('jaringan-intra-pemerintah'),
			component: components.get('jaringan-intra-pemerintah'),
			meta: {
				label: i18n.t('infrastruktur.meta.label_perangkat_jip'),
				icon: 'fal fa-address-card',
				access:app.user.can('jaringan-intra-pemerintah')
			}
		},
		{
			path: route.path('tambah-jaringan-intra-pemerintah'),
			name: route.name('tambah-jaringan-intra-pemerintah'),
			component: componentsJaringanIntraPemerintah.get('jaringan-intra-pemerintah-form'),
			meta: {
				label: i18n.t('infrastruktur.meta.label_jip_tambah'),
				icon: 'fal fa-address-card',
				access: app.user.can('tambah-jaringan-intra-pemerintah')
			}
		},
		{
			path: route.path('ubah-jaringan-intra-pemerintah/:id/:status'),
			name: route.name('ubah-jaringan-intra-pemerintah'),
			component: componentsJaringanIntraPemerintah.get('jaringan-intra-pemerintah-form'),
			meta: {
				label: i18n.t('infrastruktur.meta.label_jip_ubah'),
				icon: 'fal fa-address-card',
				access: app.user.can('edit-jaringan-intra-pemerintah')
			}
		},
		{
			path: route.path('detil-jaringan-intra-pemerintahan/:id/:status'),
			name: route.name('detil-jaringan-intra-pemerintah'),
			component: componentsJaringanIntraPemerintah.get('jaringan-intra-pemerintah-form'),
			meta: {
				label: i18n.t('infrastruktur.meta.label_jip_detil'),
				icon: 'fal fa-address-card',
				access:app.user.can('lihat-daftar-jaringan-intra-pemerintah')
			}
		},
		{
      path: route.path('sistem-penghubung-layanan-pemerintah/:opd_id?'),
			name: route.name('sistempenghubunglayananpemerintah'),
			props: true,
			component: components.get('sistem-penghubung-layanan-pemerintah'),
			meta: {
				label: i18n.t('infrastruktur.meta.label_splp'),
				icon: 'fal fa-book',
				access: true
			},
		},
		{
      path: route.path('sistem-penghubung-layanan-pemerintah-add/:opd_id'),
			name: 'sistem-penghubung-layanan-pemerintah-add',
			component: components.get('sistem-penghubung-layanan-pemerintah-form'),
			meta: {
				label: i18n.t('infrastruktur.meta.label_splp_tambah'),
				icon: 'fal fa-address-card',
				access: true
			}
		},
		{
			path: route.path('sistem-penghubung-layanan-pemerintah-detil/:id/:opd_id/:status'),
			name: 'sistem-penghubung-layanan-pemerintah-detil',
			props: true,
			component: components.get('sistem-penghubung-layanan-pemerintah-detil'),
			meta: {
				label: 'Detil Sistem Penghubung Layanan Pemerintah',
				icon: 'fal fa-book',
				access: true
			},
		},
		{
      path: route.path('sistem-penghubung-layanan-pemerintah-update/:id/:opd_id/:status'),
			name: 'sistem-penghubung-layanan-pemerintah-update',
			props: true,
			component: components.get('sistem-penghubung-layanan-pemerintah-form'),
			meta: {
				label: i18n.t('infrastruktur.meta.label_splp_update'),
				icon: 'fal fa-book',
				access: true
			},
		},
		/**Periferal */
		{
			path: route.path('periferal/:opd_id?'),
			name: route.name('periferal'),
			component: components.get('periferal'),
			meta: {
				label: i18n.t('infrastruktur.meta.label_perangkat_periferal'),
				icon: 'fal fa-address-card',
				access:true
			}
		},
		{
			path: route.path('tambah-periferal/:opd_id'),
			name: route.name('tambah-periferal'),
			component: componentsPeriferal.get('periferal-form'),
			meta: {
				label: i18n.t('infrastruktur.meta.label_periferal_tambah'),
				icon: 'fal fa-address-card',
				access:true
			}
		},
		{
			path: route.path('ubah-periferal/:id/:status'),
			name: route.name('ubah-periferal'),
			component: componentsPeriferal.get('periferal-form'),
			meta: {
				label: i18n.t('infrastruktur.meta.label_periferal_ubah'),
				icon: 'fal fa-address-card',
				access:true
			}
		},
		{
			path: route.path('detil-periferal/:id/:status'),
			name: route.name('detil-periferal'),
			component: componentsPeriferal.get('periferal-form'),
			meta: {
				label: i18n.t('infrastruktur.meta.label_periferal_detil'),
				icon: 'fal fa-address-card',
				access:true
			}
		},
		/**Media Penyimpanan */
		{
			path: route.path('media-penyimpanan/:opd_id?'),
			name: route.name('media-penyimpanan'),
			component: components.get('media-penyimpanan'),
			meta: {
				label: i18n.t('infrastruktur.meta.label_perangkat_media_penyimpanan'),
				icon: 'fal fa-address-card',
				access:true
			}
		},
		{
      path: route.path('tambah-media-penyimpanan/:opd_id'),
			name: route.name('tambah-media-penyimpanan'),
			component: componentsMediaPenyimpanan.get('media-penyimpanan-form'),
			meta: {
				label: i18n.t('infrastruktur.meta.label_media_penyimpanan_tambah'),
				icon: 'fal fa-address-card',
				access:true
			}
		},
		{
			path: route.path('ubah-media-penyimpanan/:id/:opd_id/:status'),
			name: route.name('ubah-media-penyimpanan'),
			component: componentsMediaPenyimpanan.get('media-penyimpanan-form'),
			meta: {
				label: i18n.t('infrastruktur.meta.label_media_penyimpanan_ubah'),
				icon: 'fal fa-address-card',
				access:true
			}
		},
		{
      path: route.path('detil-media-penyimpanan/:id/:opd_id/:status'),
			name: route.name('detil-media-penyimpanan'),
			component: componentsMediaPenyimpanan.get('media-penyimpanan-form'),
			meta: {
				label: i18n.t('infrastruktur.meta.label_media_penyimpanan_detil'),
				icon: 'fal fa-address-card',
				access:true
			}
		},
		/**Perangkat Jaringan*/
		{
			path: route.path('perangkat-jaringan'),
			name: route.name('perangkat-jaringan'),
			component: components.get('perangkat-jaringan'),
			meta: {
				label: i18n.t('infrastruktur.meta.label_perangkat_perangkat_jaringan'),
				icon: 'fal fa-address-card',
				access:true
			}
		},
		{
      path: route.path('tambah-perangkat-jaringan'),
			name: route.name('tambah-perangkat-jaringan'),
			component: componentsPerangkatJaringan.get('perangkat-jaringan-form'),
			meta: {
				label: i18n.t('infrastruktur.meta.label_perangkat_jaringan_tambah'),
				icon: 'fal fa-address-card',
				access:true
			}
		},
		{
			path: route.path('ubah-perangkat-jaringan/:id/:status'),
			name: route.name('ubah-perangkat-jaringan'),
			component: componentsPerangkatJaringan.get('perangkat-jaringan-form'),
			meta: {
				label: i18n.t('infrastruktur.meta.label_perangkat_jaringan_ubah'),
				icon: 'fal fa-address-card',
				access:true
			}
		},
		{
			path: route.path('detil-perangkat-jaringan/:id/:status'),
			name: route.name('detil-perangkat-jaringan'),
			component: componentsPerangkatJaringan.get('perangkat-jaringan-form'),
			meta: {
				label: i18n.t('infrastruktur.meta.label_perangkat_jaringan_detil'),
				icon: 'fal fa-address-card',
				access:true
			}
		},
		/**Fasilitas Komputasi*/
		{
			path: route.path('fasilitas-komputasi/:opd_id?'),
			name: route.name('fasilitas-komputasi'),
			component: components.get('fasilitas-komputasi'),
			meta: {
				label: i18n.t('infrastruktur.meta.label_fasilitas_komputasi'),
				icon: 'fal fa-address-card',
				access:true
			}
		},
		{
			path: route.path('tambah-fasilitas-komputasi/:opd_id?'),
			name: route.name('tambah-fasilitas-komputasi'),
			component: componentsFasilitasKomputasi.get('fasilitas-komputasi-form'),
			meta: {
				label: i18n.t('infrastruktur.meta.label_fasilitas_komputasi_tambah'),
				icon: 'fal fa-address-card',
				access:true
			}
		},
		{
			path: route.path('ubah-fasilitas-komputasi/:id/:status'),
			name: route.name('ubah-fasilitas-komputasi'),
			component: componentsFasilitasKomputasi.get('fasilitas-komputasi-form'),
			meta: {
				label: i18n.t('infrastruktur.meta.label_fasilitas_komputasi_ubah'),
				icon: 'fal fa-address-card',
				access:true
			}
		},
		{
			path: route.path('detil-fasilitas-komputasi/:id/:status'),
			name: route.name('detil-fasilitas-komputasi'),
			component: componentsFasilitasKomputasi.get('fasilitas-komputasi-form'),
			meta: {
				label: i18n.t('infrastruktur.meta.label_fasilitas_komputasi_detil'),
				icon: 'fal fa-address-card',
				access:true
			}
		},

		//perangkat keamanan
		{
			path: route.path('perangkat-keamanan'),
			name: route.name('perangkat-keamanan'),
			component: components.get('perangkat-keamanan'),
			meta: {
				label: i18n.t('infrastruktur.meta.label_perangkat_keamanan'),
				//label: 'Perangkat Keamanan',
				icon: 'fal fa-address-card',
				access:true
			}
		},
		{
			path: route.path('tambah-perangkat-keamanan/:opd_id/:status'),
			name: route.name('tambah-perangkat-keamanan'),
			component: components.get('perangkat-keamanan-form'),
			meta: {
				label: i18n.t('infrastruktur.meta.label_perangkat_keamanan_tambah'),
				icon: 'fal fa-address-card',
				access:true
			}
		},
		{
			path: route.path('ubah-perangkat-keamanan/:opd_id/:id/:status'),
			name: route.name('ubah-perangkat-keamanan'),
			component: components.get('perangkat-keamanan-form'),
			meta: {
				label: i18n.t('infrastruktur.meta.label_perangkat_keamanan_ubah'),
				icon: 'fal fa-address-card',
				access:true
			}
		},
		{
			path: route.path('detil-perangkat-keamanan/:opd_id/:id/:status'),
			name: route.name('detil-perangkat-keamanan'),
			component: components.get('perangkat-keamanan-form'),
			meta: {
				label: i18n.t('infrastruktur.meta.label_perangkat_keamanan_detil'),
				icon: 'fal fa-address-card',
				access:true
			}
		},
	]
}
