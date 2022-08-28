<template>
  <!-- BEGIN Page Wrapper -->
  <div class="page-wrapper">
    <div class="page-inner">
      <!-- BEGIN Left Aside -->
      <part-aside></part-aside>
      <!-- END Left Aside -->
      <div class="page-content-wrapper">
        <!-- BEGIN Page Header -->
        <header class="page-header" role="banner">
          <!-- DOC: nav menu layout change shortcut -->
          <div class="hidden-md-down dropdown-icon-menu position-relative">
            <a
              href="#"
              class="header-btn btn press-scale-down"
              data-action="toggle"
              data-class="nav-function-minify"
              :title="btnTitle"
              :state="isMinify"
              @click="onClick"
            >
              <i class="ni ni-menu"></i>
            </a>
          </div>
          <!-- DOC: mobile button appears during mobile width -->
          <div class="hidden-lg-up">
            <a
              href="#"
              class="header-btn btn press-scale-down"
              data-action="toggle"
              data-class="mobile-nav-on"
              @click="onClick"
            >
              <i class="ni ni-menu"></i>
            </a>
          </div>
          <div class="ml-auto d-flex">
            <!-- app options -->
            <!-- <part-options></part-options> -->
            <!-- app notification menu -->
            <!-- <part-notif></part-notif> -->
            <!-- app user menu -->
            <part-user></part-user>
          </div>
        </header>
        <!-- END Page Header -->
        <!-- BEGIN Page Content -->
        <main id="js-page-content" role="main" class="page-content">
          <part-breadcrumb></part-breadcrumb>
          <part-subheader></part-subheader>
          <router-view></router-view>
        </main>
        <!-- END Page Content -->
        <!-- this overlay is activated only when mobile menu is triggered -->
        <div class="page-content-overlay" data-action="toggle" data-class="mobile-nav-on"></div>
        <part-footer></part-footer>
      </div>
    </div>
    <b-modal
      size="md"
      centered
      hide-header
      hide-footer
      hide-header-close
      no-close-on-backdrop
      title="Ganti Password"
      v-model="isExpired"
      content-class="shadow p-0"
      id="change-password"
      name="change-password"
      ref="changePass"
    >
      <h5 class="font-weight-bolder">Ubah Password</h5>
      <b-alert show class="mt-2 mb-3 pt-2 pb-2 pl-3 pr-3">
        <span>Terakhir Diubah : </span>
        <template v-if="$app.user.d_last_update_pass">
          {{ $app.user.d_last_update_pass | formatDateNoTime }}
        </template>
        <template v-else>
          -
        </template>
      </b-alert>
      <ganti-password></ganti-password>
    </b-modal>
  </div>
  <!-- END Page Wrapper -->
</template>

<script>
import PartAside from './parts/PartAside'
import PartOptions from './parts/PartOptions'
// import PartNotif from './parts/PartNotif'
import PartUser from './parts/PartUser'
import PartFooter from './parts/PartFooter'
import PartBreadcrumb from './parts/PartBreadcrumb'
import PartSubheader from './parts/PartSubheader'
import GantiPassword from './parts/GantiPassword'

export default {
  name: 'Container',
  components: {
    PartAside,
    PartOptions,
    // PartNotif,
    PartUser,
    PartFooter,
    PartBreadcrumb,
    PartSubheader,
    GantiPassword,
  },
  data() {
    return {
      isMinify: false,
    }
  },
  computed: {
    btnTitle() {
      return this.isMinify ? 'Perbesar menu' : 'Perkecil menu'
    },
    btnIcon() {
      return this.isMinify ? 'fal fa-times' : 'fal fa-thumbtack'
      // <i class="fal fa-thumbtack"></i>
    },
    isExpired() {
      // expired when last update more than 3 month
      if(this.$app.user.d_last_update_pass) {
        let currentDate = this.$moment(this.$app.current_date).format('YYYY-MM-DD')
        let lastUpdatePass = this.$moment(this.$app.user.d_last_update_pass).format('YYYY-MM-DD')
        return this.$moment(currentDate).diff(lastUpdatePass, 'month') >= 3 ? true : false
      }
      return true
    },
  },
  methods: {
    onClick(e) {
      this.isMinify = !this.isMinify
      let el = this.$children.filter(child => Object.keys(child.$refs).includes('jsPrimaryNav')).shift()
      let nav = $(el.$refs.jsPrimaryNav)

      if (this.isMinify) {
        if (nav.parent().hasClass('slimScrollDiv')) {
          nav.removeAttr('style')
          nav.slimScroll({ destroy: true })
        }
      } else {
        nav.slimScroll({
            height: '100%',
            color: '#fff',
            size: '4px',
            distance: '4px',
            railOpacity: 0.4,
            wheelStep: 10
          })
      }
    }
  }
}
</script>
