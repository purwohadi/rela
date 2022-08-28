<template>
  <div class="notif-menu">
    <!-- <div class="header-icon header-switch">
      <a
        href="#"
        :class="`icon-switch icon-sun ${selectedTheme.icon == 'moon' ? 'animate-sun' : ''}`"
        :title="`Switch to dark`"
        @click="changeTheme(selectedTheme.scheme)"
      >
        <i :class="`fas fa-sun`"></i>
      </a>
      <a
        href="#"
        :class="`icon-switch icon-moon ${selectedTheme.icon == 'moon' ? 'animate-moon' : ''}`"
        :title="`Switch to light`"
        @click="changeTheme(selectedTheme.scheme)"
      >
        <i :class="`fas fa-moon`"></i>
      </a>
    </div> -->
    <div class="header-icon header-switch" :title="`Switch to ${selectedTheme.icon == 'moon' ? 'light' : 'dark'}`">
      <div :class="`moon moon-icon ${selectedTheme.icon == 'moon' ? 'animate-moon' : ''}`" @click="changeTheme(selectedTheme.scheme)">
        <i class="fas fa-moon"></i>
      </div>    
      <div :class="`sun sun-icon ${selectedTheme.icon == 'moon' ? 'animate-sun' : ''}`" @click="changeTheme(selectedTheme.scheme)">
        <i class="fas fa-sun"></i>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'PartOptions',
  data() {
    return {
      selectedTheme : {
        name: 'light',
        scheme: 'light',
        icon: 'sun',
      }
    }
  },
  methods: {
    changeTheme (theme) {
      let skin = 'mod-skin-'
      var selected = theme == 'light' ? 'dark' : 'light'
      var body = document.body
      var contains = body.classList.contains(skin+theme)

      body.classList.remove(skin+theme)
      if(contains) {
        body.classList.add(skin+selected)
      }
      this.selectedTheme.name = theme
      this.selectedTheme.scheme = selected
      this.selectedTheme.icon = theme == 'light' ? 'moon' : 'sun'
    }
  }
}
</script>
