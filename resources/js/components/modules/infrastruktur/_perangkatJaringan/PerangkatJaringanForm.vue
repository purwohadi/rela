<template>
	<div class="row">
		<div class="col-12">
			<section id="perangkat-jaringan-form">
				<b-card class="mb-4 mt-3 rounded">
					<b-row>
						<b-col lg="12" md="12" sm="12" class="text-right">
							<button
								type="button"
								style="margin: 10px 15px 0px;"
								class="btn btn-danger btn-sm rounded waves-effect waves-themed"
								v-b-tooltip.hover.top="$t('general.button.back')"
                v-show="!isDetail"
								@click="onBack">
								<i class="fal fa-arrow-circle-left"></i>
								{{ $t('general.button.back') }}
							</button>
						</b-col>
					</b-row>

					<ValidationObserver v-slot="{ passes }" :slim="true">
						<form @submit.prevent="passes(onSubmit)">
							<b-form-group
								label-cols="2"
								label-cols-lg="2"
								label-for="rai-level_1"
								label="Referensi Arsitektur Infrastruktur Level 1">
								<b-col sm="6">
									<validation-provider name="Referensi Arsitektur Infrastruktur Level 1" rules="required" v-slot="{ errors, ariaMsg }">
										<m-select
											id="rai-level_1"
											ref="rai-level_1"
											class="mb-2"
											:option-height="73"
											:tabindex="7"
											:options="optionsRaiLevel1"
											v-model="model.rai_level_1"
											label="rail"
											select-label=""
											selected-label=""
											deselect-label=""
											track-by="kode_nama"
											placeholder="-- silahkan pilih --"
											:searchable="true"
											:limit="100"
											:options-limit="100"
											:allow-empty="false"
											:disabled="true">

											<template #noOptions>
												Tidak ada data
											</template>
											<template #noResult>
												Data tidak ditemukan
											</template>

											<template #option="{ option }">
												<div class="d-flex align-items-baseline mb-1">
													<i class="fal fa-laptop mr-2"></i>
													<span class="text-wrap">{{ option.kode_nama }}</span>
												</div>
											</template>
										</m-select>

										<small v-bind="ariaMsg" style="color: #fd3995; width: 100%; font-size: .6875rem; margin-top: 0.325rem;">
											{{ errors[0] }}
										</small>
									</validation-provider>
								</b-col>
							</b-form-group>

							<b-form-group
								label-cols="2"
								label-cols-lg="2"
								label-for="rai-level_2"
								label="Referensi Arsitektur Infrastruktur Level 2">
								<b-col sm="6">
									<validation-provider name="Referensi Arsitektur Infrastruktur Level 2" rules="required" v-slot="{ errors, ariaMsg }">
										<m-select
											id="rai-level_2"
											ref="rai-level_2"
											class="mb-2"
											:option-height="73"
											:tabindex="7"
											:options="optionsRaiLevel2"
											v-model="model.rai_level_2"
											label="rail"
											select-label=""
											selected-label=""
											deselect-label=""
											track-by="kode_nama"
											placeholder="-- silahkan pilih --"
											:searchable="true"
											:limit="100"
											:options-limit="100"
											:allow-empty="false"
											:disabled="true">

											<template #noOptions>
												Tidak ada data
											</template>
											<template #noResult>
												Data tidak ditemukan
											</template>

											<template #option="{ option }">
												<div class="d-flex align-items-baseline mb-1">
													<i class="fal fa-laptop mr-2"></i>
													<span class="text-wrap">{{ option.kode_nama }}</span>
												</div>
											</template>
										</m-select>

										<small v-bind="ariaMsg" style="color: #fd3995; width: 100%; font-size: .6875rem; margin-top: 0.325rem;">
											{{ errors[0] }}
										</small>
									</validation-provider>
								</b-col>
							</b-form-group>

							<b-form-group
								label-cols="2"
								label-cols-lg="2"
								label-for="rai-level_3"
								label="Referensi Arsitektur Infrastruktur Level 3">
								<b-col sm="6">
									<validation-provider name="Referensi Arsitektur Infrastruktur Level 3" rules="required" v-slot="{ errors, ariaMsg }">
										<m-select
											id="rai-level_3"
											ref="rai-level_3"
											class="mb-2"
											:option-height="73"
											:tabindex="7"
											:options="optionsRaiLevel3"
											v-model="model.rai_level_3"
											label="rail"
											select-label=""
											selected-label=""
											deselect-label=""
											track-by="kode_nama"
											placeholder="-- silahkan pilih --"
											:searchable="true"
											:limit="100"
											:options-limit="100"
											:allow-empty="false"
											:disabled="true">

											<template #noOptions>
												Tidak ada data
											</template>
											<template #noResult>
												Data tidak ditemukan
											</template>

											<template #option="{ option }">
												<div class="d-flex align-items-baseline mb-1">
													<i class="fal fa-laptop mr-2"></i>
													<span class="text-wrap">{{ option.kode_nama }}</span>
												</div>
											</template>
										</m-select>

										<small v-bind="ariaMsg" style="color: #fd3995; width: 100%; font-size: .6875rem; margin-top: 0.325rem;">
											{{ errors[0] }}
										</small>
									</validation-provider>
								</b-col>
							</b-form-group>

							<b-form-group
								label-cols="2"
								label-cols-lg="2"
								label-for="rai-level_4"
								label="Referensi Arsitektur Infrastruktur Level 4">
								<b-col sm="6">
									<validation-provider name="Referensi Arsitektur Infrastruktur Level 4" rules="required" v-slot="{ errors, ariaMsg }">
										<m-select
											id="rai-level_4"
											ref="rai-level_4"
											class="mb-2"
											:option-height="73"
											:tabindex="7"
											:options="optionsRaiLevel4"
											v-model="model.rai_level_4"
											:custom-label="nameSelected"
											select-label=""
											selected-label=""
											deselect-label=""
											track-by="kode_nama"
											placeholder="-- silahkan pilih --"
											:searchable="true"
											:limit="100"
											:options-limit="100"
											:allow-empty="false"
											:disabled="!isDetail">

											<template #noOptions>
												Tidak ada data
											</template>
											<template #noResult>
												Data tidak ditemukan
											</template>

											<template #option="{ option }">
												<div class="d-flex align-items-baseline mb-1">
													<i class="fal fa-laptop mr-2"></i>
													<span class="text-wrap">{{ option.kode_nama }}</span>
												</div>
											</template>
										</m-select>

										<small v-bind="ariaMsg" style="color: #fd3995; width: 100%; font-size: .6875rem; margin-top: 0.325rem;">
											{{ errors[0] }}
										</small>
									</validation-provider>
								</b-col>
							</b-form-group>

							<b-form-group
								label-cols="2"
								label-cols-lg="2"
								label-for="nama"
								label="Nama Perangkat Jaringan">
								<b-col sm="6">
									<ValidationProvider
										rules="required"
										v-slot="{ valid, errors }"
										name="Nama Perangkat Jaringan"
										:debounce="250">
										<b-form-input
											v-model="model.nama"
											:id="'nama'"
											placeholder="Nama Perangkat Jaringan"
											:state="errors[0] ? false : (valid ? null : null)"
											:disabled="!isDetail">
										</b-form-input>
										<b-form-invalid-feedback class="ml-2">{{ errors[0] }}</b-form-invalid-feedback>
									</ValidationProvider>
								</b-col>
							</b-form-group>

							<b-form-group
								label-cols="2"
								label-cols-lg="2"
								label-for="deskripsi"
								label="Deskripsi Perangkat Jaringan">
								<b-col sm="6">
									<ValidationProvider
										rules="required"
										v-slot="{ valid, errors }"
										name="Deskripsi Perangkat Jaringan"
										:debounce="250">
										<b-form-textarea
											:id="'deskripsi'"
											v-model="model.deskripsi"
											placeholder="Deskripsi Perangkat Jaringan"
											rows="3"
											max-rows="6"
            								:state="errors[0] ? false : (valid ? null : null)"
											:disabled="!isDetail">
										</b-form-textarea>
										<b-form-invalid-feedback class="ml-2">{{ errors[0] }}</b-form-invalid-feedback>
									</ValidationProvider>
								</b-col>
							</b-form-group>

              <b-form-group
								label-cols="2"
								label-cols-lg="2"
								label-for="instansi_1"
								label="Instansi 1">
								<b-col sm="6">
									<ValidationProvider
                  rules="required" v-slot="{ valid, errors }"
                  :name="'Instansi 1'" :debounce="250">
                  <m-select
                    id="instansi_1" :disabled="true" v-model="model.instansi_1" :options="optionsInstansi1" :multiple="false"
                    :close-on-select="true" :clear-on-select="false" :preserve-search="true" :preselect-first="false"
                    :placeholder="'Instansi 1'" label="instansi_1" track-by="instansi_1"
                    :searchable="true" :state="errors[0] ? false : (valid ? true : null)">
                  </m-select>
                  <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
                </ValidationProvider>
								</b-col>
							</b-form-group>

              <b-form-group
								label-cols="2"
								label-cols-lg="2"
								label-for="instansi_2"
								label="Instansi 2">
								<b-col sm="6">
									<ValidationProvider
                  rules="required" v-slot="{ valid, errors }"
                  :name="'Instansi 2'" :debounce="250">
                  <m-select
                    id="instansi_2" :disabled="!isDetail" v-model="model.instansi_2" :options="optionsInstansi2" :multiple="false"
                    :close-on-select="true" :clear-on-select="false" :preserve-search="true" :preselect-first="false"
                    :placeholder="'Instansi 2'" label="instansi_2" track-by="instansi_2"
                    :searchable="true" :state="errors[0] ? false : (valid ? true : null)">
                  </m-select>
                  <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
                </ValidationProvider>
								</b-col>
							</b-form-group>

							<b-form-group
								label-cols="2"
								label-cols-lg="2"
								label-for="tipe-device"
								label="Tipe Perangkat">
								<b-col sm="6">
									<validation-provider name="Tipe Perangkat" rules="required" v-slot="{ errors, ariaMsg }">
										<m-select
											id="tipe-device"
											ref="tipe-device"
											class="mb-2"
											:option-height="73"
											:tabindex="7"
											:options="optionsTipeDevice"
											v-model="model.tipe_device"
											:custom-label="nameSelected"
											select-label=""
											selected-label=""
											deselect-label=""
											track-by="kode_nama"
											placeholder="-- silahkan pilih --"
											:searchable="true"
											:limit="100"
											:options-limit="100"
											:allow-empty="false"
											:disabled="!isDetail">

											<template #noOptions>
												Tidak ada data
											</template>
											<template #noResult>
												Data tidak ditemukan
											</template>

											<template #option="{ option }">
												<div class="d-flex align-items-baseline mb-1">
													<i class="fal fa-laptop mr-2"></i>
													<span class="text-wrap">{{ option.kode_nama }}</span>
												</div>
											</template>
										</m-select>

										<small v-bind="ariaMsg" style="color: #fd3995; width: 100%; font-size: .6875rem; margin-top: 0.325rem;">
											{{ errors[0] }}
										</small>
									</validation-provider>
								</b-col>
							</b-form-group>

							<b-form-group
								label-cols="2"
								label-cols-lg="2"
								label-for="tipe-device-2"
								label="Tipe Perangkat 2">
								<b-col sm="6">
									<ValidationProvider
										rules="required"
										v-slot="{ valid, errors }"
										name="Tipe Perangkat 2"
										:debounce="250">
										<b-form-input
											v-model="model.tipe_device_2"
											:id="'tipe-device-2'"
											placeholder="Tipe Perangkat 2"
											:state="errors[0] ? false : (valid ? null : null)"
											:disabled="!isDetail">
										</b-form-input>
										<b-form-invalid-feedback class="ml-2">{{ errors[0] }}</b-form-invalid-feedback>
									</ValidationProvider>
								</b-col>
							</b-form-group>
              <br>
							<b-form-group
								label-cols="2"
								label-cols-lg="2"
								label-for="kepemilikan"
								label="Kepemilikan">
								<b-col sm="6">
									<validation-provider name="Kepemilikan" rules="required" v-slot="{ errors, ariaMsg }">
										<m-select
											id="kepemilikan"
											ref="kepemilikan"
											class="mb-2"
											:option-height="73"
											:tabindex="7"
											:options="optionsKepemilikan"
											v-model="model.ownership"
											:custom-label="nameSelected"
											select-label=""
											selected-label=""
											deselect-label=""
											track-by="kode_nama"
											placeholder="-- silahkan pilih --"
											:searchable="true"
											:limit="100"
											:options-limit="100"
											:allow-empty="false"
											:disabled="!isDetail">

											<template #noOptions>
												Tidak ada data
											</template>

											<template #noResult>
												Data tidak ditemukan
											</template>

											<template #option="{ option }">
												<div class="d-flex align-items-baseline mb-1">
													<i class="fal fa-laptop mr-2"></i>
													<span class="text-wrap">{{ option.kode_nama }}</span>
												</div>
											</template>
										</m-select>

										<small v-bind="ariaMsg" style="color: #fd3995; width: 100%; font-size: .6875rem; margin-top: 0.325rem;">
											{{ errors[0] }}
										</small>
									</validation-provider>
								</b-col>
							</b-form-group>

              <div v-if="model.ownership.length == '0'">
              </div>
              <div v-else>
                <span v-if="model.ownership.kode == 'Milik Sendiri'">
                  <b-form-group
                  label-cols="2"
                  label-cols-lg="2"
                  label-for="nama_owner2" :label="$t('domain.form.field.own_name.label')">
                    <b-col sm="6">
                      <ValidationProvider
                      rules="required" v-slot="{ valid, errors }"
                      :name="$t('domain.form.field.own_name.label')" :debounce="250">
                      <m-select
                        id="nama_owner2" v-model="model.nama_owner2" :options="optionsNamaOwner2" :multiple="false"
                        :close-on-select="true" :clear-on-select="false" :preserve-search="true" :preselect-first="false" :disabled="!isDetail"
                        :placeholder="$t('domain.form.field.own_name.placeholder')" label="akronim" track-by="value"
                        :searchable="true" :state="errors[0] ? false : (valid ? true : null)">
                      </m-select>
                      <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
                      </ValidationProvider>
                    </b-col>
                  </b-form-group>
                  <br>
                </span>
                <span v-else>
                  <b-form-group
                    label-cols="2"
                    label-cols-lg="2"
                    label-for="nama-owner"
                    label="Nama Pemilik">
                    <b-col sm="6">
                      <ValidationProvider
                        rules="required"
                        v-slot="{ valid, errors }"
                        name="Nama Pemilik"
                        :debounce="250">
                        <b-form-input
                          v-model="model.nama_owner"
                          :id="'nama-owner'"
                          placeholder="Nama Pemilik"
                          :state="errors[0] ? false : (valid ? true : null)"
                          :disabled="!isDetail">
                        </b-form-input>
                        <b-form-invalid-feedback class="ml-2">{{ errors[0] }}</b-form-invalid-feedback>
                      </ValidationProvider>
                    </b-col>
                  </b-form-group>
                  <br>
                </span>
              </div>

							<b-form-group
								label-cols="2"
								label-cols-lg="2"
								label-for="unit-pengelola"
								label="Unit Pengelola">
								<b-col sm="6">
									<ValidationProvider
										rules="required"
										v-slot="{ valid, errors }"
										name="Unit Pengelola"
										:debounce="250">
										<b-form-input
											v-model="model.unit_pengelola"
											:id="'unit-pengelola'"
											placeholder="Unit Pengelola"
											:state="errors[0] ? false : (valid ? null : null)"
											:disabled="!isDetail">
										</b-form-input>
										<b-form-invalid-feedback class="ml-2">{{ errors[0] }}</b-form-invalid-feedback>
									</ValidationProvider>
								</b-col>
							</b-form-group>

							<b-form-group
								label-cols="2"
								label-cols-lg="2"
								label-for="id-metadata-jip"
								label="Jaringan Intra Pemerintah yang Terhubung">
								<b-col sm="6">
									<validation-provider name="Jaringan Intra Pemerintah yang Terhubung" rules="required" v-slot="{ errors, ariaMsg }">
										<m-select
											id="id-metadata-jip"
											ref="id-metadata-jip"
											class="mb-2"
											:option-height="73"
                      :multiple="true"
                      :close-on-select="false"
                      :clear-on-select="false"
                      :preselect-first="false"
											:tabindex="7"
											:options="optionsIdMetadataJip"
											v-model="model.id_metadata_jip"
											label = "kode_nama"
                      track-by="kode_nama"
                      :taggable="true"
											placeholder="-- silahkan pilih --"
											:searchable="true"
											:limit="100"
											:options-limit="100"
											:allow-empty="false"
											:disabled="!isDetail">

											<template #noOptions>
												Tidak ada data
											</template>

											<template #noResult>
												Data tidak ditemukan
											</template>

											<template #option="{ option }">
												<div class="d-flex align-items-baseline mb-1">
													<i class="fal fa-laptop mr-2"></i>
													<span class="text-wrap">{{ option.kode_nama }}</span>
												</div>
											</template>
										</m-select>

										<small v-bind="ariaMsg" style="color: #fd3995; width: 100%; font-size: .6875rem; margin-top: 0.325rem;">
											{{ errors[0] }}
										</small>
									</validation-provider>
								</b-col>
							</b-form-group>

							<b-form-group
								label-cols="2"
								label-cols-lg="2"
								label-for="keterangan"
								label="Keterangan Perangkat Keras">
								<b-col sm="6">
									<ValidationProvider
										rules="required"
										v-slot="{ valid, errors }"
										name="Keterangan Perangkat Keras"
										:debounce="250">
										<b-form-textarea
											:id="'keterangan'"
											v-model="model.keterangan"
											placeholder="Keterangan Perangkat Keras"
											rows="3"
											max-rows="6"
                      :state="errors[0] ? false : (valid ? null : null)"
											:disabled="!isDetail">
										</b-form-textarea>
										<b-form-invalid-feedback class="ml-2">{{ errors[0] }}</b-form-invalid-feedback>
									</ValidationProvider>
								</b-col>
							</b-form-group>

              <b-form-group
								label-cols="2"
								label-cols-lg="2"
								label-for="id-metadata-fasilitas"
								label="ID Metadata Terkait (Fasilitas Komputasi)">
								<b-col sm="6">
									<ValidationProvider
                    rules="required" v-slot="{ errors, ariaMsg }"
                    :name="`ID Metadata Terkait (Fasilitas Komputasi)`"
                    :debounce="250">
                    <m-select
                      id="id_metadata_fasilitas"
                      v-model="model.id_metadata_fasilitas"
                      :options="optionsIdMetadataFasilitas"
                      :multiple="true"
                      :close-on-select="false"
                      :clear-on-select="false"
                      :preselect-first="false"
                      :placeholder="`Masukkan ID Metadata Terkait (Fasilitas Komputasi)`"
											:custom-label="fasilitasName"
                      track-by="kode"
                      :searchable="true" :disabled="!isDetail">
                    </m-select>
                    <small v-bind="ariaMsg" style="color: #fd3995; width: 100%; font-size: .6875rem; margin-top: 0.325rem;">
                      {{ errors[0] }}
                    </small>
                  </ValidationProvider>
								</b-col>
							</b-form-group>

							<div class="text-right mt-4 pt-3">
                <div class="col-7">
                  <b-button type="submit" variant="primary" v-show="isDetail">
                    <i class="fal fa-save"></i>
                    {{ $t('general.form.button_add') }}
                  </b-button>
                  <b-button ref="closebtn" variant="default" @click="$router.go(-1)" v-show="isDetail">
                    {{ $t('general.form.button_cancel') }}
                  </b-button>
                </div>
							</div>
						</form>
					</ValidationObserver>

				</b-card>
			</section>
		</div>
	</div>
</template>

<script>
export default
{
	name: 'PerangkatJaringanForm',
	components: {
	},
	data(){
		return{
			model: {
				rai_level_1: [],
				rai_level_2: [],
				rai_level_3: [],
				rai_level_4: [],
				nama: '',
				deskripsi: '',
				instansi_1: [],
				instansi_2: [],
				tipe_device: [],
				tipe_device_2: '',
				ownership: [],
				nama_owner: '',
				nama_owner2: [],
				unit_pengelola: '',
				id_metadata_jip: [],
				keterangan: '',
				id_metadata_fasilitas: [],
				id: this.$route?.params?.id,
				status: this.$route?.params?.status,
			},
			optionsRaiLevel1: [],
			optionsRaiLevel2: [],
			optionsRaiLevel3: [],
			optionsRaiLevel4: [],
			optionsTipeDevice:[
				{kode: "Switch L2", kode_nama: "Switch L2"},
				{kode: "Switch L3", kode_nama: "Switch L3"},
				{kode: "Switch L4", kode_nama: "Switch L4"},
				{kode: "Switch L7", kode_nama: "Switch L7"},
				{kode: "Multilayer Switch", kode_nama: "Multilayer Switch"},
				{kode: "Router", kode_nama: "Router"},
				{kode: "Wireless equipment", kode_nama: "Wireless equipment"},
				{kode: "Transmission equipment", kode_nama: "Transmission equipment"},
				{kode: "Lainnya", kode_nama: "Lainnya"},
			],
			optionsKepemilikan:[
				{kode: "Milik Sendiri", kode_nama: "Milik Sendiri"},
				{kode: "Milik Instansi Pemerintah Lain", kode_nama: "Milik Instansi Pemerintah Lain"},
				{kode: "Milik BUMN", kode_nama: "Milik BUMN"},
				{kode: "Milik Pihak Ketiga - Dalam Negeri", kode_nama: "Milik Pihak Ketiga - Dalam Negeri"},
				{kode: "Milik Pihak Ketiga - Luar Negeri", kode_nama: "Milik Pihak Ketiga - Luar Negeri"}
			],
      optionsInstansi1:[],
      optionsInstansi2:[],
			optionsIdMetadataJip:[],
			optionsNamaOwner2:[],
			optionsIdMetadataFasilitas:[],
			isDetail: false,
		}
	},
	computed: { },
	watch: {
	},
	mounted:function(){ },
	created(){
		this.isDetail = (this.model.status == 'detail')?false:true
		this.resRal('',1).then((data) =>{this.optionsRaiLevel1 = data})
		this.resRal('',2).then((data) =>{this.optionsRaiLevel2 = data})
		this.resRal('',3).then((data) =>{this.optionsRaiLevel3 = data})
		this.resRal('03.01.03',4).then((data) =>{this.optionsRaiLevel4 = data})
    this.getInstansi1()
		this.resMetadata().then((data) =>{this.optionsIdMetadataJip = data})
		this.resMetadataFasilitas()
		this.getRail1Def()
    if(this.$route.params.status == 'edit' || this.$route.params.status == 'detail'){
      this.resDomainInfraNetdev()
    }
	},
	methods :
	{
		onBack() {
			this.$router.go(-1)
		},
		onSubmit(){
			let vm 			= this
      let routeName 	= vm.model.status ? 'perangkat-jaringan.update-data-domain-infra-netdev' : 'perangkat-jaringan.simpan-data-domain-infra-netdev'
			let url 		= vm.$app.route(routeName)
			let frm 		= new FormData()
			let formData 	= vm.$app.objectToFormData(vm.model, frm)
			let method ='post'
			vm.$app.confirm({
				text: vm.$t('Yakin Simpan Data'),
				preConfirm: () => {
					return vm.$http
						[method](url, formData)
						.then(response => {
							if (response.data.status == "error") {
								throw new Error(response.data.message)
							} else {
								return response
							}
						})
						.catch(error => {
							vm.$app.alert.showValidationMessage(error)
						})
				}
			})
				.then(result => {
					if (result.isDismissed) return
					if (result.value.data.status == "success")
					{
						vm.$app.alert.fire({
              icon: result.value.data.status,
              title: result.value.data.status ? 'Sukses' : 'Info',
              text: result.value.data.message,
              showConfirmButton: false,
              timer: 1300
            })
            .then(response => {
              vm.$bvModal.hide(vm.modal)
              this.$router.go(-1)
            })
					}
				})
		},
		async resRal(kode, tingkat, kode_nama=''){
			const res = await this.$http.get(this.$app.route('domain.data-ral.get', {kode: kode, tingkat: tingkat, kode_nama:kode_nama, kategori:'rai'}))
			return res.data
		},
		async resMetadata(){
			const res = await this.$http.get(this.$app.route('jaringan-intra-pemerintah.get-data-by.get', {col:'nama_jip'}))
			return res.data
		},
		async resMetadataFasilitas(){
			let vm = this
			vm.groupLoading = true
			vm.$http.get(vm.$app.route('fasilitas.get-data-by.get'), {
				params: {col: 'domain_code'}
			}).then(response => {
				vm.optionsIdMetadataFasilitas = response.data
			})
		},
		nameSelected({kode_nama}){
			return `${kode_nama}`
		},
    async getRail1Def() {
      const res = await this.$http.get(this.$app.route('perangkat-jaringan.get_rail1'))
      let result = res.data.data[0]
      let rail1 = _.find(this.optionsRaiLevel1, function(o) { return o.rail = result['rail'] ; })
      this.$set(this.model, 'rai_level_1', rail1)
      this.getRail2Def()
    },
    async getRail2Def() {
      const res = await this.$http.get(this.$app.route('perangkat-jaringan.get_rail2'))
      let result = res.data.data[0]
      let rail2 = _.find(this.optionsRaiLevel2, function(o) { return o.rail = result['rail'] ; })
      this.$set(this.model, 'rai_level_2', rail2)
      this.getRail3Def()
    },
    async getRail3Def() {
      const res = await this.$http.get(this.$app.route('perangkat-jaringan.get_rail3'))
      let result = res.data.data[0]
      let rail3 = _.find(this.optionsRaiLevel3, function(o) { return o.rail = result['rail'] ; })
      this.$set(this.model, 'rai_level_3', rail3)
    },
    async getInstansi1() {
      let vm = this
      vm.groupLoading = true
      vm.$http.get(vm.$app.route('perangkat-jaringan.get_instansi1'), {
        params: {}
      }).then(response => {
        const instansiOption = [];
        response.data.map(function (value, key) {
          instansiOption.push({ value: [value.opd_id, value.nama_opd], instansi_1: value.nama_opd });
        });
        vm.optionsInstansi1 = instansiOption
        this.resInstansi1()
      })
    },
    async resInstansi1() {
	    const res = await this.$http.get(this.$app.route('perangkat-jaringan.get_instansi1'))
	    let result = res.data[0]
      let instansi_1 = _.find(this.optionsInstansi1, function(o) { return o.instansi_1 = result['nama_opd'] ; })
      this.$set(this.model, 'instansi_1', instansi_1)
      this.getInstansi2()
    },
    async getInstansi2() {
      let vm = this
      vm.groupLoading = true
      vm.$http.get(vm.$app.route('perangkat-jaringan.data-perangkat-daerah.get'), {
        params: {}
      }).then(response => {
        const instansiOption = [];
        const own2Option = [];
        response.data.map(function (value, key) {
          instansiOption.push({ value: [value.opd_id, value.akronim], instansi_2: value.akronim });
          own2Option.push({ value: [value.opd_id, value.akronim], akronim: value.akronim });
        });
        vm.optionsInstansi2 = instansiOption
        vm.optionsNamaOwner2 = own2Option
        this.getMilikOPD()
      })
    },
    async getMilikOPD() {
      let vm = this
      vm.groupLoading = true
      vm.$http.get(vm.$app.route('perangkat-jaringan.data-perangkat-daerah.get'), {
        params: {}
      }).then(response => {
        const own2Option = [];
        response.data.map(function (value, key) {
          own2Option.push({ value: [value.opd_id, value.akronim], akronim: value.akronim });
        });
        vm.optionsNamaOwner2 = own2Option
      })
    },
    // async resMilikOPD() {
	  //   const res = await this.$http.get(this.$app.route('perangkat-jaringan.data-perangkat-daerah.get', {opd_id : this.$route.params.opd_id}))
    //   let result = res.data[0]
    //   let instansi = _.find(this.optionsNamaOwner2, function(o) { return o.akronim = result['akronim'] ; })
    //   this.$set(this.model, 'nama_owner2', instansi)
    // },
    async resDomainInfraNetdev(){
			const res = await this.$http.get(this.$app.route('perangkat-jaringan.search-intra-netdev.get', {id_netdev: this.model.id}))
			if(res.data){
				const rai1 = await this.resRal('',1,res.data.rai_level_1)
				const rai2 = await this.resRal(res.data.rai_level_1.split(' ')[0],2,res.data.rai_level_2)
				const rai3 = await this.resRal(res.data.rai_level_2.split(' ')[0],3,res.data.rai_level_3)
				const rai4 = await this.resRal(res.data.rai_level_3.split(' ')[0],4,res.data.rai_level_4)
				this.model.id					= res.data.id
				let rail4 = _.find(this.optionsRaiLevel4, function(o) { return o.rail = res.data.rai_level_4 })
        this.$set(this.model, 'rai_level_4', rail4)
				this.model.nama					= res.data.nama
				this.model.deskripsi 			= res.data.deskripsi
				this.model.tipe_device 			= this.optionsTipeDevice.find(data => data.kode === res.data.tipe_device);
				this.model.tipe_device_2 		= res.data.tipe_device_2
				this.model.ownership 			= this.optionsKepemilikan.find(data => data.kode === res.data.ownership)
        if(res.data['ownership'] === 'Milik Sendiri'){
          this.resInstansi2(res.data.opd_id_2)
        }else{
          this.model.nama_owner = res.data.nama_owner
        }
				this.model.unit_pengelola 		= res.data.unit_pengelola
				this.resMetadataJIP(res.data.id)
				this.model.keterangan 			= res.data.keterangan
        this.resInstansi2(res.data.opd_id_2)
			}
		},
    async resInstansi2(opd_id){
			const res = await this.$http.get(this.$app.route('media-penyimpanan.get_detail_instansi', {opd_id : opd_id}))
			let result = res.data[0]
			let instansi = _.find(this.optionsInstansi2, function(o) { return o.instansi_2 = result['akronim'] ; })
			this.$set(this.model, 'instansi_2', instansi)
			let nama_owner2 = _.find(this.optionsNamaOwner2, function(o) { return o.akronim = result['akronim'] ; })
			this.model.nama_owner2 = nama_owner2
		},
    async resMetadataJIP(id){
			return this.$http.get(this.$app.route('perangkat-jaringan.get_metadata_jip', {id: id})).then((res) => {
				let result = res.data
	
				let domain_jip_arr = result.map(val => val.kode_nama)
				this.model.id_metadata_jip = result
	
				this.resDataMetadataFasilitas(id)
			})
		},
		async resDataMetadataFasilitas(id){
			return this.$http.get(this.$app.route('perangkat-jaringan.get_metadata_fasilitas', {id: id})).then((res) => {
				let result = res.data
				
				let domain_fasilitas_arr = result.map(val => val.kode_nama)
				
				this.model.id_metadata_fasilitas = this.optionsIdMetadataFasilitas.filter((val) => {
					return domain_fasilitas_arr.includes(val.kode_nama)
				})
			})
		},
		fasilitasName({kode, nama}) {
			return `${kode} - ${nama}`
		}
	},
}
</script>

<style>
#app {
  margin: 20px;
}
</style>
