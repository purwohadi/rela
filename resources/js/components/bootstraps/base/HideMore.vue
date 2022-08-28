<template>
  <component :is="tag">
    <template v-for="(item, idx) in show">
      <slot name="show" v-bind:data="item">
        <template v-if="useHighlight">
          <span
            :class="`
              badge badge-${ isHighlight(item) ? highlightColor : type }
              badge-pill mr-1 mb-1`"
            :key="`show_${idx}`"
          >
            {{ item[label] }}
          </span>
        </template>
        <template v-else>
          <span :class="`badge badge-${type} badge-pill mr-1 mb-1`" :key="`show_${idx}`">
            {{ item[label] }}
          </span>
        </template>
      </slot>
    </template>

    <transition-group name="slide-fade" appear>
      <template v-for="(item, idx) in more" v-if="loadMore">
        <slot name="more" v-bind:data="item">
          <template v-if="useHighlight">
            <span
              :class="`
                badge badge-${ isHighlight(item) ? highlightColor : type }
                badge-pill mr-1`"
              :key="`more_${idx}`"
            >
              {{ item[label] }}
            </span>
          </template>
          <template v-else>
            <span :class="`badge badge-${type} badge-pill mr-1`" :key="`more_${idx}`">
              {{ item[label] }}
            </span>
          </template>
        </slot>
      </template>
    </transition-group>

    <small v-if="more.length">
      <b-badge variant="info" class="pointer" @click="loadMore = !loadMore">
        <template v-if="loadMore">
          <slot name="hideText">
            {{ $t('general.hide-more.hide') }}
          </slot>
        </template>
        <template v-else>
          <slot name="showText">
            {{ $t('general.hide-more.more', { count: more.length }) }}
          </slot>
        </template>
      </b-badge>
    </small>
  </component>
</template>

<script>
export default {
  name: "HideMore",
  props: {
    tag: {
      type: String,
      default: "span",
      required: false,
    },
    items: {
      type: Array,
      required: true,
    },
    max: {
      type: Number,
      default: 1000,
      required: false,
    },
    label: {
      type: String,
      default: "name",
      required: false,
    },
    type: {
      type: String,
      default: "success",
      required: false,
    },
    searchHighligt: {
      type: Boolean,
      default: false,
      required: false,
    },
    highlightText: {
      type: String,
      required: false
    },
    highlightColor: {
      type: String,
      default: 'primary',
      required: false
    }
  },
  data() {
    return {
      loadMore: false,
      modifyItems: []
    }
  },
  computed: {
    show() {
      const vm = this
      if (vm.modifyItems.length > vm.max) {
        return _.take(vm.modifyItems, vm.max)
      } else {
        return vm.modifyItems
      }
    },
    more() {
      const vm = this
      return vm.modifyItems.length > vm.max ? _.takeRight(vm.modifyItems, vm.modifyItems.length - vm.max) : []
    },
    useHighlight() {
      return this.searchHighligt && this.highlightText && this.highlightText.length
    },
  },
  created() {
    let vm = this
    if (
      vm.searchHighligt &&
      vm.highlightText &&
      vm.highlightText.length > 0
    ) {
      let deletedItems = []
      let temp = vm.items.filter(item => {
        if (item[vm.label].toLowerCase().includes(this.highlightText.toLowerCase())) {
          deletedItems.unshift(item)
        }
        return !item[vm.label].toLowerCase().includes(this.highlightText.toLowerCase())
      })
      deletedItems.forEach(deletedItem => {
        temp.unshift(deletedItem)
      })

      vm.modifyItems = temp
    } else {
      vm.modifyItems = this.items
    }
  },
  methods: {
    isHighlight(value) {
      return value[this.label].toLowerCase().includes(this.highlightText.toLowerCase())
    }
  }
}
</script>

<style scoped>
.pointer {
  cursor: pointer !important;
}
</style>
