<template>
  <section v-if="options.length">
    <div v-for="(option, idx) in options" :key="idx">
      <input
        type="checkbox"
        class="mr-2 d-none"
        :id="`chk-${option[keyItem]}-${idx}`"
        :value="option[keyItem]"
        :checked="initCheck"
        @input="handleInput($event)"
      >
      <label :for="`chk-${option[keyItem]}-${idx}`" class="d-flex flex-row align-items-center pointer">
        <i
          class="mr-2"
          :class="{
            'fas fa-check-square text-primary': value.indexOf(option) !== -1,
            'fal fa-square text-muted': value.indexOf(option) === -1,
          }"
        ></i>
        {{ option[labelItem] }}
      </label>
    </div>
  </section>
</template>

<script>
export default {
  name: 'FaCheckBoxGroup',
  props: {
    value: {
      type: [Array, String],
      required: true,
    },
    options: {
      type: Array,
      required: true,
    },
    initCheck: {
      type: Boolean,
      required: false,
      default: false
    },
    labelItem: {
      type: String,
      required: false,
      default: 'text'
    },
    keyItem: {
      type: String,
      required: false,
      default: 'value'
    },
  },
  mounted() {
    if (this.initCheck) {
      this.updateOptions = [...this.options]
      this.$emit('input', this.updateOptions)
    }
  },
  methods: {
    handleInput(e) {
      let vm = this
      let options = [...vm.options]
      let selected = options.find(opt => opt[vm.keyItem] == e.target.value)
      let updateOptions = [...vm.value]
      if (e.target.checked) {
        updateOptions.push(selected)
      } else {
        updateOptions.splice(updateOptions.indexOf(selected), 1)
      }
      vm.$emit('input', updateOptions)
    }
  },
}
</script>

<style>

</style>
