<template>
  <footer class="page-footer" role="contentinfo">
    <div class="d-flex align-items-center flex-1 text-muted">
      <span class="hidden-md-down fw-700">
        2021 © {{ $app.appname }} by&nbsp;
        <a
          :href="$app.owner.web"
          class="text-dark opacity-75 fw-500"
          :title="$app.owner.name"
          target="_blank"
        >
          {{ $app.owner.name }}
        </a>
      </span>
    </div>
    <div>
      <ul class="list-table m-0">
        <li class="pl-3">
          <!-- <a href="#" class="text-secondary fw-700">Buku Manual</a> -->
          <router-link class="text-secondary fw-700" :to="{ name: 'manualbook.list'}"><i class="fas fa-book pr-2"></i>Buku Manual</router-link>
        </li>
      </ul>
    </div>
  </footer>
</template>

<script>
export default {
  name: 'PartFooter'
}
</script>
