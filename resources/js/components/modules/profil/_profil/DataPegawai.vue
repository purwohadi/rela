<template>
  <div class="col-sm-12 col-lg-6 col-xl-6">
    <div class="panel">
      <div class="panel-hdr">
        <h2>
          Data <span class="fw-300">Pegawai</span>
        </h2>
      </div>
      <div class="panel-container show">
        <div class="panel-content">
          <div class="form-group row">
            <label class="col-form-label col-6 col-lg-3 form-label text-lg-left">NRK</label>
            <div class="col-6 col-lg-9">
              <b-form-input
                class="form-control" dat-peg="datPeg.v_nrk" :disabled="isDisabled"
                placeholder="NRK Pegawai">
              </b-form-input>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-form-label col-6 col-lg-3 form-label text-lg-left">Nama</label>
            <div class="col-6 col-lg-9">
              <b-form-input
                class="form-control" dat-peg="datPeg.v_nama" :disabled="isDisabled"
                placeholder="Nama Pegawai">
              </b-form-input>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-form-label col-6 col-lg-3 form-label text-lg-left">PD Induk</label>
            <div class="col-6 col-lg-9">
              <b-form-input class="form-control" dat-peg="datPeg.pd_induk" :disabled="isDisabled" placeholder="PD Induk">
              </b-form-input>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-form-label col-6 col-lg-3 form-label text-lg-left">Lokasi Gaji</label>
            <div class="col-6 col-lg-9">
              <b-form-input
                class="form-control" dat-peg="datPeg.lokasi_gaji_pegawai" :disabled="isDisabled"
                placeholder="Lokasi Gaji">
              </b-form-input>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-form-label col-6 col-lg-3 form-label text-lg-left">Lokasi Kerja</label>
            <div class="col-6 col-lg-9">
              <b-form-input
                class="form-control" dat-peg="datPeg.nama_lokasi" :disabled="isDisabled"
                placeholder="Lokasi Kerja">
              </b-form-input>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-form-label col-6 col-lg-3 form-label text-lg-left">Jenis Pegawai</label>
            <div class="col-6 col-lg-9">
              <b-form-input
                class="form-control" dat-peg="datPeg.jenis_pegawai" :disabled="isDisabled"
                placeholder="Jenis Pegawai">
              </b-form-input>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-form-label col-6 col-lg-3 form-label text-lg-left">Jabatan</label>
            <div class="col-6 col-lg-9">
              <b-form-input
                class="form-control" dat-peg="datPeg.jabatan_pegawai" :disabled="isDisabled"
                placeholder="Jabatan">
              </b-form-input>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-form-label col-6 col-lg-3 form-label text-lg-left">Eselon</label>
            <div class="col-6 col-lg-9">
              <b-form-input
                class="form-control" dat-peg="datPeg.nama_eselon" :disabled="isDisabled"
                placeholder="Eselon">
              </b-form-input>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-form-label col-6 col-lg-3 form-label text-lg-left">Status Pegawai</label>
            <div class="col-6 col-lg-9">
              <b-form-input
                class="form-control" dat-peg="datPeg.status_pegawai_pegawai" :disabled="isDisabled"
                placeholder="Status Pegawai">
              </b-form-input>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-form-label col-6 col-lg-3 form-label text-lg-left">Status BKO</label>
            <div class="col-6 col-lg-9">
              <b-form-input
                class="form-control" dat-peg="datPeg.status_bko_pegawai" :disabled="isDisabled"
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
		name: 'DataPegawai',
		props: {
			datPeg: {
				type: Object,
				//type: String,
				required: true,
				default: () => {}
			}
		},
		data()
		{
			return {
				model : {
					nrk_pegawai : '',
					nama_pegawai : '',
					pd_induk_pegawai : '',
					lokasi_gaji_pegawai : '',
					lokasi_kerja_pegawai : '',
					jenis_pegawai_pegawai : '',
					jabatan_pegawai : '',
					eselon_pegawai : '',
					status_pegawai_pegawai : '',
					status_bko_pegawai : ''
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
			datPeg: {
				handler: function(n, o) {
					this.model = this.datPeg
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
