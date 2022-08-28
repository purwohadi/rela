export default {
  watch: {
    'fields': {
      deep: true,
			immediate: true,
      handler: function(n) {
        let vm = this

        let defaultExclude = ['customaction', 'rownum', 'rowaction']
        let mappedExclude = [...vm.filterExclude, ...defaultExclude]
        vm.filterColumns = vm.fields
        .filter(f => !mappedExclude.includes(f.key))
        .map(f => ({ text: f.label || f.key.charAt(0).toUpperCase() + f.key.slice(1), value: f.key }))

      vm.selectedColumns = vm.fields
        .filter(f => !mappedExclude.includes(f.key))
        .map(f => f.key)
      }
    },
  },
  created() {
    let vm = this
    let _fields = []
    let defaultExclude = ['customaction', 'rownum', 'rowaction']
    let mappedExclude = [...vm.filterExclude, ...defaultExclude]

    Object.keys(vm.fields).forEach(idx => {
      let field = vm.fields[idx]
      if (field.key == 'rowaction') {
        field.thStyle = { 'width': vm.rowActionWidth }
      }
      if (field.key == 'rownum') {
        field.thStyle = { 'width': vm.rowNumWidth }
      }

        _fields.push(field.key)
    })

    vm.filterColumns = vm.fields
      .filter(f => !mappedExclude.includes(f.key))
      .map(f => ({ text: f.label || f.key.charAt(0).toUpperCase() + f.key.slice(1), value: f.key }))

    vm.selectedColumns = vm.fields
      .filter(f => !mappedExclude.includes(f.key))
      .map(f => f.key)

    vm.optionsFilter = vm.optionsFilterFields.map(f => ({ text: f.label || f.key.charAt(0).toUpperCase() + f.key.slice(1), value: f.key }))
    vm.selectedOptionsFilter = null

    vm.dates = vm.vDate
    vm.datesAwal = vm.vDateAwal
    vm.datesAkhir = vm.vDateAkhir

    if (vm.intialSortDesc) {
      vm.sortDesc = vm.intialSortDesc
    }

    if (vm.defaultSortBy && vm.defaultSortBy.length) {
      vm.sortBy = vm.defaultSortBy
    } else {
      let fieldWoRow = _fields.filter(field =>
        field != 'rowaction' &&
        !field.toLowerCase().includes('action')
        && field != 'rownum'
      )
      vm.sortBy = fieldWoRow.shift()
    }
  },
  data() {
    return {
      currentPage: 1,
      from: 1,
      to: 0,
      totalRows: 0,
      perPage: (this.perPageCustom) ? this.perPageCustom : 15,
      searchText: '',
      filter: null,
      sortBy: null,
      sortDesc: false,
      isBusy: false,
      pageOptions: [(this.perPageCustom) ? this.perPageCustom : 15, 25, 50, 75, 100],
      filterColumns: [],
      selectedColumns: [],
      optionsFilter: [],
      selectedOptionsFilter: [],
      flagDateFilter: false,
      flagDateFilterRange: false,
      dates: '',
      datesAwal: '',
      datesAkhir: '',
      selectedDate: '',
      selectedDateAwal: '',
      selectedDateAkhir: '',
      tanggalFormat: {
        format: "dd MM yyyy"
      },
      tahunFormat: {
        format: "yyyy",
        minViewMode: "years",
        startView: "years",
        viewMode: "years",
      },
    }
  },
  computed: {
    availableFields() {
      return this.fields.map(field => {
        return (typeof field === "string") ? field : field.key
      })
    },
    firstTitle() {
      let title = (' ' + this.title).slice(1).split(' ')
      return title ? title.shift() : ''
    },
    restOfTitle() {
      let title = (' ' + this.title).slice(1).split(' ')
      title.shift()
      return title ? title.join(' ') : ''
    },
    panelBorder() {
      return this.panelBorderNone ? 'border-0' : ''
    },
    panelShadow() {
      return this.panelShadowNone ? 'shadow-0' : ''
    },
    getSelectedColumns() {
      return this.selectedColumns
    },
    getSelectedOptionsFilter() {
      return this.selectedOptionsFilter
    },
    getSelectedDate() {
      return this.dates
    },
    getSelectedDateRange() {
      let result = {
        awal: this.datesAwal,
        akhir: this.datesAkhir
      }
      return result
    },
    getUrlParams() {
      return this.urlParams
    }
  },
  methods: {
    getTitle() {
      let title = (' ' + this.title).slice(1).split(' ')
      this.firstTitle = title ? title.shift() : ''
      this.restOfTitle = title ? title.join(' ') : ''
    },
    async loadProvider(ctx, callback) {
      let vm = this
      if (ctx.apiUrl) {
        let routing = _.isEmpty(this.argsRoute)
            ? this.$app.route(ctx.apiUrl)
            : this.$app.route(ctx.apiUrl, this.argsRoute)
        vm.isBusy = true
        vm.$http
          .get(routing, {
            params: {
              page: ctx.currentPage,
              limit: ctx.perPage,
              sort_by: ctx.sortBy ? ctx.sortBy : null,
              sort_desc: ctx.sortDesc ? "desc" : "asc",
              search: ctx.filter,
              column_filters: vm.getSelectedColumns,
              filter_select: vm.getSelectedOptionsFilter,
              date_filter: vm.flagDateFilter ? vm.getSelectedDate : null,
              date_filter_range: vm.flagDateFilterRange ? vm.getSelectedDateRange : null
            },
          })
          .then(output => {
            setTimeout(() => {
              let res = (vm.isNotPaging) ? (('data' in output) ? output.data : output) : output.data
              let meta = ('meta' in output.data) ? output.data.meta : res;

              vm.isBusy = false
              vm.totalRows = meta.total
              vm.from = meta.from
              vm.to = meta.to
              vm.$emit('onLoadProvider', res.data || vm.items)
              callback(res.data || vm.items)
            }, vm.delay)
          })
          .catch(error => {
            vm.isBusy = false
            vm.flagDateFilter = false
            vm.flagDateFilterRange = false
            callback([])
            console.log({ error })
          })
      } else {
        return vm.items || []
      }
    },
    onSizeChange(e) {
      if (!this.searchText.length) {
        let element = {
          // wrapper: {
          //   add: e.type == 'focus' ? 'wider' : 'small',
          //   remove: e.type == 'focus' ? 'small' : 'wider',
          // },
          btnClear: {
            add: e.type == 'focus' ? 'go-show' : 'go-transparent',
            remove: e.type == 'focus' ? 'go-transparent' : 'go-show',
          }
        }

        Object.keys(element).forEach(ref => {
          Object.keys(element[ref]).forEach(action => {
            this.$refs[ref].classList[action](element[ref][action])
          })
        })
      }
    },
    onClear() {
      if (this.searchText.length) {
        this.searchText = ''
        this.onSearch()
        this.$refs.searchInput.focus()
      }
    },
    onRefresh() {
      this.$refs[this.id].refresh()
      this.flagDateFilter = false
      this.flagDateFilterRange = false
    },
    getRowNum(idx) {
      return this.from + idx
    },
    perpageChange(perPage) {
      this.$refs.perpage.classList.remove('show')

      if (this.perPage !== perPage)
        this.perPage = perPage
    },
    downloadHandle(type) {
      let output = ''
      switch (type) {
        case 'P':
          output = 'print'
          break;
        case 'F':
          output = 'pdf'
          break;
        case 'E':
          output = 'spreadsheet'
          break;
        case 'V':
          output = 'csv'
          break;
      }
      window.location = this.$app.route(this.apiUrl, {
        search: this.searchText,
        export: true,
        type: output,
        ...this.argsRoute
      })
      this.$refs.downloadAction.classList.remove('show')
      this.$refs.downloadDropdown.classList.remove('show')
    },
    onSearch: _.debounce(function () {
      if (this.searchText.trim().length >= this.minimumSearchLen || this.searchText.length == 0) {
        this.filter = this.searchText
        this.$emit('onQuerySearch', this.filter)
        return true
      } else {
        return false
      }
    }, 550),
    onChange() {
      this.$refs[this.id].refresh()
    },
    onFilterTanggal() {
      if ((this.dates == '')) {
        this.$app.alert.fire("Proses Gagal", "Tanggal harus dipilih", "warning")
      } else {
        this.flagDateFilter = true
        this.$refs[this.id].refresh()
      }
    },
    onFilterTanggalRange() {
      if ((this.datesAwal == '' || this.datesAkhir == '')) {
        this.$app.alert.fire("Proses Gagal", "Tanggal awal dan akhir harus dipilih", "warning")
      } else {
        if (((new Date(this.datesAwal).getTime()/1000) > (new Date(this.datesAkhir).getTime()/1000))) {
          this.$app.alert.fire("Proses Gagal", "Tanggal awal tidak boleh lebih besar dari tanggal akhir", "warning")
        } else {
          this.flagDateFilterRange = true
          this.$refs[this.id].refresh()
        }
      }
    },
    onSelectedDate(date) {
      this.dates = (date.date == undefined) ? '' :this.$moment(date.date).format('YYYY-MM-DD')
      this.flagDateFilter = false
    },
    onSelectedDateAwal(date) {
      this.datesAwal = (date.date == undefined) ? '' :this.$moment(date.date).format('YYYY-MM-DD')
      this.flagDateFilterRange = false
    },
    onSelectedDateAkhir(date) {
      this.datesAkhir = (date.date == undefined) ? '' :this.$moment(date.date).format('YYYY-MM-DD')
      this.flagDateFilterRange = false
    }
  }
}
