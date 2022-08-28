<template>
  <section :class="`donut-card ${getLoading ? 'w-100' : ''}`">
    <div v-if="getLoading" class="mr-4">
      <div class="d-flex">
        <b-skeleton type="avatar mr-2"></b-skeleton>
        <div class="desc w-75">
          <b-skeleton animation="wave" width="90%"></b-skeleton>
          <div class="d-flex">
            <div class="w-50 pr-1">
              <b-skeleton animation="wave" width="100%"></b-skeleton>
            </div>
            <div class="w-50 pl-1">
              <b-skeleton animation="wave" width="100%"></b-skeleton>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="d-flex align-items-center" :style="`${ getLoading ? 'display: none !important' : ''}`">
      <div>
        <span
          ref="donutCard"
          class="peity-donut"
          :data-peity="getSettings"
        >
        </span>
      </div>
      <div class="pl-3 pr-2 w-100">
        <div class="donut-title">{{ title }}</div>
        <div class="donut-content d-flex mt-1">
          <div class="activity d-flex">
            <div class="content-value">{{ aktivitas }}</div>
            <div class="content-subtitle">Aktivitas</div>
          </div>
          <div class="activity d-flex pl-2 pr-2">
            <div class="content-value">{{ menit }}</div>
            <div class="content-subtitle">Menit</div>
          </div>
        </div>
      </div>
    </div>
    <slot name="button">
    </slot>
  </section>
</template>

<script>
export default {
  name: 'DonutCard',
  props: {
    title: {
      type: String,
      required: true,
    },
    aktivitas: {
      type: [Number, String],
      default: 0,
    },
    menit: {
      type: [Number, String],
      default: 0,
    },
    chartValue: {
      type: String,
      required: true
    },
    variant: {
      type: String,
      required: false,
      default: 'success'
    },
    radius: {
      type: [String, Number],
      required: false,
      default: 20,
    },
    innerRadius: {
      type: [String, Number],
      required: false,
      default: 14,
    },
    loading: {
      type: Boolean,
      required: false,
      default: false
    }
  },
  data() {
    return {
      $peity: null,
      fill: {
        success: `["#1dc9b7", "#c1eae6"]`,
        danger: `["#fd3995", "#f9e7ef"]`,
        warning: `["#ffc241", "#fdefd1"]`,
      }
    }
  },
  computed: {
    getVariant() {
      let variants = Object.keys(this.fill)
      if (!variants.includes(this.variant)) return this.fill.success
      return this.fill[this.variant]
    },
    getSettings() {
      return `{ "fill": ${this.getVariant},  "innerRadius": ${this.innerRadius}, "radius": ${this.radius} }`
    },
    getLoading() {
      return this.loading
    }
  },
  watch: {
    chartValue: function(n, o) {
      if (n && n != o) this.initChart()
    },
    getLoading: {
      immediate: true,
      handler: function(n) {
        this.initChart()
      }
    }
  },
  mounted() {
    this.initChart()
  },
  methods: {
    initChart() {
      if (this.getLoading) return

      if (this.$refs.donutCard) {
        this.$refs.donutCard.textContent = this.chartValue
        $(this.$refs.donutCard).peity('donut')
      }
    }
  }
}
</script>

<style lang="scss">
.donut-card {
  color: #212529;
  position: relative;
  .donut-title {
    font-size: .8rem;
    font-weight: 500;
  }
  .donut-content {
    .content-value {
      font-size: 1.14rem;
      margin-right: .3rem;
      font-weight: 600;
      text-align: right;
    }
    .content-subtitle {
      font-size: .6rem;
      color: var(--gray);
    }
  }
  .additional-button {
    font-size: .9rem;
    position: absolute;
    top: -5px;
    right: 0;
  }
}
</style>
