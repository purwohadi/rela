<template>
  <b-modal
    :id="mId"
    :ref="mId"
    :title="title"
    size=" "
    hide-footer
    no-close-on-backdrop
    no-close-on-esc
    @close="onCloseModal"
    @hide="onCloseModal">
    <validation-observer v-slot="{ passes }" :slim="true">
      <div class="d-flex flex-wrap flex-lg-nowrap mb-lg-4 justify">
        <b-form-group
          label-cols="4"
          label-cols-lg="2"
          label="Tahun"
          label-for="tahun">
          <ValidationProvider
            rules="required"
            v-slot="{ valid, errors }"
            name="Tahun"
            :debounce="250">
            <bs-datepicker
              id="tahun"
              class="datepicker-input"
              v-model="form.tahun"
              placeholder="Tahun"
              label=""
              :settings="dtp.settings"
              :state="errors[0] ? false : (valid ? true : null)" />
            <invalid-feedback :error="errors[0]"></invalid-feedback>
          </ValidationProvider>
        </b-form-group>
        <b-button
          variant="primary"
          class="ml-lg-2 mb-4"
          @click="makesearch"> Tampilkan
        </b-button>
      </div>

      <form @submit.prevent="passes(submit)" v-if="show">
        <div class="panel-content">
          <div class="row">
            <template>
              <div class="col-sm-12 col-lg-6 col-xl-6">
                <div class="panel">
                  <div class="panel-hdr">
                    <h2>
                      <span>Non Guru</span>
                    </h2>
                  </div>
                  <div class="panel-container show">
                    <div class="panel-content">
                      <b-row class="my-1" v-for="(input, index) in jumlahHariNonGuru" :key="index">
                        <b-form-group
                          label-cols="3"
                          label-cols-lg="4"
                          :label="`${input.bulan}`"
                          :label-for="`harikerja_nonguru_${input.id}`">
                          <ValidationProvider
                            rules="required"
                            v-slot="{ errors }"
                            :name="`Jumlah Hari Kerja Non Guru ${input.bulan}`"
                            :debounce="250">
                            <b-form-input
                              :id="`harikerja_nonguru_${input.id}`"
                              v-model="form.valuesNonGuru[index]"
                              track-by="slug_path"
                              type="number"
                              :readonly="readonly"
                              :placeholder="`Jumlah Hari Kerja Non Guru ${input.bulan}`"
                              :searchable="false">
                            </b-form-input>
                            <invalid-feedback :error="errors[0]"></invalid-feedback>
                          </ValidationProvider>
                        </b-form-group>
                      </b-row>
                    </div>
                  </div>
                </div>
              </div>
            </template>

            <template>
              <div class="col-sm-12 col-lg-6 col-xl-6">
                <div class="panel">
                  <div class="panel-hdr">
                    <h2>
                      <span>Guru</span>
                    </h2>
                  </div>
                  <div class="panel-container show">
                    <div class="panel-content">
                      <b-row class="my-1" v-for="(input, index) in jumlahHari" :key="index">
                        <b-form-group
                          label-cols="3"
                          label-cols-lg="4"
                          :label="`${input.bulan}`"
                          :label-for="`harikerja_guru_${input.id}`">
                          <ValidationProvider
                            rules="required"
                            v-slot="{ errors }"
                            :name="`Jumlah Hari Kerja Guru ${input.bulan}`"
                            :debounce="250">
                            <b-form-input
                              :id="`harikerja_guru_${input.id}`"
                              v-model="form.valuesGuru[index]"
                              track-by="slug_path"
                              type="number"
                              :placeholder="`Jumlah Hari Kerja Guru ${input.bulan}`"
                              :searchable="false">
                            </b-form-input>
                            <invalid-feedback :error="errors[0]"></invalid-feedback>
                          </ValidationProvider>
                        </b-form-group>
                      </b-row>
                    </div>
                  </div>
                </div>
              </div>
            </template>

          </div>
        </div>

        <div :class="`action-area d-flex justify-content-end`">
          <div class="text-right">
            <b-button ref="closebtn" variant="default" @click.prevent="onCloseModal" class="mr-2">
              <i class="fal fa-times"></i>
              {{ $t('general.form.button_cancel') }}
            </b-button>
            <b-button type="submit" variant="primary">
              <i class="fal fa-save"></i>
              {{ $t(`general.form.button_add`) }}
            </b-button>
          </div>
        </div>
      </form>
    </validation-observer>
  </b-modal>
</template>

<script>
export default
{
	name: 'FormTambahJumlahHariKerjaEfektif',
	props: {
		mId: {
			type: String,
			required: true,
		},
		title: {
			type: String,
			required: false,
			default: ''
		},
		item: {
			type: Object,
			require: false,
			default: () => {}
		},
		datNonGuru: {
			type: Array
		}
	},
	data() {
		return {
			show: true,
			isEdit: false,
			rulesForName: '',
			readonly:true,
			itemsData:{},
			dtp: {
				settings: {
					format: "yyyy",
					minViewMode: "years",
					startView: "years",
					viewMode: "year",
					todayBtn: true,
					immediateUpdates: false,
					todayHighlight: true
				},
				model : ''
			},
			form: {
				tahun : this.$app.getCurrentDate('YYYY'),
				created_at: null,
				created_by: null,
				valuesNonGuru:{},
				valuesGuru:{},
			},
			lists: {
				source: [],
				topic: []
			},
			loading: {
				topic: false,
			},
			jumlahHari : [{bulan: "Januari",
						   id : "januari",
						  },
						  {bulan: "Februari",
						   id : "februari",
						  },
						  {bulan: "Maret",
						   id : "maret",
						  },
						  {bulan: "April",
						   id : "april",
						  },
						  {bulan: "Mei",
						   id : "mei",
						  },
						  {bulan: "Juni",
						   id : "juni",
						  },
						  {bulan: "Juli",
						   id : "juli",
						  },
						  {bulan: "Agustus",
						   id : "agustus",
						  },
						  {bulan: "September",
						   id : "september",
						  },
						  {bulan: "Oktober",
						   id : "oktober",
						  },
						  {bulan: "November",
						   id : "november",
						  },
						  {bulan: "Desember",
						   id : "desember",
						  },
						],
			jumlahHariNonGuru : [],
		}
	},
	watch : {
			datNonGuru: {
				handler: function(n, o) {
					this.jumlahHariNonGuru = this.datNonGuru
					for(let i = 0; i < this.jumlahHariNonGuru.length; i++)
					{
						this.form.valuesNonGuru[i] = this.jumlahHariNonGuru[i].jum_hari_kerja;
					}
				},
				deep: true,
				immediate: true
			}
	},
	mounted() { },
	created(){},
	methods:{
		resetForm()
		{
			this.form = {
				tahun: this.$app.getCurrentDate('YYYY'),
				valuesNonGuru:{},
				valuesGuru:{},
			}
		},
		onCloseModal()
		{
			this.$bvModal.hide(this.mId)
			this.resetForm()
		},
		submit()
		{
			let vm = this
			this.form.created_by 	= this.$app.user.v_userid
			this.form.created_at 	= moment().format("yyyy-MM-DD")

			let data = Object.assign({}, vm.$data.form)
			let mode = vm.isEdit ? 'edit' : 'add'
			let url = vm.$app.route(mode == 'add' ? 'jumlah-hari-kerja.store' : 'jumlah-hari-kerja.update')
			let method = mode == 'add' ? 'post' : 'put'
			vm.$app.confirm({
				text: vm.$t(`manajemendata.alert.confirm.jum_harikerja.${mode}`),
				preConfirm: () => {
				return vm.$http
					[method](url, data)
					.then(response => {
						console.log(response)
					if (response.data.status == "error") {
						console.log('error')
						throw new Error(response.data.message)
					} else {
						return response
					}
					})
					.catch(error => {
						console.log('error 2');
					vm.$app.alert.showValidationMessage(error)
					})
				}
			})
			.then(result => {
				if (result.isDismissed) return
				if (result.value.data.status == "success" || result.value.data.status == "info")
				{
					vm.$app.success(
					result.value.data.message,
					result.value.data.status,
					vm.$t(`manajemendata.alert.${result.value.data.status}`)
					)
					.then(response => {
						if (response.value === true)
						{
							vm.$root.$emit('bv::refresh::table', 'jumlah-hari-kerja')
							vm.$bvModal.hide(vm.mId)
						}
					})
				}
			})
		},
		async makesearch(){
			const action = this.$app.route('jumlah-hari-kerja.data-non-guru.get', {'tahun': this.form.tahun})
        	const {data} = await this.$http.get(action)
			this.jumlahHariNonGuru = data
			for(let i = 0; i < this.jumlahHariNonGuru.length; i++)
			{
				this.form.valuesNonGuru[i] = this.jumlahHariNonGuru[i].jum_hari_kerja;
			}

		},
	}
}
</script>

