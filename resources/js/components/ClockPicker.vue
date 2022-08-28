<template>
  <div id="c-clockpicker">
    <div class="form-group">
      <b-input
        :id="uuid"
        :ref="uuid"
        type="text"
        :class="`${classInput} ${customClass}`"
        autocomplete="off"
        v-model="inputModel"
        v-mask="timeMask"
        @keydown="onKeyUp"
        @focus="onFocus"
        :tabindex="tabIndex"
        :key="idx"
      ></b-input>
    </div>
  </div>
</template>

<script>
const ID = () => {
  const random = Math.random().toString(36).substring(2, 9);
  const now = Date.now().toString(36);
  return `clock_picker_${now + random}`;
};

export default {
  name: 'ClockPicker',
  props: {
    id: {
      type: String,
      default: null
    },
    canInput: {
      type: Boolean,
      default: true
    },
    value: {
      type: String,
      required: true
    },
    settings: {
      type: Object,
      required: false,
      default: () => {}
    },
    tabIndex: {
      type: [String, Number],
      required: false,
      default: '-1'
    },
  },
  data() {
    let vm = this
    return {
      classInput: 'form-control rounded-0 border-top-0 border-left-0 border-right-0 px-0 bg-transparent position-relative',
      customClass: '',
      clockpicker: null,
      uuid: this.id || ID(),
      inputModel: null,
      timeMask: vm.ftimeMask,
      idx: 0
    }
  },
  watch: {
    'value': {
      immediate: true,
      handler: function(n) {
        if (n && n.length > 0) {
          this.inputModel = n
          ++this.idx
        }
      }
    },
  },
  mounted() {
    this.initClockPicker()
  },
  methods: {
    initClockPicker() {
      const vm = this
      const defaultSettings = {
        'default': 'now',
        vibrate: true,
        placement: "bottom",
        align: "right",
        autoclose: true,
        twelvehour: false,
        afterDone: vm.handleInput
      }

      const mergedSettings = {...defaultSettings, ...vm.settings}
      if (!_.isEmpty(vm.clockpicker)) vm.clockpicker.clockpicker('remove')
      vm.clockpicker = $(vm.$refs[vm.uuid].$el).clockpicker(mergedSettings)
    },
    handleInput(e) {
      let selected = moment(e).format("HH:mm")
      let timeValue = moment(e).isValid() ? selected : e.target.value
      this.inputModel = timeValue
      this.$emit('input', timeValue)
      this.$emit('onSelected', timeValue)
    },
    onKeyUp: _.debounce(function(e) {
      if(e.target.value.length > 4) this.handleInput(e)
    }, 250),
    onFocus() {
      this.initClockPicker()
    },
    ftimeMask(value) {
      const hours = [
        /[0-2]/,
        value.charAt(0) === '2' ? /[0-3]/ : /[0-9]/,
      ];
      const minutes = [/[0-5]/, /[0-9]/];
      return value.length > 2
        ? [...hours, ':', ...minutes]
        : hours;
    }
  }
}
</script>

<style lang="scss">
.clockpicker-popover {
  box-shadow: 0 24px 38px 3px rgba(0,0,0,.14);
  .popover-header {
    background-color: var(--theme-primary-400);
    border-top-left-radius: .4rem;
    border-top-right-radius: .4rem;
  }
  .popover-body {
    border-bottom-right-radius: .4rem;
    border-bottom-left-radius: .4rem;
  }
}
</style>
