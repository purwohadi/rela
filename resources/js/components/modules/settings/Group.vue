<template>
  <b-row>
    <b-col xl="12" md="12" sm="12">
      <data-table
        :id="`${resourceName}`"
        :ref="`${resourceName}Table`"
        :fields="fields"
        :api-url="`${routeName}.get`"
        :title="$t(`${resourceName}.datatable.title`)"
        :actions="'SCRUNWM'"
        row-action-width="8%"
        @add="handleAdd"
        @update="handleUpdate"
        @delete="handleDelete"
        @onQuerySearch="handleQuerySearch"
        :options-filter-fields="optionsFilterFields"
        :filter-exclude="filterExclude"
      >
        <template #cell(image)="{ data }">
          <b-img :src="data.item.thumbnail_background_path" fluid :alt="data.item.title"></b-img>
        </template>
        <template #cell(status)="{ data }">
          <b-badge :variant="data.item.status ? 'success' : 'danger'">{{ data.item.status ? 'Aktif' : 'Tidak Aktif' }}</b-badge>
        </template>
        <template #cell(featureaccess)="{ data }">
          <hide-more
            label="name"
            :max="10"
            :items="data.item.features"
            :highlight-text="querySearch"
            search-highligt
          />
        </template>
      </data-table>
    </b-col>
  </b-row>
</template>

<script>
export default {
  name: "Group",
  data() {
    let resourceName = 'group'
    return {
      show: true,
      title: '',
      querySearch: '',
      resourceName: resourceName,
      routeName: `${resourceName}`,
      form: {
        id: '',
        title: '',
        subtitle: '',
        description: '',
        image: [],
        background: null,
        has_background_image: false,
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
          key: 'nama',
          sortable: true,
          label: this.$t(`${resourceName}.form.field.name.label`)
        },
        {
          key: 'opd',
          sortable: true,
          label: this.$t(`${resourceName}.form.field.opd.label`)
        },
        {
          key: 'featureaccess',
          sortable: true,
          label: this.$t(`${resourceName}.form.field.permissions.label`)
        },
        {
          key: 'status',
          sortable: true,
          thStyle: { 'width': '10%' },
          label: this.$t(`${resourceName}.form.field.status.label`)
        },
      ],
      isMounted: false,
      optionsFilterFields: [
        { key: null, label: 'Status' },
        { key: '1', label: 'Aktif' },
        { key: '0', label: 'Tidak Aktif' }
      ],
      filterExclude: ['status']
    }
  },
  methods: {
    handleAdd() {
      this.$router.push({name: 'group-form'})
    },
    handleUpdate(item, index, $el) {
      this.$router.push({name: 'group-edit', params: { id: item.slug_path }})
    },
    handleFeatureAccess(item) {
      this.$router.push({name: 'group-hak-akses', params: { id: item.slug_path }})
    },
    handleDelete(item, index, $el) {
      const vm = this
      vm.$app.confirm({
        text: vm.$t('alert.confirm.drop', { name: item.name }),
        preConfirm: () => {
          return vm.$http
            .delete(vm.$app.route(`${this.routeName}.drop`), {
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
                vm.$root.$emit('bv::refresh::table', this.resourceName)
                vm.$bvModal.hide(`${this.resourceName}-add`)
              }
            })
          }
        })
    },
    handleQuerySearch(q) {
      this.querySearch = q
    },
    onHide() {
      this.form.id = null
      this.form.title = ''
      this.form.subtitle = ''
      this.form.description = ''
      this.form.image = null
    },
    onCloseModal() {
      this.$bvModal.hide(`${this.resourceName}-add`)
    },
    async submit() {
      let vm = this
      let data = Object.assign({}, vm.$data.form)
      let mode = data.hasOwnProperty('id') && data.id ? 'edit' : 'add'
      let url = vm.$app.route(mode == 'add' ? `${this.routeName}.store` : `${this.routeName}.edit`)
      let method = mode == 'add' ? 'post' : 'put'
      let formData = this.$app.objectToFormData(vm.$data.form)

      if(mode == 'edit') {
        formData.append('_method', 'PUT')
      }

      vm.$app.confirm({
        text: vm.$t(`alert.confirm.${mode}`),
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
              vm.$t(`alert.${result.value.data.status}`)
            )
              .then(response => {
                if (response.value === true) {
                  vm.$root.$emit('bv::refresh::table', this.resourceName)
                  vm.$bvModal.hide(`${this.resourceName}-add`)
                }
              })
					}
				})
    },
  }
}
</script>

<style>

</style>
