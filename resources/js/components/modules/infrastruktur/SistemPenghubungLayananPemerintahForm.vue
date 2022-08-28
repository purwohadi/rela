<template>
  <b-card class="p-3">
    <section class="user">
      <div class="col-6">
        <validation-observer v-slot="{ passes }" :slim="true">
          <form @submit.prevent="passes(submit)">
            <template>

              <b-form-group label-for="rail1" :label="$t('domain.form.field.rail1.label')">
                <input v-model="selected.rail1" type="hidden">
                <ValidationProvider
                  rules="required" v-slot="{ valid, errors }"
                  :name="$t('domain.form.field.rail1.label')" :debounce="250">
                  <m-select
                    id="rail1" v-model="selected.rail1" :options="options.rail1" :multiple="false"
                    :close-on-select="true" :clear-on-select="false" :preserve-search="true" :preselect-first="true"
                    :placeholder="$t('domain.form.field.rail1.placeholder')" label="rail" track-by="key"
                    :searchable="true" :state="errors[0] ? false : (valid ? true : null)" :disabled="true">
                  </m-select>
                  <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
                </ValidationProvider>
              </b-form-group>

              <b-form-group label-for="rail2" :label="$t('domain.form.field.rail2.label')">
                <input v-model="selected.rail2" type="hidden">
                <ValidationProvider
                  rules="required" v-slot="{ valid, errors }"
                  :name="$t('domain.form.field.rail2.label')" :debounce="250">
                  <m-select
                    id="rail2" v-model="selected.rail2" :options="options.rail2" :multiple="false"
                    :close-on-select="true" :clear-on-select="false" :preserve-search="true" :preselect-first="true"
                    :placeholder="$t('domain.form.field.rail2.placeholder')" label="rail" track-by="key"
                    :searchable="true" :state="errors[0] ? false : (valid ? true : null)" :disabled="true">
                  </m-select>
                  <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
                </ValidationProvider>
              </b-form-group>

              <b-form-group label-for="rail3" :label="$t('domain.form.field.rail3.label')">
                <input v-model="selected.rail3" type="hidden">
                <ValidationProvider
                  rules="required" v-slot="{ valid, errors }"
                  :name="$t('domain.form.field.rail3.label')" :debounce="250">
                  <m-select
                    id="rail3" v-model="selected.rail3" :options="options.rail3" :multiple="false"
                    :close-on-select="true" :clear-on-select="false" :preserve-search="true" :preselect-first="true"
                    :placeholder="$t('domain.form.field.rail3.placeholder')" label="rail" track-by="key" @input="onChange"
                    :searchable="true" :state="errors[0] ? false : (valid ? true : null)">
                  </m-select>
                  <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
                </ValidationProvider>
              </b-form-group>

              <b-form-group label-for="rail4" :label="$t('domain.form.field.rail4.label')">
                <input v-model="selected.rail4" type="hidden">
                <ValidationProvider
                  rules="required" v-slot="{ valid, errors }"
                  :name="$t('domain.form.field.rail4.label')" :debounce="250">
                  <m-select
                    id="rail4" v-model="selected.rail4" :options="options.rail4" :multiple="false"
                    :close-on-select="true" :clear-on-select="false" :preserve-search="true" :preselect-first="true"
                    :placeholder="$t('domain.form.field.rail4.placeholder')" label="rail" track-by="key"
                    :searchable="true" :state="errors[0] ? false : (valid ? true : null)">
                  </m-select>
                  <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
                </ValidationProvider>
              </b-form-group>

              <b-form-group
                label-for="name_splp"
                :label="$t('infrastruktur.form.field.name_splp.label')">
                <ValidationProvider
                  rules="required" v-slot="{ errors }"
                  :name="$t('infrastruktur.form.field.name_splp.label')" :debounce="250">
                  <b-form-input
                    :id="'name_splp'"
                    v-model="form.name_splp"
                    :placeholder="'Contoh: SPLD Data peta corona untuk aplikasi KSBB'">
                  </b-form-input>
                  <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
                </ValidationProvider>
              </b-form-group>

              <b-form-group label-for="instansi" :label="$t('domain.form.field.instansi.label')" v-show="isAdmin">
                <input v-model="form.instansi" type="hidden">
                <ValidationProvider
                  rules="required" v-slot="{ valid, errors }"
                  :name="$t('domain.form.field.instansi.label')" :debounce="250">
                  <m-select
                    id="instansi" v-model="form.instansi" :disabled="true" :options="options.instansi" :multiple="false"
                    :close-on-select="true" :clear-on-select="false" :preserve-search="true" :preselect-first="true"
                    :placeholder="$t('domain.form.field.instansi.placeholder')" label="akronim" track-by="value"
                    :searchable="true" :state="errors[0] ? false : (valid ? true : null)">
                  </m-select>
                  <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
                </ValidationProvider>
              </b-form-group>

              <b-form-group
                label-for="desc_splp"
                :label="$t('infrastruktur.form.field.desc_splp.label')">
                <ValidationProvider
                  rules="required" v-slot="{ errors }"
                  :name="$t('infrastruktur.form.field.desc_splp.label')" :debounce="250">
                  <b-form-textarea
                    :id="'desc_splp'"
                    v-model="form.desc_splp"
                    rows="3"
                    max-rows="6"
                    :placeholder="$t('infrastruktur.form.field.desc_splp.placeholder')">
                  </b-form-textarea>
                  <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
                </ValidationProvider>
              </b-form-group>

              <b-form-group label-for="own" :label="$t('infrastruktur.form.field.own.label')">
                <input v-model="form.own" type="hidden">
                <ValidationProvider
                  rules="required" v-slot="{ valid, errors }"
                  :name="$t('infrastruktur.form.field.own.label')" :debounce="250">
                  <m-select
                    id="own" v-model="form.own" :options="options.own" :multiple="false"
                    :close-on-select="true" :clear-on-select="false" :preserve-search="true" :preselect-first="true"
                    :placeholder="$t('infrastruktur.form.field.own.placeholder')" label="label" track-by="value"
                    :searchable="true" :state="errors[0] ? false : (valid ? true : null)">
                  </m-select>
                  <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
                </ValidationProvider>
              </b-form-group>

              <div v-if="form.own === null">
              </div>
              <div v-else>
                <span v-if="form.own.label === 'Milik Sendiri'">
                  <b-form-group label-for="own_name2" :label="$t('domain.form.field.own_name.label')">
                    <input v-model="form.own_name2" type="hidden">
                    <ValidationProvider
                      rules="required" v-slot="{ valid, errors }"
                      :name="$t('domain.form.field.own_name.label')" :debounce="250">
                      <m-select
                        id="own_name2" v-model="form.own_name2" :disabled="true" :options="options.own_name2" :multiple="false"
                        :close-on-select="true" :clear-on-select="false" :preserve-search="true" :preselect-first="true"
                        :placeholder="$t('domain.form.field.own_name.placeholder')" label="akronim" track-by="value"
                        :searchable="true" :state="errors[0] ? false : (valid ? true : null)">
                      </m-select>
                      <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
                    </ValidationProvider>
                  </b-form-group>
                </span>
                <span v-else>
                  <span v-if="form.own.label === 'Milik Instansi Pemerintah Lain'">
                    <b-form-group label-for="own_name3" :label="$t('domain.form.field.own_name.label')">
                      <input v-model="form.own_name3" type="hidden">
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

              <div v-if="form.own_name3 === null">
              </div>
              <div v-else>
                <div v-if="form.own_name3.akronim === 'Lainnya'">
                  <b-form-group
                      label-for="own_name4"
                      :label="'Nama Pemilik Lainnya'">
                      <ValidationProvider
                        rules="required" v-slot="{errors }"
                        :name="'Nama Pemilik Lainnya'" :debounce="250">
                        <b-form-input
                          :id="'own_name4'"
                          v-model="form.own_name4"
                          :placeholder="'Nama Pemilik Lainnya'">
                        </b-form-input>
                        <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
                      </ValidationProvider>
                    </b-form-group>
                </div>
                <br>
              </div>

              <b-form-group
                label-for="app_connect"
                :label="$t('infrastruktur.form.field.app_connect.label')">
                <ValidationProvider
                  rules="required" v-slot="{ valid, errors }"
                  :name="$t('infrastruktur.form.field.app_connect.label')" :debounce="250">
                  <m-select
                    id="app_connect" v-model="form.app_connect" :options="options.app_connect" :multiple="false"
                    :close-on-select="true" :clear-on-select="false" :preserve-search="true" :preselect-first="true"
                    :placeholder="$t('infrastruktur.form.field.app_connect.placeholder')" label="label" track-by="label"
                    :searchable="true" :state="errors[0] ? false : (valid ? true : null)">
                  </m-select>
                  <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
                </ValidationProvider>
              </b-form-group>

              <b-form-group
                label-for="app_connected"
                :label="$t('infrastruktur.form.field.app_connected.label')">
                <ValidationProvider
                  rules="required" v-slot="{ valid, errors }"
                  :name="$t('infrastruktur.form.field.app_connected.label')" :debounce="250">
                  <m-select
                    id="app_connected" v-model="form.app_connected" :options="options.app_connected" :multiple="false"
                    :close-on-select="true" :clear-on-select="false" :preserve-search="true" :preselect-first="true"
                    :placeholder="$t('infrastruktur.form.field.app_connected.placeholder')" label="label" track-by="label"
                    :searchable="true" :state="errors[0] ? false : (valid ? true : null)">
                  </m-select>
                  <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
                </ValidationProvider>
              </b-form-group>

              <b-form-group label-for="id_metadata" :label="$t('infrastruktur.form.field.id_metadata.label')">
                <input v-model="form.id_metadata" type="hidden">
                <ValidationProvider
                  rules="required" v-slot="{ valid, errors }"
                  :name="$t('infrastruktur.form.field.id_metadata.label')" :debounce="250">
                  <m-select
                    id="id_metadata" v-model="form.id_metadata" :options="options.id_metadata" :multiple="true"
                    :close-on-select="false" :clear-on-select="false" :preserve-search="true" :preselect-first="true"
                    :placeholder="$t('infrastruktur.form.field.id_metadata.placeholder')" label="id_metadata" track-by="id_metadata"
                    :searchable="true" :state="errors[0] ? false : (valid ? true : null)">
                  </m-select>
                  <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
                </ValidationProvider>
              <span>*ID Metadata dapat diisi lebih dari 1</span>
              </b-form-group>

            </template>

            <div class="text-right mt-4 pt-3">
              <b-button type="submit" variant="primary">
                {{ $t('general.form.button_add') }}
              </b-button>
              <b-button ref="closebtn" variant="default" @click="onCancel">
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
  name: 'SistemPenghubungLayananPemerintahForm',
  props: {
    id: null,
    props: ['id', 'status']
  },
  data() {
    let resourceName = 'sistem-penghubung-layanan-pemerintah';
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
      fields: {
        id: 'id',
        parentID: 'parent_id',
        text: 'name',
        hasChildren: 'hasChild',
        dataSource: null,
      },
      checkedNodes: [],
      form: {
        selected: null,
        type: null,
        own: null,
        own_name: null,
        own_name2: null,
        own_name3: null,
        own_name4: null,
        name_splp: null,
        desc_splp: null,
        instansi: null,
        id_metadata: null,
        app_connect: null,
        app_connected: null,
        jip_name: null,
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
        rail4: null,
      },
      options: {
        rail1: [],
        rail2: [],
        rail3: [],
        rail4: [],
        // jenis: [],
        own: [],
        instansi: [],
        // jip_name: [],
        app_connect: [],
        app_connected: [],
        id_metadata: [],
      },
    }
  },
  computed: {
    isNew() {
      return this.id === undefined ? true : false
    }
  },
  watch: {
	},
  created() {
    this.isUpdate = (this.$route.params.status == 'update')?false:true
    this.isAdmin = this.$app.user.is_admin ? true : false
    this.getRail1();
    this.getOwner();
  },
  methods: {
    onCancel(){
      this.$router.push({ name: 'infrastruktur.sistempenghubunglayananpemerintah',
      params: {
        'opd_id' : this.$route.params.opd_id
      }
      })
    },
    async submit() {
      // console.log(this.form.own_name4);
      let vm = this
      Object.keys(this.selected).forEach(key => {
        vm.form[key] = vm.selected[key].rail
      })

      let { rail1, rail2, rail3, rail4, name_splp, desc_splp, own, own_name, own_name2, own_name3, app_connect, app_connected } = vm.form
      let data =  {
        rail1: rail1,
        rail2: rail2,
        rail3: rail3,
        rail4: rail4,
        name_splp: name_splp,
        instansi: this.form.instansi.value,
        desc_splp: desc_splp,
        own: own ? own.value : null,
        own_name: own_name,
        own_name2: own_name2 ? own_name2.akronim : null,
        own_name3: own_name3.akronim == 'Lainnya' ? this.form.own_name4 : own_name3.akronim,
        app_connect: app_connect ? app_connect.label : null,
        id_app_connect: this.form.app_connect.value ? this.form.app_connect.value : null,
        app_connected: app_connected ? app_connected.label : null,
        id_app_connected: this.form.app_connected.value ? this.form.app_connected.value : null,
        id_metadata: this.form.id_metadata
      }
      let mode = this.isNew ? 'add' : 'edit'
      let formData = this.$app.objectToFormData(data)
      if (!this.isNew) {
        formData.append('_method', 'GET')
      }
      let url = vm.$app.route(this.isNew ? `sistem-penghubung-layanan-pemerintah.store` : `${this.routeName}.update`, { id: this.id })
      vm.$app.confirm({
        text: vm.$t(`infrastruktur.alert_splp.confirm.${mode}`),
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
              this.$router.push({ name: 'infrastruktur.sistempenghubunglayananpemerintah', params: {
                'opd_id' : this.$route.params.opd_id
              }})
            })
          }
        })
    },
    getRail1() {
      let vm = this
      vm.groupLoading = true
      vm.$http
        .get(vm.$app.route('sistem-penghubung-layanan-pemerintah.get_rail1'))
        .then(({data}) => {
          vm.options['rail1'] = data.data
          this.getRail2();
        })
    },
    getRail2() {
      let vm = this
      vm.groupLoading = true
      vm.$http
        .get(vm.$app.route('sistem-penghubung-layanan-pemerintah.get_rail2'))
        .then(({data}) => {
          vm.options['rail2'] = data.data
          this.getRail1Def();
          this.getRail2Def();
          this.getRail3();
          this.getOwnerName();
        })
    },
    getRail3() {
      let vm = this
      vm.groupLoading = true
      vm.$http
        .get(vm.$app.route('sistem-penghubung-layanan-pemerintah.get_rail3'))
        .then(({data}) => {
          vm.options['rail3'] = data.data
          if(this.$route.params.status == 'update'){
            this.getRail4();
          }
        })
    },
    onChange(){
      this.getRail4(this.selected.rail3.rail)
      this.selected.rail4 = [];
    },
    getRail4(rail) {
      let vm = this
      vm.groupLoading = true
      vm.$http
        .get(vm.$app.route('sistem-penghubung-layanan-pemerintah.get_rail4'),{
          params: {
            'rail' : rail
          }
        })
        .then(({ data }) => {
          vm.options['rail4'] = data.data
        })
    },
    async getRail1Def() {
      const res = await this.$http.get(this.$app.route('sistem-penghubung-layanan-pemerintah.get_rail1'))
      let result = res.data.data[0]
      let txt = 'rail'
      let rail1 = _.find(this.options.rail1, function(o) { return o.rail = result[txt] ; })
      this.selected.rail1 = rail1
    },
    async getRail2Def() {
      const res = await this.$http.get(this.$app.route('sistem-penghubung-layanan-pemerintah.get_rail2'))
      let result = res.data.data[0]
      let txt = 'rail'
      let rail2 = _.find(this.options.rail2, function(o) { return o.rail = result[txt] ; })
      this.selected.rail2 = rail2
    },
    getOwner(){
      let vm = this
      vm.groupLoading = true
      vm.$http
        .get(vm.$app.route('owner.all'), {
          params: {
          }
        })
        .then(response => {
          const ownerOption = [];
          response.data.map(function (value, key) {
            ownerOption.push({ value: value.status_ownership, label: value.status_ownership });
          });

          vm.options['own'] = ownerOption
        })
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
      vm.$http.get(vm.$app.route('perangkat-jaringan.data-perangkat-daerah.get'), {
        params: {opd_id : this.$route.params.opd_id}
      }).then(response => {
        const own2Option = [];
        response.data.map(function (value, key) {
          own2Option.push({ value: [value.opd_id, value.akronim], akronim: value.akronim });
        });
        vm.options.instansi = own2Option
        vm.options.own_name2 = own2Option
        this.resMilikOPD()
      })
    },
    async resMilikOPD() {
	    const res = await this.$http.get(this.$app.route('perangkat-jaringan.data-perangkat-daerah.get', {opd_id : this.$route.params.opd_id}))
      let result = res.data[0]
      let instansi = _.find(this.options.own_name2, function(o) { return o.akronim = result['akronim'] ; })
      this.$set(this.form, 'own_name2', instansi)
      this.$set(this.form, 'instansi', instansi)
      this.getAppConnect();
    },
    // getJenis(){
    //   let vm = this
    //   vm.groupLoading = true
    //   vm.$http
    //     .get(vm.$app.route('jenis.all'), {
    //       params: {
    //       }
    //     })
    //     .then(response => {
    //       const jenisOption = [];
    //       response.data.map(function (value, key) {
    //         jenisOption.push({ value: value.jenis, label: value.jenis });
    //       });

    //       vm.options['jenis'] = jenisOption
    //       this.getAppConnect();
    //     })
    // },
    getAppConnect(){
      let vm = this
      vm.groupLoading = true
      vm.$http
        .get(vm.$app.route('app.all'), {
          params: {
          }
        })
        .then(response => {
          let appOptions = response.data.map(function (value, key) {
            return { value: value.apl_id + ' ' + value.nama_apl, label: value.akronim == null ? ' ' + 'Aplikasi Milik Eksternal ' + value.nama_apl : value.akronim + ' ' + value.nama_apl };
          });

          vm.options['app_connect'] = appOptions
          this.getAppConnected();
        })
    },
    getAppConnected(){
      let vm = this
      vm.groupLoading = true
      vm.$http
        .get(vm.$app.route('app.all'), {
          params: {
          }
        })
        .then(response => {
          let appOptions2 = response.data.map(function (value, key) {
            return { value: value.apl_id + ' ' + value.nama_apl, label: value.akronim == null ? ' ' + 'Aplikasi Milik Eksternal ' + value.nama_apl : value.akronim + ' ' + value.nama_apl };
          });

          vm.options['app_connected'] = appOptions2
          this.getIDMetadata();
        })
    },
    getIDMetadata(){
      let vm = this
      vm.groupLoading = true
      vm.$http.get(vm.$app.route('sistem-penghubung-layanan-pemerintah.get_metadata'), {
        params: {}
      }).then(response => {
        const optionsJip = [];
        response.data.map(function (value, key) {
          optionsJip.push({ value: value.kode, id_metadata: value.kode_nama });
        });
        vm.options.id_metadata = optionsJip
        if(this.$route.params.status == 'update'){
          this.loadDataSplp();
        }
      })
    },
    async loadDataSplp(){
			const res = await this.$http.get(this.$app.route('sistem-penghubung-layanan-pemerintah.sistem-penghubung-layanan-pemerintah.get', {id: this.id}))
      let result = res.data[0]
      this.getRail4(result.rai_level_3)
      Object.entries(this.selected).forEach((val, key) => {
        let txt = `rai_level_${key+1}`
        let rail = _.find(this.options[val[0]], function(o) { return o.rail = result[txt] ; })
        this.selected[val[0]] = rail
      })
      this.form.name_splp = result.nama
      this.form.desc_splp = result.deskripsi
      if(result['ownership'] === 'Milik Sendiri'){
        let own_name2 = _.find(this.options.own_name2, function(o) { return o.akronim = result['nama_owner'] ; })
        this.form.own_name2 = own_name2
      }else{
        if(result['ownership'] === 'Milik Instansi Pemerintah Lain'){
          let own_name3 = _.find(this.options.own_name3, function(o) { return o.akronim = "Lainnya" ; })
          this.form.own_name3 = own_name3
          let own_name4 = result['nama_owner']
          this.form.own_name4 = own_name4
        }else{
          this.form.own_name = result.nama_owner
        }
      }
      let txt0 = 'instansi'
      let instansi = _.find(this.options.instansi, function(o) { return o.akronim = result[txt0] ; })
      this.form.instansi = instansi
      // let txt = 'jenis'
      // let jenis = _.find(this.options.jenis, function(o) { return o.label = result[txt] ; })
      // this.options.jenis[0] = jenis
      // this.form.jenis = jenis
      let txt2 = 'ownership'
      let own = _.find(this.options.own, function(o) { return o.label = result[txt2] ; })
      this.form.own = own
      // let txt3 = 'nama_jip'
      // let jip_name = _.find(this.options.jip_name, function(o) { return o.label = result[txt3] ; })
      // this.form.jip_name = jip_name
      let app_connect = _.find(this.options.app_connect, function(o) { return o.label = result['app_dihubungkan'] ; })
      this.form.app_connect = app_connect
      let app_connected = _.find(this.options.app_connected, function(o) { return o.label = result['app_terhubung'] ; })
      this.form.app_connected = app_connected
      this.getIDMetadataJIP(result.id)
		},
    async getIDMetadataJIP(id){
			const res = await this.$http.get(this.$app.route('sistem-penghubung-layanan-pemerintah.get_metadata_detail', {id: id}))
      let result = res.data
      let metadata_id = [];

      result.map(function (value, key) {
        metadata_id.push({ id_metadata: value.kode_nama });
      });

      this.form.id_metadata = metadata_id
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
