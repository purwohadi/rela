<template>
	<section>
		<section id="formlogin" v-if="!showResetPassword">
			<validation-observer v-slot="{ passes }" :slim="true">
				<b-form @submit.prevent="passes(submit)" id="form-login">
					<b-form-group
						description="Gunakan NRK atau Username Anda yang sudah terdaftar"
						label="Username"
						label-for="username">
						<validation-provider
							rules="required"
							v-slot="{ errors }"
							name="Username">
							<b-input-group
								prepend="@"
								name="username"
								class="mb-2 mr-sm-2 mb-sm-0">
								<template slot="prepend">
									<span class="input-group-text">
										<i class="fal fa-user-alt fs-xl"></i>
									</span>
								</template>
								<b-form-input
									v-model="model.username"
									trim
									id="username"
									v-focus
									:disabled="loading"
									placeholder="Username"
									tabindex="1">
								</b-form-input>
							</b-input-group>
							<invalid-feedback :error="errors[0] || messages.username" class="mt-1"></invalid-feedback>
						</validation-provider>
					</b-form-group>
					<b-form-group
						description="Untuk keamanan silahkan ganti kata sandi Anda secara berkala"
						label="Password"
						label-for="password">
						<ValidationProvider
							rules="required"
							v-slot="{ errors }"
							name="Password">
							<b-input-group prepend="@" class="mb-2 mr-sm-2 mb-sm-0">
								<template slot="prepend">
									<span class="input-group-text">
										<i class="fal fa-lock-alt fs-xl"></i>
									</span>
								</template>
								<b-form-input
									v-model="model.password"
									id="password"
									type="password"
									:disabled="loading"
									name="password"
									placeholder="Password"
									tabindex="2">
								</b-form-input>
							</b-input-group>
							<invalid-feedback :error="errors[0] || (messages.username.length == 0 ? messages.password : '')" class="mt-1"></invalid-feedback>
						</ValidationProvider>
					</b-form-group>
					<div class="form-group mt-0 mb-2">
						<div class="captcha row no-gutters">
							<div class="col-lg-5 pr-lg-1 my-2">
								<div style="display: inline-block; border-radius: 0.3rem; overflow: hidden; width: 130px; height: 45px;">
								<b-img
									id="captcha-img"
									:blank="!hasCaptcha"
									blank-color="#f2f2f2"
									width="130px"
									alt="Loading..."
									:src="captcha_img"
									ref="captcha-img"/>
								</div>
							</div>
							<div class="col-lg-7 pr-lg-1 my-2">
								<div class="row no-gutters">
									<div class="col-lg-6">
										<div class="reload-btn pl-2">
											<button type="button" class="btn btn-danger btn-sm reload" id="reload-captcha" :disabled="loading" @click="getCaptcha()" tabindex="5">
												Reload Captcha
											</button>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="reload-btn pl-2">
											<button
												type="button"
												class="btn btn-primary btn-sm reload"
												id="audio-captcha"
												:disabled="loading"
												@click.prevent="readAudio"
												aria-describedby="Captcha Suara"
												tabindex="6">
												Captcha Suara
											</button>
										</div>
									</div>
									<div class="col-lg-6" v-if="false">
										<div class="klik-btn pl-1">
											<button
												type="button"
												class="btn btn-outline-light btn-sm read"
												id="read-captcha"
												@click="readCaptcha()">
												{{
													captcha_read
													? `Captchanya adalah ${captcha_read}`
													: "Klik Captcha"
												}}
											</button>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="captcha-input mt-1">
							<ValidationProvider
								:rules="captchaRules"
								v-slot="{ errors }"
								name="Captcha">
								<input
								id="captcha"
								name="captcha"
								type="text"
								class="form-control"
								autocomplete="off"
								v-mask="'#####'"
								v-model="model.captcha"
								placeholder="Captcha"
								aria-label="Captcha"
								:disabled="loading"
								tabindex="3" />
								<invalid-feedback
									:error="errors[0] || messages.captcha"
									class="mt-1">
								</invalid-feedback>
							</ValidationProvider>
						</div>
					</div>
					<div class="action-button mt-3">
						<div class="row no-gutters">
							<div class="col-lg-12 pr-lg-1 my-1">
								<button
									id="js-login-btn"
									type="submit"
									class="btn btn-info btn-block btn-md"
									:disabled="loading"
									tabindex="4">
									<i class="fal fa-sign-in mr-1"></i>
									{{ loading ? 'Proses...' : 'Masuk' }}
								</button>
							</div>
						</div>
						<div class="row no-gutters" v-if="settings.etpp_existing">
						<div class="col-lg-12 pr-lg-1 my-1">
							<a
							:href="settings.url_etpp_existing"
							target="_blank"
							id="js-login-exist-btn"
							type="button"
							class="btn btn-success btn-block btn-md text-white"
							tabindex="8"
							>
							<i class="fal fa-globe mr-1"></i>
							ETPP 2021
							</a>
						</div>
						</div>
						<div class="text-right text-primary mt-2 reset-password">
						<span @click="forgotPassword()" tabindex="7">
							Lupa passsword?
						</span>
						</div>
					</div>
				</b-form>
			</validation-observer>
		</section>
		<section v-else>
			<reset-password :nrk="model.username" @backToLogin="showFormLogin()"></reset-password>
		</section>
	</section>
</template>

<script>
import ResetPassword from '@js/frontend/login/_ResetPassword.vue';
import encparams from '@components/mixins/encparams'

export default {
  name: "FormLogin",
  components: {
    ResetPassword
  },
  directives: {
    focus: {
      // directive definition
      inserted: function (el) {
        el.focus()
      }
    }
  },
  mixins: [
    encparams
  ],
  props: {
    settings: {
      type: Object,
      default: () => {}
    }
  },
  data() {
    return {
      loading: false,
      loadingCaptcha: false,
      loadingRead: false,
      loadingAudio: false,
      showResetPassword: false,
      captcha_img: null,
      captcha_val: null,
      model: {
        username: null,
        password: null,
        captcha: null,
      },
      messages: {
        username: '',
        password: '',
        captcha: '',
      },
      captchaRules: '',
      isPlaying: false,
    };
  },
  computed: {
    hasCaptcha() {
      return !this.loadingCaptcha || !this.captcha_img
    },
    onPlaying() {
      return this.isPlaying
    }
  },
  mounted() {
    this.captchaRules = !this.settings.is_local ? 'required' : ''
    setTimeout(() => this.getCaptcha(true), 250)
  },
  methods: {
    async submit() {
      let vm = this
      vm.loading = true

      vm.messages.username = ''
      vm.messages.password = ''
      vm.messages.captcha = ''

      Promise.resolve(vm.encrPrms(JSON.stringify(vm.model)))
        .then(credentials => vm.$http.post(vm.$app.route('login'), {credentials}))
        .then(({ data }) => {
          if (data.status != 'success') {
            vm.$app.error('Login bermasalah, silakan lapor Admin Sistem')
            return
          }

          let home = vm.settings.home
          vm.$app.toast.fire({
            timer: 1500,
            icon: 'info',
            position: 'top',
            title: 'Login sukses!',
            timerProgressBar: true
          })
          .then(({ isDismissed }) => {
            // ketika timer habis: {dismiss: 'timer', isDismissed: true, isConfirmed: false}
            // ketika di click user: {dismiss: 'close', isDismissed: true, isConfirmed: false}
            if (!isDismissed) return

            // redirect ketika dismissed
            setTimeout(() => vm.loading = false, 250)
            location.href = home
          })
        })
        .catch(err => {
          if (err.response) {
            let error = err.response?.data
            Object.keys(error.errors).forEach(idx => {
              vm.messages[idx] = error.errors[idx].shift()
            })
            vm.loading = false
          }
        })
    },
    async getCaptcha(firstLoad = false) {
      this.loadingCaptcha = true;
      try {
        let url = this.$app.route("reload-captcha");
        let { data } = await this.$http.get(url);
        this.captcha_img = data.img
        this.captcha_val = data.val
        this.loadingCaptcha = false;
        this.$emit('loadPengumuman', firstLoad)
      } catch (error) {
        this.loadingCaptcha = false;
        this.$app.error(error)
      }
    },
    readAudio() {
      let vm = this
      if(vm.onPlaying) return
      var audio = new Audio(`audio-captcha?audio=${this.captcha_val}`)
      audio.onplaying = function() {
        vm.isPlaying = true
      }
      audio.onended = function() {
        vm.isPlaying = false
      }
      audio.play()
    },

    forgotPassword () {
      this.showResetPassword = true
    },
    showFormLogin () {
      this.showResetPassword = false
    },
  },
};
</script>

<style lang="scss">
.login-container {
  .loginpage {
    border-radius: 0.7rem;
    box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.06);
    border: none;
    &--form {
      padding: 1rem 1.7rem;

      .btn-xs,
      .btn-group-xs > .btn {
        padding: 0.25rem 0.644rem;
        font-size: 0.65rem;
        line-height: 1.5;
        border-radius: 4px;
      }

      #form-login {
        .form-group {
          margin-bottom: .75rem;
          label {
            font-size: 0.7rem;
            color: var(--secondary);
          }
        }

        .reload-btn {
          .reload {
            font-size: 0.66rem;
          }
        }
        .klik-btn {
          .read {
            font-size: 0.55rem;
          }
        }
        .reset-password {
          cursor: pointer;
          font-size: .7rem;
        }
      }
    }
  }
}
</style>
