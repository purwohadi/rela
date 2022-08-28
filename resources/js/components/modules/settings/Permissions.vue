<template>
  <div class="row">
    <div class="col-12">
      <section class="permissions">
        <data-table
          id="permissionstable"
          :fields="fields"
          api-url="permission.get"
          :title="$t('permissions.datatable.title')"
          actions="SCREWPFUDV"
          row-action-width="10%"
          @add="handleAdd"
          @update="handleUpdate"
          @delete="handleDelete"
        >
          <!-- begin custom header with lang -->
          <template #head(name)="{ data }">
            {{ $t('permissions.datatable.column.name') }}
          </template>
          <template #head(guard_name)="{ data }">
            {{ $t('permissions.datatable.column.guard_name') }}
          </template>
          <!-- end custom header with lang -->
        </data-table>

        <!-- form add -->
        <b-modal
          id="permission-add"
          :title="title"
          hide-footer
          no-close-on-backdrop
          no-close-on-esc
          @hide="onHide"
        >
          <ValidationObserver v-slot="{ passes }" :slim="true">
            <form @submit.prevent="passes(submit)" v-if="show">
              <b-form-group
                label-for="permission-name"
                :label="$t('permissions.form.field.name.label')"
              >
                <ValidationProvider name="permissionid">
                  <input type="hidden" v-model="form.id">
                </ValidationProvider>
                <ValidationProvider
                  :rules="rulesForName"
                  v-slot="{ valid, errors }"
                  :name="$t('permissions.form.field.name.label')"
                  :debounce="250"
                >
                  <b-form-input
                    v-model="form.name"
                    :state="errors[0] ? false : (valid ? true : null)"
                    :placeholder="$t('permissions.form.field.name.placeholder')"
                    autofocus
                  >
                  </b-form-input>
                  <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
                </ValidationProvider>
              </b-form-group>
              <div class="text-right mt-4">
                <b-button ref="closebtn" variant="default" @click="onCloseModal">
                  {{ $t('general.form.button_cancel') }}
                </b-button>
                <b-button type="submit" variant="primary">
                  {{ $t('general.form.button_add') }}
                </b-button>
              </div>
            </form>
          </ValidationObserver>
        </b-modal>
      </section>
    </div>
  </div>
</template>

<script>
import { extend } from 'vee-validate'
export default {
  name: 'SettingsPermissions',
  data() {
    return {
      show: true,
      title: '',
      rulesForName: '',
      form: {
        id: null,
        name: '',
        guard_name: 'web'
      },
      fields: [
        {
          key: 'rowaction',
          label: '',
          class: 'text-center',
        },
        {
          key: 'rownum',
          class: 'text-center',
        },
        {
          key: 'name',
          sortable: true,
        },
      ],
    }
  },
  created() {
    let vm = this
    extend("unique", {
      validate: async (value) => {
        const exist = async value => await vm.$http.post(vm.$app.route('permission.exist'), { name: value })
        const isUnique = await exist(value)
        return (! isUnique.data) ? true : vm.$t('permissions.validation.unique', { value })
      }
    })
    extend("uniqueExclude", {
      params: ['target'],
      validate: async (value, { target }) => {
        const exclude = async value => await vm.$http.post(vm.$app.route('permission.exclude'), { id: target, name: value })
        const isUniqueExclude = await exclude(value)
        return (! isUniqueExclude.data) ? true : vm.$t('permissions.validation.unique', { value })
      }
    })
  },
  methods: {
    onRefreshed() {
      this.$root.$emit('bv::refresh::table', 'permissionstable')
      this.$bvModal.hide("permission-add")
    },
    handleAdd() {
      this.rulesForName = 'required|min:3|max:200|unique'
      this.title = this.$t('permissions.form.title.add')
      this.$bvModal.show('permission-add')
    },
    submit() {
      let vm = this
      let data = Object.assign({}, vm.$data.form)
      let mode = data.hasOwnProperty('id') && data.id ? 'edit' : 'add'
      let url = vm.$app.route(mode == 'add' ? 'permission.store' : 'permission.edit')
      let method = mode == 'add' ? 'post' : 'put'

      vm.$app.confirm({
        text: vm.$t(`permissions.alert.confirm.${mode}`),
        preConfirm: () => {
          return vm.$http
            [method](url, vm.$data.form)
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
              vm.$t(`permissions.alert.${result.value.data.status}`)
            )
              .then(response => {
                if (response.value === true) vm.onRefreshed()
              })
					}
				})
    },
    onHide() {
      this.form.id = null
      this.form.name = '',
      this.form.guard_name = 'web'
    },
    onCloseModal() {
      this.$bvModal.hide('permission-add')
    },
    handleUpdate(item, index, $el) {
      this.rulesForName = 'required|min:3|max:200|uniqueExclude:@permissionid'
      this.form.id = item.id
      this.form.name = item.name,
      this.form.guard_name = item.guard_name
      this.title = this.$t('permissions.form.title.edit')
      this.$bvModal.show('permission-add')
    },
    handleDelete(item, index, $el) {
      const vm = this
      vm.$app.confirm({
        text: vm.$t('permissions.alert.confirm.drop', { name: item.name }),
        preConfirm: () => {
          return vm.$http
            .delete(vm.$app.route('permission.drop'), {
              data: { id: item.id }
            })
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
          if (result.value.data.status == "success") {
            vm.$app.success(result.value.data.message)
            .then(response => {
              if (response.value === true) {
                vm.onRefreshed()
              }
            })
          }
        })
    },
  }
}
</script>
