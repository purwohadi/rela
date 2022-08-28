<template>
  <section class="riwayat-jabatan">
    <data-table
      :id="tableId"
      :fields="fields"
      :api-url="`/profil/riwayat-jabatan/${nrk}`"
      :force-url="true"
      :title="$t('profil.datatable.titleJabatan')"
      actions=""
      row-action-width="13%"
      row-num-width="5%"
    >
    </data-table>
  </section>
</template>

<script>
  export default {
    name: 'RiwayatJabatan',
    props: {
      jabatan: {
        type: String,
        required: true,
        default: () => ''
      }
    },
    data() {
      return {
        fields: [
          {
            key: 'rownum',
            class: 'text-center',
          },
          {
            key: 'nosk',
            label: 'No SK',
            sortable: true,
          },
          {
            key: 'tgsk',
            label: 'Tgl SK',
            sortable: true,
            formatter: (x) => (x ? this.$moment(x).format('DD-MM-YYYY') : null),
          },
          {
            key: 'tmt',
            label: 'TMT',
            sortable: true,
            formatter: (x) => (x ? this.$moment(x).format('DD-MM-YYYY') : null),
          },
          {
            key: 'lokasi_kerja',
            label: 'Lokasi Kerja',
            sortable: true,
          },
          {
            key: 'jabatan1',
            label: 'Jabatan',
            sortable: true
          },
          {
            key: 'tg_upd',
            label: 'Tgl Update',
            sortable: true,
            formatter: (x) => (x ? this.$moment(x).format('DD-MM-YYYY') : null)
          },
        ],
        querySearch: '',
        tableId: 'strukturtable',
        cariNrkAtasan: null,
        isBusy: false,
        nrk : this.nrk,
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
      jabatan: {
        deep: true,
        immediate: true,
        handler: function(n, o) {
          this.nrk = this.jabatan
        },
      }
    },
    methods: {
    },
  }
</script>
