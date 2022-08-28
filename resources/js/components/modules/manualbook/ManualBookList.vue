<template>
  <b-card class="panel">
    <div class="panel-hdr">
      <h3 class="text-dark"><span class="font-weight-bold">Buku Manual</span> {{ $app.appname }}</h3>
    </div>
    <template v-if="loading">
      Loading
    </template>
    <div class="pt-2 pb-2" v-else>
      <b-list-group id="list-of-manual-book" flush>
        <b-list-group-item v-for="(book, index) in manualBooks" :key="index">
          <div class="mb-3 book-item" v-b-toggle="'collapse-'+index">
            <div class="book-item--icon"></div> {{ book.name }}
          </div>
          <template v-if="book.hasChild">
            <b-collapse :visible="book.hasChild ? true : false" :id="`collapse-${index}`" v-for="(child, key) in book.childrens" :key="key" class="h6 font-weight-normal ml-2 pl-3 pr-3 pt-2 pb-2">
              <div class="d-flex flex-row align-item-start">
                <div class="mr-4">
                  <i class="far fa-file pr-2 fa-lg"></i>
                  <a target="_blank" :href="child.file_book" class="text-decoration-none">{{ child.name }}</a>
                </div>
                <div>
                  <button 
                    class="btn btn-link btn-video p-0 fw-500" 
                    v-if="child.url_video"             
                    @click="handleVideo(child.url_video, child.name)"
                  >
                    <i class="fab fa-youtube fa-lg"></i>
                    Lihat Video
                  </button>
                </div>
              </div>
            </b-collapse>
          </template>
        </b-list-group-item>
      </b-list-group>
    </div>
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
  </b-card>
</template>

<script>
import ManualBookVideo from '@components/modules/manualbook/ManualBookVideo'

export default {
  name: 'ManualBookList',
  components: {
    ManualBookVideo
  },
  data() {
    return {
      resourceName: 'manualbook',
      loading: false,
      manualBooks: [],
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
  created() {
    this.fetchManualBook()
  },
  methods: {
    handleVideo(url, title) {
      this.selectedUrl = url
      this.selectedTitle = title
      this.showModal.video = true
    },
    async fetchManualBook() {
      let vm = this
      vm.loading = true
      vm.$http
      .get(vm.$app.route('manualbook.all-book'))
      .then(response => {
        vm.manualBooks = response.data.data
        vm.loading = false
      })
    },
  }
}
</script>

<style lang="scss">
@mixin faClass {
  font-family: 'Font Awesome 5 Pro';
  font-weight: 400;
  font-size: 1.33333em;
  display: unset;
}

#list-of-manual-book {
  .book-item {
    transition: all .3s ease-in;
    font-size: 0.9rem;
    &:hover {
      cursor: pointer;
    }

    &.not-collapsed {
      .book-item--icon {
        @include faClass;
        margin-right: .4rem;
        &::before {
          content: "\f07c";
        }
      }
    }
    &.collapsed {
      .book-item--icon {
        @include faClass;
        margin-right: .4rem;
        &::before {
          content: "\f07b";
        }
      }
    }
  }
  .text-decoration-none {
    text-decoration: none !important;
  }
}

  .btn-video {
    &:active {
      box-shadow: none !important;
    }
    font-size: 0.875rem;
  }
</style>
