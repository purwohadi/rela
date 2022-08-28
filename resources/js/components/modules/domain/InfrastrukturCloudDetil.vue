<template>
	<div class="row">
		<div class="col-12">
			<section id="domain-layanan-form">
				<b-card class="mb-4 mt-3 rounded p-2">
					<b-row>
						<b-col lg="12" md="12" sm="12" class="text-right">
							<button
								type="button"
								style="margin: 10px 15px 0px;"
								class="btn btn-danger btn-sm rounded waves-effect waves-themed mb-4"
								v-b-tooltip.hover.top="$t('general.button.back')"
								@click="onBack">
								<i class="fal fa-arrow-circle-left"></i>
								{{ $t('general.button.back') }}
							</button>
						</b-col>
					</b-row>

					<form @submit.prevent="passes(onSubmit)">
						<b-form-group
							label-cols="2"
							label-cols-lg="2"
							label-for="rai_level_1"
							label="Referensi Arsitektur Infrastruktur Level 1">
							<b-form-input
								class="ml-2"
								v-model="form.rai_level_1"
								:id="'rai_level_1'"
								placeholder="Referensi Arsitektur Infrastruktur Level 1"
								:readonly="true">
							</b-form-input>
						</b-form-group>
						<b-form-group
							label-cols="2"
							label-cols-lg="2"
							label-for="rai_level_2"
							label="Referensi Arsitektur Infrastruktur Level 2">
							<b-form-input
								class="ml-2"
								v-model="form.rai_level_2"
								:id="'rai_level_2'"
								placeholder="Referensi Arsitektur Infrastruktur Level 2"
								:readonly="true">
							</b-form-input>
						</b-form-group>
						<b-form-group
							label-cols="2"
							label-cols-lg="2"
							label-for="rai_level_3"
							label="Referensi Arsitektur Infrastruktur Level 3">
							<b-form-input
								class="ml-2"
								v-model="form.rai_level_3"
								:id="'rai_level_3'"
								placeholder="Referensi Arsitektur Infrastruktur Level 3"
								:readonly="true">
							</b-form-input>
						</b-form-group>
						<b-form-group
							label-cols="2"
							label-cols-lg="2"
							label-for="instansi"
							label="Instansi">
							<b-form-input
								class="ml-2"
								v-model="model.instansi"
								:id="'instansi'"
								placeholder="Instansi"
								:readonly="true">
							</b-form-input>
						</b-form-group>
						<b-form-group
							label-cols="2"
							label-cols-lg="2"
							label-for="name_gov"
							label="Nama Government Cloud">
							<b-form-input
								class="ml-2"
								v-model="model.nama"
								:id="'name_gov'"
								placeholder="Nama Government Cloud"
								:readonly="true">
							</b-form-input>
						</b-form-group>
						<b-form-group
							label-cols="2"
							label-cols-lg="2"
							label-for="desc_gov"
							label="Deskripsi Government Cloud">
							<b-form-textarea
								class="ml-2"
								rows="3"
								max-rows="6"
								v-model="model.deskripsi"
								:id="'desc_gov'"
								placeholder="Deskripsi Government Cloud"
								:readonly="true">
							</b-form-textarea>
						</b-form-group>
						<b-form-group
							label-cols="2"
							label-cols-lg="2"
							label-for="status_ownership"
							label="Kepemilikan">
							<b-form-input
								class="ml-2"
								v-model="model.status_ownership"
								:id="'status_ownership'"
								placeholder="Kepemilikan"
								:readonly="true">
							</b-form-input>
						</b-form-group>
						<b-form-group
							label-cols="2"
							label-cols-lg="2"
							label-for="nama_owner"
							label="Nama Pemilik">
							<b-form-input
								class="ml-2"
								v-model="model.nama_owner"
								:id="'nama_owner'"
								placeholder="Nama Pemilik"
								:readonly="true">
							</b-form-input>
						</b-form-group>
						<b-form-group
							label-cols="2"
							label-cols-lg="2"
							label-for="biaya"
							label="Biaya Layanan">
							<b-form-input
								class="ml-2"
								v-model="model.biaya"
								:id="'biaya'"
								placeholder="Biaya Layanan"
								:readonly="true">
							</b-form-input>
						</b-form-group>
						<b-form-group
							label-cols="2"
							label-cols-lg="2"
							label-for="unit_dev"
							label="Unit Pengembang Government Cloud">
							<b-form-input
								class="ml-2"
								v-model="model.unit_dev"
								:id="'unit_dev'"
								placeholder="Unit Pengembang Government Cloud"
								:readonly="true">
							</b-form-input>
						</b-form-group>
						<b-form-group
							label-cols="2"
							label-cols-lg="2"
							label-for="unit_oper"
							label="Unit Operasional Government Cloud">
							<b-form-input
								class="ml-2"
								v-model="model.unit_oper"
								:id="'unit_oper'"
								placeholder="Unit Operasional Government Cloud"
								:readonly="true">
							</b-form-input>
						</b-form-group>
						<b-form-group
							label-cols="2"
							label-cols-lg="2"
							label-for="id_metadata_komputasi"
							label="ID Metadata (Fasilitas Komputasi)">
							<m-select
								id="id-metadata-komputasi"
								ref="id-metadata-komputasi"
								class="mb-2"
								:option-height="73"
								:tabindex="7"
								:options="options.metadata_komputasi"
								v-model="form.metadata_komputasi"
								:custom-label="fasilitasName"
                :multiple="true"
                :taggable="true"
								select-label=""
								selected-label=""
								deselect-label=""
								track-by="kode"
								placeholder="-- silahkan pilih --"
								:searchable="true"
								:limit="100"
								:options-limit="100"
								:allow-empty="false"
                :disabled="true"
								>

								<template #noOptions>
								Tidak ada data
								</template>

								<template #noResult>
								Data tidak ditemukan
								</template>
							</m-select>
						</b-form-group>
						<b-form-group label="Jangka Waktu: " v-slot="{ ariaDescribedby }">
							<b-form-radio-group>
								<b-form-radio v-model="model.jangka_waktu" :aria-describedby="ariaDescribedby" name="some-radios" value="Selamanya">Selamanya</b-form-radio>
								<b-form-radio v-model="model.jangka_waktu" :aria-describedby="ariaDescribedby" name="some-radios" value="RentangWaktu">Rentang Waktu Tertentu</b-form-radio>
							</b-form-radio-group>
						</b-form-group>

						<div v-if="model.jangka_waktu!= null">
							<span v-if="model.jangka_waktu === 'RentangWaktu'">
								<div class="d-flex flex-wrap flex-lg-nowrap">
									<ValidationObserver
										tag="div"
										class="d-flex flex-wrap flex-lg-nowrap align-items-start mb-4">
										<b-form-group label="Waktu Awal">
											<bs-datepicker
												v-model="model.selectDateFrom"
												:settings="dpSettings"
												:label="``"
												:cleardate="false"
												:disabled="true"
											></bs-datepicker>
										</b-form-group>
									</ValidationObserver>
								</div>
								<br>
								<div class="d-flex flex-wrap flex-lg-nowrap">
									<ValidationObserver
										tag="div"
										class="d-flex flex-wrap flex-lg-nowrap align-items-start mb-4">
											<b-form-group label="Waktu Akhir">
												<bs-datepicker
													v-model="model.selectDateLast"
													:settings="dpSettings"
													:label="``"
													:cleardate="false"
													:disabled="true"
												></bs-datepicker>
											</b-form-group>
									</ValidationObserver>
								</div>
							</span>
							<br>
						</div>
					</form>
				</b-card>
			</section>
		</div>
	</div>
</template>

<script>
export default {
	name: 'InfrastrukturCloudDetil',
	props: ['id', 'status'],
	data(){
		return{
			model: {
				id : null,
				instansi : null,
				nama : null,
				deskripsi : null,
				status_ownership : null,
				nama_owner : null,
				biaya : null,
				unit_dev : null,
				unit_oper : null,
				id_metadata_terkait : null,
				selectDateFrom: '',
				selectDateLast: ''
			},
			form: {
				instansi: null,
        rai_level_1 : null,
				rai_level_2 : null,
				rai_level_3 : null,
        metadata_komputasi: null,
			},
			dpSettings: {
        format: "MM yyyy",
        minViewMode: "months",
        startView: "months",
        viewMode: "year",
      },
			selected: {
			},
			options: {
        metadata_komputasi: []
			},
		}
	},
	computed: {

	},
	watch: {
	},
	created() {
    this.getIdMetadataTerkait();
		this.loadDataCloud();
		this.getRail1Def();
	},
	methods: {
    getIdMetadataTerkait(){
			let vm = this
			vm.groupLoading = true
			vm.$http.get(vm.$app.route('fasilitas.get-data-by.get'), {
				params: {col: 'domain_code'}
			}).then(response => {
				vm.options['metadata_komputasi'] = response.data
			})
		},
		async loadDataCloud(){
			const res = await this.$http.get(this.$app.route('domain-infrastruktur-cloud.data-infrastruktur-cloud.get', {id: this.id}))
			let result = res.data[0]
			this.model = result
      this.getRail3Def(result.rai_level_3)
      this.getIDMetadataKomputasi(result.id)
			
			if (result.jangka_waktu !== 'Selamanya') {
				let selectedDate = result.jangka_waktu.split(' s/d ')
				this.model.selectDateLast = this.$moment(selectedDate[1], 'MMM-yyyy').format('MMMM yyyy')
				this.model.selectDateFrom = this.$moment(selectedDate[0], 'MMM-yyyy').format('MMMM yyyy')

				this.model.jangka_waktu = 'RentangWaktu'
			}
		},
    async getRail1Def() {
      const res = await this.$http.get(this.$app.route('domain-infrastruktur-cloud.get_rail1'))
      let result = res.data.data[0]
      this.$set(this.form, 'rai_level_1', result.rail)
		  this.getRail2Def();
    },
    async getRail2Def() {
      const res = await this.$http.get(this.$app.route('domain-infrastruktur-cloud.get_rail2'))
      let result = res.data.data[0]
      this.$set(this.form, 'rai_level_2', result.rail)
      // this.getRail2Def()
    },
    async getRail3Def(rail3) {
      const res = await this.$http.get(this.$app.route('domain-infrastruktur-cloud.get_rail3', {rail3: rail3}))
      let result = res.data.data[0]
      this.$set(this.form, 'rai_level_3', result.rail)
      // this.getRail2Def()
    },
    async getIDMetadataKomputasi(id){
			const res = await this.$http.get(this.$app.route('domain-infrastruktur-cloud.get_metadata', {id: id}))
      let result = res.data

			let domain_fasilitas_arr = result.map(val => val.kode_nama)
      
      this.form.metadata_komputasi = this.options.metadata_komputasi.filter((val) => {
        return domain_fasilitas_arr.includes(val.kode_nama)
      })
		},
		onBack() {
			this.$router.push({ name: 'domaininfrastrukturcloud',
				params: {
					'opd_id' : this.$route.params.opd_id
				}
			})
		},
		fasilitasName({kode, nama}) {
			return `${kode} - ${nama}`
		}
	}
}
</script>

<style>

</style>
