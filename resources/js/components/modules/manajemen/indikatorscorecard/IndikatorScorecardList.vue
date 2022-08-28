<template>
  <div class="row">
    <div class="col-12">
      <section class="indi-bsc">
        <data-table
          :id="`${resourceName}`"
          :fields="fields"
          api-url="manajemen-indikator-scorecard.search"
          title="Daftar Indikator Scorecard"
          actions="SCRWUDN"
          row-action-width="10%"
          :minimum-search-len="2"
          @add="handleAdd"
          @update="handleUpdate"
          @delete="handleDelete"
          @onQuerySearch="handleQuerySearch"
        >
          <template #cell(dt_updated_at)="{ data }">
            <span>{{ data.item.dt_updated_at }}</span>
          </template>
          <template #cell(e_status_aktif)="{ data }">
            <b-form-checkbox
              :checked="data.item.e_status_aktif"
              switch
              @change="onActiveToggle(data.item)"
            >
            </b-form-checkbox>
          </template>
        </data-table>
      </section>
    </div>
    <indikator-scorecard-modal
      :m-id="modal.id"
      :title="modal.title"
      :item="modal.item"
      :is-edit="modal.isEdit"
    ></indikator-scorecard-modal>
  </div>
</template>

<script>
import  IndikatorScorecardModal from './IndikatorScorecardModal.vue'

export default {
  name: 'IndikatorScorecardList',
  components:{
    IndikatorScorecardModal
  },
  data() {
    return {
      modelName: 'slug',
      resourceName: 'indikator_scorecard_table',
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
          key: 'e_jabatan',
          label: 'Jabatan',
          sortable: true,
        },
        {
          key: 'e_sifat',
          label: 'Sifat',
          sortable: true,
        },
        {
          key: 'v_satuan',
          label: 'Satuan',
          sortable: true
        },
        {
          key: 'tx_indikator',
          label: 'Indikator',
          sortable: false
        },
        {
          key: 'f_bobot',
          label: 'Bobot',
          sortable: true,
        },
        {
          key: 'v_tahun_mulai',
          label: 'Mulai Berlaku',
          sortable: true,
        },
        {
          key: 'v_tahun_akhir',
          label: 'Akhir Berlaku',
          sortable: true,
        },
      ],
      modal:{
        id: 'form-tambah-scorecard',
        title: '',
        isEdit: '',
        item: {}
      },
      querySearch: '',
    }
  },
  methods: {
    handleAdd() {
      this.modal.title = 'Tambah Indikator Scorecard'
      this.modal.isEdit = false
      this.$bvModal.show(this.modal.id)
    },
    handleQuerySearch(q) {
      this.querySearch = q
    },
    handleUpdate(item) {
      this.modal.item = { ...item }
      this.modal.isEdit = true
      this.modal.title = 'Ubah Indikator Scorecard'
      this.$bvModal.show(this.modal.id)
    },
    handleDelete(item) {
      const vm = this
      vm.$app.confirm({
        text: 'Apakah yakin akan menghapus data ?',
        preConfirm: () => {
          return vm.$http
            .delete(vm.$app.route('manajemen-indikator-scorecard.delete'), {
              data: { slug: item.slug_path }
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
                this.$root.$emit('bv::refresh::table', this.resourceName)
              }
            })
          }
        })
    },
    onActiveToggle(items) {
      this.$http
      .post(
        this.$app.route(`manajemen-indikator-scorecard.active`, {
          [this.modelName]: items.slug_path,
        })
      )
      .finally(() => {
        this.$root.$emit('bv::refresh::table', 'indikator_scorecard_table')
      })
      .catch(error => {
        this.$app.error(error)
      })
    },
  }
}
</script>

<style lang="scss">
  .image-preview {
    border-radius: .35rem;
    margin: .7rem 0;
    width: 100px;
    height: auto;
    transition: ease-in-out 0.3s;
    img {
      border-radius: .35rem;
      width: 100px;
      height: auto;
      &.image-cover {
        object-fit: cover;
        object-position: right top;
      }
    }
  }

  .tx-indikator > span {
    display: none !important;
  }
</style>

