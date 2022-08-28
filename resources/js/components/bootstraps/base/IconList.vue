<template>
  <m-select
    label="icon"
    v-model="getSelectedIcon"
    :placeholder="getPlaceholder"
    :options="icons"
    :searchable="true"
    :internal-search="true"
    :clear-on-select="true"
    :close-on-select="true"
    :disabled="disabled"
  >
    <span slot="singleLabel" slot-scope="props" class="text-capitalize">
      <i :class="`${ props.option.icon } fa-fw mr-1`"></i>
      {{ props.option.name }}
    </span>
    <span slot="option" slot-scope="props" class="text-capitalize">
      <i :class="`${ props.option.icon } fa-fw mr-1`"></i>
      {{ props.option.name }}
    </span>

    <span slot="noOptions">
      {{ $t('general.multiselect.no-options') }}
    </span>
    <span slot="noResult">
      {{ $t('general.multiselect.no-options') }}
    </span>
  </m-select>
</template>

<script>
import { mapGetters } from 'vuex'
export default {
  name: 'IconList',
  props: {
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
  },
  data() {
    return {
      icons: [],
      selectedIcon: null
    }
  },
  computed: {
    ...mapGetters({
      getFaBrandList: 'getFaBrandList',
      getFaIconList: 'getFaIconList',
      getNgIconList: 'getNgIconList',
    }),
    getPlaceholder() {
      return this.placeholder
        ? this.placeholder
        : this.$t('general.multiselect.icon-placeholder')
    },
    getSelectedIcon: {
      get() {
        return this.selectedIcon || this.$attrs.value
      },
      set(val) {
        this.$emit('input', val)
      }
    }
  },
  mounted() {
    this.icons = this.getFaIconList.map(icon => {
      return {
        'icon': `fal fa${icon}`,
        'name': icon.replace(/-/g, ' ').trim()
      }
    })
  },
}
</script>

<style>

</style>
