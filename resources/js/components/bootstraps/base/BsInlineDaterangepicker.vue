<template>
  <div ref="range" class="range d-flex" id="range">
    <div ref="range-start" class="range-start d-block border-0"></div>
    <div ref="range-end" class="range-end d-block border-0"></div>
  </div>
</template>

<script>
import { toCamel } from '@js/helpers/convert-case.js'
const dateFmt = 'DD/MM/YYYY'
export default {
  name: 'BsInlineDaterangepicker',
  props: {
    value: {
      type: Object,
      required: true
    },
    settings: {
      type: Object,
      required: false,
      default: () => {}
    },
    setDates: {
      type: Array,
      required: false,
      default: () => []
    },
    setLimit: {
      type: Boolean,
      required: false,
      default: false
    }
  },
  data() {
    return {
      dtp: null,
      controls: {
        leftArrow: '<i class="fal fa-angle-left" style="font-size: 1.25rem"></i>',
        rightArrow: '<i class="fal fa-angle-right" style="font-size: 1.25rem"></i>'
      },
      selected: {
        rangeStart: null,
        rangeEnd: null,
      },
      mergedSettings: {}
    }
  },
  watch: {
    setDates: {
      immediate: false,
      handler: function(n) {
        let vm = this
        if (n.length) {
          let [start, finish] = n
          vm.setLimitDate()
          $(vm.$refs['range-start']).datepicker('setDate', start)
          $(vm.$refs['range-end']).datepicker('setDate', finish)
          vm.setSelectedDate(start, finish)
        } else {
          vm.initDatepicker(vm.mergedSettings)
        }
      }
    },
  },
  mounted() {
    let vm = this
    const defaultSettings = {
      language: "id",
      format: "d MM yyyy",
      immediateUpdates: true,
      templates: vm.controls,
    }

    const inputs = [$(vm.$refs['range-start']), $(vm.$refs['range-end'])]
    vm.mergedSettings = {...defaultSettings, ...vm.settings, inputs}

    Promise.resolve(vm.mergedSettings)
      .then(settings => vm.initDatepicker(settings))
  },
  beforeDestroy() {
    if (this.dtp) this.dtp.datepicker('destroy')
  },
  methods: {
    initDatepicker(settings) {
      let vm = this
      if (vm.dtp) vm.dtp.datepicker('destroy')
      vm.dtp = $(vm.$refs['range']).datepicker(settings).on('changeDate', vm.onChangeDate)

      let start = !vm.setDates.length ? vm.$app.getCurrentDate(dateFmt) : vm.setDates[0]
      let finish = !vm.setDates.length ? vm.$app.getCurrentDate(dateFmt) : vm.setDates[1]

      vm.setLimitDate()

      $(vm.$refs['range-start']).datepicker('setDate', start)
      $(vm.$refs['range-end']).datepicker('setDate', finish)

      vm.setSelectedDate(start, finish)
    },
    setSelectedDate: _.debounce(function(start, finish) {
      let vm = this
      let moment = {
        start: vm.$moment(start, dateFmt),
        finish: vm.$moment(finish, dateFmt)
      }
      vm.selected.rangeStart = {
        date: moment.start.toString(),
        formatDate: moment.start.format('D MMMM YYYY'),
        timeStamp: moment.start.valueOf()
      }

      vm.selected.rangeEnd = {
        date: moment.finish.toString(),
        formatDate: moment.finish.format('D MMMM YYYY'),
        timeStamp: moment.finish.valueOf()
      }
      vm.$emit('input', vm.selected)
    }, 500),
    onChangeDate: _.debounce(function(obj) {
      let vm = this
      let objClass = obj.target.className.includes('start') ? 'rangeStart' : 'rangeEnd'
      let selected = {
        date: obj.date,
        formatDate: obj.format(),
        timeStamp: obj.timeStamp
      }
      vm.selected[objClass] = selected
      vm.syncSelected(objClass, selected)
    }, 250),
    onSelected: _.debounce(function() {
      this.$emit('input', this.selected)
    }, 0),
    syncSelected(objClass, objTimeStamp) {
      if (
        objClass == 'rangeStart' &&
        (
          this.selected.rangeEnd == null ||
          objTimeStamp.date > this.selected.rangeEnd.date
        )
      ) {
        this.selected.rangeEnd = objTimeStamp
      }

      if (
        objClass == 'rangeEnd' &&
        (
          this.selected.rangeStart == null ||
          objTimeStamp.date < this.selected.rangeStart.date
        )
      ) {
        this.selected.rangeStart = objTimeStamp
      }

      this.onSelected()
    },
    setLimitDate() {
      let start = !this.setLimit ? null : this.setDates[0]
      let finish = !this.setLimit ? null : this.setDates[1]
      $(this.$refs['range']).children().each(function() {
        $(this).datepicker('setStartDate', start).datepicker('setEndDate', finish)
      })
    }
  }
}
</script>

<style>
.range-start > .datepicker,
.range-end > .datepicker {
  border: none !important;
}

td.active.day {
  background-color: unset !important;
  color: #666666 !important;
}

td.active.range.day {
  background-color: #eee !important;
  color: #000 !important;
}

.range > .range-start > div > div.datepicker-days > table > tbody > tr > td.old.selected,
.range > .range-start > div > div.datepicker-days > table > tbody > tr > td.active.selected,
.range > .range-end > div > div.datepicker-days > table > tbody > tr > td.old.selected,
.range > .range-end > div > div.datepicker-days > table > tbody > tr > td.active.selected {
  background-color: #366bc3 !important;
  border-color: var(--theme-primary-700) !important;
  color: #ffffff !important;
}
</style>
