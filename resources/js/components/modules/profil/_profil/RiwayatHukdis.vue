<template>
  <section class="riwayat-hukdis">
    <data-table
      :id="tableId"
      :fields="fields"
      :api-url="`/profil/riwayat-hukdis/${nrk}`"
      :force-url="true"
      :title="$t('profil.datatable.titleHukdis')"
      actions=" "
      row-action-width="13%"
      row-num-width="5%"
      panel-border-none
      panel-shadow-none>
    </data-table>
  </section>
</template>

<script>
	export default {
		name: 'RiwayatHukdis',
		name: 'riwayat-hukdis',
		props: {
			hukdis: {
				//type: Object,
				type: String,
				required: true,
				default: () => ''
			}
		},
		data() {
			return {
				fields: [
					{
						key: 'rownum',
						class: 'text-center',
					},
					{
						key: 'ket_lengkap_jenhukdis',
						label: 'Jenis Hukuman',
						sortable: true,
					},
					{
						key: 'tgmulai',
						label: 'Tgl Mulai',
						sortable: true,
						formatter: (x) => (x ? this.$moment(x).format('DD-MM-YYYY') : null),
					},
					{
						key: 'tgakhir',
						label: 'Tgl Berakhir',
						sortable: true,
						formatter: (x) => (x ? this.$moment(x).format('DD-MM-YYYY') : null),
					},
					{
						key: 'nosk',
						label: 'No SK',
						sortable: true,
					},
					{
						key: 'tgsk',
						label: 'Tgl SK',
						sortable: true,
						formatter: (x) => (x ? this.$moment(x).format('DD-MM-YYYY') : null),
					},
					{
						key: 'pejtt',
						label: 'Pejabat Penanda Tangan',
						sortable: true
					},
				],
				querySearch: '',
				thbl: this.$moment('01 Mar 2021').format('YYYYMM'),
				tableId: 'strukturtable',
				isBusy: false,
				nrk : this.$app.user.v_userid,
			}
		},	
		computed: {
			propList() {
				return Object.keys(this.props).map(item => ({
				name: item,
				}));
			},
		},
		watch: {
			hukdis: {
				handler: function(n, o) {
					this.nrk = this.hukdis
				},
				deep: true,
				immediate: true
			}
		},
		created() 
		{
			
		},
		methods: {
		},
	}
</script>
