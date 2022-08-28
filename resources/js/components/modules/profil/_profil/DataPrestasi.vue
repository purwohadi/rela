<template>
  <section class="data-prestasi">
    <div class="tabs">
      <b-nav tabs>
        <b-nav-item to="#tab_pendidikan_formal" :active="$route.hash === '#tab_pendidikan_formal' || $route.hash === ''">
          {{ $t('profil.meta.tabs.header.pendidikan_formal') }}
        </b-nav-item>
        <b-nav-item to="#tab_pendidikan_nonformal" :active="$route.hash === '#tab_pendidikan_nonformal'">
          {{ $t('profil.meta.tabs.header.pendidikan_nonformal') }}
        </b-nav-item>
        <b-nav-item to="#tab_narasumber" :active="$route.hash === '#tab_narasumber'">
          {{ $t('profil.meta.tabs.header.narasumber') }}
        </b-nav-item>
        <b-nav-item to="#tab_kegiatan" :active="$route.hash === '#tab_kegiatan'">
          {{ $t('profil.meta.tabs.header.kegiatan') }}
        </b-nav-item>
        <b-nav-item to="#tab_jabatan" :active="$route.hash === '#tab_jabatan'">
          {{ $t('profil.meta.tabs.header.jabatan') }}
        </b-nav-item>
      </b-nav>
      <div class="tab-content">
        <div :class="['tab-pane', { 'active': $route.hash === '#tab_pendidikan_formal' || $route.hash === '' }]" class="p-2">
          <p><pendidikan-formal v-if="nrk" :vnrk="nrk"></pendidikan-formal></p>
        </div>
        <div :class="['tab-pane', { 'active': $route.hash === '#tab_pendidikan_nonformal' }]" class="p-2">
          <p><pendidikan-non-formal v-if="nrk" :vnrk="nrk"></pendidikan-non-formal></p>
        </div>
        <div :class="['tab-pane', { 'active': $route.hash === '#tab_narasumber' }]" class="p-2">
          <p><narasumber v-if="nrk" :vnrk="nrk"></narasumber></p>
        </div>
        <div :class="['tab-pane', { 'active': $route.hash === '#tab_kegiatan' }]" class="p-2">
          <p><prestasi-kegiatan v-if="nrk" :vnrk="nrk"></prestasi-kegiatan></p>
        </div>
        <div :class="['tab-pane', { 'active': $route.hash === '#tab_jabatan' }]" class="p-2">
          <p><prestasi-jabatan v-if="nrk" :vnrk="nrk"></prestasi-jabatan></p>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
	import PendidikanFormal from './_prestasi/PendidikanFormal'
	import PendidikanNonFormal from './_prestasi/PendidikanNonFormal'
	import Narasumber from './_prestasi/Narasumber'
	import PrestasiKegiatan from './_prestasi/PrestasiKegiatan'
	import PrestasiJabatan from './_prestasi/PrestasiJabatan'

	export default {
		name: 'DataPrestasi',
		components: {
			PendidikanFormal,
			PendidikanNonFormal,
			Narasumber,
			PrestasiKegiatan,
			PrestasiJabatan,
		},
		props: {
			nrk: {
				type: String,
				required: true,
				default: () => ''
			}
		},
		data() 
		{
			return {}
		},
		computed: {
			propList() {
				return Object.keys(this.props).map(item => ({
				name: item,
				}));
			},
		},
		methods: {},
	}
</script>
