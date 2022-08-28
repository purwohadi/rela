<template>
  <section class="user-card">
    <div class="panel mb-g">
      <div class="row no-gutters row-grid">
        <div class="col-12">
          <div class="d-flex flex-column align-items-center justify-content-center p-4">
            <template>
              <b-avatar
                class="rounded-circle shadow-2 img-thumbnail avatar"
                size="7rem"
                :src="avatar"
                :alt="$app.user.v_username"
                :text="$app.getInitialName($app.user.v_username)"
                :variant="avatar ? 'defalt' : 'secondary'"
              ></b-avatar>
            </template>
            <b-skeleton-wrapper :loading="loading" class="box-skeleton">
              <template #loading>
                <b-skeleton animation="fade"></b-skeleton>
                <b-skeleton animation="fade" width="95%"></b-skeleton>
                <b-skeleton animation="fade"></b-skeleton>
                <b-skeleton animation="fade" width="95%"></b-skeleton>
                <b-skeleton animation="fade"></b-skeleton>
                <b-skeleton animation="fade" width="95%"></b-skeleton>
                <b-skeleton animation="fade"></b-skeleton>
                <b-skeleton animation="fade" width="95%"></b-skeleton>
              </template>
            </b-skeleton-wrapper>
            <div v-if="!loading">
              <template v-if="canDashboard">
                <h5 class="box-profile mb-0 mt-3">
                  <template v-if="$app.user.v_userid == 'admin'">
                    <div class="fw-700">
                      {{ $app.user.v_username }}
                    </div>
                  </template>
                  <template v-else>
                    <div class="mb-1 name-text">
                      {{ $app.user.v_username }}
                    </div>
                    <div v-if="hasProfile">
                      <p class="email-text fw-500">
                        {{ users.email }}
                      </p>
                      <p class="mb-1">
                        <i class="fal fa-credit-card"></i>
                        {{ users.nrk }} - {{ users.nip }}
                      </p>
                      <p class="mb-1">
                        <i class="fal fa-birthday-cake"></i>
                        {{ users.tempat_lahir }}, {{ users.tanggal_lahir }}
                      </p>
                      <p class="mb-1">
                        <i class="fab fa-ioxhost"></i>
                        {{ (users.eselon) ?
                          `${users.status} / ${users.kode_jab}/ ${users.eselon} / ${users.nama_pangkat} (${users.gol})` :
                          users.username
                        }}
                      </p>
                      <p class="mb-1">
                        <i class="fas fa-map-marker-alt"></i>
                        {{ users.lokasi_kerja }}
                      </p>
                      <p class="mb-1">
                        <i class="fas fa-chart-line"></i>
                        {{ users.nama_jabatan }}
                      </p>
                      <p class="mb-1">
                        <i class="far fa-money-bill-alt"></i>
                        {{ users.lokasi_gaji }}
                      </p>
                    </div>
                  </template>
                </h5>
              </template>
              <template v-else>
                <h5 class="mb-0 fw-700 text-center mt-3">
                  {{ users.username }}
                  <small class="text-muted mb-0">
                    {{ users.lokasi_kerja }}
                  </small>
                  <small class="text-muted mb-0">
                    {{ users.nama_jabatan }}
                  </small>
                </h5>
              </template>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
export default {
	name: 'UserCard',
	props: {
    canDashboard: {
      type: Boolean,
			required: false,
			default: false
    },
		canUpload: {
			type: Boolean,
			required: false,
			default: false
		},
    users: {
      type: Object,
      required: false,
      default: () => {},
    },
    loading: {
      type: Boolean,
      required: false,
      default: false
    },
    hasProfile: {
      type: Boolean,
      required: false,
      default: true
    }
	},
	computed: {
		...mapGetters({ avatar: 'getAvatar', hasAvatar: 'getHasAvatarImage' }),
	},
	methods: {
		...mapActions({ update_avatar: 'updateLiveAvatar' }),
		// async onProcess(result) {
		// const formData = new FormData()
		// const action = this.$app.route('user.upload')
		// formData.append('photo', result.output, result.output.name)
		// const { data } = await this.$http.post(action, formData)
		// if(data.status == 'success') {
		// 	this.$app.success(data.message, data.status)
		// 	this.update_avatar(data.data)
		// }
		// }
	}
}
</script>

<style lang="scss">
.change-icon {
  cursor: pointer;
  i {
    position: relative;
    font-size: 1.5rem;
    top: 5px;
    left: 50%;
    opacity: 0;
  }
  .avatar {
    margin-top: 0px;
    width: 100px;
    height: 100px;
    object-fit: cover;
    object-position: center top;
  }
  &:hover {
    opacity: .8;
    i {
      opacity: 1 !important;
      z-index: 2;
    }
  }
}

.box-skeleton {
  margin-top: 16px;
  width: 100%;
}

.fw-600 {
  font-weight: 600;
}

.nrk-text {
  font-size: 15px;
  margin: 5px;
}

.name-text {
  font-size: 16px;
  font-weight: 600;
  margin-bottom: 2px;
}

.email-text {
  word-break: break-word;
  margin-bottom: 8px;
}

.box-profile p {
  font-size: 11px;
}
.box-profile i {
  min-width: 16px;
  text-align: center;
}
</style>
