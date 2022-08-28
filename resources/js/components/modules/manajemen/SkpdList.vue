<template>
  <div class="row">
    <div class="col-12">
      <section class="skpd">
        <data-table
          id="skpdlisttable"
          :fields="fields"
          :options-filter-fields="optionsFilterFields"
          api-url="manajemen-skpd.search"
          title="Daftar Perangkat Daerah"
          actions="SREWPFUDVN"
          row-action-width="10%"
          :minimum-search-len="2"
          @add="handleAdd"
          @update="handleUpdate"
          @delete="handleDelete"
          @onQuerySearch="handleQuerySearch"
        >
        </data-table>
      </section>
    </div>
  </div>
</template>

<script>
export default {
  name: 'SkpdList',
  data() {
    return {
      fields: [
        {
          key: 'rowaction',
          label: '',
          class: 'text-center',
        },
        {
          key: 'rownum',
          class: 'text-center',
        },
        {
          key: 'v_kode_skpd',
          label: 'Kode PD',
          sortable: true,
        },
        {
          key: 'v_nama_skpd',
          label: 'Nama PD',
          sortable: true,
        },
        {
          key: 'v_unit_id',
          label: 'Unit ID',
          sortable: true,
        },
        {
          key: 'bidang',
          label: 'Bidang Asisten',
          sortable: true,
        },
        {
          key: 'is_induk',
          label: 'Induk',
          sortable: true,
        },
        {
          key: 'v_tahun_awal',
          label: 'Tahun Awal',
          sortable: true,
        },
        {
          key: 'v_tahun_akhir',
          label: 'Tahun Akhir',
          sortable: true,
        },
      ],
      optionsFilterFields: [
        { key: null, label: 'Filter Induk' },
        { key: '1', label: 'Ya' },
        { key: '0', label: 'Tidak' }
      ],
      querySearch: '',
    }
  },
  methods: {
    handleAdd() {
      this.$router.push({name: 'tambah-pd'})
    },
    handleQuerySearch(q) {
      this.querySearch = q
    },
    handleUpdate(item) {
      this.$router.push({name: 'ubah-pd', params: { id: item.slug_path }})
    },
    handleDelete(item) {
      const vm = this
      vm.$app.confirm({
        text: 'Apakah yakin akan menghapus data PD '+item.v_nama_skpd,
        preConfirm: () => {
          return vm.$http
            .delete(vm.$app.route('manajemen-skpd.drop'), {
              data: { kode_skpd: item.v_kode_skpd }
            })
            .then(response => {
              if (response.data.status == "error") {
                let errors = response.data.message
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
          if (result.value.data.status == "success") {
            vm.$app.success(result.value.data.message)
            .then(response => {
              if (response.value === true) {
                this.$root.$emit('bv::refresh::table', 'skpdlisttable')
              }
            })
          }
        })
    },
  }
}
</script>
