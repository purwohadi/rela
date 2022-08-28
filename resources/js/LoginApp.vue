<template>
	<div id="login-page">
		<div class="page-wrapper">
			<div class="page-inner">
				<div class="page-content-wrapper bg-transparent m-0">
					<div
						class="flex-1"
						:style="`
              background: url(${page.background}) no-repeat center bottom
                fixed;
              background-size: cover;
            `"
					>
						<div class="logo text-center mt-4">
							<a href="#" class="page-logo-link press-scale-down">
								<img
									:src="page.logo"
									class="img-fluid"
									:alt="settings.appname"
									aria-roledescription="logo"
									style="width: 4.2rem; height: auto"
									tabindex="-1"
								/>
								<img
									:src="page.logo_spbe"
									class="img-fluid"
									:alt="settings.appname"
									aria-roledescription="logo"
									style="width: 4.5rem; height: auto"
									tabindex="-1"
								/>

							</a>
							<div class="text-dark mb-2 mt-2 font-weight-bold lead">
								<!-- {{ settings.appname }} -->
								SISTEM PEMERINTAHAN BERBASIS ELEKTRONIK <br /> PEMERINTAH PROVINSI DKI JAKARTA
							</div>
						</div>
						<div class="container login-container py-2">
							<div class="card m-3 p-0 loginpage">
								<div class="row no-gutters justify-content-center mt-4">
									<div class="col-sm-12 loginpage--form">
										<form-login ref="formLogin" :settings="settings" @loadPengumuman="loadPengumuman"></form-login>
									</div>
									<!-- <div class="col col-md-6 col-lg-8 hidden-sm-down announc loginpage--announcement" v-if="!isMobile">
                    <pengumuman ref="pengumuman" :settings="settings"></pengumuman>
                  </div> -->
								</div>
							</div>
						</div>
					</div>
					<footer>
						<div
							class="container mx-auto sponsor pt-2"
							style="display: block; margin-bottom: 0rem !important"
						>
							<div class="px-4 text-center">
								<img
									:src="page.footer_logo"
									class="img-fluid"
									width="105px"
								/>
							</div>
						</div>
						<div
							class="pos-bottom pos-left pos-right p-3 mt-0 mx-auto text-center"
						>
							2021 © {{ settings.appname }} by&nbsp;
							<a
								:href="settings.owner.web"
								class="text-dark opacity-75 fw-500"
								:title="settings.owner.name"
								target="_blank"
							>
								{{ settings.owner.name }}
							</a>
							<div class="hash-version">
								{{ settings.hash_version }}
							</div>
						</div>
					</footer>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import FormLogin from './frontend/login/_FormLogin.vue';
import Pengumuman from './frontend/login/_Pengumuman.vue';
export default {
	name: "LoginApp",
	components: {
		Pengumuman,
		FormLogin
	},
	data() {
		return {
			settings: window.settings,
			page: {
				logo: 'img/logo.png',
				logo_spbe: 'img/logo-spbe.png',
				background: 'img/svg/pattern-3.svg',
				footer_logo: 'img/plusjakarta-logo-black.svg'
			}
		};
	},
	computed: {
		isMobile() {
			return (this.$screen.breakpoint == 'xs' || this.$screen.breakpoint == 'sm')
		},
	},
	methods: {
		loadPengumuman(firstLoad) {
			if(firstLoad) this.$refs.pengumuman?.fetchPengumuman()
		},
	}
};
</script>

<style lang="scss">
@media (min-width: 992px) {
  .login-container {
    max-width: 480px;
  }
}
.login-container {
  .klik-btn .read,
  .klik-btn .read:hover,
  .klik-btn .read:focus,
  .klik-btn .read:active {
    background: transparent !important;
    color: transparent !important;
    border: none !important;
    border-color: transparent !important;
    box-shadow: none !important;
  }
}
.modal-backdrop {
  opacity: .2 !important;
}

.hash-version {
  font-size: .66rem;
  margin-top: .4rem;
  color: rgb(172, 170, 170);
}

.lead {
  font-size: 1.3rem;
}
</style>
