<template>
  <div class="d-flex flex-wrap justify-content-center align-items-center text-center text-danger my-2">
    <div class="sk-swing mr-2">
      <div class="sk-swing-dot bg-warning"></div>
      <div class="sk-swing-dot bg-success"></div>
    </div>
    <slot name="text">
      <strong>{{ $t('general.datatable.body.loading') }}</strong>
    </slot>
  </div>
</template>

<script>
export default {
  name: 'Spinner'
}
</script>
