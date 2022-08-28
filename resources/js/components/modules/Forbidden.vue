<template>
  <div class="row justify-content-center">
    <div class="col-lg-12">
      <div class="d-flex flex-column align-items-center justify-content-center text-center">
        <h1 class="display-3 fw-700 color-fusion-500 mb-0">
          <small class="fw-500 fs-xxl mb-0">
            Akses ditolak.
          </small>
        </h1>
        <p class="fw-300 mb-0">
          Mohon maaf, Anda tidak memiliki izin untuk mengakses halaman ini. <br>
          Anda dapat kembali ke halaman <span class="text-info cursor-pointer" @click="$router.go(-1)">sebelumnya</span>.
        </p>
        <b-img
          v-bind="{ width: 300 }"
          src="/img/svg/403.svg"
          fluid alt="403"
        >
        </b-img>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Forbidden'
}
</script>
