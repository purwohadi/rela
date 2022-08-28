<template>
  <div class="reset-password">
    <div class="reset-password--title">
      Reset Password
    </div>
    <div class="reset-password--description">
      <p>
        Permintaan reset password akan di kirimkan ke email, silakan cek email anda.
      </p>
      <p>
        Gunakan email yang aktif, jika sudah tidak aktif silahkan melakukan pembaharuan data email pada website: <span class="marked"><a href="https://pegawai.jakarta.go.id" target="_blank">pegawai.jakarta.go.id</a></span> .
      </p>
      <p v-if="message.status == 'error'" v-html="message.text" class="desc-message"></p>
    </div>
    <template v-if="message.status != 'success'">
      <div class="reset-password--form">
        <validation-observer v-slot="{ passes }" :slim="true">
          <b-form @submit.prevent="passes(submit)" id="form-login">
            <b-form-group
              description="Gunakan NRK Anda yang sudah terdaftar"
              label="NRK"
              label-for="nrk"
            >
              <ValidationProvider
                rules="required"
                v-slot="{ errors }"
                name="NRK"
              >
                <b-input-group
                  prepend="@"
                  name="nrk"
                  class="mb-2 mr-sm-2 mb-sm-0"
                >
                  <template slot="prepend">
                    <span class="input-group-text">
                      <i class="fal fa-user-alt fs-xl"></i>
                    </span>
                  </template>
                  <b-form-input
                    v-model="model.nrk"
                    trim
                    id="nrk"
                    :disabled="loading"
                    placeholder="NRK"
                  ></b-form-input>
                </b-input-group>
                <invalid-feedback :error="errors[0]" class="mt-1"></invalid-feedback>
              </ValidationProvider>
            </b-form-group>
            <b-form-group
              description="Gunakan Email anda yang terdaftar"
              label="Email"
              label-for="email"
            >
              <ValidationProvider
                rules="required"
                v-slot="{ errors }"
                name="Email"
              >
                <b-input-group prepend="@" class="mb-2 mr-sm-2 mb-sm-0">
                  <template slot="prepend">
                    <span class="input-group-text">
                      <i class="fal fa-envelope fs-xl"></i>
                    </span>
                  </template>
                  <b-form-input
                    v-model="model.email"
                    id="email"
                    type="email"
                    :disabled="loading"
                    name="email"
                    placeholder="Email"
                  ></b-form-input>
                </b-input-group>
                <invalid-feedback :error="errors[0]" class="mt-1"></invalid-feedback>
              </ValidationProvider>
            </b-form-group>
            <div class="action-button mt-3">
              <div class="pr-lg-1 my-1">
                <button
                  id="js-reset-btn"
                  type="submit"
                  class="btn btn-info btn-block btn-md"
                  :disabled="loading"
                >
                  <i class="fal fa-sync mr-1"></i>
                  {{ loading ? 'Proses...' : 'Reset' }}
                </button>
              </div>
            </div>
          </b-form>
        </validation-observer>
      </div>
    </template>
    <template v-else>
      <div class="after-success">
        <div class="after-success--icon">
          <i class="fas fa-check-circle"></i>
        </div>
        <div class="after-success--label">
          Email Berhasil Dikirim
        </div>
        <div class="after-success--label small">
          Kami telah mengirimkan link untuk reset password, silakan cek kotak masuk email Anda!
        </div>
      </div>
    </template>
    <div class="backlogin pr-lg-1 mt-4 text-center text-primary" @click="goBackLogin()">
      <i class="fal fa-chevron-left mr-1"></i> Kembali ke Halaman Login
    </div>
  </div>
</template>

<script>
import encparams from '@components/mixins/encparams'

export default {
  name: 'ResetPassword',
  mixins: [
    encparams
  ],
  props: {
    nrk: {
      type: [String, Number],
      default: null
    }
  },
  data() {
    return {
      loading: false,
      message: {
        status: null,
        text: null,
      },
      model: {
        nrk: '',
        email: ''
      }
    }
  },
  watch: {
    nrk: {
      immediate: true,
      handler: function(n,o) {
        this.model.nrk = n
      }
    }
  },
  methods: {
    goBackLogin() {
      this.$emit('backToLogin')
    },
    async submit() {
      let vm = this
      vm.loading = true
      let id = vm.encrPrms(JSON.stringify(vm.model))
      vm.$http
        .post(vm.$app.route('reset-password'), {id:id})
        .then(async res => {
          vm.message.status = res.data.status
          if(res.data.status == 'error') {
            vm.message.text = res.data.message
          }
          vm.loading = false
        })
        .catch(err => {
          vm.message.text = null
          vm.loading = false
        })
    }
  }
}
</script>

<style lang="scss">
  .reset-password {
    margin: 1.2rem .4rem .4rem .4rem;
    &--title {
      font-size: 1.3rem;
      font-weight: 500;
    }
    &--description {
      font-size: .7rem;
      font-weight: normal;
      color: #979bac;
      p {
        margin-bottom: .4rem;
        .marked {
          color: #212529;
          font-weight: 500;
        }
      }

      .desc-message {
        color: var(--red);
        font-size: .6rem;
        font-weight: 500;
        background: rgba(253, 57, 149, .15);
        padding: .5rem .65rem;
        border-radius: .4rem;
      }
    }
    &--form {
      margin-top: .6rem;
    }
    .backlogin {
      font-size: .7rem;
      cursor: pointer;
    }

    .after-success {
      margin-top: .6rem;
      text-align: center;
      padding: .8rem;
      &--icon {
        margin-bottom: 1rem;
        i {
          color: var(--green);
          font-size: 8rem;
        }
      }
      &--label {
        font-weight: 600;
        font-size: 1rem;

        &.small {
          font-weight: 400;
          color: #858999;
          font-size: .7rem;
        }
      }
    }
  }
</style>
