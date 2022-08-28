<template>
  <div>
    <div class="announc--title">
      <i
        class="fal fa-bullhorn icon-stack-1x opacity-100 color-primary mr-1"
      ></i>
      Pengumuman

      <div class="float-right">
        <small class="mr-3">{{ settings.current_date | formatFullWithDay }}</small>
        <span @click="fetchPengumuman()" title="Refresh Pengumuman" style="cursor:pointer;">
          <i class="fal fa-sync"></i>
        </span>
      </div>
    </div>
    
    <div class="announc--content-pinned" v-if="!loading && announcement.new">
      <div class="pinned-title">Pengumuman Terbaru</div>
      <read-more
        :text="announcement.new.isi_pengumuman"
        link="#"
        more-str="Baca selengkapnya"
        less-str="Baca lebih sedikit"
        :max-chars="350"
      >
      </read-more>
    </div>
    <div class="announc--content">
      <div class="title">Pengumuman Lainnya</div>
      <div id="panel-container-information" class="content-container">
        <template v-if="!loading && announcement.all">
          <perfect-scrollbar :options="options">
            <template v-for="(item, key) in announcement.all">
              <div class="content" :key="key">
                <read-more
                  :text="item.isi_pengumuman"
                  link="#"
                  more-str="Baca selengkapnya"
                  less-str="Baca lebih sedikit"
                  :max-chars="350"
                ></read-more>
                <div class="content-foot">
                  <div class="create-on" :title="item.created_at">
                    {{ item.created_at | formatRelativeDay }}
                  </div>
                  <div class="dot">
                    <i class="fas fa-circle"></i>
                  </div>
                  <div class="create-by">by {{ item.created_by }}</div>
                </div>
              </div>
            </template>
          </perfect-scrollbar>
        </template>
        <template v-else>
          <div class="p-2 mt-6 mb-4 text-center">
            <div style="font-size:3rem;font-weight:light;">
              <i class="far fa-scroll"></i>
            </div>
            <div>
              {{ loading ? 'Memuat' : 'Belum ada' }} pengumuman
            </div>
          </div>
        </template>
      </div>
    </div>
    <b-modal
      centered
      v-model="showBanner"
      hide-header
      hide-footer
      body-class="p-2"
      dialog-class="modal-banner"
      size="md"
    >
      <banner :banners="announcement.banners"></banner>
    </b-modal>
  </div>
</template>

<script>
import { PerfectScrollbar } from "vue2-perfect-scrollbar";
import Banner from "@js/frontend/login/__Banner"

export default {
  name: "Pengumuman",
  components: {
    PerfectScrollbar,
    Banner
  },
  props: {
    settings: {
      type: Object,
      default: () => {}
    }
  },
  data() {
    return {
      loading: false,
      options: {
        wheelSpeed: 1,
        wheelPropagation: true,
        minScrollbarLength: 20,
      },
      showBanner: false,
      announcement: {
        new: null,
        all: null,
        banners: null
      },
    };
  },
  methods: {
    async fetchPengumuman() {
      this.loading = true;
      try {
        let url = this.$app.route("pengumuman");
        let { data } = await this.$http.get(url);
        this.announcement = data;

        this.showBanner = !_.isEmpty(this.announcement.banners);
        this.loading = false;
      } catch (error) {
        this.loading = false;
        this.$app.error(error);
      }
    },
  },
};
</script>

<style src="vue2-perfect-scrollbar/dist/vue2-perfect-scrollbar.css" />
<style lang="scss">
.ps {
  height: 300px;
}
.login-container {
  .loginpage {
    &--announcement {
      padding: 1.15rem;
      border-radius: 0 0.7rem 0.7rem 0;
      background-color: rgb(70, 121, 204);
    }
    .announc {
      font-size: 0.82rem;
      &--title {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 1rem;
        color: rgb(255, 255, 255);
      }
      &--content-pinned {
        position: relative;
        margin-top: 1rem;
        margin-bottom: 1rem;
        background-color: rgb(255, 255, 255);
        padding: 0.9rem;
        padding-bottom: 2rem;
        border-radius: 0.7rem;
        > .pinned-title {
          font-size: 0.9rem;
          font-weight: 600;
          margin-bottom: 0.4rem;
          color: rgb(225, 46, 73);
          position: relative;
          &::before {
            font-family: "Font Awesome 5 Pro";
            font-weight: 400;
            content: "\f02e";
            font-size: 1.4rem;
            padding: 0.6rem;
            color: rgb(225, 46, 73);
            position: absolute;
            /* transform: rotate(60deg); */
            top: -18px;
            right: -8px;
          }
        }

        p {
          margin-bottom: .6rem;
        }
        span {
          position: absolute;
          right: 15px;
          >#readmore {
            color: var(--secondary);
            font-size: 0.7rem;
            padding-right: 0.4rem;
            text-decoration: none;
            cursor: pointer;
            &:nth-of-type(1) {
              &::after {
                content: "\f101";
                font-family:'Font Awesome 5 Pro';
                display: inline-block;
                padding-left: .2rem;
                padding-right: .2rem;
                transition: all ease-in-out 0.3s;
              }
              &:hover {
                &::after {
                  padding-left: .3rem;
                }
              }
            }
            &:nth-of-type(2) {
              &::after {
                content: "\f101";
                font-family:'Font Awesome 5 Pro';
                display: inline-block;
                transform: scale(-1);
                padding-left: .2rem;
                padding-right: .2rem;
              }
            }
          }
        }
      }
      &--content {
        color: rgb(255, 255, 255);
        > .title {
          font-size: 0.75rem;
          font-weight: 600;
          margin-bottom: 0.6rem;
        }
        .content-container {
          .content {
            position: relative;
            background-color: rgba(255, 255, 255, 0.2);
            padding: 0.9rem;
            border-radius: 0.7rem;
            margin-bottom: 0.8rem;
            .content-foot {
              display: flex;
              align-content: center;
              font-size: 0.6rem;
              margin-top: 0.6rem;
              color: rgb(223, 223, 223);
              .create-by {
                padding-left: 0.4rem;
              }
              .dot {
                transform: scale(0.45);
              }
              .create-on {
                padding-right: 0.4rem;
              }
            }
          }

          span {
            position: absolute;
            right: 15px;
            bottom: 20px;
            font-size: 0.6rem;
            >#readmore {
              text-decoration: none;
              cursor: pointer;
              margin-top: -0.3rem;
              padding: .3rem .5rem;
              border-radius: 0.4rem;
              background-color: rgba(255, 255, 255, 0.2);
              color: rgb(255, 255, 255);
              transition: all ease-in-out 0.3s;
              &:nth-of-type(1) {
                &::after {
                  content: "\f101";
                  font-family:'Font Awesome 5 Pro';
                  display: inline-block;
                  padding-left: .2rem;
                  padding-right: .2rem;
                  transition: all ease-in-out 0.3s;
                }
              }
              &:nth-of-type(2) {
                &::after {
                  content: "\f101";
                  font-family:'Font Awesome 5 Pro';
                  display: inline-block;
                  transform: scale(-1);
                  padding-left: .2rem;
                  padding-right: .2rem;
                }
              }
              &:hover {
                background-color: rgba(255, 255, 255, 0.35);
              }
            }
          }
        }
      }
    }
  }
}
.modal-banner {
  max-width: 580px;
  margin: 30px auto;
}
</style>
