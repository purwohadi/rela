import { RouteGenerator, LoadComponent } from "@js/helpers/commons"

const files= require.context('@components/modules/keamanan', true, /\.vue$/i)
const route = new RouteGenerator('keamanan')
const components = new LoadComponent(files)

const filesStandarTeknisKeamanan 		= require.context('@components/modules/keamanan/_standarTeknisKeamanan', true, /\.vue$/i) 
const componentsStandarTeknisKeamanan 	= new LoadComponent(filesStandarTeknisKeamanan)

/*
const filesEdukasiKeamanan 				= require.context('@components/modules/keamanan/_edukasiKeamanan', true, /\.vue$/i) 
const componentsEdukasiKeamanan 		= new LoadComponent(filesEdukasiKeamanan)


const filesAuditKeamananSpbe 			= require.context('@components/modules/keamanan/_auditKeamananSpbe', true, /\.vue$/i) 
const componentsAuditKeamananSpbe 		= new LoadComponent(filesAuditKeamananSpbe)


const filesPeningkatanKeamanan 			= require.context('@components/modules/keamanan/_peningkatanKeamanan', true, /\.vue$/i) 
const componentsPeningkatanKeamanan 	= new LoadComponent(filesPeningkatanKeamanan)

*/

export function keamanan(app, i18n){
	return [
		/**Standar Teknis Keamanan*/
		{
			path: route.path('standar-teknis-keamanan'),
			name: route.name('standar-teknis-keamanan'),
			component: components.get('standar-teknis-keamanan'),
			meta: {
				label: i18n.t('keamanan.meta.label_teknis_keamanan'),
				icon: 'fal fa-address-card',
				access:true
			}
		},
		{
			path: route.path('tambah-standar-teknis-keamanan'),
			name: route.name('tambah-standar-teknis-keamanan'),
			component: componentsStandarTeknisKeamanan.get('standar-teknis-keamanan-form'),
			meta: {
				label: i18n.t('keamanan.meta.label_teknis_keamanan_tambah'),
				icon: 'fal fa-address-card',
				access:true
			}
		},
		{
			path: route.path('ubah-standar-teknis-keamanan/:id/:status'),
			name: route.name('ubah-standar-teknis-keamanan'),
			component: componentsStandarTeknisKeamanan.get('standar-teknis-keamanan-form'),
			meta: {
				label: i18n.t('keamanan.meta.label_teknis_keamanan_ubah'),
				icon: 'fal fa-address-card',
				access:true
			}
		},		
		{
			path: route.path('detil-standar-teknis-keamanan/:id/:status'),
			name: route.name('detil-standar-teknis-keamanan'),
			component: componentsStandarTeknisKeamanan.get('standar-teknis-keamanan-form'),
			meta: {
				label: i18n.t('keamanan.meta.label_teknis_keamanan_detil'),
				icon: 'fal fa-address-card',
				access:true
			}
		},

		/* Edukasi Keamanan */
		{
			path: route.path('edukasi-keamanan'),
			name: route.name('edukasi-keamanan'),
			component: components.get('edukasi-keamanan'),
			meta: {
				label: i18n.t('keamanan.meta.label_edukasi_keamanan'),
				icon: 'fal fa-address-card',
				access:true
			}
		},
		{
			path: route.path('tambah-edukasi-keamanan'),
			name: route.name('tambah-edukasi-keamanan'),
			component: components.get('edukasi-keamanan-form'),
			meta: {
				label: i18n.t('keamanan.meta.label_edukasi_tambah'),
				icon: 'fal fa-address-card',
				access:true
			}
		},
		{
			path: route.path('ubah-edukasi-keamanan/:id/:status'),
			name: route.name('ubah-edukasi-keamanan'),
			component: components.get('edukasi-keamanan-form'),
			meta: {
				label: i18n.t('keamanan.meta.label_edukasi_ubah'),
				icon: 'fal fa-address-card',
				access:true
			}
		},		
		{
			path: route.path('detil-edukasi-keamanan/:id/:status'),
			name: route.name('detil-edukasi-keamanan'),
			component: components.get('edukasi-keamanan-form'),
			meta: {
				label: i18n.t('keamanan.meta.label_edukasi_detil'),
				icon: 'fal fa-address-card',
				access:true
			}
		},
		
		/* Audit Keamanan */
		{
			path: route.path('audit-keamanan'),
			name: route.name('audit-keamanan'),
			component: components.get('audit-keamanan'),
			meta: {
				label: i18n.t('keamanan.meta.label_audit_keamanan'),
				icon: 'fal fa-address-card',
				access:true
			}
		},
		{
			path: route.path('tambah-audit-keamanan'),
			name: route.name('tambah-audit-keamanan'),
			component: components.get('audit-keamanan-form'),
			meta: {
				label: i18n.t('keamanan.meta.label_audit_tambah'),
				icon: 'fal fa-address-card',
				access:true
			}
		},
		{
			path: route.path('ubah-audit-keamanan/:id/:status'),
			name: route.name('ubah-audit-keamanan'),
			component: components.get('audit-keamanan-form'),
			meta: {
				label: i18n.t('keamanan.meta.label_audit_ubah'),
				icon: 'fal fa-address-card',
				access:true
			}
		},		
		{
			path: route.path('detil-audit-keamanan/:id/:status'),
			name: route.name('detil-audit-keamanan'),
			component: components.get('audit-keamanan-form'),
			meta: {
				label: i18n.t('keamanan.meta.label_audit_detil'),
				icon: 'fal fa-address-card',
				access:true
			}
		},

		/* Peningkatan Keamanan */
		{
			path: route.path('peningkatan-keamanan'),
			name: route.name('peningkatan-keamanan'),
			component: components.get('peningkatan-keamanan'),
			meta: {
				label: i18n.t('keamanan.meta.label_peningkatan_keamanan'),
				icon: 'fal fa-address-card',
				access:true
			}
		},
		{
			path: route.path('tambah-peningkatan-keamanan'),
			name: route.name('tambah-peningkatan-keamanan'),
			component: components.get('peningkatan-keamanan-form'),
			meta: {
				label: i18n.t('keamanan.meta.label_peningkatan_tambah'),
				icon: 'fal fa-address-card',
				access:true
			}
		},
		{
			path: route.path('ubah-peningkatan-keamanan/:id/:status'),
			name: route.name('ubah-peningkatan-keamanan'),
			component: components.get('peningkatan-keamanan-form'),
			meta: {
				label: i18n.t('keamanan.meta.label_peningkatan_ubah'),
				icon: 'fal fa-address-card',
				access:true
			}
		},		
		{
			path: route.path('detil-peningkatan-keamanan/:id/:status'),
			name: route.name('detil-peningkatan-keamanan'),
			component: components.get('peningkatan-keamanan-form'),
			meta: {
				label: i18n.t('keamanan.meta.label_peningkatan_detil'),
				icon: 'fal fa-address-card',
				access:true
			}
		},

	]
}
