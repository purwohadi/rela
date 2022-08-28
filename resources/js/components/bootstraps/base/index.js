const files = require.context("./", true, /\.vue$/i) // the power of autoload hehehe
export default {
  install(Vue) {
    files.keys().map(key => {
      const componentName = files(key).default.name
        ? files(key).default.name
        : key.split("/").pop().split(".").shift()
      Vue.component(componentName, files(key).default)
    })
  }
}
