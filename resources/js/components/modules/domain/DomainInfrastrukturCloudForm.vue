<template>
  <b-card class="p-3">
    <section class="user">
      <div class="col-6">
        <validation-observer v-slot="{ passes }" :slim="true">
          <form @submit.prevent="passes(submit)">
            <template>

              <b-form-group
                label-for="id"
                label="ID"
                v-show="false">
                  <b-form-input
                    :id="'id'"
                    v-model="form.id"
                    placeholder="ID"
                    :readonly="true">
                  </b-form-input>
              </b-form-group>

              <b-form-group label-for="rail1" :label="$t('domain.form.field.rail1.label')">
                <ValidationProvider
                  rules="required" v-slot="{ valid, errors }"
                  :name="$t('domain.form.field.rail1.label')" :debounce="250">
                  <m-select
                    id="rail1" v-model="selected.rail1" :options="options.rail1" :multiple="false"
                    :close-on-select="true" :clear-on-select="false" :preserve-search="true" :preselect-first="true"
                    :placeholder="$t('domain.form.field.rail1.placeholder')" label="rail" track-by="key" :disabled="true"
                    :searchable="true" :state="errors[0] ? false : (valid ? true : null)">
                  </m-select>
                  <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
                </ValidationProvider>
              </b-form-group>

              <b-form-group label-for="rail2" :label="$t('domain.form.field.rail2.label')">
                <ValidationProvider
                  rules="required" v-slot="{ valid, errors }"
                  :name="$t('domain.form.field.rail2.label')" :debounce="250">
                  <m-select
                    id="rail2" v-model="selected.rail2" :options="options.rail2" :multiple="false"
                    :close-on-select="true" :clear-on-select="false" :preserve-search="true" :preselect-first="true"
                    :placeholder="$t('domain.form.field.rail2.placeholder')" label="rail" track-by="key" :disabled="true"
                    :searchable="true" :state="errors[0] ? false : (valid ? true : null)">
                  </m-select>
                  <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
                </ValidationProvider>
              </b-form-group>

              <b-form-group label-for="rail3" :label="$t('domain.form.field.rail3.label')">
                <ValidationProvider
                  v-slot="{ valid, errors }"
                  :name="$t('domain.form.field.rail3.label')" :debounce="250">
                  <m-select
                    id="rail3" v-model="selected.rail3" :options="options.rail3" :multiple="false"
                    :close-on-select="true" :clear-on-select="false" :preserve-search="true" :preselect-first="true"
                    :placeholder="$t('domain.form.field.rail3.placeholder')" label="rail" track-by="key"
                    :searchable="true" :state="errors[0] ? false : (valid ? true : null)">
                  </m-select>
                  <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
                </ValidationProvider>
              </b-form-group>

              <b-form-group label-for="rail4" :label="$t('domain.form.field.rail4.label')">
                <ValidationProvider
                  rules="required" v-slot="{ valid, errors }"
                  :name="$t('domain.form.field.rail4.label')" :debounce="250">
                  <b-form-input
                    id="rail4"
                    v-model="form.rail4"
                    :disabled="true">
                  </b-form-input>
                  <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
                </ValidationProvider>
              </b-form-group>

              <b-form-group label-for="instansi" :label="$t('domain.form.field.instansi.label')">
                <ValidationProvider
                  rules="required" v-slot="{ valid, errors }"
                  :name="$t('domain.form.field.instansi.label')" :debounce="250">
                   <b-form-input
                    id="instansi"
                    v-model="form.instansi"
                    placeholder="Instansi"
                    :disabled="true">
                  </b-form-input>
                  <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
                </ValidationProvider>
              </b-form-group>

              <b-form-group
                label-for="name_gov"
                :label="$t('domain.form.field.name_gov.label')">
                <ValidationProvider
                  rules="required" v-slot="{ errors }"
                  :name="$t('domain.form.field.name_gov.label')" :debounce="250">
                  <b-form-input
                    :id="'name_gov'"
                    v-model="form.name_gov"
                    :placeholder="$t('domain.form.field.name_gov.placeholder')">
                  </b-form-input>
                  <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
                </ValidationProvider>
              </b-form-group>

              <b-form-group
                label-for="desc_gov"
                :label="$t('domain.form.field.desc_gov.label')">
                <ValidationProvider
                  rules="required" v-slot="{ errors }"
                  :name="$t('domain.form.field.desc_gov.label')" :debounce="250">
                  <b-form-textarea
                    :id="'desc_gov'"
                    v-model="form.desc_gov"
                    rows="3"
                    max-rows="6"
                    :placeholder="$t('domain.form.field.name_gov.placeholder')">
                  </b-form-textarea>
                  <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
                </ValidationProvider>
              </b-form-group>

              <b-form-group label-for="own" :label="$t('domain.form.field.own.label')">
                <ValidationProvider
                  rules="required" v-slot="{ valid, errors }"
                  :name="$t('domain.form.field.own.label')" :debounce="250">
                  <m-select
                  id="own"
                  v-model="form.own"
                  :options="options.own"
                  :multiple="false"
                  :close-on-select="true"
                  :clear-on-select="false"
                  :preserve-search="true"
                  :preselect-first="false"
                  :placeholder="$t('domain.form.field.own.placeholder')"
                  label="label"
                  track-by="value"
                  :searchable="true" :state="errors[0] ? false : (valid ? true : null)">
                  </m-select>
                  <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
                </ValidationProvider>
              </b-form-group>

              <div v-if="form.own != null">
                <span v-if="form.own.label == 'Milik Sendiri'">
                  <b-form-group label-for="own_name2" :label="$t('domain.form.field.own_name.label')">
                    <ValidationProvider
                      rules="required" v-slot="{ valid, errors }"
                      :name="$t('domain.form.field.own_name.label')" :debounce="250">
                      <m-select
                        id="own_name2" v-model="form.own_name2" :options="options.own_name2" :multiple="false"
                        :close-on-select="true" :clear-on-select="false" :preserve-search="true" :preselect-first="false"
                        :placeholder="$t('domain.form.field.own_name.placeholder')" label="akronim" track-by="value" :disabled="true"
                        :searchable="true" :state="errors[0] ? false : (valid ? true : null)">
                      </m-select>
                      <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
                    </ValidationProvider>
                  </b-form-group>
                </span>
                <span v-else>
                  <span v-if="form.own.label === 'Milik Instansi Pemerintah Lain'">
                    <b-form-group label-for="own_name3" :label="$t('domain.form.field.own_name.label')">
                      <ValidationProvider
                        rules="required" v-slot="{ valid, errors }"
                        :name="$t('domain.form.field.own_name.label')" :debounce="250">
                        <m-select
                          id="own_name3" v-model="form.own_name3" :options="options.own_name3" :multiple="false"
                          :close-on-select="true" :clear-on-select="false" :preserve-search="true" :preselect-first="false"
                          :placeholder="$t('domain.form.field.own_name.placeholder')" label="akronim" track-by="value"
                          :searchable="true" :state="errors[0] ? false : (valid ? true : null)">
                        </m-select>
                        <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
                      </ValidationProvider>
                    </b-form-group>
                  </span>
                  <span v-else>
                    <b-form-group
                      label-for="own_name"
                      :label="$t('infrastruktur.form.field.own_name.label')">
                      <ValidationProvider
                        rules="required" v-slot="{errors }"
                        :name="$t('infrastruktur.form.field.own_name.label')" :debounce="250">
                        <b-form-input
                          :id="'own_name'"
                          v-model="form.own_name"
                          :placeholder="$t('infrastruktur.form.field.own_name.placeholder')">
                        </b-form-input>
                        <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
                      </ValidationProvider>
                    </b-form-group>
                  </span>
                </span>
                <br>
              </div>

              <b-form-group
                label-for="price"
                :label="$t('domain.form.field.price.label')">
                <ValidationProvider
                  rules="required" v-slot="{ errors }"
                  :name="$t('domain.form.field.price.label')" :debounce="250">
                  <b-form-input
                    :id="'price'"
                    type="number"
                    v-model="form.price"
                    :placeholder="$t('domain.form.field.price.placeholder')">
                  </b-form-input>
                  <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
                </ValidationProvider>
              </b-form-group>

              <b-form-group
                label-for="unit_dev"
                :label="$t('domain.form.field.unit_dev.label')">
                <ValidationProvider
                  rules="required" v-slot="{ errors }"
                  :name="$t('domain.form.field.unit_dev.label')" :debounce="250">
                  <b-form-input
                    :id="'unit_dev'"
                    v-model="form.unit_dev"
                    :placeholder="$t('domain.form.field.unit_dev.placeholder')">
                  </b-form-input>
                  <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
                </ValidationProvider>
              </b-form-group>

              <b-form-group
                label-for="unit_opr"
                :label="$t('domain.form.field.unit_opr.label')">
                <ValidationProvider
                  rules="required" v-slot="{ errors }"
                  :name="$t('domain.form.field.unit_opr.label')" :debounce="250">
                  <b-form-input
                    :id="'unit_opr'"
                    v-model="form.unit_opr"
                    :placeholder="$t('domain.form.field.unit_opr.placeholder')">
                  </b-form-input>
                  <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
                </ValidationProvider>
              </b-form-group>

              <b-form-group
                label-for="id_metadata"
                :label="`ID Metadata Terkait (Fasilitas Komputasi)`">
                <input v-model="form.id_metadata" type="hidden">
                <ValidationProvider
                  rules="required" v-slot="{ errors, ariaMsg }"
                  :name="`ID Metadata Terkait (Fasilitas Komputasi)`"
                  :debounce="250">
                  <m-select
                    id="id_metadata"
                    v-model="form.id_metadata"
                    :options="options.id_metadata"
                    :multiple="true"
                    :close-on-select="false"
                    :clear-on-select="false"
                    :preserve-search="true"
                    :preselect-first="false"
                    :placeholder="`Masukkan ID Metadata Terkait (Fasilitas Komputasi)`"
                    :custom-label="fasilitasName"
                    track-by="kode"
                    :searchable="true" >
                  </m-select>
                  <small v-bind="ariaMsg" style="color: #fd3995; width: 100%; font-size: .6875rem; margin-top: 0.325rem;">
                    {{ errors[0] }}
                  </small>
                </ValidationProvider>
              </b-form-group>

              <b-form-group label="Jangka Waktu: " v-slot="{ ariaDescribedby }">
                <b-form-radio-group>
                  <b-form-radio v-model="form.selectedWaktu" :aria-describedby="ariaDescribedby" name="some-radios" value="Selamanya">Selamanya</b-form-radio>
                  <b-form-radio v-model="form.selectedWaktu" :aria-describedby="ariaDescribedby" name="some-radios" value="RentangWaktu">Rentang Waktu Tertentu</b-form-radio>
                </b-form-radio-group>
              </b-form-group>

              <div v-if="form.selectedWaktu != null">
                <span v-if="form.selectedWaktu === 'RentangWaktu'">
                  <div class="d-flex flex-wrap flex-lg-nowrap">
                    <ValidationObserver
                      tag="div"
                      class="d-flex flex-wrap flex-lg-nowrap align-items-start mb-4">
                      <b-form-group label="Waktu Awal">
                        <bs-datepicker
                          v-model="form.selectDateFrom"
                          :settings="dpSettings"
                          :label="``"
                          :cleardate="false"
                          class="datepicker-input"
                          placeholder="Pilih Waktu Awal"
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
                            v-model="form.selectDateFromLast"
                            :settings="dpSettings"
                            :label="``"
                            :cleardate="false"
                            placeholder="Pilih Waktu Akhir"
                            class="datepicker-input"
                          ></bs-datepicker>
                        </b-form-group>
                    </ValidationObserver>
                  </div>
                </span>
                <br>
              </div>
            </template>
            <div class="text-right mt-4 pt-3">
              <b-button type="submit" variant="primary">
                {{ $t('general.form.button_add') }}
              </b-button>
              <b-button ref="closebtn" variant="default" @click="$router.go(-1)">
                {{ $t('general.form.button_cancel') }}
              </b-button>
            </div>
          </form>
        </validation-observer>
      </div>
    </section>
  </b-card>
</template>

<script>
export default {
	name: 'DomainInfrastrukturCloudForm',
	props: {
		id: null,
		props: ['id', 'status'],
	},
	data() {
		let resourceName = 'domain-infrastruktur-cloud';
		return {
			show: true,
			title: '',
			querySearch: '',
			rulesForPassword: '',
			rulesForPasswordConfirmed: '',
			resourceName: resourceName,
			routeName: `${resourceName}`,
			model: {
				id : null,
			},
      dpSettings: {
        format: "MM yyyy",
        minViewMode: "months",
        startView: "months",
        viewMode: "year",
      },
			fields: {
				id: 'id',
				parentID: 'parent_id',
				text: 'name',
				hasChildren: 'hasChild',
				dataSource: null,
			},
			checkedNodes: [],
			form: {
        opd_id : null,
				instansi: null,
				selected: null,
				proses_id: null,
				name_gov: null,
				desc_gov: null,
				own: null,
        own_name: null,
        own_name2: null,
        own_name3: null,
				price: null,
				unit_dev: null,
				unit_opr: null,
				id_metadata: null,
        selectDateFrom: '',
        selectDateFromLast: '',
        selectedWaktu: '',
        rail1: null,
        rail2: null,
        rail3: null,
        rail4: null,
			},
			statusOptions: [
				{ id: 1, name: 'Aktif' },
				{ id: 0, name: 'Tidak Aktif' },
			],
			fieldTypePasword: 'password',
			iconPassword: 'fa-eye-slash',
			fieldTypePaswordConfirm: 'password',
			iconPasswordConfirm: 'fa-eye-slash',
			selected: {
				rail1: null,
				rail2: null,
				rail3: null,
        rail4: null
			},
			options: {
				rail1: [],
				rail2: [],
				rail3: [],
				instansi: [],
				own: [
					{value: "Milik Sendiri", label: "Milik Sendiri"},
					{value: "Milik Instansi Pemerintah Lain", label: "Milik Instansi Pemerintah Lain"},
					{value: "Milik BUMN", label: "Milik BUMN"},
					{value: "Milik Pihak Ketiga - Dalam Negeri", label: "Milik Pihak Ketiga - Dalam Negeri"},
					{value: "Milik Pihak Ketiga - Luar Negeri", label: "Milik Pihak Ketiga - Luar Negeri"}
				],
				id_metadata: [],
        own_name2: [],
			},
      cloud_lv2 : '03.02'
		}
	},
  watch : {
    'selected.rail1':{
			handler: function(data){
				if (data) {
          this.form.rail1 = data.rail
				}
			},
		},
    'selected.rail2':{
			handler: function(data){
				if (data) {
          this.form.rail2 = data.rail
				}
			},
		},
    'selected.rail3':{
			handler: function(data){
				if (data) {
          this.form.rail3 = data.rail
          let kode_rail3 = this.convertCode(data.rail)
          this.form.rail4 = `${kode_rail3}.${this.form.opd_id} ${this.form.instansi}`
				}
			},
		},
  },
	computed: {
		isNew() {
		  return this.id === undefined ? true : false
		},
	},
	created() {
		this.isUpdate = (this.$route.params.status == 'update')?false:true

		this.form.opd_id = this.$route.params.opd_id
    this.getOwnerName()
		this.getRail1Def();
    
	},
	methods: {
    convertCode(nama) {
      return nama.split(' ')[0]
    },
		async submit() {
			let vm = this

			let { rail1, rail2, rail3, rail4, opd_id, instansi, name_gov, desc_gov, own_name, own, own_name2, own_name3, price, unit_dev, unit_opr, id_metadata } = vm.form
      let data =  {
				rail1: rail1,
				rail2: rail2,
				rail3: rail3,
        rail4: rail4,
        opd_id: opd_id,
				instansi: instansi,
				name_gov: name_gov,
				desc_gov: desc_gov,
				own_name: own_name,
        own_name2: own_name2 ? own_name2.akronim : null,
        own_name3: own_name3 ? own_name3.akronim : null,
				own: own ? own.value : null,
				price: price,
				unit_dev: unit_dev,
				unit_opr: unit_opr,
				id_metadata: id_metadata ? this.form.id_metadata: null,
        selectedWaktu: this.form.selectedWaktu,
				selectDateFrom: this.form.selectDateFrom,
				selectDateFromLast: this.form.selectDateFromLast,
			}
			let mode = this.isNew ? 'add' : 'edit'
			let formData = this.$app.objectToFormData(data)
			if (!this.isNew) {
				formData.append('_method', 'GET')
			}
			let url = vm.$app.route(this.isNew ? `domain-infrastruktur-cloud.store` : `${this.routeName}.update`, { id: this.id })
			vm.$app.confirm({
				text: vm.$t(`domain.alert_cloud.confirm.${mode}`),
				preConfirm: () => {
				return vm.$http.post(url, formData)
					.then(response => {
					if (response.data.status == "error") {
						let errors = response.data.message
						throw new Error(response.data.message)
					} else {
						return response
					}
					})
					.catch(error => {
					vm.$app.alert.showValidationMessage(error)
					})
				}
			}).then(result => {
				if (result.isDismissed) return
				if (result.value.data.status == "success" || result.value.data.status == "info") {
					vm.$app.alert.fire({
            icon: result.value.data.status,
            title: result.value.data.status ? 'Sukses' : 'Info',
            text: result.value.data.message,
            showConfirmButton: false,
            timer: 1300
          })
          .then(response => {
            vm.$bvModal.hide(vm.modal)
            this.$router.push({ name: 'domaininfrastrukturcloud', params:{
              'opd_id' : this.$route.params.opd_id
            }})
          })
				}
			})
		},
    async getRail1Def() {
      const res = await this.$http.get(this.$app.route('domain-infrastruktur-cloud.get_rail1'))
      let result = res.data.data[0]
      this.$set(this.selected, 'rail1', result)
		  this.getRail2Def();
    },
    async getRail2Def() {
      const res = await this.$http.get(this.$app.route('domain-infrastruktur-cloud.get_rail2'))
      let result = res.data.data[0]
      this.$set(this.selected, 'rail2', result)

      let kode_lv2 = result ? result.rail.split(' ')[0] : this.cloud_lv2
      this.getRail3Def(kode_lv2)
    },
    async getRail3Def(kode) {
      const res = await this.$http.get(this.$app.route('domain-infrastruktur-cloud.get_rail3', {rail3: kode}))
      let result = res.data.data
      this.options.rail3 = result
    },
    getOwnerName(){
			let vm = this
      vm.groupLoading = true
      vm.$http.get(vm.$app.route('sistem-penghubung-layanan-pemerintah.get_owner'), {
        params: {opd_id : this.$route.params.opd_id}
      }).then(response => {
        const own3Option = [];
        response.data.map(function (value, key) {
          own3Option.push({ value: [value.opd_id, value.akronim], akronim: value.akronim });
        });
        own3Option.push({ value: ['Lainnya', 'Lainnya'], akronim: 'Lainnya'});
        vm.options.own_name3 = own3Option
        this.getMilikOPD()
      })
		},
    async getMilikOPD() {
      let vm = this
      vm.groupLoading = true
      vm.$http.get(vm.$app.route('domain-infrastruktur-cloud.data-perangkat-daerah.get'), {
        params: {opd_id : this.$route.params.opd_id}
      }).then(response => {
        const own2Option = [];
        response.data.map(function (value, key) {
          own2Option.push({ value: [value.opd_id, value.akronim], akronim: value.akronim });
        });
        vm.options.own_name2 = own2Option
        this.resMilikOPD()
      })
    },
    async resMilikOPD() {
	    const res = await this.$http.get(this.$app.route('perangkat-jaringan.data-perangkat-daerah.get', {opd_id : this.$route.params.opd_id}))
      let result = res.data[0]
      let instansi = _.find(this.options.own_name2, function(o) { return o.akronim = result['akronim'] ; })
      this.$set(this.form, 'own_name2', instansi)
      this.$set(this.form, 'instansi', instansi.akronim)

      this.getIdMetadataTerkait()
    },
    getIdMetadataTerkait(){
			let vm = this
			vm.groupLoading = true
			vm.$http.get(vm.$app.route('fasilitas.get-data-by.get'), {
				params: {col: 'domain_code'}
			}).then(response => {
				vm.options['id_metadata'] = response.data
        if(this.$route.params.status === 'update'){
          this.loadDataCloud();
        }
			})
		},
		async loadDataCloud(){
			const res = await this.$http.get(this.$app.route('domain-infrastruktur-cloud.data-infrastruktur-cloud.get', {id: this.id}))
			let result = res.data[0]
			this.model = result

      if (this.options.rail3.length == 0) {
        this.getRail3Def(result.rai_level_3).then(() => {
          this.selected.rail3 = this.options.rail3.find((o) => o.rail.split(' ')[0] == this.model.rai_level_3)
        })
      } else {
        this.selected.rail3 = this.options.rail3.find((o) => o.rail.split(' ')[0] == this.model.rai_level_3)
      }

      this.form.instansi = result.instansi

			this.form.id = result.id
			this.form.name_gov = result.nama
			this.form.desc_gov = result.deskripsi

      if(result['status_ownership'] === 'Milik Sendiri'){
        let own_name2 = _.find(this.options.own_name2, function(o) { return o.akronim = result['nama_owner'] ; })
        this.form.own_name2 = own_name2
      }else{
        if(result['status_ownership'] === 'Milik Instansi Pemerintah Lain'){
          let own_name3 = _.find(this.options.own_name3, function(o) { return o.akronim = result['nama_owner'] ; })
          this.form.own_name3 = own_name3
        }else{
          this.form.own_name = result.nama_owner
        }
      }

			let txt3 = 'status_ownership'
			let own 		= this.options.own.find(data => data.label ===  result[txt3])
			this.form.own 	= own

			this.form.own_name = result.nama_owner
			this.form.price = result.biaya
			this.form.unit_dev = result.unit_dev
			this.form.unit_opr = result.unit_oper
      if(result['jangka_waktu'] != 'Selamanya'){
        this.form.selectedWaktu = 'RentangWaktu'
				let selectedDate = result.jangka_waktu.split(' s/d ')
				this.form.selectDateFrom = this.$moment(selectedDate[0], 'MMM-yyyy').format('MMMM yyyy')
				this.form.selectDateFromLast = this.$moment(selectedDate[1], 'MMM-yyyy').format('MMMM yyyy')

      }else{
        this.form.selectedWaktu = result.jangka_waktu
      }

      this.getIDMetadataKomputasi(result.id)
		},
    async getIDMetadataKomputasi(id){
			const res = await this.$http.get(this.$app.route('domain-infrastruktur-cloud.get_metadata', {id: id}))
      let result = res.data

      let domain_fasilitas_arr = result.map(val => val.kode_nama)
      
      this.form.id_metadata = this.options.id_metadata.filter((val) => {
        return domain_fasilitas_arr.includes(val.kode_nama)
      })
		},
    fasilitasName({kode, nama}) {
			return `${kode} - ${nama}`
		},
	}
}
</script>

<style lang="scss">
@import '~@syncfusion/ej2-base/styles/bootstrap4.css';
@import "~@syncfusion/ej2-buttons/styles/bootstrap4.css";
@import "~@syncfusion/ej2-vue-navigations/styles/bootstrap4.css";

#tree-feature {
  margin-left: -1rem;
  margin-right: -1rem;
  font-family: "Poppins", sans-serif;

  .e-list-text {
    font-size: 13px;
  }
}
</style>
<style>
.control_wrapper {
  display: block;
  max-width: 350px;
  max-height: 350px;
  margin: auto;
  overflow: auto;
  border: 1px solid #dddddd;
  border-radius: 3px;
}

.radius_icon_password {
  border-radius: 0px 4px 4px 0px !important;
}

.custom-checkbox {
  width: 300px;
  padding-top: 7px;
  padding-bottom: 12px;
}

.custom-radio {
  padding-top: 5px;
}

.multiselect {
  width: 100% !important;
}

.multiselect__tag {
  padding: 7px 26px 7px 11px !important;
  margin: 3px 4px !important;
}

.disabled-nrk {
  background: #f3f3f3 !important;
}
</style>
