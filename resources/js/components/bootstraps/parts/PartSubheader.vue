<template>
  <div class="subheader">
    <h1 class="subheader-title">
      <i :class="`subheader-icon ${ icon }`"></i>
      {{ firstLabel() }}
      <span class="fw-300">
        {{ restOfLabel() }}
      </span>
      <!-- <sup class='badge badge-primary fw-500'>
        ADDON
      </sup> -->
      <!-- <small>
        blank description
      </small> -->
    </h1>
    <!-- <div class="subheader-block">
      Right content of header
    </div> -->
  </div>
</template>

<script>
export default {
  name: 'PartSubheader',
  computed: {
    label() {
      return this.$route.meta && this.$route.meta.label
        ? this.$route.meta.label.split(' ')
        : []
    },
    icon() {
      return this.$route.meta.icon || ''
    }
  },
  methods: {
    firstLabel() {
      let label = [...this.label]
      return label ? label.shift() : ''
    },
    restOfLabel() {
      let label = [...this.label]
      if (label) label.shift()
      return label ? label.join(' ') : ''
    }
  }
}
</script>
