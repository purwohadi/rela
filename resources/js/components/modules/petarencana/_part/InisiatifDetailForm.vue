<template>
	<b-card>
		<b-card-body>
			<b-form-group
        label-cols="2"
        label-cols-lg="2"
        label-for="nama-inisiatif"
        :label="$t('petarencana.form.field.nama_inisiatif.label')"
      >
        <b-col sm="5">
          <ValidationProvider
            rules=""
            v-slot="{ valid, errors }"
            name="Nama Inisiatif"
            :debounce="250">
            <b-form-input
              v-model="form.nama_inisiatif"
              id="nama-inisiatif" 
              :state="errors[0] ? false : (valid ? true : null)"
            >
            </b-form-input>
            <b-form-invalid-feedback class="ml-2">{{ errors[0] }}</b-form-invalid-feedback>
          </ValidationProvider>
        </b-col>
			</b-form-group>
			<b-form-group
        label-cols="2"
        label-cols-lg="2"
        label-for="unit-pj"
        :label="$t('petarencana.form.field.unit_pj.label')"
      >
        <b-col sm="5">
          <ValidationProvider
            rules=""
            v-slot="{ valid, errors }"
            name="Unit Penanggung Jawab"
            :debounce="250">
            <b-form-input
              v-model="form.unit_pj"
              id="unit-pj" 
              :state="errors[0] ? false : (valid ? true : null)"
            >
            </b-form-input>
            <b-form-invalid-feedback class="ml-2">{{ errors[0] }}</b-form-invalid-feedback>
          </ValidationProvider>
        </b-col>
			</b-form-group>
      <b-form-group
        :label="$t('petarencana.form.field.tahun_implementasi.label')"
        label-cols="2"
        label-cols-lg="2"
      >
        <b-col sm="12">
          <ValidationProvider
            rules=""
            name="Unit Penanggung Jawab"
            :debounce="250"
          >
            <b-form-checkbox
              v-for="option in optionsYear"
              v-model="form.tahun_implementasi"
              :key="option"
              :value="option"
              inline
            >
              {{ option }}
            </b-form-checkbox>
          </ValidationProvider>
        </b-col>
      </b-form-group>
      <!-- <b-form-group
        v-if="parentForm && parentForm.domain_arsitektur"
        label-cols="2"
        label-cols-lg="2"
        label-for="kegiatan"
        :label="$t('petarencana.form.field.aplikasi.label')">
        <b-col sm="8">
          <validation-provider name="Aplikasi" rules="" v-slot="{ errors, ariaMsg }">
            <m-select
              id="aplikasi"
              :option-height="73"
              :tabindex="7"
              :options="optionsAplikasi"
              v-model="model.aplikasi_selected"
              label="nama_apl"
              :placeholder="$t('petarencana.form.field.aplikasi.placeholder')"
              track-by="apl_Id"
              :searchable="true"			
              :allow-empty="false"
            >     
              <template #noOptions>
                Tidak ada data
              </template>
              <template #noResult>
                Data tidak ditemukan
              </template>
            </m-select>
            <small v-bind="ariaMsg" style="color: #fd3995; width: 100%; font-size: .6875rem; margin-top: 0.325rem;">
              {{ errors[0] }}
            </small>
          </validation-provider>
        </b-col>
      </b-form-group> -->
      <div class="text-left">
        <b-button type="submit" size="sm" variant="primary">
          <i class="fal fa-save"></i>
          {{ $t('general.form.button_add') }}
        </b-button>
      </div>
		</b-card-body>
  </b-card>
</template>

<script>
export default {
	name: 'InisiatifDetailForm',
	props: {
		parentForm: {
			type: Object,
      default: null
		},
	},
	data() {
		return {
			show: true,
			title: '',
			form: {
				id: null,
        nama_inisiatif: null,
        kegiatan_id: null,
        sub_kegiatan_id: null,
        tahun_implementasi: []
			},
      optionsYear: ['2022', '2023', '2024', '2025', '2026'],
      optionsApps:  []
		}
	},
	mounted() {
    let query_opd = this.$route.query.opd_id
    if (query_opd) {
        this.opd_id = query_opd
    }
  },
	methods: {
    async loadApps(){
        return this.$http.get(this.$app.route('ref-kemendagri.ref-kegiatan', {})).then(res => {
          this.optionsApps = res.data 
        })
    },
    onSubmit(){
			let vm 			= this	
			let isEdit = this.$route.path.includes('edit') 
      let url 	=  isEdit ? '/peta-rencana/update/' + this.form.id : '/peta-rencana/save'
      console.log('form', this.form, this.parentForm);
			// let frm 		= new FormData()
			// let formData 	= vm.$app.objectToFormData(vm.model, frm)

			// let method = 'post'
			// vm.$app.confirm({
			// 	text: vm.$t('peta-rencana.alert.confirm.add', {name: this.form.nama_inisiatif}),
			// 	preConfirm: () => {
			// 		return vm.$http
			// 			[method](url, formData)
			// 			.then(response => {
			// 				if (response.data.status == "error") {
			// 					throw new Error(response.data.message)
			// 				} else {
			// 					return response
			// 				}
			// 			})
			// 			.catch(error => {
			// 				vm.$app.alert.showValidationMessage(error)
			// 			})
			// 	}
			// })
			// 	.then(result => {
			// 		if (result.isDismissed) return
			// 		if (result.value.data.status == "success")
			// 		{
      //       vm.$app.alert.fire('Sukses', 'Data Berhasil Disimpan' , 'success');
      //       this.$emit('refresh')
			// 		}
			// 	})
		},
	}
}
</script>
<style scoped>
.custom-checkbox {
  width: 50px;
}
</style>