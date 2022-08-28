<template>
  <b-card class="p-3">
    <ValidationObserver v-slot="{ passes }" :slim="true">
      <form @submit.prevent="passes(submit)">
        <template>
          <b-form-group
            label-for="nama"
            :label="$t('user.form.field.nama.label')"
          >
            <input type="hidden" v-model="form.nama" />
            <ValidationProvider
              rules="required"
              v-slot="{ valid, errors }"
              :name="$t('user.form.field.nama.label')"
              :debounce="250"
            >
              <b-form-input
                id="nama"
                v-model="form.nama"
                :state="errors[0] ? false : valid ? true : null"
                :placeholder="$t('user.form.field.nama.placeholder')"
                :readonly="readonly"
              >
              </b-form-input>
              <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
            </ValidationProvider>
          </b-form-group>

          <b-form-group
            label-for="user_id"
            :label="$t('user.form.field.user_id.label')"
          >
            <input type="hidden" v-model="form.user_id" />
            <ValidationProvider
              rules="required"
              v-slot="{ valid, errors }"
              :name="$t('user.form.field.user_id.label')"
              :debounce="250"
            >
              <b-form-input
                id="user_id"
                v-model="form.user_id"
                :state="errors[0] ? false : valid ? true : null"
                :placeholder="$t('user.form.field.user_id.placeholder')"
                :readonly="readonly"
              >
              </b-form-input>
              <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
            </ValidationProvider>
          </b-form-group>

          <b-form-group
            label-for="password_lama"
            class="mt-4"
            :label="$t('user.form.field.password_lama.label')"
          >
            <input type="hidden" v-model="form.password_lama" />
            <ValidationProvider
              rules="required|oldPassword"
              v-slot="{ valid, errors }"
              :name="$t('user.form.field.password_lama.label')"
              :debounce="250"
            >
              <b-input-group>
                <b-form-input
                  id="password_lama"
                  :type="showOldPassword ? 'text' : 'password'"
                  v-model="form.password_lama"
                  debounce="500"
                  :state="errors[0] ? false : valid ? true : null"
                  :placeholder="$t('user.form.field.password_lama.placeholder')"
                >
                </b-form-input>
                <template>
                  <b-input-group-text class="radius_icon_password">
                    <i
                      :class="`fa ${showOldPassword ? 'fa-eye-slash' : 'fa-eye'} fs-xl pointer show-hide`"
                      @click="showOldPassword = !showOldPassword"
                    ></i>
                  </b-input-group-text>
                </template>
                <b-form-invalid-feedback>{{
                  errors[0]
                }}</b-form-invalid-feedback>
              </b-input-group>
            </ValidationProvider>
          </b-form-group>

          <b-form-group
            label-for="password"
            :label="$t('user.form.field.password.label')"
          >
            <input type="hidden" v-model="form.password" />
            <ValidationProvider
              :rules="rulesForPassword"
              v-slot="{ valid, errors }"
              :name="$t('user.form.field.password.label')"
              :debounce="250"
            >
              <b-input-group>
                <b-form-input
                  id="password"
                  :type="fieldTypePasword"
                  v-model="form.password"
                  :state="errors[0] ? false : valid ? true : null"
                  :placeholder="$t('user.form.field.password.placeholder')"
                >
                </b-form-input>
                <template>
                  <b-input-group-text class="radius_icon_password">
                    <i
                      :class="`fa ${iconPassword} fs-xl pointer show-hide`"
                      @click="toggleClassPassword"
                    ></i>
                  </b-input-group-text>
                </template>
                <b-form-invalid-feedback>{{
                  errors[0]
                }}</b-form-invalid-feedback>
              </b-input-group>
            </ValidationProvider>
          </b-form-group>

          <b-form-group
            label-for="password_confirm"
            :label="$t('user.form.field.password_confirm.label')"
          >
            <input type="hidden" v-model="form.password_confirm" />
            <ValidationProvider
              :rules="rulesForPasswordConfirmed"
              v-slot="{ valid, errors }"
              :name="$t('user.form.field.password_confirm.label')"
            >
              <b-input-group>
                <b-form-input
                  id="password_confirm"
                  :type="fieldTypePaswordConfirm"
                  v-model="form.password_confirm"
                  :state="errors[0] ? false : valid ? true : null"
                  :placeholder="
                    $t('user.form.field.password_confirm.placeholder')
                  "
                >
                </b-form-input>
                <template>
                  <b-input-group-text class="radius_icon_password">
                    <i
                      :class="
                        `fa ${iconPasswordConfirm} fs-xl pointer show-hide`
                      "
                      @click="toggleClassPasswordConfirm"
                    ></i>
                  </b-input-group-text>
                </template>
                <b-form-invalid-feedback>{{
                  errors[0]
                }}</b-form-invalid-feedback>
              </b-input-group>
            </ValidationProvider>
          </b-form-group>
        </template>

        <div class="text-right mt-4 pt-3">
          <b-button type="submit" variant="primary">
            {{ $t('general.form.button_add') }}
          </b-button>
          <b-button ref="closebtn" variant="default" @click="$router.go(-1)">
            {{ $t('general.form.button_cancel') }}
          </b-button>
        </div>
      </form>
    </ValidationObserver>
  </b-card>
</template>

<script>
import { extend } from 'vee-validate'
import encparams from '@components/mixins/encparams'

export default {
  name: 'UbahPassword',
  mixins: [
    encparams
  ],
  props: {
    id: null
  },
  data() {
    return {
      readonly: true,
      rulesForPassword: '',
      rulesForPasswordConfirmed: '',
      form: {
        nama: this.$app.user.v_username,
        user_id: this.$app.user.v_userid
      },
      fieldTypePasword: 'password',
      iconPassword: 'fa-eye',
      fieldTypePaswordConfirm: 'password',
      iconPasswordConfirm: 'fa-eye',
      showOldPassword: false,
      group: []
    }
  },
  created() {
    this.rulesForPassword = 'required|min:8'
    this.rulesForPasswordConfirmed = 'required|confirmed:Password|min:8'

    const oldPassword = value => {
      let credentials = this.encrPrms(JSON.stringify({
        password: value,
        user_id: this.form.user_id
      }))
      return this.$http
      .post(this.$app.route('user.check-current-password'), {credentials})
      .then(response => {
        if(!response.data.valid) {
          return 'Password yang anda masukkan tidak sesuai!'
        }
        return true
      })
    }

    extend('oldPassword', {
      validate: oldPassword
    });
  },
  methods: {
    async submit() {
      let vm = this
      let formData = this.$app.objectToFormData(vm.$data.form)
      let url = vm.$app.route('user.change-password', { id: this.form.user_id })
      vm.$app
        .confirm({
          text: vm.$t('user.alert.confirm.edit', { name: vm.$data.form.nama }),
          preConfirm: () => {
            return vm.$http
              .post(url, formData)
              .then(response => {
                if (response.data.status == 'error') {
                  let errors = response.data.message
                  throw new Error(response.data.message)
                } else {
                  return response
                }
              })
              .catch(error => {
                vm.$app.alert.showValidationMessage(error)
              })
          }
        })
        .then(result => {
          if (result.isDismissed) return
          if (
            result.value.data.status == 'success' ||
            result.value.data.status == 'info'
          ) {
            vm.$app.success(`${result.value.data.message}`).then(response => {
              if (response.value === true) {
                this.$router.go(-1)
              }
            })
          }
        })
    },
    toggleClassPassword(e) {
      if (this.fieldTypePasword === 'password') {
        this.fieldTypePasword = 'text'
        this.iconPassword = 'fa-eye-slash'
        e.target.classList.add('hide')
      } else {
        this.fieldTypePasword = 'password'
        this.iconPassword = 'fa-eye'
        e.target.classList.remove('hide')
      }
    },
    toggleClassPasswordConfirm(e) {
      if (this.fieldTypePaswordConfirm === 'password') {
        this.fieldTypePaswordConfirm = 'text'
        this.iconPasswordConfirm = 'fa-eye-slash'
        e.target.classList.add('hide')
      } else {
        this.fieldTypePaswordConfirm = 'password'
        this.iconPasswordConfirm = 'fa-eye'
        e.target.classList.remove('hide')
      }
    }
  }
}
</script>

<style lang="scss">
@import '~@syncfusion/ej2-base/styles/bootstrap4.css';
@import '~@syncfusion/ej2-buttons/styles/bootstrap4.css';
@import '~@syncfusion/ej2-vue-navigations/styles/bootstrap4.css';
#tree-feature {
  margin-left: -1rem;
  margin-right: -1rem;
  font-family: 'Poppins', sans-serif;
  .e-list-text {
    font-size: 13px;
  }
}
</style>
<style>
.control_wrapper {
  display: block;
  max-width: 350px;
  max-height: 350px;
  margin: auto;
  overflow: auto;
  border: 1px solid #dddddd;
  border-radius: 3px;
}

.radius_icon_password {
  border-left: 0;
  border-radius: 0px 4px 4px 0px !important;
}

.custom-checkbox {
  width: 300px;
  padding-top: 7px;
  padding-bottom: 12px;
}

.custom-radio {
  padding-top: 5px;
}

.multiselect {
  width: 100% !important;
}

.multiselect__tag {
  padding: 7px 26px 7px 11px !important;
  margin: 3px 4px !important;
}
</style>
