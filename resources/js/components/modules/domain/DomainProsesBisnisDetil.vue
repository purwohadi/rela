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
              label-for="proses_id"
              label="Proses ID"
              v-show="false">
                <b-form-input
                  class="ml-2"
                  v-model="model.proses_id"
                  :id="'proses_id'"
                  placeholder="Proses ID"
                  :readonly="true">
                </b-form-input>
            </b-form-group>
            <b-form-group
              label-cols="2"
              label-cols-lg="2"
              label-for="opd_id"
              label="OPD"
              v-show="false">
                <b-form-input
                  class="ml-2"
                  v-model="model.opd_id"
                  :id="'opd_id'"
                  placeholder="OPD"
                  :readonly="true">
                </b-form-input>
            </b-form-group>
            <b-form-group
              label-cols="2"
              label-cols-lg="2"
              label-for="nama_opd"
              label="Perangkat Daerah">
                <b-form-input
                  class="ml-2"
                  v-model="model.nama_opd"
                  :id="'nama_opd'"
                  placeholder="Perangkat Daerah"
                  :readonly="true">
                </b-form-input>
            </b-form-group>
            <b-form-group
              label-cols="2"
              label-cols-lg="2"
              label-for="rab_level1"
              label="RAB Level 1">
                <b-form-input
                  class="ml-2"
                  v-model="model.rab_level1"
                  :id="'rab_level1'"
                  placeholder="RAB Level 1"
                  :readonly="true">
                </b-form-input>
            </b-form-group>
            <b-form-group
              label-cols="2"
              label-cols-lg="2"
              label-for="rab_level2"
              label="RAB Level 2">
                <b-form-input
                  class="ml-2"
                  v-model="model.rab_level2"
                  :id="'rab_level2'"
                  placeholder="RAB Level 2"
                  :readonly="true">
                </b-form-input>
            </b-form-group>
            <b-form-group
              label-cols="2"
              label-cols-lg="2"
              label-for="rab_level3"
              label="RAB Level 3">
                <b-form-input
                  class="ml-2"
                  v-model="model.rab_level3"
                  :id="'rab_level3'"
                  placeholder="RAB Level 3"
                  :readonly="true">
                </b-form-input>
            </b-form-group>
            <b-form-group
              label-cols="2"
              label-cols-lg="2"
              label-for="program"
              label="Program">
                <b-form-input
                  class="ml-2"
                  v-model="model.program"
                  :id="'program'"
                  placeholder="Program"
                  :readonly="true">
                </b-form-input>
            </b-form-group>
            <b-form-group
              label-cols="2"
              label-cols-lg="2"
              label-for="rab_level4"
              label="RAB Level 4">
                <b-form-input
                  class="ml-2"
                  v-model="model.rab_level4"
                  :id="'rab_level4'"
                  placeholder="RAB Level 4"
                  :readonly="true">
                </b-form-input>
            </b-form-group>
          </form>
          <data-tables style="margin-top:50px"
            id="usertable" :fields="fields2"
            api-url="domain-proses.get_urusan" :title="$t('domain.datatable.title.t_urusan')"
            :args-route="{'proses_id': this.proses_id}"
            actions="S" row-action-width="10%">
          </data-tables>
				</b-card>
			</section>
		</div>
	</div>
</template>

<script>
export default {
  name: 'ProsesBisnisDetil',
  props: ['proses_id', 'status'],
  data(){
    return{
      model: {
        proses_id : null,
        id_opd : null,
        nama_opd : null,
        rab_level1 : null,
        rab_level2 : null,
        rab_level3 : null,
        rab_level4 : null
      },
      fields2: [
        {
          key: 'num_rows',
          label: this.$t('domain.datatable.column.v_number'),
          sortable: true,
          class: 'text-left'
        },
        {
          key: 'tupoksi_desc',
          label: this.$t('domain.datatable.column.v_ref_urus'),
          sortable: true,
          class: 'text-left'
        },
      ],
    }
  },
  computed: {

  },
  watch: {
  },
  created() {
    this.resProsesBisnis();
  },
  methods: {
    async resProsesBisnis(){
			const res = await this.$http.get(this.$app.route('domain-proses.data-proses-bisnis.get', {proses_id: this.proses_id}))
      let result = res.data.data[0]
      this.model = result
      if(result.is_provinsi == '1'){
        let txt1 = 'program'
        let program = 'Tingkat Provinsi - ' + result[txt1];
        this.model.program = program
        let txt2 = 'rab_level4'
        let rabl4 = 'Tingkat Provinsi - ' + result[txt2]
        this.model.rab_level4 = rabl4
      }else{
        let txt1 = 'program'
        let program = 'Tingkat Kota - ' + result[txt1];
        this.model.program = program
        let txt2 = 'rab_level4'
        let rabl4 = 'Tingkat Kota - ' + result[txt2]
        this.model.rab_level4 = rabl4
      }
		},
    onBack() {
      this.$router.push({ name: 'domainprosesbisnis',
      params: {
        'opd_id' : this.$route.params.opd_id
      }
      })
    },
    onSubmit() {

    }
  }
}
</script>

<style>

</style>
