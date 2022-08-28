<template>
  <div>
    <data-table
      :id="`${resourceName}-table`"
      :fields="fields"
      api-url="manualbook.get"
      title="Daftar Manual Book"
      actions="SCRWUDN"
      row-action-width="10%"
      :minimum-search-len="2"
      @add="handleAdd"
      @update="handleUpdate"
      @delete="handleDelete"
      @onQuerySearch="handleQuerySearch"
      :filter-exclude="[`nama_file`]"
    >
      <template #cell(folder)="{ data }">
        <template v-if="data.item.folder">
          <i class="far fa-folder"></i> {{ data.item.folder.nama_folder }}
        </template>
      </template>
      <template #cell(video)="{ data }">
        <template v-if="data.item.url_video">
          <b-button 
            variant="primary"
            @click="handleVideo(data.item.url_video, data.item.nama_judul)"
          >
            <i class="fas fa-play"></i> Lihat Video
          </b-button>
        </template>
      </template>
      <template #cell(nama_file)="{ data }">
        <template v-if="data.item.nama_file">
          <b-button
            :href="data.item.file_book"
            target="_blank"
            variant="outline-info"
            size="sm"
          >
            <i class="far fa-file-alt"></i>
            {{ data.item.nama_file }}
          </b-button>
        </template>
      </template>
    </data-table>

    <b-modal
      :id="`${resourceName}-add`"
      title="Buku Manual"
      v-model="showModal.form"
      size="lg"
      hide-footer
      body-class="pt-0 pl-3 pr-3 pb-3"
    >
      <manual-book-form :id="selectedBook"></manual-book-form>
    </b-modal>

    <b-modal
      :id="`${resourceName}-view-video`"
      :title="`Video Tutorial ${selectedTitle}`"
      v-model="showModal.video"
      size="xl"
      hide-footer
      body-class="pt-0 pl-3 pr-3 pb-3"
    >
      <manual-book-video :url="selectedUrl"></manual-book-video>
    </b-modal>
  </div>
</template>

<script>
import ManualBookForm from '@components/modules/manualbook/ManualBookForm'
import ManualBookVideo from '@components/modules/manualbook/ManualBookVideo'

export default {
  name: 'ManualBook',
  components: {
    ManualBookForm, ManualBookVideo
  },
  data() {
    return {
      resourceName: 'manualbook',
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
          key: 'type',
          label: 'Jenis',
          sortable: true,
          class: 'text-capitalize'
        },
        {
          key: 'folder',
          label: 'Lokasi Folder',
          sortable: true,
        },
        {
          key: 'nama_judul',
          label: 'Nama Judul',
          sortable: true,
        },
        {
          key: 'nama_file',
          label: 'Nama File',
          sortable: true,
        },
        {
          key: 'video',
          label: 'Video Tutorial'
        }
      ],
      selectedBook: null,
      selectedUrl: '',
      selectedTitle: '',
      showModal: {
        video: false,
        form: false
      }
    }
  },
  watch: {
    'showModal.video' (n) {
      if(!n) {
        this.selectedUrl = ''
        this.selectedTitle = ''
      }
    }
  },
  methods: {
    handleAdd() {
      this.selectedBook = null
      this.showModal.form = true
    },
    handleVideo(url, title) {
      this.selectedUrl = url
      this.selectedTitle = title
      this.showModal.video = true
    },
    handleQuerySearch() {},
    handleUpdate(data) {
      this.selectedBook = data.slug_path
      this.showModal.form = true
    },
    handleDelete(item, index, $el) {
      const vm = this
      vm.$app.confirm({
      text: vm.$t(`${vm.resourceName}.alert.confirm.drop`, { name: item.nama_judul }),
      preConfirm: () => {
        return vm.$http
        .delete(vm.$app.route(`${vm.resourceName}.drop`), {
          data: { slug_path: item.slug_path }
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
          vm.$root.$emit('bv::refresh::table', `${vm.resourceName}-table`)
          }
        })
      }
    })
    },
  }
}
</script>

<style>

</style>
