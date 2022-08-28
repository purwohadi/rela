<template>
  <section class="date-filter">
    <button
      id="desktop-filter-date"
      ref="filterDate"
      type="button"
      class="btn btn-default btn-sm rounded waves-effect waves-themed btn-sm-block btn-tgl"
      @click="showPanel = true"
    >
      <i :class="`fal ${btn.icon}`"></i>
      {{ btn.label }}
    </button>
    <div class="date-overlay" v-if="showPanel" @click="showPanel = false"></div>
    <div
      id="date-filter-panel"
      ref="dateFilterPanel"
      v-if="showPanel"
      class="panel shadow-lg"
      :style=" {
        display: 'block',
        maxWidth: isMobile ? '100%' : 'fit-content',
        position: isMobile ? 'unset' : 'absolute',
        zIndex: '10002',
        top: `${$refs.filterDate.offsetTop + 35}px`,
        left: `${$refs.filterDate.offsetLeft / 2}px`,
      }"
    >
      <div class="panel-hdr">
        <h2>Rentang <span class="fw-300"><i>Waktu</i></span></h2>
      </div>
      <div class="panel-container show">
        <div class="panel-content">
          <div class="row">
            <div class="col-auto">
              <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <a
                  :class="{ 'nav-link': true, 'active': setRange == 0 }"
                  data-toggle="pill"
                  href="javascript:void(0)"
                  aria-selected="true"
                  @click="setRanges(0)"
                >
                  Pilih Tanggal
                </a>
                <a
                  :class="{ 'nav-link': true, 'active': setRange == 30 }"
                  data-toggle="pill"
                  href="javascript:void(0)"
                  aria-selected="true"
                  @click="setRanges(30)"
                >
                  30 Hari Terakhir
                </a>
                <a
                  :class="{ 'nav-link': true, 'active': setRange == 90 }"
                  data-toggle="pill"
                  href="javascript:void(0)"
                  aria-selected="true"
                  @click="setRanges(90)"
                >
                  90 Hari Terakhir
                </a>
              </div>
            </div>
            <div class="col">
              <bs-inline-daterangepicker
                v-model="daterange"
                :set-dates="setDates"
                :set-limit="setLimit"
              />
            </div>
          </div>
          <div class="d-flex px-1 justify-content-end">
            <button
              type="button"
              class="btn btn-default btn-sm rounded waves-effect waves-themed btn-sm-block mr-2"
              @click="showPanel = false"
            >
              <i class="fal fa-times"></i>
              Batalkan
            </button>
            <button
              type="button"
              class="btn btn-default btn-sm rounded waves-effect waves-themed btn-sm-block mr-2"
              @click="onReset"
              :disabled="isDisabled"
            >
              <i class="fal fa-redo fa-flip-horizontal"></i>
              Atur Ulang
            </button>
            <button
              type="button"
              class="btn btn-primary btn-sm rounded waves-effect waves-themed btn-sm-block"
              @click="applyDate"
              :disabled="isDisabled"
            >
              <i class="fal fa-calendar-check"></i>
              Terapkan
            </button>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  name: 'DateFilters',
  props: {
    value: {
      type: Object,
      required: true,
    },
    isMobile: Boolean,
    placeholder:{
      type:String,
      default:'Filter Tanggal'
    }
  },
  data() {
    let vm = this
    return {
      showPanel: false,
      daterange: {},
      setRange: 0,
      isDisabled: true,
      setDates: [],
      btn: {
        icon: 'fa-calendar-alt',
        label: this.placeholder
      },
      setLimit: false,
    }
  },
  watch: {
    daterange: {
      immediate: false,
      deep: true,
      handler: function(n) {
        this.isDisabled = (!n.rangeStart || !n.rangeEnd)
        if (!n.rangeStart && !n.rangeEnd) {
          this.setDates = [this.daterange.rangeStart.formatDate, this.daterange.rangeEnd.formatDate]
        }
      }
    }
  },
  // computed:{
  //   placeholder() {
  //   },
  // },
  methods: {
    setRanges(range = 0) {
      let dates = {}
      dates.finish = this.$moment()
      dates.start = Number(range) > 0 ? this.$moment().subtract(range, 'days') : this.$moment()
      this.setLimit = Number(range) > 0
      this.setRange = range
      this.setDates = [dates.start.format('DD/MM/YYYY'), dates.finish.format('DD/MM/YYYY')]
    },
    applyDate() {
      if (!this.isDisabled) {
        this.showPanel = false
        this.onApply()
      }
    },
    onReset() {
      if (!this.isDisabled) {
        this.setDates = []
        this.setRange = 0
        this.daterange.rangeStart = {}
        this.daterange.rangeEnd = {}
        this.onApply(true)
        this.showPanel = false
      }
    },
    onApply(reset = false) {
      this.setRanges(this.setRange)
      this.setLabel(reset)
      this.$emit('input', this.daterange)
      this.$emit('onApply', this.daterange)
    },
    setLabel(reset) {
      if (reset) {
        this.btn.icon = 'fa-calendar-alt'
        this.btn.label = this.placeholder
      } else {
        this.setDates = [this.daterange.rangeStart.formatDate, this.daterange.rangeEnd.formatDate]
        this.btn.icon = 'fa-calendar-check'
        this.btn.label = `${this.daterange.rangeStart.formatDate} - ${this.daterange.rangeEnd.formatDate}`
      }
    }
  }
}
</script>

<style lang="scss" scoped>
.nav-pills .nav-link {
  border-radius: 0.5rem !important;
}
.nav-link {
  padding: 0.325rem 1.125rem !important;
}
.date-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: transparent;
  z-index: 10001;
}
</style>
