<template>
  <!-- begin form add -->
  <b-modal
    :id="mId"
    :ref="mId"
    :title="title"
    size="lg"
    hide-footer
    no-close-on-backdrop
    no-close-on-esc
    @close="onCloseModal"
    @hide="onCloseModal"
  >
    <table class="table table-striped">
      <tbody>
        <tr>
          <td>Nama Inisiatif</td>
          <td>: {{ item.nama_inisiatif }}</td>
        </tr>
        <tr>
          <td>OPD Pemilik</td>
          <td>: {{ item.opd_pemilik }}</td>
        </tr>
        <tr>
          <td>OPD Koordinator</td>
          <td>: {{ item.opd_koordinator || '-' }}</td>
        </tr>
        <tr>
          <td>Jenis Inisiatif</td>
          <td>: {{ item.jenis_inisiatif || '-' }}</td>
        </tr>
        <tr>
          <td>Domain Arsitektur</td>
          <td>: {{ item.domain_arsitektur || '-' }}</td>
        </tr>
        <tr>
          <td>Jenis Kesenjangan Aplikasi</td>
          <td>: {{ item.jenis_kesenjangan_app || '-' }}</td>
        </tr>
        <tr>
          <td>Aplikasi</td>
          <td>: {{ item.aplikasi || '-' }}</td>
        </tr>
        <tr>
          <td>Deskripsi Pekerjaan</td>
          <td>: {{ item.deskripsi_pekerjaan || '-' }}</td>
        </tr>
        <tr>
          <td>Tahun Awal</td>
          <td>: {{ item.tahun_awal || '-' }}</td>
        </tr>
        <tr>
          <td>Tahun Akhir</td>
          <td>: {{ item.tahun_akhir || '-' }}</td>
        </tr>
      </tbody>
    </table>
  </b-modal>
  <!-- end form add -->
</template>

<script>
export default {
    name: 'RefInisiatifView',
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
            required: true,
            default: () => {}
        }
    },
    data() {
        return {
            show: true,
        }
    },
    methods: {
        onCloseModal() {
            this.$bvModal.hide(this.mId)
        }
    }
}
</script>
