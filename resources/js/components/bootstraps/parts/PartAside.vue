<template>
  <aside class="page-sidebar">
    <div class="page-logo">
      <router-link
        :to="{ name: 'home' }"
        class="page-logo-link press-scale-down d-flex align-items-center position-relative" data-toggle="modal"
        data-target="#modal-shortcut">
        <img :src="'/img/logo.png'" :alt="$app.appname" aria-roledescription="logo" style="height: 2.275rem">
        <span class="page-logo-text mr-1">
          {{ $app.appname }}
        </span>
      </router-link>
    </div>
    <!-- BEGIN PRIMARY NAVIGATION -->
    <nav id="js-primary-nav" ref="jsPrimaryNav" class="primary-nav" role="navigation">
      <div class="nav-filter">
        <div class="position-relative">
          <input
            type="text" id="nav_filter_input" ref="navFilterInput" placeholder="Filter menu" class="form-control"
            tabindex="0">
          <a
            href="#" onclick="return false;" class="btn-primary btn-search-close js-waves-off" data-action="toggle"
            data-class="list-filter-active" data-target=".page-sidebar">
            <i class="fal fa-chevron-up"></i>
          </a>
        </div>
      </div>
      <div class="info-card">
        <b-avatar
          class="profile-image" size="2.8rem" :src="avatar" :alt="$app.user.v_username"
          :text="$app.getInitialName($app.user.v_username)" :variant="avatar ? 'defalt' : 'secondary'"></b-avatar>
        <div class="info-card-text">
          <a href="#" class="d-flex align-items-center text-white txt-username">
            <span
              class="text-truncate text-truncate-sm d-inline-block" data-toggle="tooltip" data-placement="top"
              :title="$app.user.v_username">
              {{ $app.user.v_username }}
            </span>
          </a>
          <!-- <span
          class="d-inline-block text-truncate text-truncate-sm txt-location"
          data-toggle="tooltip"
          data-placement="bottom"
          title="DISKOMINFOTIK"
        >
          DISKOMINFOTIK
        </span> -->
        </div>
        <img :src="'/img/card-backgrounds/cover-2-lg.png'" class="cover" alt="cover">
        <!-- <a href="#" onclick="return false;" class="pull-trigger-btn" data-action="toggle" data-class="list-filter-active" data-target=".page-sidebar" data-focus="nav_filter_input">
      <i class="fal fa-angle-down"></i>
      </a> -->
      </div>
      <div class="line-divider"></div>
      <ul id="js-nav-menu" ref="jsNavMenu" class="nav-menu">
        <li
          v-for="level1 in userMenu"
          :key="level1.child && level1.child.length ? `parent${level1.key}` : level1.key"
          :class="{ 'nav-title': level1.group && level1.group.length > 0 }"
        >
          <template v-if="level1.group && level1.group.length > 0">
            {{ level1.group }}
          </template>
          <template v-else>
            <part-navlink
              :item="level1"
              @onClick="handleOnClick"
            />
            <template v-if="level1.child && level1.child.length > 0">
              <ul>
                <li
                  v-for="level2 in level1.child"
                  :key="level2.key"
                  :ref="level2.child && level2.child.length ? 'parent'+level2.key : level2.key.replace('.', '')"
                >
                  <part-navlink :item="level2" :using-icon="false" @onClick="handleOnClick" />
                </li>
              </ul>
            </template>
          </template>
        </li>

        <!-- <template v-for="(level1, idx) in userMenu">
          <li class="nav-title" v-if="level1.group && level1.group.length > 0" :key="idx">
            {{ level1.group }}
          </li>
          <li :key="level1.key" :ref="level1.child && level1.child.length ? 'parent'+level1.key : level1.key">
            <part-navlink :item="level1" @onClick="handleOnClick">
            </part-navlink>
            <template v-if="level1.child && level1.child.length > 0">
              <ul>
                <li v-for="level2 in level1.child" :key="level2.key"
                  :ref="level2.child && level2.child.length ? 'parent'+level2.key : level2.key.replace('.', '')">
                  <part-navlink :item="level2" :using-icon="false" @onClick="handleOnClick">
                  </part-navlink>
                </li>
              </ul>
            </template>
          </li>
        </template> -->
      </ul>
      <!-- <div class="filter-message js-filter-message bg-success-600"></div> -->
    </nav>
    <!-- END PRIMARY NAVIGATION -->
  </aside>
</template>

<script>
import { mapGetters } from 'vuex'
import PartNavlink from './PartNavlink'
export default {
  name: 'PartAside',
  components: {
    PartNavlink
  },
  data() {
    return {
      menuItems: this.$app.user.menu,
      ignoreRefs: ['jsNavMenu', 'jsPrimaryNav', 'navFilterInput'],
    }
  },
  computed: {
    ...mapGetters({
      avatar: 'getAvatar',
      userMenu: 'getStructureMenu',
      allMenu: 'getFlattenMenu'
    }),
  },
  beforeDestroy() {
    $(this.$refs.jsPrimaryNav).slimScroll({ destroy: true })
  },
  mounted() {
    initApp.listFilter($(this.$refs.jsNavMenu), $(this.$refs.navFilterInput))
    initApp.buildNavigation(this.$refs.jsNavMenu)
    $(this.$refs.jsPrimaryNav).slimScroll({
      height: '100%',
      color: '#ccc',
      size: '4px',
      distance: '4px',
      railOpacity: 0.4,
      wheelStep: 10
    })
    this.handleOnClick(this.$route.name)
  },
  methods: {
    handleOnClick(name) {
      let vm = this
      const temp = Object.values(vm.allMenu)
      let isFound = temp.find(menu => menu.route === name)
      if (name && isFound) {
        const currentActiveMenu = temp.filter(menu => menu.route === name).shift()
        let selectedMenu = currentActiveMenu.key
        const filtered = Object.keys(vm.$refs).filter(ref => !vm.ignoreRefs.includes(ref))
        filtered.forEach(ref => {
          let tempElement = [...vm.$refs[ref]]
          let element = tempElement.shift()

          vm.setActiveELement(element, ref === selectedMenu.replace('.', ''))
        })

        let liParent = this.$refs[selectedMenu][0].parentNode.previousElementSibling.parentElement
        if (!liParent.classList.contains('open')) {
          liParent.classList.add('open')
        }

        if (!liParent.classList.contains('active')) {
          liParent.classList.add('active')
        }

        document.body.classList.remove('mobile-nav-on')
      }
    },
    setActiveELement(elem, active) {
      elem.classList[active ? 'add' : 'remove']('active')
    }
  }
}
</script>
