export default {
  data() {
    return {
      multiple: false,
      permissions: [],
      permissionsLoading: false,
      closeOnSelect: true,
    }
  },
  methods: {
    asyncFind(query) {
      let vm = this
      vm.permissionsLoading = true
      return vm.$http
        .get(vm.$app.route('permission.get'), {
          params: {
            sort_by: 'name',
            sort_desc: 'asc',
            search: query,
          },
        })
        .then(response => {
          vm.permissions = response.data
          vm.permissionsLoading = false
          return response.data
        })
    },
  }
}
