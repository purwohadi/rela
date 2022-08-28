<script>
  'use strict'

  var classHolder = document.getElementsByTagName("BODY")[0]
  /**
   * Load from localstorage
   **/
  var themeSettings = (localStorage.getItem('themeSettings'))
        ? JSON.parse(localStorage.getItem('themeSettings'))
        : { themeOptions: 'mod-bg-1 header-function-fixed nav-function-fixed mod-skin-light', themeURL: '' }

  var themeURL = themeSettings.themeURL || ''
  var themeOptions = themeSettings.themeOptions || 'mod-bg-1 header-function-fixed nav-function-fixed mod-skin-light'

  /**
   * Load theme options
   **/
  if (themeSettings.themeOptions)
    classHolder.className = themeSettings.themeOptions

  if (themeSettings.themeURL && !document.getElementById('mytheme')) {
    var cssfile = document.createElement('link')
    cssfile.id = 'mytheme'
    cssfile.rel = 'stylesheet'
    cssfile.href = themeURL
    document.getElementsByTagName('head')[0].appendChild(cssfile)
  }

  /**
   * Save to localstorage
   **/
  var saveSettings = function () {
    themeSettings.themeOptions = String(classHolder.className).split(/[^\w-]+/).filter(function (item) {
      return /^(nav|header|mod|display)-/i.test(item)
    }).join(' ')

    if (document.getElementById('mytheme')) {
      themeSettings.themeURL = document.getElementById('mytheme').getAttribute("href")
    }

    localStorage.setItem('themeSettings', JSON.stringify(themeSettings))
  }
  /**
   * Reset settings
   **/
  var resetSettings = function () {
    localStorage.setItem("themeSettings", "")
  }
</script>
