<template>
  <div class="row">
    <div class="col-12">
      <section class="skpd">
        <data-table
          :id="`${resourceName}`"
          :fields="fields"
          :options-filter-fields="optionsFilterFields"
          api-url="manajemen-pengumuman.search"
          title="Daftar Pengumuman"
          actions="SCRWUDNM"
          row-action-width="10%"
          :minimum-search-len="2"
          @add="handleAdd"
          @update="handleUpdate"
          @delete="handleDelete"
          @onQuerySearch="handleQuerySearch"
        >
          <template #cell(tx_isi_pengumuman)="{ data }">
            <span v-if="data.item.has_banner_image">
              <!-- <b-img
                class="image-preview"
                :src="data.item.thumbnail_image_path"
                variant="secondary"
              ></b-img> -->
              {{ data.item.media[0].file_name }}
            </span>
            <span v-else>{{ data.item.tx_isi_pengumuman }}</span>
          </template>
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
          <template #extraMessage>
            <button
              type="button"
              class="btn btn-warning btn-sm rounded waves-effect waves-themed mr-lg-1"
              data-toggle="tooltip"
              data-placement="top"
              v-b-tooltip.hover.top="'Kirim pesan'"
              @click="handleMessage"
            >
              <i class="fal fa-comment"></i> Kirim pesan
            </button>
          </template>
          <!-- <template v-slot:cell(e_highlight)="{ data }">
            <b-form-checkbox
              v-if="data.item.e_kat_pengumuman == 1"
              :checked="data.item.e_highlight"
              switch
              @change="onHighlightToggle(data.item)"
            >
            </b-form-checkbox>
          </template> -->
        </data-table>
      </section>
    </div>
    <pengumuman-form
      :m-id="modal.id"
      :title="modal.title"
      :item="modal.item"
    ></pengumuman-form>
    <inbox-form
      :m-id="'kirim-pesan'"
      :title="modal.title"
      :item="modal.item"
      :user_group="user_group"
    ></inbox-form>
  </div>
</template>

<script>
import PengumumanForm from './PengumumanForm.vue'
import inboxForm from '../../inbox/InboxFormAdmin.vue'

export default {
  name: 'PengumumanList',
  components:{
    PengumumanForm,
    inboxForm
  },
  data() {
    return {
      modelName: 'slug',
      resourceName: 'pengumuman_table',
      user_group:[],
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
          key: 'kategori',
          label: 'Kategori',
          sortable: true,
        },
        // {
        //   key: 'e_highlight',
        //   label: 'Highlight',
        //   sortable: true,
        // },
        {
          key: 'tx_isi_pengumuman',
          label: 'Isi Pengumuman',
          sortable: true,
        },
        {
          key: 'v_updated_by',
          label: 'User Update',
          sortable: true,
        },
        {
          key: 'dt_updated_at',
          label: 'Tanggal Update',
          sortable: true,
        },
        {
          key: 'e_status_aktif',
          label: 'Aktif',
          sortable: true,
        },

      ],
      modal:{
        id: 'form-tambah-pengumuman',
        title: '',
        item: {}
      },
      optionsFilterFields: [
        { key: null, label: 'Filter Kategori' },
        { key: '1', label: 'Info Depan' },
        { key: '2', label: 'Banner' },
      ],
      querySearch: '',
    }
  },
  methods: {
    handleAdd() {
      this.modal.title = 'Tambah Pengumuman'
      this.$bvModal.show(this.modal.id)
    },
    handleQuerySearch(q) {
      this.querySearch = q
    },
    handleUpdate(item) {
      this.modal.item = { ...item }
      this.modal.title = 'Ubah Pengumuman'
      this.$bvModal.show(this.modal.id)
    },
    handleDelete(item) {
      const vm = this
      vm.$app.confirm({
        text: 'Apakah yakin akan menghapus data ?',
        preConfirm: () => {
          return vm.$http
            .delete(vm.$app.route('manajemen-pengumuman.drop'), {
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
    handleMessage(item) {
      this.getUserGroup()
      this.modal.item = { ...item }
      this.modal.title = 'Kirim Pesan'
      this.$bvModal.show('kirim-pesan')
    },
    onActiveToggle(items) {
      this.$http
      .post(
        this.$app.route(`manajemen-pengumuman.active`, {
          [this.modelName]: items.slug_path,
        })
      )
      .finally(() => {
        this.$root.$emit('bv::refresh::table', 'pengumuman_table')
      })
      .catch(error => {
        this.$app.error(error)
      })
    },
    getUserGroup() {
      this.$http
      .get(
        this.$app.route(`group.all`)
      )
      .then(result => {
          if (result.isDismissed) return
          this.user_group = result.data
        })
      .finally(() => {
        // this.$root.$emit('bv::refresh::table', 'pengumuman_table')
      })
      .catch(error => {
        this.$app.error(error)
      })
    },
    // onHighlightToggle(items) {
    //   this.$http
    //   .post(
    //     this.$app.route(`manajemen-pengumuman.highlight`, {
    //       [this.modelName]: items.slug_path,
    //     })
    //   )
    //   .finally(() => {
    //     this.$root.$emit('bv::refresh::table', 'pengumuman_table')
    //   })
    //   .catch(error => {
    //     this.$app.error(error)
    //   })
    // },
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
</style>

