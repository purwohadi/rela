import Vue from 'vue'
import VueI18n from 'vue-i18n'

Vue.use(VueI18n)

const Locale = (locale) => {
  const files = require.context('@js/lang', true, /\.js$/i)
  let lang = Object.create(null)
  Object.assign(lang, { [locale]: {} })
  files.keys().forEach(key => {
    let names = [...key.split('/')]
    let section = names.pop().split('.').shift()
    let i18n = names.pop()
    if (i18n === locale)
      Object.assign(lang[i18n], { [section]: files(key).default })

  })
  return lang
}

export function createLocales(locale) {
  return new VueI18n({
    locale: locale,
    messages: Locale(locale)
  })
}
