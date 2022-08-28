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
    <!--{{item}}-->
    <validation-observer v-slot="{ passes }" :slim="true">
      <form @submit.prevent="passes(submit)" v-if="show">
        <b-form-input 
          id="i_id" 
          v-if="false"
          v-model="form.i_id" 
          :searchable="false">
        </b-form-input>	
        <b-form-group
          label-cols="3"
          label-cols-lg="4"
          label="Tahun Bulan"
          label-for="tahunBulan">
          <ValidationProvider
            rules="required"
            v-slot="{ valid, errors }"
            name="Tahun Bulan"
            :debounce="250">
            <bs-datepicker
              id="tahunBulan"
              class="datepicker-input"
              v-model="form.tahun_bulan"
              placeholder="Tahun Bulan"
              label=""
              :settings="dtp.settings"
              @onSelected="onSelectedDateAdditional"
              :state="errors[0] ? false : (valid ? true : null)" />
            <invalid-feedback :error="errors[0]"></invalid-feedback>
          </ValidationProvider>
        </b-form-group>

        <b-form-group
          label-cols="3"
          label-cols-lg="4"
          label="Jumlah Hari Kerja Non Guru"
          label-for="harikerja_nonguru">
          <ValidationProvider
            rules="required"
            v-slot="{ valid, errors }"
            name="Jumlah Hari Kerja Non Guru"
            :debounce="250">
            <b-form-input 
              id="harikerja_nonguru" 
              v-model="form.harikerja_nonguru" 
              track-by="slug_path"
              type="number"
              placeholder="Jumlah Hari Kerja Non Guru"
              :searchable="false">
            </b-form-input>	
						
            <invalid-feedback :error="errors[0]"></invalid-feedback>
          </ValidationProvider>
        </b-form-group>

        <b-form-group
          label-cols="3"
          label-cols-lg="4"
          label="Jumlah Hari Kerja Guru"
          label-for="harikerja_guru">
          <ValidationProvider
            rules="required"
            v-slot="{ valid, errors }"
            name="Jumlah Hari Kerja Guru"
            :debounce="250">
            <b-form-input 
              id="harikerja_guru" 
              v-model="form.harikerja_guru" 
              track-by="slug_path"
              type="number"
              placeholder="Jumlah Hari Kerja Guru"
              :searchable="false">
            </b-form-input>	
            <invalid-feedback :error="errors[0]"></invalid-feedback>
          </ValidationProvider>
        </b-form-group>	

        <div :class="`action-area d-flex justify-content-end`">
          <div class="text-right">
            <b-button ref="closebtn" variant="default" @click.prevent="onCloseModal" class="mr-2">
              <i class="fal fa-times"></i>
              {{ $t('general.form.button_cancel') }}
            </b-button>
            <b-button type="submit" variant="primary">
              <i class="fal fa-save"></i>
              {{ $t(`general.form.button_update`) }}
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
	name: 'FormUbahJumlahHariKerjaEfektif',
	props: {
		mId: {
			type: String,
			required: true,
		},		
		title: {
			type: String,
			required: false,
			default: 'Hai'
		},
		item: {
			type: Object,
			require: false,
			default: () => {}
		}
	},
	data() {
		return {
		show: true,
		rulesForName: '',
		dtp: {
			settings: {
				format: "MM yyyy",
				minViewMode: "months",
				startView: "months",
				viewMode: "year",
				todayBtn: true,
				immediateUpdates: false,
				todayHighlight: true
			}
		},
		form: {
			tahun_bulan: null,
			harikerja_nonguru: '',
			harikerja_guru: '',
			bulan : null,
			tahun : null,
			created_at: null,
			created_by: null,
			i_id: '',
		},
		lists: {
			source: [],
			topic: []
		},
		loading: {
			topic: false,
		},
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
		'$parent.sources': {
			deep: true,
			immediate: true,
			handler: function(n) {
				this.lists.source = n
			}
		},
		item: {
			handler: function(n) {
				this.form.i_id 				= n.i_id
				this.form.harikerja_nonguru = n.si_harikerja_nonguru
				this.form.harikerja_guru 	= n.si_harikerja_guru
				this.form.tahun_bulan 		= this.$moment(n.si_bulan).format('MMMM') +' '+n.v_tahun
				this.form.tahun				= n.v_tahun
				this.form.bulan				= n.si_bulan
			},
			deep: true,
			immediate: true,
		},
	},
	methods:{
		onCloseModal() {
			this.$bvModal.hide(this.mId)
		},		
		onSelectedDateAdditional(date) {
			this.datesAdditionalMonth = (date.date == undefined) ? '' :this.$moment(date.date).format('M')
			this.datesAdditionalYear = (date.date == undefined) ? '' :this.$moment(date.date).format('YYYY')
			this.form.bulan = this.datesAdditionalMonth
			this.form.tahun =this.datesAdditionalYear
		},
		submit() 
		{
			let vm = this	
			this.form.created_by 	= this.$app.user.v_userid
			this.form.created_at 	= moment().format("yyyy-MM-DD")
			let data 				= Object.assign({}, vm.$data.form)
			let mode 				= 'edit'
			let url 				= vm.$app.route(mode == 'add' ? 'jumlah-hari-kerja.store' : 'jumlah-hari-kerja.update')
			let method 				= 'post'
			vm.$app.confirm({
				text: vm.$t(`manajemendata.alert.confirm.jum_harikerja.${mode}`),
				preConfirm: () => {
				return vm.$http
					[method](url, data)
					.then(response => {
						console.log(response)
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
	}
}
</script>

