<template>
  <div class="row">
    <div class="col-12">
      <div class="panel">
        <b-skeleton-wrapper>
          <div class="mt-2 ml-4 mr-4 b-bottom">
            <div class="info-text-capaian">{{ $app.user.v_username }}</div>
            <div class="info-text-capaian-bold pb-2">
              <span>{{ $app.user.email }}</span>
            </div>
          </div>
        </b-skeleton-wrapper>
        <div class="col-6 col-md-9">
          <div class="d-flex flex-wrap flex-lg-nowrap mt-3">
            <validation-observer
              v-slot="{ passes }"
              tag="div"
              class="d-flex flex-wrap flex-lg-nowrap align-items-start mb-2 col-xl-12">
              <template v-if="!readonly">
                <ValidationProvider
                  rules="required|min:6|max:10"
                  v-slot="{ valid, errors }"
                  name="NRK"
                  :debounce="250">
                  <b-form-input
                    id="input-nrk"
                    ref="input-nrk"
                    v-model="nrk"
                    placeholder="Masukkan NRK"
                    class="mt-2"
                    maxlength="10"
                    :state="errors[0] ? false : (valid ? true : null)" />
                  <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
                </ValidationProvider>
              </template>
              <template v-else>
                <div class="nrk-placeholder">
                  {{ nrk }}
                  <template v-if="nrk == $app.user.v_userid">
                    - {{ $app.user.v_username }}
                  </template>
                </div>
              </template>

              <bs-datepicker
                class="ml-1 ml-lg-1 mt-2"
                v-model="selectedDate"
                label=""
                :settings="dpSettings"
                @onSelected="onSelected"
                :cleardate="false"
                v-once>
              </bs-datepicker>

              <b-button
                variant="primary"
                class="responsive-btn ml-1 ml-lg-1 mt-2"
                @click.prevent="passes(makesearch)"> Tampilkan
              </b-button>
            </validation-observer>
          </div>
        </div>
        <div class="panel-hdr border-faded border-top-0 border-right-0 border-left-0 shadow-0">
          <div class="panel-toolbar pl-3">
            <ul class="nav nav-tabs border-bottom-0 nav-tabs-clean" role="tablist">

              <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#tab_data_bulanan" role="tab" aria-selected="true">
                  {{ $t('profil.meta.tabs.header.data_bulanan') }}
                </a>
              </li>

              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#tab_riwayat_jabatan" role="tab" aria-selected="false">
                  {{ $t('profil.meta.tabs.header.riwayat_jabatan') }}
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#tab_riwayat_hukdis" role="tab" aria-selected="false">
                  {{ $t('profil.meta.tabs.header.riwayat_hukdis') }}
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#tab_prestasi" role="tab" aria-selected="false">
                  {{ $t('profil.meta.tabs.header.prestasi') }}
                </a>
              </li>
            </ul>
          </div>
        </div>
        <div class="panel-container show">
          <div class="panel-content pb-0">
            <div class="tab-content">
              <!--Konten Data Bulanan-->
              <div id="tab_data_bulanan" class="tab-pane active" role="tabpanel" aria-hidden="false">
                <!--konten Data Bulanan-->
                <div class="panel-content p-0">
                  <div class="row">
                    <data-pegawai :dat-peg="tempDataPegawai"> </data-pegawai>
                    <data-atasan :atasan="tempDataAtasan"></data-atasan>
                  </div>
                </div>
              </div>

              <!--Konten Riwayat Jabatan-->
              <div id="tab_riwayat_jabatan" class="tab-pane mb-5" role="tabpanel" aria-hidden="true">
                <riwayat-jabatan v-if="tempDataRiwayatJabatan" :jabatan="tempDataRiwayatJabatan"></riwayat-jabatan>
              </div>

              <!--Konten Riwayat Hukdis-->
              <div id="tab_riwayat_hukdis" class="tab-pane mb-5" role="tabpanel" aria-hidden="true">
                <riwayat-hukdis v-if="tempDataRiwayatHukdis" :hukdis="tempDataRiwayatHukdis"></riwayat-hukdis>
              </div>

              <!--Konten Data Prestasi-->
              <div id="tab_prestasi" class="tab-pane mb-5" role="tabpanel" aria-hidden="true">
                <data-prestasi v-if="tempDataRiwayatJabatan" :nrk="tempDataRiwayatJabatan"></data-prestasi>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
	import DataPrestasi from './_profil/DataPrestasi'
	import RiwayatJabatan from './_profil/RiwayatJabatan'
	import RiwayatHukdis from './_profil/RiwayatHukdis'
	import DataPegawai from './_profil/DataPegawai'
	import DataAtasan from './_profil/DataAtasan'

	export default
	{
		name: 'Profil',
		components: {
			DataPrestasi,
			RiwayatJabatan,
			RiwayatHukdis,
			DataAtasan,
			DataPegawai
		},
		data(){
			return{
				tempDataPegawai: {
					v_nrk:'',
					v_nama:'',
					pd_induk:'',
					lokasi_gaji_pegawai:'',
					nama_lokasi:'',
					jenis_pegawai:'',
					jabatan_pegawai:'',
					eselon_pegawai:'',
					status_pegawai_pegawai:'',
					status_bko_pegawai:''
				},
				tempDataAtasan: {
					nrk_atasan:'',
					nama_atasan:'',
					pd_induk_atasan:'',
					lokasi_gaji_atasan:'',
					lokasi_kerja_atasan:'',
					jenis_pegawai_atasan:'',
					jabatan_atasan:'',
					eselon_atasan:'',
					status_pegawai_atasan:'',
					status_bko_atasan:''
				},
				tempDataRiwayatJabatan : '',
				tempDataRiwayatHukdis : '',
				nrk : this.$app.user.v_userid,
				selectedDate: this.$app.getCurrentDateByMonthYear(),
				thbl: this.$app.getCurrentDate('YYYYMM'),
				tempThbl: this.$app.getCurrentDate('YYYYMM'),
				search : '',
				showsearch : false,
				getdata : [],
				dpSettings: {
					format: "MM yyyy",
					minViewMode: "months",
					startView: "months",
					viewMode: "year",
				},
				cariNrkAtasan: null,
      			isBusy: false,
				selectedAtasan: [],
				loading: false,
				readonly:true
			}
		},
		computed: {
			isDisabled() {
			// evaluate whatever you need to determine disabled here...
			return true;
			},
			validationNrk() {
				return this.nrk.length > 5 && this.nrk.length < 7 ? true : false
			}
		},
		 mounted:function(){
       if (this.$app.user.can('profil-nrk') || this.$app.user.can('profil-nrk-all')) {
					this.readonly 				= false
          this.nrk = ''
				}
			  this.makesearch() //method1 will execute at pageload
		},
		methods :
		{
			onSelected(date) {
				this.tempThbl = this.$moment(date.date).format('YYYYMM')
			},
			async resPegawai(nrk, tempThbl){
				const resPegawai = await this.$http.get(
													this.$app.route('profil.data-bulanan.get', {
													'nrk': nrk,
													'thbl':tempThbl,
													'readonly':this.readonly
													})
									)
				return resPegawai.data ? resPegawai.data : '-'
			},
			async resAtasan(nrk, tempThbl){
				const resAtasan = await this.$http.get(
									this.$app.route('profil.data-atasan.get', {
									'nrk': nrk,
									'thbl': tempThbl
									})
					)
				return resAtasan.data ? resAtasan.data : {}
			},
       		async makesearch()
			{
				if (this.$app.user.can('profil-nrk') || this.$app.user.can('profil-nrk-all')) {
					this.readonly 				= false
				}
    
				var nrk = ''
        if (this.nrk) {
          var dataResPegawai = await this.resPegawai(this.nrk, this.tempThbl).then(response => {
            if (response === '-') {
              this.$app.alert.fire("Proses Gagal", "Data profil tidak ditemukan", "warning")
            }
            return response
          });

          if(dataResPegawai == '-')
          {
            nrk = ''
            dataResPegawai = {}
          }
          else
          {
            nrk = this.nrk
          }

          this.tempDataPegawai 		= dataResPegawai

        }


        if(nrk) {
          var dataResAtasanPegawai	= await this.resAtasan(nrk, this.tempThbl).then(response => {
            return response
          });

				  this.tempDataAtasan 		= dataResAtasanPegawai
        }

				this.tempDataRiwayatJabatan = nrk
				this.tempDataRiwayatHukdis 	= nrk
            }
        }

   	}
	</script>

<style lang="scss" scoped>
  .nrk-placeholder {
    background-color: #f3f3f3;
    display: block;
    height: calc(1.47em + 1rem + 2px);
    padding: 0.5rem 0.875rem;
    font-size: 0.8125rem;
    font-weight: 500;
    line-height: 1.47;
    color: #495057;
    border: 1px solid #E5E5E5;
    border-radius: 4px;
    margin-top: 0.5rem
  }

  .b-bottom {
	  border-bottom: 2px solid rgb(235, 235, 235);
  }
</style>