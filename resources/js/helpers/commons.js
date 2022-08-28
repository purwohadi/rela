export function getSettings() {
  const jsonSettings = document.querySelector(
    '[data-settings-selector="settings-json"]'
  )
  return jsonSettings ? JSON.parse(jsonSettings.textContent) : {}
}

export function kebabCase(string) {
  return string.replace(/([a-z])([A-Z])/g, '$1-$2').replace(/\s+/g, '-').toLowerCase()
}

export class RouteGenerator {
  constructor(module) {
    this.module = module
  }

  path(path = null) {
    let fullPath = this.build(path).join('/')
    return fullPath.padStart(fullPath.length + 1, '/')
  }

  name(name = null) {
    return name ? this.build(name).join('.') : this.build(name).join('')
  }

  build(value) {
    return [
      this.module,
      value
    ]
  }
}

export class LoadComponent {
  constructor(files) {
    let components = []
    files.keys()
      .filter(k => !k.includes('__')) // skip file inside directory with double underscore prefix
      .map(key => {
        let componentName = kebabCase(key.split('/').pop().split('.').shift())
        components[componentName] = files(key).default
      })
    this.components = components
  }

  get(key) {
    return this.components[key]
  }
}

export function toFixed(num, fixed, rounding = false, separator = '.') {
  if (rounding) {
    return Number(num).toFixed(fixed)
  }

  let numAsString = num.toString()
  return numAsString.includes(separator)
    ? numAsString.slice(0, (numAsString.indexOf(separator)) + fixed + 1)
    : numAsString
}
