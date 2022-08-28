<template>
  <div class="user-menu" ref="usermenu">
    <a
      ref="userthumb"
      href="#"
      data-toggle="dropdown"
      :title="$app.user.v_username"
      class="header-icon d-flex align-items-center justify-content-center ml-2"
    >
      <b-avatar
        :variant="hasAvatar? 'default' : 'secondary'"
        :src="avatar"
        :text="$app.getInitialName($app.user.v_username)"
        :alt="$app.user.v_username"
      ></b-avatar>
    </a>
    <div class="dropdown-menu dropdown-menu-animated w-auto h-auto" ref="dropdown">
      <div class="dropdown-header bg-trans-gradient d-flex justify-content-center align-items-center rounded-top">
        <h4 class="m-0 text-center color-white">
          {{ $app.user.v_username }}
          <small class="mb-0 opacity-80 text-truncate text-truncate-lg">
            {{ $app.user.email }}
          </small>
        </h4>
      </div>
      <div class="dropdown-divider m-0"></div>
      <router-link
        :to="{ name: 'profile' }"
        class="dropdown-item"
        data-toggle="modal"
        data-target=".js-modal-settings"
        @click.native="hideMenu"
      >
        <i class="fal fa-address-card mr-2"></i>
        Profil Pengguna
      </router-link>
      <router-link
        :to="{ name: 'ubah-password' }"
        class="dropdown-item"
        data-toggle="modal"
        data-target=".js-modal-settings"
        @click.native="hideMenu"
      >
        <i class="fal fa-address-card mr-2"></i>
        Ubah Password
      </router-link>
      <template v-if="canChangePeran">
        <div class="dropdown-divider m-0"></div>
        <div class="dropdown-item" @click.prevent="showModalPeran()">
          <i class="fal fa-users-cog mr-2"></i>
          Ganti Peran
        </div>
      </template>
      <div class="dropdown-divider m-0"></div>
      <a
        class="dropdown-item fw-500 pt-3 pb-3"
        href="javascript:void(0)"
        onclick="doLogout.apply(this, arguments)"
      >
        <i class="fal fa-sign-out mr-2"></i>
        Keluar
      </a>
    </div>
    <b-modal
      :id="modal.id"
      :ref="modal.id"
      :title="modal.title"
      size="sm"
      hide-footer
      no-close-on-backdrop
      no-close-on-esc
    >
      <div>
        <h6>Peran Anda saat ini adalah <b>Pengguna {{ getPeran }}.</b></h6>
        <b-form-group label="Pilih Peran: " v-slot="{ ariaDescribedby }">
          <b-form-radio-group>
            <b-form-radio v-if="anotherUsers.main" class="mr-1" v-model="selectedPeran" :aria-describedby="ariaDescribedby" name="some-radios" value="utama">Utama</b-form-radio>
            <b-form-radio v-if="anotherUsers.plt" class="mr-1" v-model="selectedPeran" :aria-describedby="ariaDescribedby" name="some-radios" value="plt">PLT</b-form-radio>
            <b-form-radio v-if="anotherUsers.plh" class="mr-1" v-model="selectedPeran" :aria-describedby="ariaDescribedby" name="some-radios" value="plh">PLH</b-form-radio>
            <b-form-radio v-if="anotherUsers.pjs" class="mr-1" v-model="selectedPeran" :aria-describedby="ariaDescribedby" name="some-radios" value="pjs">PJS</b-form-radio>
          </b-form-radio-group>
        </b-form-group>
        <div class="text-right mt-4">
          <b-button ref="closebtn" variant="default" @click="onCloseModal()" class="mr-2">
            <i class="fal fa-times"></i>
            {{ $t('general.form.button_cancel') }}
          </b-button>
          <b-button @click="changePeran()" variant="primary" :disabled="loading || !selectedPeran">
            <i class="fal fa-check"></i>
            {{ $t('general.form.button_ok') }}
          </b-button>
        </div>
      </div>
    </b-modal>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
export default {
  name: 'PartUser',
  data() {
    return {
      modal: {
        id: 'modal-ganti-user',
        title: 'Ganti Peran',
      },
      selectedPeran: '',
      anotherUsers: {
        main: false,
        plt: false,
        plh: false,
        pjh: false
      },
      isHaveAnotherUser: false,
      loading: false
    }
  },
  computed: {
    ...mapGetters({ avatar: 'getAvatar', hasAvatar: 'getHasAvatarImage' }),
    getPeran() {
      let userId =  this.$app.user.v_userid
      let temp = userId.split('-')
      if (temp.length > 1) {
        return temp[1].toUpperCase() 
      }
      return 'Utama'
    },
    canChangePeran() {
      let currUser = this.$app.user 
      return currUser.is_impersonating || (currUser.is_main_user && currUser.another_user.length)
    }
  },
  created () {
    let anotherUser = this.$app.user.another_user
    anotherUser.forEach(element => {
      let temp = element.split('-')
      if (temp.length > 1) {
        this.anotherUsers[temp[1]] = true
      } else {
        this.anotherUsers['main'] = true
      }
      
      this.isHaveAnotherUser = true
    });
  },
  methods: {
    hideMenu() {
      this.$refs.usermenu.classList.remove('show')
      this.$refs.userthumb.removeAttribute('aria-expanded')
      this.$refs.dropdown.classList.remove('show')
    },
    showModalPeran() {
      let vm = this
      if (this.isHaveAnotherUser) {
        this.$bvModal.show(this.modal.id)
      } else {
        let userId = this.$app.user.v_userid
        vm.$app.alert.fire("Perhatian", 'Tidak dapat mengganti peran dengan user id ' + userId, "warning");
        this.onCloseModal()
      }
    },
    onCloseModal() {
      this.$bvModal.hide(this.modal.id)
      this.selectedPeran = ''
    },
    async changePeran() {
      let vm = this
      let url = vm.selectedPeran == 'utama' ? 
        vm.$app.route('user.leave-impersonate') :
        vm.$app.route('user.impersonate', {role: this.selectedPeran})

      this.loading = true
      
      this.$http
      .post(url)
      .then(response => {
        this.loading = false
        this.onCloseModal()
        if(response.status == 200) {
          vm.$router.go({name: 'home'})
        } else {
          vm.$app.alert.fire('Proses Gagal', response.data ,"warning");
          this.onCloseModal()
        }
      })
      .catch(error => {        
        this.loading = false
        this.onCloseModal()
        vm.$app.alert.fire('Proses Gagal', 'Gagal mengganti peran. Harap menghubungi admin.', "warning");
        this.onCloseModal()
      })
    },
  }
}
</script>