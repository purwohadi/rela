<template>
  <div class="row">
    <div class="col-12">
      <section class="user">
        <data-table
          id="usertable"
          :fields="fields"
          :options-filter-fields="optionsFilterFields"
          api-url="user.get"
          :title="$t('user.datatable.title')"
          :filter-exclude="filterExclude"
          actions="SCRLUDNM"
          row-action-width="10%"
          @add="handleAdd"
          @update="handleUpdate"
          @delete="handleDelete"
        >
          <template #cell(userstatus)="{ data }">
            <span :class="`badge badge-${ data.item.userstatus == '1' ? 'success' : 'danger' } badge-pill mr-1`">
              {{ data.item.userstatus == '1' ? 'Aktif' : 'Tidak Aktif' }}
            </span>
          </template>

          <template #cell(last_update_password)="{ data }">
            {{ data.item.last_update_password ? data.item.last_update_password : '-' }}
          </template>
        </data-table>
      </section>
    </div>
  </div>
</template>

<script>
import { extend } from 'vee-validate'
export default {
  name: 'User',
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
          sortable: false,
          class: 'text-center',
        },
        {
          key: 'user_id',
          label: this.$t('user.datatable.column.v_userid'),
          sortable: true,
        },
        {
          key: 'username',
          label: this.$t('user.datatable.column.v_username'),
          sortable: true,
        },
        {
          key: 'userstatus',
          label: this.$t('user.datatable.column.e_user_enable'),
          sortable: true,
        },
        {
          key: 'last_update_password',
          label: this.$t('user.datatable.column.d_last_update_pass'),
          sortable: true,
        },
      ],
      optionsFilterFields: [
        { key: null, label: 'Status' },
        { key: '1', label: 'Aktif' },
        { key: '0', label: 'Tidak Aktif' }
      ],
      filterExclude: ['userstatus']
    }
  },
  created() {
  },
  methods: {
    handleAdd() {
      this.$router.push({name: 'user-add'})
    },
    handleUpdate(item, index, $el) {
      this.$router.push({name: 'user-edit', params: { id: item.slug_path }})
    },
    handleDetail(item, index, $el) {
      this.$router.push({name: 'user-detail', params: { id: item.slug_path }})
    },
    handleDelete(item, index, $el) {
      const vm = this
      vm.$app.confirm({
        text: vm.$t('user.alert.confirm.drop', { name: item.username }),
        preConfirm: () => {
          return vm.$http
            .delete(vm.$app.route('user.drop'), {
              data: { slug: item.user_id }
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
            vm.$app.success(this.$t(`user.alert.actions.drop.${result.value.data.status}`))
            .then(response => {
              if (response.value === true) {
                vm.$root.$emit('bv::refresh::table', 'usertable')
              }
            })
          }
        })
    },
  }
}
</script>
