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
          <validation-observer v-slot="{ passes }" :slim="true">
            <form @submit.prevent="passes(submit)">
              <b-form-group
                label-cols="2"
                label-cols-lg="2"
                label-for="nama_opd"
                label="Unit Kerja">
                  <b-form-input
                    class="ml-2"
                    v-model="model.nama_opd"
                    :id="'nama_opd'"
                    placeholder="Unit Kerja"
                    :readonly="true">
                  </b-form-input>
              </b-form-group>
              <b-form-group
                label-cols="2"
                label-cols-lg="2"
                label-for="radl1"
                :label="$t('domain.form.field.radl1.label')">
                  <input v-model="form.rad_level_1" type="hidden">
                  <b-form-input
                    class="ml-2"
                    v-model="model.rad_level_1_nama"
                    id="radl1"
                    placeholder=""
                    :readonly="!isUpdate">
                  </b-form-input>
              </b-form-group>
              <b-form-group
                label-cols="2"
                label-cols-lg="2"
                label-for="radl2"
                :label="$t('domain.form.field.radl2.label')">
                  <input v-model="form.rad_level_2" type="hidden">
                  <b-form-input
                    class="ml-2"
                    v-model="model.rad_level_2_nama"
                    id="radl2"
                    placeholder=""
                    :readonly="!isUpdate">
                  </b-form-input>
              </b-form-group>
              <b-form-group
                label-cols="2"
                label-cols-lg="2"
                label-for="radl2"
                :label="$t('domain.form.field.radl3.label')">
                  <input v-model="form.rad_level_3" type="hidden">
                  <b-form-input
                    class="ml-2"
                    v-model="model.rad_level_3_nama"
                    id="radl3"
                    placeholder=""
                    :readonly="!isUpdate">
                  </b-form-input>
              </b-form-group>
              <b-form-group
                label-cols="2"
                label-cols-lg="2"
                label-for="nama_data"
                label="Nama Data">
                  <input v-model="form.nama_data" type="hidden">
                  <b-form-input
                    class="ml-2"
                    v-model="model.nama_data"
                    :id="'nama_data'"
                    placeholder="Nama Data"
                    :readonly="!isUpdate">
                  </b-form-input>
              </b-form-group>
              <b-form-group
                label-cols="2"
                label-cols-lg="2"
                label-for="probis"
                label="Proses Bisnis Terkait">
                  <m-select
                    id="probis_terkait" v-model="model.probis" :multiple="true" :options="options.probis"
                    class="ml-2" :disabled="true" placeholder="" label="probis" track-by="key"
                  >
                  </m-select>
              </b-form-group>
            </form>
          </validation-observer>
          <data-tables style="margin-top:50px"
            id="datainfotable" :fields="fields2"
            api-url="domain-data-informasi.get_detail_data" :title="'Daftar Data Informasi'"
            :args-route="{'info_id': this.info_id}"
            :actions="actionsAplikasi"
            row-action-width="10%"
            @add="handleAdd"
            @detail="handleDetail"
            @update="handleUpdate"
            @delete="handleDelete"
            >
          </data-tables>
				</b-card>
			</section>
		</div>
	</div>
</template>

<script>
export default {
  name: 'ProsesBisnisDetil',
  props: ['info_id', 'id_opd', 'status'],
  data(){
    let resourceName = 'domain-proses';
    return{
      resourceName: resourceName,
      routeName: `${resourceName}`,
      model: {
        nama_opd : null,
        info_id : null,
        nama_data : null,
        opd_id : null,
        rad_level_1: null,
        rad_level_2: null,
        probis: []
      },
      fields2: [
        {
          key: 'rowaction',
          label: '',
          sortable: false,
          class: 'text-center',
        },
        {
          key: 'uraian_data',
          label: "Uraian Data",
          sortable: true,
        },
        {
          key: 'tujuan_data',
          label: 'Tujuan Data',
          sortable: true,
        },
        {
          key: 'sifat_data',
          label: "Sifat Data",
          sortable: true,
        },
        {
          key: 'komponen_data',
          label: 'Komponen Data',
          sortable: true,
        },
        {
          key: 'jenis_data1',
          label: "Jenis Data 1",
          sortable: true,
        },
        {
          key: 'jenis_data2',
          label: 'Jenis Data 2',
          sortable: true,
        },
        {
          key: 'data_owner',
          label: "Penanggung Jawab",
          sortable: true,
        },
      ],
      form: {
        nama_data: null,
        rad_level_1: null,
        rad_level_2: null,
      },
      options: {
        probis: []
      }
    }
  },
  computed: {
    actionsAplikasi() {
			let actions = 'SR'
			actions += this.$app.user.can('lihat-daftar-data-dan-informasi') ? 'L' : ''
			if (this.model.opd_id) {
        if (this.$app.user.opd_id) {
          if((this.model.opd_id==this.$app.user?.opd_id) || this.$app.user.is_admin) {
            actions += this.$app.user.can('edit-data-dan-informasi') ? 'CUD' : ''
          }
        } else {
          actions += this.$app.user.can('edit-data-dan-informasi') ? 'CUD' : ''
        }
			}
      return actions
		},
    isNew() {
      return this.$route.params.info_id === undefined ? true : false
    }
  },
  watch: {
  },
  created() {
    this.isUpdate = (this.$route.params.status == 'update')
    let query_opd = this.$route.params.opd_id ? this.$route.params.opd_id : this.$app.user.opd_id

		this.model.opd_id = query_opd
    this.resDataInformasi();
    this.getProbis()
    this.fetchProbis()
  },
  methods: {
    async resDataInformasi(){
			const res = await this.$http.get(this.$app.route('domain-data-informasi.data-informasi.get', {info_id: this.$route.params.info_id}))
      let result = res.data
      this.model = { ...this.model, ...result }
		},
    getProbis() {
      let vm = this
      vm.groupLoading = true
      vm.$http
        .get(vm.$app.route('domain-data-informasi.get_probis_terkait'),{
          params: {
            'opd_id' : this.$route.params.opd_id
          }
        })
        .then(({ data }) => {
          vm.options['probis'] = data.data
        })
    },
    async fetchProbis(){
			return this.$http.get(this.$app.route('domain-data-informasi.get_probis_data', {id: this.$route.params.info_id})).then((res) => {
        let result = res.data.data
        let probis_id = []
  
        probis_id = result.map(value => {
          return { key: value.key, probis: value.probis }
        })
  
        this.model.probis = probis_id

      }).catch(error => {
        return console.error(error);
      })
		},
    handleAdd() {
      // console.log(this.model.opd_id);
      this.$router.push({ name: 'domain-data-informasi-detail-add', params: {
        'opd_id' : this.model.opd_id,
        'info_id' : this.info_id
      }})
    },
    handleDetail(item) {
      // console.log(this.info_id);
      this.$router.push({ name: 'domain-data-informasi-detail-detail', params: {
        'opd_id' : this.model.opd_id,
        'info_id' : this.info_id,
        'id' : item.id,
        'status' : 'detail'
      }})
    },
    handleUpdate(item) {
      this.$router.push({ name: 'domain-data-informasi-detail-update', params: {
        'opd_id' : this.model.opd_id,
        'info_id' : this.info_id,
        'id' : item.id,
        'status' : 'update'
      }})
    },
    handleDelete(item, index, $el) {
      const vm = this
      vm.$app.confirm({
        text: vm.$t('domain.alert_detail_data_informasi.confirm.drop'),
        preConfirm: () => {
          return vm.$http
            .post(vm.$app.route('domain-data-informasi.drop_detail'), {
              data: { id: item.id}
            })
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
            vm.$app.success(this.$t(`domain.alert_detail_data_informasi.actions.drop.${result.value.data.status}`))
              .then(response => {
                if (response.value === true) {
                  vm.$root.$emit('bv::refresh::table', 'datainfotable')
                }
              })
          }
        })
    },
    onBack() {
      this.$router.go(-1)
    },
  }
}
</script>

<style>

</style>
