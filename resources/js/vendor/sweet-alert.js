window.swal = require("sweetalert2")

window.toast = window.swal.mixin({
  toast: true,
  position: "top-end",
  showConfirmButton: false,
  timer: 3000,
})

window.successAlert = function successAlert(text, icon = "success", title = "Sukses") {
  return window.swal.fire({
    icon: icon,
    title: title,
    text: text
  })
}

window.errorAlert = function errorAlert(text, icon = "error", title = "Ooppss!") {
  return window.swal.fire({
    icon: icon,
    title: title,
    text: text,
  })
}

window.confirmAlert = function confirmAlert(options) {
  const defaults = {
    icon: "info",
    title: "Konfirmasi",
    text: "Apakah anda yakin?",
    showCancelButton: true,
    cancelButtonText: "Batalkan",
    confirmButtonText: "Ya, saya sangat yakin",
    confirmButtonColor: "#3085d6",
    showLoaderOnConfirm: true,
    preConfirm: null,
  }
  let settings = Object.assign(defaults, options)
  return window.swal.fire({
    icon: settings.icon,
    title: settings.title,
    text: settings.text,
    showCancelButton: settings.showCancelButton,
    cancelButtonText: settings.cancelButtonText,
    confirmButtonText: settings.confirmButtonText,
    confirmButtonColor: settings.confirmButtonColor,
    showLoaderOnConfirm: settings.showLoaderOnConfirm,
    preConfirm: settings.preConfirm,
    allowOutsideClick: () => !window.swal.isLoading(),
  })
}
