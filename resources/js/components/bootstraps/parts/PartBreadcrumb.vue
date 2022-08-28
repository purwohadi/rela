<template>
  <ol class="breadcrumb page-breadcrumb">
    <li class="breadcrumb-item"><a :href="$app.route('home')">Beranda</a></li>
    <li class="breadcrumb-item active">{{ $route.meta.label }}</li>
    <li class="position-absolute pos-top pos-right d-none d-sm-block">
      {{ $app.getCurrentDate() }}
    </li>
  </ol>
</template>

<script>
export default {
  name: 'PartBreadcrumb'
}
</script>
