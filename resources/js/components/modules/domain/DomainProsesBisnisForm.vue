<template>
  <b-card class="p-3">
    <section class="user">
      <div class="col-9">
        <ul class="nav nav-tabs nav-fill" role="tablist" style="margin-left: 4px; margin-right: 15px;">
          <li class="nav-item col-3"><a class="nav-link active" data-toggle="tab" href="#tab_justified-1" role="tab">ProsesBisnis</a>
            </li>
            <li class="nav-item col-5"><a class="nav-link" data-toggle="tab" href="#tab_justified-2" role="tab">Referensi Kepmendagri 50/2020</a>
            </li>
            <li class="nav-item col-4"><a class="nav-link" data-toggle="tab" href="#tab_justified-3" role="tab">Referensi Tupoksi</a>
            </li>
        </ul>
      </div>
      <div class="tab-content p-3">
        <div class=" tab-pane fade show active" id="tab_justified-1" role="tabpanel">
          <validation-observer v-slot="{ passes }" :slim="true">
            <form @submit.prevent="passes(submit)">
              <template>
                <div class="col-9">
                  <b-form-group
                    label-for="proses_id"
                    label="Proses ID"
                    v-show="false">
                      <b-form-input
                        :id="'proses_id'"
                        v-model="model.proses_id"
                        placeholder="Proses ID"
                        :readonly="true">
                      </b-form-input>
                  </b-form-group>

                  <b-form-group label-for="unit" :label="$t('domain.form.field.unit.label')">
                    <input v-model="form.unit" type="hidden">
                    <ValidationProvider
                      rules="required" v-slot="{ valid, errors }"
                      :name="$t('domain.form.field.unit.label')" :debounce="250">
                      <m-select
                        id="unit" v-model="form.unit" :options="options.unit" :multiple="false"
                        :close-on-select="true" :clear-on-select="false" :preserve-search="true" :preselect-first="true"
                        :placeholder="$t('domain.form.field.unit.placeholder')" label="label" track-by="value"
                        :searchable="true" :state="errors[0] ? false : (valid ? true : null)"
                        :disabled="true">
                      </m-select>
                      <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
                    </ValidationProvider>
                  </b-form-group>

                  <b-form-group label-for="rabl1" :label="$t('domain.form.field.rabl1.label')">
                    <input v-model="selected.rabl1" type="hidden">
                    <ValidationProvider
                      rules="required" v-slot="{ valid, errors }"
                      :name="$t('domain.form.field.rabl1.label')" :debounce="250">
                      <m-select
                        id="rabl1" v-model="selected.rabl1" :options="options.rabl1" :multiple="false"
                        :close-on-select="true" :clear-on-select="false" :preserve-search="true" :preselect-first="true"
                        :placeholder="$t('domain.form.field.rabl1.placeholder')" label="rabl" track-by="key" @input="onChange2"
                        :searchable="true" :state="errors[0] ? false : (valid ? true : null)"
                        >
                      </m-select>
                      <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
                    </ValidationProvider>
                  </b-form-group>

                  <b-form-group label-for="rabl_2" :label="$t('domain.form.field.rabl2.label')">
                    <input v-model="selected.rabl_2" type="hidden">
                    <ValidationProvider
                      rules="required" v-slot="{ valid, errors }"
                      :name="$t('domain.form.field.rabl2.label')" :debounce="250">
                      <m-select
                        id="rabl_2" v-model="selected.rabl_2" :options="options.rabl_2" :multiple="false"
                        :close-on-select="true" :clear-on-select="false" :preserve-search="true" :preselect-first="true"
                        :placeholder="$t('domain.form.field.rabl2.placeholder')" label="rabl" track-by="rabl" @input="onChange3"
                        :searchable="true" :state="errors[0] ? false : (valid ? true : null)">
                      </m-select>
                      <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
                    </ValidationProvider>
                  </b-form-group>

                  <b-form-group label-for="rabl_3" :label="$t('domain.form.field.rabl3.label')">
                    <input v-model="selected.rabl_3" type="hidden">
                    <ValidationProvider
                      rules="required" v-slot="{ valid, errors }"
                      :name="$t('domain.form.field.rabl3.label')" :debounce="250">
                      <m-select
                        id="rabl_3" v-model="selected.rabl_3" :options="options.rabl_3" :multiple="false"
                        :close-on-select="true" :clear-on-select="false" :preserve-search="true" :preselect-first="false"
                        :placeholder="$t('domain.form.field.rabl3.placeholder')" label="rabl" track-by="rabl"
                        :searchable="true" :state="errors[0] ? false : (valid ? true : null)">
                      </m-select>
                      <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
                    </ValidationProvider>
                  </b-form-group>

                  <b-form-group label-for="program" :label="'Program'">
                    <input v-model="selected.program" type="hidden">
                    <ValidationProvider
                      rules="required" v-slot="{ valid, errors }"
                      :name="'Program'" :debounce="250">
                      <m-select
                        id="program" v-model="selected.program" :options="options.program" :multiple="false"
                        :close-on-select="true" :clear-on-select="false" :preserve-search="true" :preselect-first="false"
                        :placeholder="'Program'" label="program" track-by="program" @input="onChange" :disabled="!isUpdate"
                        :searchable="true" :state="errors[0] ? false : (valid ? true : null)">
                      </m-select>
                      <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
                    </ValidationProvider>
                  </b-form-group>

                  <b-form-group label-for="rabl_4" :label="$t('domain.form.field.rabl4.label')">
                    <input v-model="selected.rabl_4" type="hidden">
                    <ValidationProvider
                      rules="required" v-slot="{ valid, errors }"
                      :name="$t('domain.form.field.rabl4.label')" :debounce="250">
                      <m-select
                        id="rabl_4" v-model="selected.rabl_4" :options="options.rabl_4" :multiple="false"
                        :close-on-select="true" :clear-on-select="false" :preserve-search="true" :preselect-first="false"
                        :placeholder="$t('domain.form.field.rabl4.placeholder')" label="rabl" track-by="rabl"
                        :searchable="true" :state="errors[0] ? false : (valid ? true : null)" :disabled="!isUpdate">
                      </m-select>
                      <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
                    </ValidationProvider>
                  </b-form-group>

                  <b-form-group label-for="tupoksi" :label="$t('domain.form.field.uraian.label')">
                    <input v-model="form.tupoksi" type="hidden">
                    <ValidationProvider
                      rules="required" v-slot="{ valid, errors }"
                      :name="$t('domain.form.field.uraian.label')" :debounce="250">
                      <m-select
                        id="tupoksi" v-model="form.tupoksi" :options="options.tupoksi" :multiple="true"
                        :args-route="{'opd_id': $route.params.opd_id}"
                        :close-on-select="false" :clear-on-select="false" :preserve-search="true" :preselect-first="true"
                        :placeholder="$t('domain.form.field.uraian.placeholder')" label="tupoksi" track-by="tupoksi"
                        :searchable="true" :state="errors[0] ? false : (valid ? true : null)">
                      </m-select>
                      <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
                    </ValidationProvider>
                  </b-form-group>
                  <div class="text-right mt-4 pt-3">
                    <b-button type="submit" variant="primary">
                      {{ $t('general.form.button_add') }}
                    </b-button>
                    <b-button ref="closebtn" variant="default" @click="onCancel">
                      {{ $t('general.form.button_cancel') }}
                    </b-button>
                  </div>
                </div>
              </template>
            </form>
          </validation-observer>
        </div>
        <div class="tab-pane fade" id="tab_justified-2" role="tabpanel" style="margin-top: -15px">
          <div class="col-12">
              <div class="panel" style="margin-left: -15px; margin-right: -15px">
                <div class="col-12">
                  <template>
                    <b-form-group
                      label-cols="2"
                      label-cols-lg="2"
                      label-for="kewenangan"
                      label="Tingkat Kewenangan">
                        <m-select
                          id="kewenangan"
                          ref="kewenangan"
                          class="col-4"
                          :option-height="73"
                          :placeholder="'--pilih tingkat--'"
                          :tabindex="7"
                          :options="optionsKewenangan"
                          v-model="model.kewenangan"
                          @input="changeKewenangan"
                          select-label=""
                          selected-label=""
                          deselect-label=""
                          label="label"
                          value="value"
                          :searchable="true"
                          :limit="100"
                          :options-limit="100"
                          :disabled="!opdUnique"
                        >

                          <template #noOptions>
                            Tidak ada data
                          </template>
                          <template #noResult>
                            Data tidak ditemukan
                          </template>

                          <template #option="{ option }">
                            <div class="d-flex align-items-baseline mb-1">
                              <i class="fal fa-laptop mr-2"></i>
                              <span class="text-wrap">{{ option.label }}</span>
                            </div>
                          </template>
                        </m-select>
                    </b-form-group>
                  </template>
                </div>
              </div>
            </div>
          <data-tables
              id="refkemendagri_table" :fields="fields2"
              api-url="ref-kemendagri.get" :args-route="{'is_provinsi': is_provinsi ? is_provinsi : null}" :title="$t('domain.datatable.title.t_ref_mendagri')"
              actions="S" row-action-width="10%">
            </data-tables>
        </div>
        <div class="tab-pane fade" id="tab_justified-3" role="tabpanel" style="margin-top: -15px">
          <data-tables
            id="usertable" :fields="fields3"
            :args-route="{'opd_id': $route.params.opd_id}"
            api-url="ref-tupoksi.get"
            :title="$t('domain.datatable.title.t_tupoksi')"
            actions="S"
            row-action-width="10%">
          </data-tables>
        </div>
      </div>
    </section>
  </b-card>
</template>

<script>
export default {
  name: 'DomainProsesBisnisForm',
  props: {
    id: null,
    props: ['proses_id', 'opd_id', 'status'],
  },
  data() {
    let resourceName = 'domain-proses';
    return {
      show: true,
      title: '',
      querySearch: '',
      rulesForPassword: '',
      rulesForPasswordConfirmed: '',
      resourceName: resourceName,
      routeName: `${resourceName}`,
      model: {
        proses_id : null,
      },
      fields: {
        id: 'id',
        parentID: 'parent_id',
        text: 'name',
        hasChildren: 'hasChild',
        dataSource: null,
      },
      fields2: [
        {
          key: 'urusan',
          label: this.$t('domain.datatable.column.v_ref_urus'),
          sortable: true,
        },
        {
          key: 'bid_urusan',
          label: this.$t('domain.datatable.column.v_ref_bidang'),
          sortable: true,
        },
        {
          key: 'program',
          label: this.$t('domain.datatable.column.v_ref_prog'), //INI lihatnya di js>lang
          sortable: true,
        },
        {
          key: 'kegiatan',
          label: this.$t('domain.datatable.column.v_ref_keg'),
          sortable: true,
        },
        {
          key: 'sub_kegiatan',
          label: this.$t('domain.datatable.column.v_ref_sub_keg'),
          sortable: true,
        },
        {
          key: 'nomenklatur_urusan',
          label: this.$t('domain.datatable.column.v_ref_nomenklatur'),
          sortable: true,
        },
        {
          key: 'kinerja',
          label: this.$t('domain.datatable.column.v_ref_kin'),
          sortable: true,
        },
        {
          key: 'indikator',
          label: this.$t('domain.datatable.column.v_ref_indikator'),
          sortable: true,
        },
        {
          key: 'satuan',
          label: this.$t('domain.datatable.column.v_ref_satuan'),
          sortable: true,
        }
      ],
      fields3: [
        {
          key: 'id_entitas',
          label: this.$t('domain.datatable.column.v_tup_id_entitas'),
          sortable: true,
        },
        {
          key: 'nama_unit',
          label: 'Nama Bidang/UPT',
          sortable: true,
        },
        {
          key: 'nama_opd',
          label: this.$t('domain.datatable.column.v_tup_nama_opd'),
          sortable: true,
        },
        {
          key: 'tupoksi',
          label: this.$t('domain.datatable.column.v_tup_tupoksi'),
          sortable: true,
        },
        {
          key: 'tupoksi_desc',
          label: this.$t('domain.datatable.column.v_tup_des'),
          sortable: true,
        },
      ],
      checkedNodes: [],
      form: {
        unit: null,
        selected: null
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
        rabl1: null,
        rabl_2: null,
        rabl_3: null,
        program: null,
        rabl_4: null,
      },
      options: {
        rabl1: [],
        rabl_2: [],
        rabl_3: [],
        program: [],
        rabl_4: [],
        unit: [],
        tupoksi: []
      },
      optionsKewenangan:[
        { value: 'provinsi', label: 'Kewenangan Tingkat Provinsi' },
        { value: 'kota', label: 'Kewenangan Tingkat Kota' }
      ],
      model:{
				kewenangan: []
			},
    }
  },
  computed: {
    isNew() {
      return this.$route.params.proses_id === undefined ? true : false
    }
  },
  watch: {
		'model.rabl4':{
			handler: function(data){
				this.model.opd_id 		= data.opd_id
				this.model.unit_kerja 	= data.nama_opd
				this.resRal('',1).then((data) =>{this.optionsRalLevel1 = data})
			},
		},
	},
  created() {
    this.is_provinsi = this.opd_id == 'O46' || this.opd_id == 'O51' ? '1' : this.$app.user.is_admin ? '2' : '0'
    this.isUpdate = (this.$route.params.status == 'update')?false:true
    this.changeOPD();
    this.getRabl(1);
    this.getRabl2();
    this.getRabl3();
    this.getRabl4();
    this.getUnit();
    this.getProgram();
  },
  methods: {
    onCancel(){
      this.$router.push({ name: 'domainprosesbisnis',
      params: {
        'opd_id' : this.$route.params.opd_id
      }
      })
    },
    async submit() {
      let vm = this
      Object.keys(this.selected).forEach(key => {
        vm.form[key] = vm.selected[key].rabl
      })

      let { unit, rabl1, rabl_2, rabl_3, rabl_4, tupoksi } = vm.form
      let data =  {
        unit: unit ? unit.value : null,
        rabl1: rabl1,
        rabl_2: rabl_2,
        rabl_3: rabl_3,
        program: this.selected.program.value,
        rabl_4: rabl_4,
        tupoksi: tupoksi ? this.form.tupoksi : null,
      }
      let mode = this.isNew ? 'add' : 'edit'
      let formData = this.$app.objectToFormData(data)
      if (!this.isNew) {
        formData.append('_method', 'GET')
      }
      let url = vm.$app.route(this.isNew ? `domain-proses.store` : `${this.routeName}.update`, { proses_id: this.$route.params.proses_id })
      vm.$app.confirm({
        text: vm.$t(`domain.alert.confirm.${mode}`),
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
      })
        .then(result => {
          if (result.isDismissed) return
          if (result.value.data.status == "success") {
            vm.$app.alert.fire({
              icon: result.value.data.status,
              title: result.value.data.status ? 'Sukses' : null,
              text: result.value.data.message,
              showConfirmButton: false,
              timer: 1300
            })
            .then(response => {
              vm.$bvModal.hide(vm.modal)
              this.$router.push({ name: 'domainprosesbisnis', params: {
                'opd_id' : this.$route.params.opd_id
              }})
            })
          }else{
            vm.$app.alert.fire({
              icon: result.value.data.status,
              title: result.value.data.status == 'info' ? 'Info' : null,
              text: result.value.data.message,
              showConfirmButton: true
            })
          }
        })
    },
    changeOPD(){
      if(this.opd_id == 'O46' || this.opd_id == 'O51'){
        this.opdUnique = true
        this.model.kewenangan = this.optionsKewenangan[1]
        this.changeKewenangan();
      }else{
        this.opdUnique = false
        this.model.kewenangan = this.optionsKewenangan[0]
        this.changeKewenangan();
      }
    },
    changeKewenangan(){
      if(this.model.kewenangan.value == 'kota'){
        this.is_provinsi = '0'
      }else{
        this.is_provinsi = '1'
      }
      this.$root.$emit('bv::refresh::table', 'refkemendagri_table')
    },
    getRabl(level = 1) {
      let vm = this
      vm.groupLoading = true
      vm.$http
        .get(vm.$app.route('domain-proses.get_rabl', { level }))
        .then(({data}) => {
          vm.options[`rabl${level}`] = data.data
        })
    },
    onChange2(){
      this.getRabl2(this.selected.rabl1.rabl)
      this.selected.rabl_2 = [];
    },
    getRabl2(kode_rabl) {
      let vm = this
      vm.groupLoading = true
      vm.$http
      .get(vm.$app.route('domain-proses.get_rabl2'),{
        params: {
          'kode_rabl' : kode_rabl
        }
      })
      .then(({ data }) => {
        vm.options['rabl_2'] = data.data
      })
    },
    onChange3(){
      this.getRabl3(this.selected.rabl_2.rabl)
      this.selected.rabl_3 = [];
    },
    getRabl3(kode_rabl) {
      let vm = this
      vm.groupLoading = true
      vm.$http
        .get(vm.$app.route('domain-proses.get_rabl3'),{
          params: {
            'kode_rabl' : kode_rabl
          }
        })
        .then(({ data }) => {
          vm.options['rabl_3'] = data.data
        })
    },
    getProgram(kode_rabl) {
      let vm = this
      vm.groupLoading = true
      vm.$http
        .get(vm.$app.route('domain-proses.get_program'),{
          params: {
            'kode_rabl' : kode_rabl,
            'opd_id' : this.$route.params.opd_id
          }
        })
        .then(response  => {
          const programOption = [];
          response.data.map(function (value, key) {
            programOption.push({ value: value.kode_rabl, program: value.is_provinsi == 1 ? 'Tingkat Provinsi - ' + value.kode_rabl + ' ' + value.program : 'Tingkat Kota - ' + value.kode_rabl + ' ' + value.program});
          });
          vm.options['program'] = programOption
        })
    },
    onChange(){
      this.getRabl4(this.selected.program.value)
      this.selected.rabl_4 = [];
    },
    getRabl4(kode_rabl) {
      let vm = this
      vm.groupLoading = true
      vm.$http
        .get(vm.$app.route('domain-proses.get_rabl4'),{
          params: {
            'kode_rabl' : kode_rabl,
            'opd_id' : this.$route.params.opd_id
          }
        })
        .then(response  => {
          const rabl4Option = [];
          response.data.map(function (value, key) {
            rabl4Option.push({ value: value.kode_rabl, rabl: value.is_provinsi == 1 ? 'Tingkat Provinsi - ' + value.kode_rabl + ' ' + value.rabl4 : 'Tingkat Kota - ' + value.kode_rabl + ' ' + value.rabl4});
          });
          vm.options['rabl_4'] = rabl4Option
        })
    },
    getUnit(){
      let vm = this
      vm.groupLoading = true
      vm.$http
        .get(vm.$app.route('domain.data-perangkat-daerah.get', {opd_id: this.$route.params.opd_id}), {
          params: {
            'opd_id' : this.opd_id
          }
        })
        .then(response => {
          const unitOption = [];
          response.data.map(function (value, key) {
            unitOption.push({ value: [value.opd_id, value.nama_opd], label: value.nama_opd });
          });
          this.form.unit = unitOption[0];
          vm.options['unit'] = unitOption
          this.getTupoksi();
        })
    },
    getTupoksi() {
      let vm = this
      vm.groupLoading = true
      vm.$http
      .get(vm.$app.route('ref-tupoksi.get_option'), {
        params: {
          'opd_id' : this.$route.params.opd_id
        }
      })
      .then(response => {
        const tupoksiOption = [];
        response.data.map(function (value, key) {
          tupoksiOption.push({ value: value.tu_ref, tupoksi: value.nama_unit ? value.nama_unit + ' - ' + value.tupoksi : 'Tingkat Biro/Badan/Dinas - ' + value.tupoksi });
        });
        vm.options['tupoksi'] = tupoksiOption
        if(this.$route.params.status == 'update'){
          this.fetchUrusan();
        }
      })
    },
    async fetchUrusan(){
			const res = await this.$http.get(this.$app.route('domain-proses.get_urusan', {proses_id: this.$route.params.proses_id}))
      let result = res.data.data
      let urusan_id = [];

      result.map(function (value, key) {
        urusan_id.push({ tupoksi: value.tupoksi, value: value.tu_ref });
      });

      this.form.tupoksi = urusan_id
      this.resProsesBisnis()
		},
    async resProsesBisnis(){
			const res = await this.$http.get(this.$app.route('domain-proses.data-proses-bisnis.get', {proses_id: this.$route.params.proses_id}))

      let result = res.data.data[0]
      let txt0 = 'nama_opd'
      let unit = _.find(this.options.unit, function(o) { return o.label = result[txt0] ; })
      this.form.unit = unit
      this.model.proses_id = result.proses_id
      Object.entries(this.selected).forEach((val, key) => {
        let txt = `rab_level${key+1}`
        let rabl 		= this.options[val[0]].find(data => data.rabl ===  result[txt])
				this.selected[val[0]] = rabl
      })
      if(result.is_provinsi == '1'){
        let txt1 = 'program'
        let program = _.find(this.options.program, function(o) { return o.program = 'Tingkat Provinsi - ' + result[txt1] ; })
        this.selected.program = program
        let txt2 = 'rab_level4'
        let rabl4 = _.find(this.options.rabl_4, function(o) { return o.rabl = 'Tingkat Provinsi - ' + result[txt2] ; })
        this.selected.rabl_4 = rabl4
      }else{
        let txt1 = 'program'
        let program = _.find(this.options.program, function(o) { return o.program = 'Tingkat Kota - ' + result[txt1] ; })
        this.selected.program = program
        let txt2 = 'rab_level4'
        let rabl4 = _.find(this.options.rabl_4, function(o) { return o.rabl = 'Tingkat Kota - ' + result[txt2] ; })
        let final = rabl4.rabl
        this.selected.rabl_4 = rabl4
      }
		},
  }
}
</script>

<style lang="scss">

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
