<template>
  <div class="col-sm-12 col-lg-6 col-xl-6">
    <div class="panel">
      <div class="panel-hdr">
        <h2>
          Data <span class="fw-300">Atasan</span>
        </h2>
      </div>
      <div class="panel-container show">
        <div class="panel-content">
          <div class="form-group row">
            <label class="col-form-label col-6 col-lg-3 form-label text-lg-left">NRK Atasan</label>
            <div class="col-6 col-lg-9">
              <b-form-input
                class="form-control" atasan="atasan.nrk_atasan" :disabled="isDisabled"
                placeholder="NRK Atasan">
              </b-form-input>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-form-label col-6 col-lg-3 form-label text-lg-left">Nama Atasan</label>
            <div class="col-6 col-lg-9">
              <b-form-input
                class="form-control" v-model="model.nama_atasan" :disabled="isDisabled"
                placeholder="Nama Atasan">
              </b-form-input>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-form-label col-6 col-lg-3 form-label text-lg-left">PD Induk</label>
            <div class="col-6 col-lg-9">
              <b-form-input
                class="form-control" v-model="model.pd_induk_atasan" :disabled="isDisabled"
                placeholder="PD Induk">
              </b-form-input>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-form-label col-6 col-lg-3 form-label text-lg-left">Lokasi Gaji</label>
            <div class="col-6 col-lg-9">
              <b-form-input
                class="form-control" v-model="model.lokasi_gaji_atasan" :disabled="isDisabled"
                placeholder="Lokasi Gaji">
              </b-form-input>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-form-label col-6 col-lg-3 form-label text-lg-left">Lokasi Kerja</label>
            <div class="col-6 col-lg-9">
              <b-form-input
                class="form-control" v-model="model.lokasi_kerja_atasan" :disabled="isDisabled"
                placeholder="Lokasi Kerja">
              </b-form-input>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-form-label col-6 col-lg-3 form-label text-lg-left">Jenis Pegawai</label>
            <div class="col-6 col-lg-9">
              <b-form-input
                class="form-control" v-model="model.jenis_pegawai_atasan" :disabled="isDisabled"
                placeholder="Jenis Pegawai">
              </b-form-input>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-form-label col-6 col-lg-3 form-label text-lg-left">Jabatan</label>
            <div class="col-6 col-lg-9">
              <b-form-input
                class="form-control" v-model="model.jabatan_atasan" :disabled="isDisabled"
                placeholder="Jabatan">
              </b-form-input>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-form-label col-6 col-lg-3 form-label text-lg-left">Eselon</label>
            <div class="col-6 col-lg-9">
              <b-form-input
                class="form-control" v-model="model.nama_eselon" :disabled="isDisabled"
                placeholder="Eselon">
              </b-form-input>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-form-label col-6 col-lg-3 form-label text-lg-left">Status Pegawai</label>
            <div class="col-6 col-lg-9">
              <b-form-input
                class="form-control" v-model="model.status_pegawai_atasan" :disabled="isDisabled"
                placeholder="Status Pegawai">
              </b-form-input>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-form-label col-6 col-lg-3 form-label text-lg-left">Status BKO</label>
            <div class="col-6 col-lg-9">
              <b-form-input
                class="form-control" v-model="model.status_bko_atasan" :disabled="isDisabled"
                placeholder="Status BKO">
              </b-form-input>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
	export default
	{
		name: 'DataAtasan',
		props: {
			atasan: {
				type: Object,
				required: true,
				default: () => {}
			}
		},
		data()
		{
			return {
				model : {
					nrk_atasan : '',
					nama_atasan : '',
					pd_induk_atasan : '',
					lokasi_gaji_atasan : '',
					lokasi_kerja_atasan : '',
					jenis_pegawai_atasan : '',
					jabatan_atasan : '',
					nama_eselon: '',
					eselon_atasan : '',
					status_pegawai_atasan : '',
					status_bko_atasan : ''
				},
				querySearch: '',
			}
		},
		computed: {
			isDisabled() {
			// evaluate whatever you need to determine disabled here...
			return true;
			}
		},
		watch: {
			atasan: {
				handler: function(n, o) {
					this.model = this.atasan
				},
				deep: true,
				immediate: true
			}
		},
		created()
		{

		}
	}
</script>
