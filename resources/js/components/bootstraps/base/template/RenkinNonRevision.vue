<template>
  <section class="renkin-non-revision">
    <span v-if="isActive">
      {{ item[field] }}
    </span>
    <span v-else>
      <del class="text-muted">{{ item[field] }}</del>
    </span>
  </section>
</template>

<script>
export default {
  name: 'RenkinNonRevision',
  props: {
    item: {
      type: Object,
      required: true,
    },
    field: {
      type: String,
      required: true,
    },
    isActive: {
      type: [Boolean, String, Number],
      required: true
    }
  },
}
</script>

<style>

</style>
