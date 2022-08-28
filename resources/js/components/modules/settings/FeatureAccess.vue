<template>
  <div class="row">
    <div class="col-12">
      <section class="featureaccess">
        <data-table
          id="featureaccesstable"
          :fields="fields"
          api-url="feature-access.get"
          :title="$t('featureaccess.datatable.title')"
          actions="SCRUN"
          row-action-width="10%"
          @add="handleAdd"
          @update="handleUpdate"
          default-sort-by="name"
        >
          <template #cell(type)="{ data }">
            <b-badge :variant="getVariant(data.item.type)" class="text-capitalize" pill>{{ data.item.type }}</b-badge>
          </template>
        </data-table>
      </section>
    </div>
  </div>
</template>

<script>
export default {
  name: 'FeatureAccess',
  filters: {
    getFirst(value = []) {
      let temp = [...value]
      return temp.length ? temp.shift().name : ''
    }
  },
  data() {
    return {
      show: true,
      title: '',
      form: {
        id: null,
        name: ''
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
          sortable: false,
        },
        {
          key: 'name',
          label: this.$t('featureaccess.datatable.column.name'),
          sortable: true,
        },
        {
          key: 'alias',
          label: this.$t('featureaccess.datatable.column.alias'),
          sortable: true,
        },
        {
          key: 'type',
          label: this.$t('featureaccess.datatable.column.type'),
          sortable: true,
        },
        {
          key: 'parent',
          label: this.$t('featureaccess.datatable.column.parent_id'),
          sortable: true,
        },
        {
          key: 'description',
          label: this.$t('featureaccess.datatable.column.description'),
          sortable: true,
        },
      ]
    }
  },
  created() {
  },
  methods: {
    handleAdd() {
      this.$router.push({name: 'feature-access-add'})
    },
    handleUpdate(item, index, $el) {
      this.$router.push({name: 'feature-access-edit', params: { id: item.slug_path }})
    },
    getVariant(type) {
      const variants = {
        'menu': 'success',
        'link': 'primary',
        'crud': 'info',
        'filter': 'danger',
        'default': 'dark'
      }

      return Object.keys(variants).includes(type)
        ? variants[type]
        : variants.default
    }
  }
}
</script>
