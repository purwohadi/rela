<template>
  <div class="row">
    <div class="col-12">
      <section class="reference">
        <data-table
          id="referencetable"
          :fields="fields"
          api-url="reference.get"
          :title="$t('reference.datatable.title')"
          actions="SCREWPFUDV"
          row-action-width="10%"
          @add="handleAdd"
          @update="handleUpdate"
          @delete="handleDelete"
        >
          <!-- begin custom header with lang -->
          <template #head(key)="{ data }">
            {{ $t('reference.datatable.column.key') }}
          </template>
          <template #head(value)="{ data }">
            {{ $t('reference.datatable.column.value') }}
          </template>
          <template #head(type)="{ data }">
            {{ $t('reference.datatable.column.type') }}
          </template>
          <!-- end custom header with lang -->
        </data-table>

        <!-- form add -->
        <b-modal
          id="reference-add"
          :title="title"
          hide-footer
          no-close-on-backdrop
          no-close-on-esc
          @hide="onHide"
        >
          <ValidationObserver v-slot="{ passes }" :slim="true">
            <form @submit.prevent="passes(submit)" v-if="show">
              <b-form-group
                label-for="reference-type"
                :label="$t('reference.form.field.type.label')"
              >
                <ValidationProvider name="referencetype">
                  <input type="hidden" v-model="form.type">
                </ValidationProvider>
                <ValidationProvider
                  rules="required|min:3|max:200"
                  v-slot="{ valid, errors }"
                  :name="$t('reference.form.field.type.label')"
                >
                  <b-form-input
                    v-model="form.type"
                    :state="errors[0] ? false : (valid ? true : null)"
                    :placeholder="$t('reference.form.field.type.placeholder')"
                    autofocus
                  >
                  </b-form-input>
                  <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
                </ValidationProvider>
              </b-form-group>

              <b-form-group
                label-for="reference-name"
                :label="$t('reference.form.field.key.label')"
              >
                <ValidationProvider name="referenceid">
                  <input type="hidden" v-model="form.id">
                </ValidationProvider>
                <ValidationProvider
                  :rules="rulesForKey"
                  v-slot="{ valid, errors }"
                  :name="$t('reference.form.field.key.label')"
                  :debounce="250"
                >
                  <b-form-input
                    v-model="form.key"
                    :state="errors[0] ? false : (valid ? true : null)"
                    :placeholder="$t('reference.form.field.key.placeholder')"
                  >
                  </b-form-input>
                  <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
                </ValidationProvider>
              </b-form-group>

              <b-form-group
                label-for="reference-value"
                :label="$t('reference.form.field.value.label')"
              >
                <ValidationProvider
                  rules="required|min:1|max:200"
                  v-slot="{ valid, errors }"
                  :name="$t('reference.form.field.value.label')"
                >
                  <b-form-input
                    v-model="form.value"
                    :state="errors[0] ? false : (valid ? true : null)"
                    :placeholder="$t('reference.form.field.value.placeholder')"
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
  name: 'SettingsReference',
  data() {
    return {
      show: true,
      title: '',
      rulesForKey: '',
      form: {
        id: null,
        key: '',
        value: '',
        type: ''
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
          key: 'type',
          sortable: true,
        },
        {
          key: 'key',
          sortable: true,
        },
        {
          key: 'value',
          sortable: true,
        },
      ],
    }
  },
  created() {
    let vm = this
    extend("unique", {
      params: ['target_type'],
      validate: async (value, { target_type }) => {
        const exist = async value => await vm.$http.post(vm.$app.route('reference.exist'), { key: value, type: target_type })
        const isUnique = await exist(value)
        return (! isUnique.data) ? true : vm.$t('reference.validation.unique', { key: value })
      }
    })
    extend("uniqueExclude", {
      params: ['target_id', 'target_type'],
      validate: async (value, { target_id, target_type }) => {
        const exclude = async value => await vm.$http.post(vm.$app.route('reference.exclude'), { id: target_id, key: value, type: target_type })
        const isUniqueExclude = await exclude(value)
        return (! isUniqueExclude.data) ? true : vm.$t('reference.validation.unique', { key: value })
      }
    })
  },
  methods: {
    handleAdd() {
      this.rulesForKey = 'required|min:3|max:200|unique:@referencetype'
      this.title = this.$t('reference.form.title.add')
      this.$bvModal.show('reference-add')
    },
    submit() {
      let vm = this
      let data = Object.assign({}, vm.$data.form)
      let mode = data.hasOwnProperty('id') && data.id ? 'edit' : 'add'
      let url = vm.$app.route(mode == 'add' ? 'reference.store' : 'reference.edit')
      let method = mode == 'add' ? 'post' : 'put'

      vm.$app.confirm({
        text: vm.$t(`reference.alert.confirm.${mode}`),
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
              vm.$t(`reference.alert.${result.value.data.status}`)
            )
              .then(response => {
                if (response.value === true) {
                  vm.$root.$emit('bv::refresh::table', 'referencetable')
                  vm.$bvModal.hide("reference-add")
                }
              })
					}
				})
    },
    onHide() {
      this.form.id = null
      this.form.key = '',
      this.form.value = ''
      this.form.type = ''
    },
    onCloseModal() {
      this.$bvModal.hide('reference-add')
    },
    handleUpdate(item, index, $el) {
      this.form.id = item.id
      this.form.key = item.key,
      this.form.value = item.value
      this.form.type = item.type
      this.title = this.$t('reference.form.title.edit')
      this.rulesForKey = 'required|min:3|max:200|uniqueExclude:@referenceid,@referencetype'
      this.$bvModal.show('reference-add')
    },
    handleDelete(item, index, $el) {
      const vm = this
      vm.$app.confirm({
        text: vm.$t('reference.alert.confirm.drop', { key: item.key }),
        preConfirm: () => {
          return vm.$http
            .delete(vm.$app.route('reference.drop'), {
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
                vm.$root.$emit('bv::refresh::table', 'referencetable')
                vm.$bvModal.hide("reference-add")
              }
            })
          }
        })
    },
  }
}
</script>
