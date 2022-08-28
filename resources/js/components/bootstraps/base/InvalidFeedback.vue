<template>
  <section class="errors">
    <span
      class="invalid-feedback"
      :style="{ display: error ? 'block' : 'none' }"
      role="alert"
    >
      {{ error }}
    </span>
  </section>
</template>

<script>
export default {
  name: "InvalidFeedback",
  props: ["error"],
}
</script>
