<template>
  <div id="form-reset">
    <div class="card">
      <div class="card-body">
        <div class="text-center mb-2">
          <h4 class="font-weight-bold">
            {{ settings.appname }}
          </h4>
          <a href="#" class="page-logo-link press-scale-down">
            <img
              :src="page.logo"
              class="img-fluid"
              :alt="settings.appname"
              aria-roledescription="logo"
              style="width: 3.3rem; height: auto"
            />
          </a>
        </div>
        <div :class="`small p-2 mb-2 error-message ${message.status == 'success' ? 'valid' : ''}`" v-if="message.status != null">
          {{ message.text }}
        </div>
        <ValidationObserver v-slot="{ passes }" :slim="true">
          <b-form @submit.prevent="passes(submit)" id="form-login" class="text-left">
            <b-form-group
              label="Password"
              label-for="password"
              description="Password minimal 8 karakter"
            >
              <ValidationProvider
                rules="required"
                v-slot="{ errors }"
                name="Password"
              >
                <b-input-group>
                  <b-form-input
                    id="password"
                    name="password"
                    trim
                    :type="fieldType.password"
                    :disabled="loading"
                    v-model="model.password"
                    placeholder="Password"
                  >
                  </b-form-input>
                  <template>
                    <b-input-group-text class="radius_icon_password" @click="toggleClassPassword('password')">
                      <i :class="`fa ${ fieldType.password_icon } fs-xl pointer show-hide`"></i>
                    </b-input-group-text>
                  </template>
                </b-input-group>
                <invalid-feedback :error="errors[0]" class="mt-1"></invalid-feedback>
              </ValidationProvider>
            </b-form-group>
            <b-form-group
              label="Konfirmasi Password"
              label-for="password_confirm"
            >
              <ValidationProvider
                rules="required"
                v-slot="{ errors }"
                name="Konfirmasi Password"
              >
                <b-input-group>
                  <b-form-input
                    id="password_confirmation"
                    name="password_confirmation"
                    trim
                    :type="fieldType.password_confirmation"
                    :disabled="loading"
                    v-model="model.password_confirmation"
                    placeholder="Konfirmasi Password"
                  >
                  </b-form-input>
                  <template>
                    <b-input-group-text class="radius_icon_password" @click="toggleClassPassword('password_confirmation')">
                      <i :class="`fa ${ fieldType.password_confirmation_icon } fs-xl pointer show-hide`"></i>
                    </b-input-group-text>
                  </template>
                </b-input-group>

                <invalid-feedback :error="errors[0] || error_form.password" class="mt-1"></invalid-feedback>
              </ValidationProvider>
            </b-form-group>
            <button
              id="btn-reset"
              type="submit"
              class="btn btn-info btn-block btn-md"
              :disabled="loading"
            >
              {{ loading ? 'Proses...' : 'Reset Password' }}
            </button>
          </b-form>
        </ValidationObserver>

        <div class="text-center mt-4">
          <a :href="settings.home" style="text-decoration: none;">
            <i class="fal fa-chevron-left mr-1"></i> Kembali ke Halaman Login
          </a>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "LoginApp",
  data() {
    return {
      settings: window.settings,
      loading: false,
      page: {
        logo: '/img/logo.png',
        background: '/img/svg/pattern-3.svg',
        footer_logo: '/img/plusjakarta-logo-black.svg'
      },
      message: {
        status: null,
        text: null
      },
      model: {
        email: null,
        token: null,
        password: null,
        password_confirmation: null,
      },
      error_form: {
        password: '',
        password_confirmation: '',
      },
      fieldType: {
        password: 'password',
        password_icon: 'fa-eye',
        password_confirmation: 'password',
        password_confirmation_icon: 'fa-eye',
      }
    };
  },
  computed: {
    isMobile() {
      return (this.$screen.breakpoint == 'xs' || this.$screen.breakpoint == 'sm')
    },
  },
  created() {
    const url = new URL(window.location.href);
    const params = new URLSearchParams(url.search);
    this.model.email = params.get('email')
    this.model.token = url.pathname.split('/', 2).pop();
  },
  methods: {
    async submit() {
      let vm = this
      vm.message.status = null
      vm.message.text = null
      vm.loading = true

      vm.$http
        .post(vm.$app.route('password-update'), vm.model)
        .then(async res => {
          let home = vm.settings.home
          vm.message.status = res.data.status
          vm.message.text = res.data.message
          if(res.data.status === 'success') {
            setTimeout(() => {
              location.href = home
            }, 250);
          }
          else {
            vm.loading = false
          }
        })
        .catch(err => {
          if (err.response) {
            let error = err.response?.data
            Object.keys(error.errors).forEach(idx => {
              vm.error_form[idx] = error.errors[idx].shift()
            })
            vm.loading = false
          }
        })
    },
    toggleClassPassword(type) {
      if(this.fieldType[type] === 'password') {
        this.fieldType[type] = 'text';
        this.fieldType[type+'_icon'] = 'fa-eye-slash';
      } else {
        this.fieldType[type] = 'password';
        this.fieldType[type+'_icon'] = 'fa-eye';
      }
    },
  }
};
</script>

<style lang="scss">
    body {
      font-family: Poppins,sans-serif !important;
      height:100% !important;
      background: url('/img/svg/pattern-3.svg') no-repeat center bottom fixed;background-size: cover;
    }
    #form-reset {
      display: flex;
      justify-content: center;
      .card {
        padding: .4rem .8rem 1rem .8rem;
        box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.06);
        border-radius: .7rem;
        border: none;
        width: 350px;

        .form-control {
          &::placeholder {
            font-size: .7rem;
          }
        }
      }
      .message-error {
        .icon {
          color: #979bac;
          i {
            font-weight: 500;
            font-size: 3rem;
          }
        }
        .label {
          margin-top: .6rem;
          font-size: 1.2rem;
          font-weight: 500;
        }
      }
      .error-message {
        font-size: .6rem;
        font-weight: 500;
        background: rgba(253, 57, 149, .15);
        padding: .5rem .65rem;
        border-radius: .4rem;
        color: var(--red);

        &.valid {
          color: var(--success);
          background: rgba(24, 170, 155, .15);
        }
      }
      .radius_icon_password {
        cursor: pointer;
        border-radius: 0px 4px 4px 0px !important;
        border-left: none;
      }
    }
</style>
