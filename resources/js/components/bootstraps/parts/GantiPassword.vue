<template>
  <validation-observer v-slot="{ passes }" :slim="true">
    <form @submit.prevent="passes(submit)">
      <b-form-group
        label-for="password"
        :label="$t('user.form.field.password.label')"
      >
        <input type="hidden" v-model="form.password">
        <ValidationProvider
          rules="required|min:8|special"
          v-slot="{ valid, errors }"
          vid="password"
          :name="$t('user.form.field.password.label')"
          :debounce="250"
        >
          <b-input-group class="mt-3">
            <b-form-input
              id="password"
              :type="showPassword ? 'text' : 'password'"
              v-model="form.password"
              :state="errors[0] ? false : (valid ? true : null)"
              :placeholder="$t('user.form.field.password.placeholder')"
              ref="password"
            >
            </b-form-input>
            <template>
              <b-input-group-text class="radius_icon_password" @click="showPassword = !showPassword">
                <i :class="`fa ${showPassword ? 'fa-eye' : 'fa-eye-slash'} fs-xl pointer show-hide`"></i>
              </b-input-group-text>
            </template>
            <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
          </b-input-group>
        </ValidationProvider>
      </b-form-group>

      <b-form-group
        label-for="password_confirm"
        :label="$t('user.form.field.password_confirm.label')"
      >
        <input type="hidden" v-model="form.password_confirm">
        <ValidationProvider
          rules="required|min:8|confirmed:password"
          v-slot="{ valid, errors }"
          :name="$t('user.form.field.password_confirm.label')"
          :debounce="250"
        >
          <b-input-group class="mt-3">
            <b-form-input
              id="password_confirm"
              :type="showConfPassword ? 'text' : 'password'"
              v-model="form.password_confirm"
              :state="errors[0] ? false : (valid ? true : null)"
              :placeholder="$t('user.form.field.password_confirm.placeholder')"
              ref="password_confirm"
            >
            </b-form-input>
            <template>
              <b-input-group-text class="radius_icon_password" @click="showConfPassword = !showConfPassword">
                <i :class="`fa ${showConfPassword ? 'fa-eye' : 'fa-eye-slash'} fs-xl pointer show-hide`"></i>
              </b-input-group-text>
            </template>
            <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
          </b-input-group>
        </ValidationProvider>
      </b-form-group>

      <div class="d-flex mt-4 pt-3">
        <b-button type="submit" variant="danger" class="mr-auto" onclick="doLogout.apply(this, arguments)">
          {{ $t('general.form.button_logout') }}
        </b-button>
        <b-button type="submit" variant="primary">
          {{ $t('general.form.button_add') }}
        </b-button>
      </div>
    </form>
  </validation-observer>
</template>

<script>
export default {
  name: 'GantiPassword',
  data() {
    let resourceName = 'user';
    return {
      resourceName: resourceName,
      routeName: `${resourceName}`,
      form: {
        password: null,
        password_confirm: null,
      },
      showPassword: false,
      showConfPassword: false,
    }
  },
  created() {
  },
  methods: {
    async submit() {
      let vm = this
      let formData = this.$app.objectToFormData(vm.$data.form)
      // formData.append('_method', 'PUT')
      let url = vm.$app.route('user.change-password')

      vm.$app.confirm({
        text: vm.$t(`${this.routeName}.alert.confirm.password`),
        preConfirm: () => {
          return vm.$http.post(url, formData)
            .then(response => {
              if (response.data.status == "error") {
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
					if (result.value.data.status == "success" || result.value.data.status == "info") {
						vm.$app.success(
              result.value.data.message,
              result.value.data.status,
              vm.$t(`${this.routeName}.alert.${result.value.data.status}`)
            )
              .then(response => {
                if (response.value === true) {
                  document.getElementById('logout-form').submit()
                }
              })
					}
				})
    }
  }
}
</script>

<style>

</style>
