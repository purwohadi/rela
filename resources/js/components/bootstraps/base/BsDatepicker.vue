<template>
  <div class="d-flex form-group align-item-baseline">
    <label v-if="!hideLabel" class="form-label nowrap mr-2 pt-2" for="bs-datepicker">
      {{ label }}
    </label>
    <div :class="`input-group group-date ${size ? `input-group-${size}` : ''}`">
      <input
        :id="id"
        ref="bs-datepicker"
        type="text"
        :placeholder="placeholder"
        :class="inputclass"
        :value="value"
        :disabledDayBefore="disabledDayBefore"
        :disabled="disabled"
        readonly
      >
      <span
        v-if="cleardate"
        :class="`
          datepicker-btn-clear
          pointer
          ${value.length ? 'go-show' : 'go-transparent'}
        `"
        :style="clearDateStyle"
        @click="handleClear"
      >
        <i class="fal fa-times-circle datepicker-btn-icon-clear"></i>
      </span>
      <div class="input-group-append pointer" @click="handleOnClick">
        <span class="input-group-text fs-xl" :class="inputGroupTextClass">
          <i class="fal fa-calendar-alt"></i>
        </span>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: 'BsDatepicker',
    props: {
      id: {
        type: String,
        required: false
      },
      label: {
        type: String,
        required: false
      },
      value: {
        type: String,
        required: true
      },
      placeholder: {
        type: String,
        required: false,
        default: ''
      },
      disabled: {
        type: Boolean,
        required: false,
        default: false,
      },
      inputclass: {
        type: String,
        required: false,
        default: 'form-control'
      },
      size: {
        type: String,
        required: false,
        default: ''
      },
      cleardate: {
        type: Boolean,
        required: false,
        default: true,
      },
      disabledDayBefore: {
        type: Boolean,
        required: false,
        default: false,
      },
      settings: {
        type: Object,
        required: false,
        default: () => {}
      },
      hideLabel: {
        type: Boolean,
        require: false,
        default: false
      },
      inputGroupTextClass: {
        type: String,
        required: false,
        default: ''
      },
      clearDateStyle: {
        type: String,
        required: false,
        default: ''
      }
    },
    data() {
      return {
        dtp: null,
        controls: {
          leftArrow: '<i class="fal fa-angle-left" style="font-size: 1.25rem"></i>',
          rightArrow: '<i class="fal fa-angle-right" style="font-size: 1.25rem"></i>'
        }
      }
    },
    watch: {
      'value': {
        immediate: true,
        handler: function(n) {
          if (n && n.length > 0) {
            if (this.dtp) this.dtp.datepicker('update', n)
          }
        }
      },
      'settings.startDate': {
        handler: function(n) {
          if (n) {
            this.updateStartDate(n)
          }
        }
      },
      'settings.endDate': {
        handler: function(n) {
          if (n) {
            this.updateEndDate(n)
          }
        }
      }
    },
    mounted() {
      const vm = this
      const defaultSettings = {
        autoclose: true,
        format: "d MM yyyy",
        immediateUpdates: true,
        language: "id",
        orientation: "bottom auto",
        templates: vm.controls,
        startDate: this.disabledDayBefore ? new Date() : 0,
      }

      const mergedSettings = {...defaultSettings, ...vm.settings}

      vm.dtp = $(vm.$refs['bs-datepicker'])
        .datepicker(mergedSettings)
        .on('changeDate', vm.onChangeDate)
    },
    beforeDestroy() {
      if (this.dtp) this.dtp.datepicker('destroy')
    },
    methods: {
      onChangeDate(obj) {
        this.$emit('onSelected', {
          date: obj.date,
          formatDate: obj.format(),
          timeStamp: obj.timeStamp
        })

        this.$emit('input', obj.format())
      },
      handleOnClick() {
        if (this.dtp) this.dtp.datepicker('show')
      },
      updateStartDate(date) {
        if (this.dtp) {
          this.dtp.datepicker('update')
          this.dtp.datepicker('setValue', date)
          this.dtp.datepicker('setStartDate', date)
        }
      },
      updateEndDate(date) {
        if (this.dtp) this.dtp.datepicker('setEndDate', date)
      },
      handleClear() {
        this.dtp.datepicker('clearDates')
      }
    }
  }
</script>

<style lang="scss" scoped>
.d-flex {
  &.form-group {
    margin-bottom: 0;
  }
}

.datepicker-btn-clear {
  position: absolute;
  top: 25%;
  right: 48px;
}

.datepicker-btn-icon-clear {
  color: #dc3545;
  font-size: 14px;
}
.datepicker-input {
  input {
    &:read-only {
      background: #fff;
    }
  }
}
</style>
