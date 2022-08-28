<template>
  <b-carousel
    id="carousel-banner"
    style="text-shadow: 0px 0px 2px #000"
    fade
    controls
    indicators
    img-width="800"
  >
    <template v-for="(banner, key) in banners">
      <b-carousel-slide
        class="d-block w-100"
        :img-src="banner.banner"
        :key="key"
      ></b-carousel-slide>
    </template>
  </b-carousel>
</template>

<script>
export default {
  name: 'Banner',
  props: {
    banners: {
      type: Array,
      default: () => []
    }
  },
  data() {
    return {
    }
  }
};
</script>

<style lang="scss">
#carousel-banner {
  .carousel-indicators {
    li {
      width: 1.5rem;
      height: 5px;
    }
  }
}
</style>
