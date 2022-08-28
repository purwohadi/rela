<template>
  <div class="row">
    <div class="col-12">
      <section class="roles">
        <data-table
          id="rolestable"
          :fields="fields"
          api-url="role.get"
          :title="$t('roles.datatable.title')"
          actions="SCREWPFUDV"
          row-action-width="10%"
          @add="handleAdd"
          @update="handleUpdate"
          @delete="handleDelete"
          @onQuerySearch="handleQuerySearch"
        >
          <!-- begin custom header with lang -->
          <template #head(name)="{ data }">
            {{ $t('roles.datatable.column.name') }}
          </template>
          <template #head(permissions)="{ data }">
            {{ $t('roles.datatable.column.permissions') }}
          </template>

          <template #actionExtra="{ data }">
            <button
              type="button"
              class="btn btn-info btn-xs btn-icon rounded-circle waves-effect waves-themed ml-lg-1"
              v-b-tooltip.hover.top="$t('roles.datatable.action.addons')"
              @click="handleAddons(data.item)"
            >
              <i class="fal fa-shield-check"></i>
            </button>
          </template>
          <!-- end custom header with lang -->

          <template #cell(permissions)="{ data }">
            <hide-more
              label="name"
              :items="data.item.permissions"
              :highlight-text="querySearch"
              search-highligt
            />
          </template>
        </data-table>

        <!-- begin form add -->
        <b-modal
          id="role-add"
          :title="title"
          hide-footer
          no-close-on-backdrop
          no-close-on-esc
          @hide="onHide"
        >
          <ValidationObserver v-slot="{ passes }" :slim="true">
            <form @submit.prevent="passes(submit)" v-if="show">
              <b-form-group
                label-for="role-name"
                :label="$t('roles.form.field.name.label')"
              >
                <ValidationProvider name="roleid">
                  <input type="hidden" v-model="form.id">
                </ValidationProvider>
                <ValidationProvider
                  :rules="rulesForName"
                  v-slot="{ valid, errors }"
                  :name="$t('roles.form.field.name.label')"
                  :debounce="250"
                >
                  <b-form-input
                    id="role-name"
                    v-model="form.name"
                    :state="errors[0] ? false : (valid ? true : null)"
                    :placeholder="$t('roles.form.field.name.placeholder')"
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
        <!-- end form add -->

        <!-- begin attach permissions -->
        <b-modal
          id="role-permission"
          :title="$t('roles.form.field.permissions.label')"
          size=" "
          hide-footer
          no-close-on-backdrop
          no-close-on-esc
          @hide="onHide"
        >
          <ValidationObserver ref="observer-detail" v-slot="{ passes }" :slim="true">
            <b-form @submit.prevent="passes(onSubmitPermissions)" v-if="show">
              <ValidationProvider
                rules="required"
                v-slot="{ valid, errors }"
                :name="$t('roles.form.field.permissions.label')"
              >
                <m-select
                  id="list-permissions"
                  v-model="selected.permissions"
                  label="name"
                  track-by="id"
                  :placeholder="$t('roles.form.field.permissions.placeholder')"
                  :multiple="true"
                  :options="permissions"
                  :searchable="true"
                  :loading="permissionsLoading"
                  :internal-search="false"
                  :clear-on-select="true"
                  :close-on-select="false"
                  @search-change="asyncFind"
                >
                  <span slot="noOptions">
                    {{ $t('general.multiselect.no-options') }}
                  </span>
                  <span slot="noResult">
                    {{ $t('general.multiselect.no-options') }}
                  </span>
                </m-select>
                <div class="text-right mt-4">
                  <b-button ref="closebtn" variant="default" @click="onCloseModal">
                    {{ $t('general.form.button_cancel') }}
                  </b-button>
                  <b-button type="submit" variant="primary">
                    {{ $t('general.form.button_add') }}
                  </b-button>
                </div>
              </ValidationProvider>
            </b-form>
          </ValidationObserver>
        </b-modal>
        <!-- end attach permissions -->
      </section>
    </div>
  </div>
</template>

<script>
import { extend } from 'vee-validate'
export default {
  name: 'SettingsRoles',
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
        {
          key: 'permissions',
          thStyle: { 'width': '45%' }
        },
      ],
      selected: {
        role: {},
        permissions: []
      },
      permissions: [],
      permissionsLoading: false,
      querySearch: '',
    }
  },
  created() {
    let vm = this
    extend("unique", {
      validate: async (value) => {
        const exist = async value => await vm.$http.post(vm.$app.route('role.exist'), { name: value })
        const isUnique = await exist(value)
        return (! isUnique.data) ? true : vm.$t('roles.validation.unique', { value })
      }
    })
    extend("uniqueExclude", {
      params: ['target'],
      validate: async (value, { target }) => {
        const exclude = async value => await vm.$http.post(vm.$app.route('role.exclude'), { id: target, name: value })
        const isUniqueExclude = await exclude(value)
        return (! isUniqueExclude.data) ? true : vm.$t('roles.validation.unique', { value })
      }
    })
  },
  methods: {
    handleAdd() {
      this.rulesForName = 'required|min:3|max:200|unique'
      this.title = this.$t('roles.form.title.add')
      this.$bvModal.show('role-add')
    },
    submit() {
      let vm = this
      let data = Object.assign({}, vm.$data.form)
      let mode = data.hasOwnProperty('id') && data.id ? 'edit' : 'add'
      let url = vm.$app.route(mode == 'add' ? 'role.store' : 'role.edit')
      let method = mode == 'add' ? 'post' : 'put'

      vm.$app.confirm({
        text: vm.$t(`roles.alert.confirm.${mode}`),
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
              vm.$t(`roles.alert.${result.value.data.status}`)
            )
              .then(response => {
                if (response.value === true) {
                  vm.$root.$emit('bv::refresh::table', 'rolestable')
                  vm.$bvModal.hide("role-add")
                }
              })
					}
				})
    },
    onHide() {
      this.form.id = null
      this.form.name = '',
      this.form.guard_name = 'web'
      this.selected.role = {}
      this.selected.permissions = []
      this.permissions = []
    },
    onCloseModal() {
      this.$bvModal.hide('role-add')
      this.$bvModal.hide('role-permission')
    },
    handleUpdate(item, index, $el) {
      this.rulesForName = 'required|min:3|max:200|uniqueExclude:@roleid'
      this.form.id = item.id
      this.form.name = item.name,
      this.form.guard_name = item.guard_name
      this.title = this.$t('roles.form.title.edit')
      this.$bvModal.show('role-add')
    },
    handleDelete(item, index, $el) {
      const vm = this
      vm.$app.confirm({
        text: vm.$t('roles.alert.confirm.drop', { name: item.name }),
        preConfirm: () => {
          return vm.$http
            .delete(vm.$app.route('role.drop'), {
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
                vm.$root.$emit('bv::refresh::table', 'rolestable')
                vm.$bvModal.hide("role-add")
              }
            })
          }
        })
    },
    handleAddons(item) {
      let currentRole = Object.assign({}, item)
      let currentPermissions = Array.from(item.permissions)
      delete currentRole['permissions']

      this.selected.role = currentRole
      this.selected.permissions = currentPermissions
      this.$bvModal.show('role-permission')
    },
    asyncFind(query) {
      let vm = this
      vm.permissionsLoading = true
      vm.$http
        .get(vm.$app.route('permission.get'), {
          params: {
            sort_by: 'name',
            sort_desc: 'asc',
            search: query,
          },
        })
          .then(response => {
            console.log(response.data);
            vm.permissions = response.data
            vm.permissionsLoading = false
          })
    },
    onSubmitPermissions() {
      let vm = this
      let formdata = vm.$app.objectToFormData({
        role: vm.selected.role.name,
        permissions: vm.selected.permissions.map(permission => permission.name)
      })

      vm.$app.confirm({
        text: vm.$t(`roles.alert.confirm.permissions`),
        preConfirm: () => {
          return vm.$http
            .post(vm.$app.route('role.sync'), formdata)
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
					if (result.dismiss && result.dismiss == "cancel") return
					if (result.value.data.status == "success" || result.value.data.status == "info") {
						vm.$app.success(
              result.value.data.message,
              result.value.data.status,
              vm.$t(`roles.alert.${result.value.data.status}`)
            )
              .then(response => {
                if (response.value === true) {
                  vm.$root.$emit('bv::refresh::table', 'rolestable')
                  vm.$bvModal.hide("role-permission")
                }
              })
					}
				})
    },
    handleQuerySearch(q) {
      this.querySearch = q
    }
  }
}
</script>
