<template>
  <section class="icon-card w-100">
    <b-card v-if="loading" class="shadow-0 rounded">
      <b-skeleton animation="wave" width="85%"></b-skeleton>
      <b-skeleton animation="wave" width="55%"></b-skeleton>
    </b-card>
    <div
      :class="`p-3 bg-${variant}-300 rounded overflow-hidden position-relative text-white ${ expandWidth ? 'w-100' : ''}`"
      v-else
    >
      <div class="">
        <h4 class="lead d-block l-h-n m-0 fw-500">
          {{ title }}
          <small class="m-0 l-h-n">{{ subTitle }}</small>
        </h4>
      </div>
      <slot name="extend">
      </slot>
      <i
        :class="`${ icon } position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1`"
        :style="`font-size:${iconSize}rem`"></i>
    </div>
  </section>
</template>

<script>
export default {
  name: 'IconCard',
  props: {
    title: {
      type: String,
      required: true,
    },
    subTitle: {
      type: String,
      required: true,
    },
    variant: {
      type: String,
      required: false,
      default: 'primary'
    },
    expandWidth: {
      type: Boolean,
      required: false,
      default: true,
    },
    icon: {
      type: String,
      required: false,
      default: 'fal fa-clock'
    },
    iconSize: {
      type: Number,
      required: false,
      default: 5
    },
    loading: {
      type: Boolean,
      required: false,
      default: false
    }
  }
}
</script>

<style>

</style>
