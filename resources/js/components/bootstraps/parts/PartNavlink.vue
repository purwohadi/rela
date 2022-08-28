<template>
  <router-link
    v-if="!item.hasOwnProperty('child') "
    :to="{ name: item.route }"
    :title="item.label"
    :data-filter-tags="item.tags"
    @click.native="handleOnClick"
  >
    <i :class="item.icon" v-if="usingIcon"></i>
    <span class="nav-link-text p-1">{{ item.label }}</span>
  </router-link>
  <router-link to="" v-else>
    <i :class="item.icon" v-if="usingIcon"></i>
    <span class="nav-link-text p-1">{{ item.label }}</span>
  </router-link>
</template>

<script>
export default {
  name: 'PartNavlink',
  props: {
    item: {
      type: Object,
      required: true,
      description: 'Navlink Item'
    },
    usingIcon: {
      type: Boolean,
      required: false,
      description: 'Icon for navlink',
      default: true,
    }
  },
  methods: {
    handleOnClick(e) {
      this.$emit("onClick", this.item.route)
    }
  }
}
</script>

<style>

</style>
