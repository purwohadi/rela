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
              label="Refrensi Arsitektur Infrastruktur Level 1">
                <b-form-input
                  class="ml-2"
                  v-model="model.rai_level_1"
                  :id="'rai_level_1'"
                  placeholder="Refrensi Arsitektur Infrastruktur Level 1"
                  :readonly="true">
                </b-form-input>
            </b-form-group>
            <b-form-group
              label-cols="2"
              label-cols-lg="2"
              label-for="rai_level_2"
              label="Refrensi Arsitektur Infrastruktur Level 2">
                <b-form-input
                  class="ml-2"
                  v-model="model.rai_level_2"
                  :id="'rai_level_2'"
                  placeholder="Refrensi Arsitektur Infrastruktur Level 2"
                  :readonly="true">
                </b-form-input>
            </b-form-group>
            <b-form-group
              label-cols="2"
              label-cols-lg="2"
              label-for="rai_level_3"
              label="Refrensi Arsitektur Infrastruktur Level 3">
                <b-form-input
                  class="ml-2"
                  v-model="model.rai_level_3"
                  :id="'rai_level_3'"
                  placeholder="Refrensi Arsitektur Infrastruktur Level 3"
                  :readonly="true">
                </b-form-input>
            </b-form-group>
            <b-form-group
              label-cols="2"
              label-cols-lg="2"
              label-for="rai_level_4"
              label="Refrensi Arsitektur Infrastruktur Level 4">
                <b-form-input
                  class="ml-2"
                  v-model="model.rai_level_4"
                  :id="'rai_level_4'"
                  placeholder="Refrensi Arsitektur Infrastruktur Level 4"
                  :readonly="true">
                </b-form-input>
            </b-form-group>
            <b-form-group
              label-cols="2"
              label-cols-lg="2"
              label-for="name_splp"
              label="Nama Sistem Penghubung Layanan Pemerintah">
                <b-form-input
                  class="ml-2"
                  v-model="model.nama"
                  :id="'name_splp'"
                  placeholder="Nama Sistem Penghubung Layanan Pemerintah"
                  :readonly="true">
                </b-form-input>
            </b-form-group>
            <b-form-group
              label-cols="2"
              label-cols-lg="2"
              label-for="desc_splp"
              label="Deskripsi Sistem Penghubung Layanan Pemerintah">
                <b-form-textarea
                  class="ml-2"
                  rows="3"
                  max-rows="6"
                  v-model="model.deskripsi"
                  :id="'desc_splp'"
                  placeholder="Deskripsi Sistem Penghubung Layanan Pemerintah"
                  :readonly="true">
                </b-form-textarea>
            </b-form-group>
            <!-- <b-form-group
              label-cols="2"
              label-cols-lg="2"
              label-for="jenis"
              label="Jenis Sistem Pendukung">
                <b-form-input
                  class="ml-2"
                  v-model="model.jenis"
                  :id="'jenis'"
                  placeholder="Jenis Sistem Pendukung"
                  :readonly="true">
                </b-form-input>
            </b-form-group> -->
            <b-form-group
              label-cols="2"
              label-cols-lg="2"
              label-for="ownership"
              label="Kepemilikan">
                <b-form-input
                  class="ml-2"
                  v-model="model.ownership"
                  :id="'ownership'"
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
            <!-- <b-form-group
              label-cols="2"
              label-cols-lg="2"
              label-for="nama_jip"
              label="Nama Jaringan Intra yang Digunakan">
                <b-form-input
                  class="ml-2"
                  v-model="model.nama_jip"
                  :id="'nama_jip'"
                  placeholder="Nama Jaringan Intra yang Digunakan"
                  :readonly="true">
                </b-form-input>
            </b-form-group> -->
            <b-form-group
              label-cols="2"
              label-cols-lg="2"
              label-for="app_dihubungkan"
              label="Aplikasi yang Dihubungkan">
                <b-form-input
                  class="ml-2"
                  v-model="model.app_dihubungkan"
                  :id="'app_dihubungkan'"
                  placeholder="Aplikasi yang Dihubungkan"
                  :readonly="true">
                </b-form-input>
            </b-form-group>
            <b-form-group
              label-cols="2"
              label-cols-lg="2"
              label-for="app_terhubung"
              label="Aplikasi Terhubung">
                <b-form-input
                  class="ml-2"
                  v-model="model.app_terhubung"
                  :id="'app_terhubung'"
                  placeholder="Aplikasi Terhubung"
                  :readonly="true">
                </b-form-input>
            </b-form-group>
            <!-- <b-form-group
              label-cols="2"
              label-cols-lg="2"
              label-for="domain_code"
              label="Kode Domain">
                <b-form-input
                  class="ml-2"
                  v-model="model.domain_code"
                  :id="'domain_code'"
                  placeholder="Kode Domain"
                  :readonly="true">
                </b-form-input>
            </b-form-group> -->
            <b-form-group
							label-cols="2"
							label-cols-lg="2"
							label-for="id_metadata_jip"
							label="ID Metadata Terkait (JIP)">
							<m-select
								id="id-metadata-jip"
								ref="id-metadata-jip"
								class="mb-2"
								:option-height="73"
								:tabindex="7"
								:options="options.metadata_jip"
								v-model="form.metadata_jip"
								label="kode_nama"
                :multiple="true"
                :taggable="true"
								select-label=""
								selected-label=""
								deselect-label=""
								track-by="kode_nama"
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
          </form>
				</b-card>
			</section>
		</div>
	</div>
</template>

<script>
export default {
  name: 'SistemPenghubungLayananPemerintahDetil',
  props: ['id', 'status'],
  data(){
    return{
      model: {
        id : null,
        rai_level_1 : null,
        rai_level_2 : null,
        rai_level_3 : null,
        name_splp : null,
        desc_splp : null,
        // jenis : null,
        ownership : null,
        nama_owner : null,
        nama_jip : null,
        app_dihubungkan : null,
        app_terhubung : null,
        domain_code : null
      },
      form: {
        instansi: null,
        metadata_jip: null
      },
      selected: {
        // instansi: null
      },
      options: {
        metadata_jip: []
      },
    }
  },
  computed: {

  },
  watch: {
  },
  created() {
    this.loadDataSplp();
  },
  methods: {
    async loadDataSplp(){
      const res = await this.$http.get(this.$app.route('sistem-penghubung-layanan-pemerintah.sistem-penghubung-layanan-pemerintah.get', {id: this.id}))
      let result = res.data[0]
      this.getIDMetadataJIP(res.data[0].id)
      this.model = result
		},
    async getIDMetadataJIP(id){
			const res = await this.$http.get(this.$app.route('sistem-penghubung-layanan-pemerintah.get_metadata_detail', {id: id}))
      let result = res.data
      let metadata_id = [];
      console.log(result);

      result.map(function (value, key) {
        metadata_id.push({ kode_nama: value.kode_nama });
      });

      this.form.metadata_jip = metadata_id
		},
    onBack() {
      this.$router.push({ name: 'infrastruktur.sistempenghubunglayananpemerintah',
      params: {
        'opd_id' : this.$route.params.opd_id
      }
      })
    },
    onSubmit() {
    },
  }
}
</script>

<style>

</style>
