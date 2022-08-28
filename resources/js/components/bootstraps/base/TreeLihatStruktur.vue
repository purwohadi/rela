<template>
  <section class="lihat-struktur">
    <b-table
      striped
      borderless
      head-variant="light"
      :id="idTable"
      :ref="idTable"
      :busy="busy"
      :fields="fields"
      :items="items"
      :api-url="apiUrl"
    >
      <template #cell(rowdetail)="{toggleDetails, detailsShowing, item}">
        <b-button
          v-if="item.has_bawahan"
          size="sm"
          :variant="`outline-${detailsShowing ? 'danger' : 'primary'}`"
          class="btn-icon rounded-circle waves-effect waves-themed hover-effect-dot"
          @click="toggleDetails"
        >
          <i
            :class="`fal ${detailsShowing ? 'fa-minus' : 'fa-plus'}`"
          >
          </i>
        </b-button>
      </template>
      <template #row-details="data">
        <tree-lihat-struktur
          v-if="data.item.has_bawahan"
          :thbl="thbl"
          :settings="{
            slug_path: data.item.slug_path,
            is_child: 'true'
          }"
        ></tree-lihat-struktur>
      </template>
      <template #table-busy>
        <spinner></spinner>
      </template>
    </b-table>
  </section>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
export default {
  name: 'TreeLihatStruktur',
  props: {
    idTable: {
      type: String,
      required: false,
      default: 'datatabletree'
    },
    thbl: {
      type: String,
      required: true
    },
    settings: {
      type: Object,
      required: false,
      default: () => {}
    },
  },
  data() {
    return {
      busy: false,
      fields: [
        {
          key: 'rowdetail',
          label: 'Detail',
          thStyle: { 'width': '5%' }
        },
        {
          key: 'nrk',
          label: 'NRK',
          sortable: false,
        },
        {
          key: 'nama',
          label: 'Nama',
          sortable: true
        },
        {
          key: 'jabatan',
          label: 'Jabatan',
          sortable: false
        },
      ],
      apiUrl: 'setting-struktur.search',
      currentCallback: null,
      items: [],
    }
  },
  computed: {
    ...mapGetters('struktur', ['getItems'])
  },
  watch: {
    thbl: {
      immediate: false,
      handler: function(n, o) {
        if (n && n !== o) setTimeout(this.loadProvider, 50)
      }
    }
  },
  mounted() {
    this.loadProvider()
  },
  methods: {
    ...mapActions('struktur', ['setItem']),
    loadProvider: _.debounce(async function() {
      let vm = this
      let results = []
      vm.busy = true
      vm.items = []

      if (vm.getItems.length) {
        let _cloneSettings = _.isEmpty(vm.settings) ? {...vm.settings, ...{slug_path: 'root'}} : {...vm.settings}
        let isFounded = vm.getItems.find(n => n.thbl == vm.thbl && n.settings.slug_path == _cloneSettings.slug_path)
        if (!_.isEmpty(isFounded)) {
          vm.setItems(isFounded.item)
          return
        }
      }
      results = await vm.$http.get(vm.$app.route(vm.apiUrl), {
        params: Object.assign({}, { thbl: vm.thbl }, vm.settings)
      })
      vm.setItems(results.data.data)
    }, 150),
    setItems(results) {
      let vm = this
      Promise.resolve(results)
        .then(results => {
          vm.items = results
          return results
        })
        .then(item => this.setItem({ thbl: vm.thbl, settings: vm.settings, item }))
        .then(vm.busy = false)
        .then(() => {
          // untuk close semua detail panel
          vm.items.forEach(item => {
            vm.$set(item, '_showDetails', false)
          })
        })
    },
    // // jangan dihapus, siapa tau ada request setiap expand satu yang lainnya ketutup hahahaha
    // handleOnExpanded(row) {
    //   if (row._showDetails) {
    //     this.$set(row, '_showDetails', false)
    //   } else {
    //     this.items.forEach(item => {
    //       this.$set(item, '_showDetails', false)
    //     })

    //     this.$nextTick(() => {
    //       this.$set(row, '_showDetails', true)
    //     })
    //   }
    // }
  }
}
</script>

<style>

</style>
