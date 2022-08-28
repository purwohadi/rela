<template>
  <div class="row">
    <div class="col-12">
      <section class="menu">
        <div class="demo-window rounded shadow-1">
          <div class="demo-window-content">
            <div class="row no-gutters">
              <div id="popover-reactive" class="col-auto bg-fusion-500">
                <div class="d-flex align-items-center position-relative p-3">
                  <i class="fal fa-search position-absolute pos-left fs-lg px-2 py-1 ml-3 fs-xs text-muted"></i>
                  <input
                    id="search_input"
                    ref="searchInput"
                    type="text"
                    class="form-control form-control-sm pl-5 rounded-pill"
                    v-model="searchText"
                    :placeholder="$t('general.datatable.toolbar.search')"
                    @focus="onSizeChange"
                    @blur="onSizeChange"
                  >
                  <i
                    ref="btnClear"
                    class="fal fa-times text-danger position-absolute pos-right fs-lg px-4 py-1 fs-xs go-transparent"
                    @click="onClear"
                  >
                  </i>
                </div>
                <div ref="slimtest">
                  <ul id="menu_list" ref="menuList" class="nav-menu mb-sm-4 mb-md-0">
                    <template
                      v-for="item in items"
                    >
                      <li
                        class="nav-title m-0 pl-4"
                        v-if="item.group && item.group.length > 0"
                        :key="item.permission_id"
                      >
                        <span class="text-muted">
                          {{ item.group }}
                        </span>
                      </li>
                      <li class="open active cursor-default" :key="item.id">
                        <a href="javascript:void(0)" :data-filter-tags="item.tags" @click="handleClick(item)">
                          <i :class="`${ item.icon } text-white`"></i>
                          <span class="nav-link-text">
                            {{ item.label }}
                          </span>
                          <strong :class="`dl-ref bg-${ item.visible ? 'info-500' : 'fusion-200' }`">
                            {{ item.order_no }}
                          </strong>
                        </a>
                        <ul
                          v-if="item.child && item.child.length"
                        >
                          <li v-for="child in item.child" :key="child.id">
                            <a href="javascript:void(0)" :data-filter-tags="child.tags" @click="handleClick(child)">
                              <span class="nav-link-text text-muted">
                                {{ child.label }}
                              </span>
                              <strong :class="`dl-ref bg-${ child.visible ? 'info-500' : 'fusion-200' }`">
                                {{ child.order_no }}
                              </strong>
                            </a>
                          </li>
                        </ul>
                      </li>
                    </template>
                  </ul>
                </div>
              </div>
              <b-popover
                target="popover-reactive"
                triggers="click"
                :show.sync="popoverShow"
                placement="right"
                container="row"
                ref="popover"
                :content="$t('menu.popover.info')"
              >
                <template #title>
                  <b-button @click="onPopperClose" class="close">
                    <span class="d-inline-block" aria-hidden="true">
                      <i class="fal fa-times"></i>
                    </span>
                  </b-button>
                  <span class="font-weight-bold">{{ $t('general.popover.title') }}</span>
                </template>
              </b-popover>
              <div class="col m-4">
                <div class="row d-flex align-items-center justify-content-start" v-if="!show">
                  <div class="col-auto mr-0 pr-0">
                    <button
                      type="button"
                      class="btn btn-success btn-icon rounded-circle waves-effect waves-themed mr-lg-1"
                      data-toggle="tooltip"
                      data-placement="top"
                      v-b-tooltip.hover.right="$t('menu.button.button_add')"
                      @click="handleAdd"
                    >
                      <i class="fal fa-plus"></i>
                    </button>
                  </div>
                </div>
                <validation-observer v-slot="{ passes }" :slim="true">
                  <form @submit.prevent="passes(submit)" v-if="show">
                    <ValidationProvider name="menuid">
                      <input type="hidden" v-model="form.id">
                    </ValidationProvider>
                    <div class="row">
                      <div class="col-12 col-lg-6">
                        <b-form-group
                          label-for="menu-group"
                          :label="$t('menu.form.field.group.label')"
                        >
                          <ValidationProvider
                            v-slot="{ valid, errors }"
                            :name="$t('menu.form.field.group.label')"
                          >
                            <m-select
                              id="list-group"
                              v-model="form.group"
                              label="value"
                              track-by="id"
                              :placeholder="$t('menu.form.field.group.placeholder')"
                              :options="groups"
                              :searchable="true"
                              :internal-search="false"
                              :clear-on-select="true"
                              :close-on-select="true"
                            >
                              <span slot="noOptions">
                                {{ $t('general.multiselect.no-options') }}
                              </span>
                              <span slot="noResult">
                                {{ $t('general.multiselect.no-options') }}
                              </span>
                            </m-select>
                          </ValidationProvider>
                        </b-form-group>
                        <b-form-group
                          label-for="menu-parent"
                          :label="$t('menu.form.field.parent.label')"
                        >
                          <ValidationProvider
                            v-slot="{ valid, errors }"
                            :name="$t('menu.form.field.parent.label')"
                          >
                            <m-select
                              id="list-parent"
                              v-model="form.parent"
                              label="label"
                              track-by="id"
                              :placeholder="$t('menu.form.field.parent.placeholder')"
                              :options="parents"
                              :searchable="true"
                              :internal-search="false"
                              :clear-on-select="true"
                              :close-on-select="true"
                            >
                              <span slot="noOptions">
                                {{ $t('general.multiselect.no-options') }}
                              </span>
                              <span slot="noResult">
                                {{ $t('general.multiselect.no-options') }}
                              </span>
                            </m-select>
                          </ValidationProvider>
                        </b-form-group>
                        <b-form-group
                          label-for="menu-route"
                          :label="$t('menu.form.field.route.label')"
                        >
                          <ValidationProvider
                            :rules="rulesForRoute"
                            v-slot="{ valid, errors }"
                            :name="$t('menu.form.field.route.label')"
                            :debounce="250"
                          >
                            <m-select
                              id="list-route"
                              v-model="form.route"
                              label="path"
                              track-by="path"
                              open-direction="top"
                              :placeholder="$t('menu.form.field.route.placeholder')"
                              :options="routes"
                              :searchable="true"
                              :internal-search="false"
                              :clear-on-select="true"
                              :close-on-select="true"
                              :max-height="200"
                            >
                              <span slot="noOptions">
                                {{ $t('general.multiselect.no-options') }}
                              </span>
                              <span slot="noResult">
                                {{ $t('general.multiselect.no-options') }}
                              </span>
                            </m-select>
                            <invalid-feedback :error="errors[0]"></invalid-feedback>
                          </ValidationProvider>
                        </b-form-group>
                        <b-form-group
                          label-for="menu-label"
                          :label="$t('menu.form.field.label.label')"
                        >
                          <ValidationProvider
                            rules="required|min:3|max:200"
                            v-slot="{ valid, errors }"
                            :name="$t('menu.form.field.label.label')"
                          >
                            <b-form-input
                              v-model="form.label"
                              :state="errors[0] ? false : (valid ? true : null)"
                              :placeholder="$t('menu.form.field.label.placeholder')"
                            >
                            </b-form-input>
                            <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
                          </ValidationProvider>
                        </b-form-group>
                      </div>
                      <div class="col-12 col-lg-6">
                        <b-form-group
                          label-for="menu-icon"
                          :label="$t('menu.form.field.icon.label')"
                        >
                          <ValidationProvider
                            :rules="rulesForIcon"
                            v-slot="{ valid, errors }"
                            :name="$t('menu.form.field.icon.label')"
                          >
                            <icon-list v-model="form.icon" :disabled="iconDisabled"></icon-list>
                            <invalid-feedback :error="errors[0]"></invalid-feedback>
                          </ValidationProvider>
                        </b-form-group>
                        <b-form-group
                          label-for="menu-tags"
                          :label="$t('menu.form.field.tags.label')"
                        >
                          <ValidationProvider
                            rules="required|min:3|max:200"
                            v-slot="{ valid, errors }"
                            :name="$t('menu.form.field.tags.label')"
                          >
                            <b-form-input
                              v-model="form.tags"
                              :state="errors[0] ? false : (valid ? true : null)"
                              :placeholder="$t('menu.form.field.tags.placeholder')"
                            >
                            </b-form-input>
                            <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
                          </ValidationProvider>
                        </b-form-group>
                        <b-form-group
                          label-for="menu-permission"
                          :label="$t('menu.form.field.permission.label')"
                        >
                          <ValidationProvider
                            rules="required"
                            v-slot="{ valid, errors }"
                            :name="$t('menu.form.field.permission.label')"
                          >
                            <m-select
                              id="list-permissions"
                              v-model="form.permission"
                              label="name"
                              track-by="id"
                              max-height="200"
                              :placeholder="$t('menu.form.field.permission.placeholder')"
                              :multiple="multiple"
                              :options="permissions"
                              :searchable="true"
                              :loading="permissionsLoading"
                              :internal-search="false"
                              :clear-on-select="true"
                              :close-on-select="closeOnSelect"
                              @search-change="asyncFind"
                            >
                              <span slot="noOptions">
                                {{ $t('general.multiselect.no-options') }}
                              </span>
                              <span slot="noResult">
                                {{ $t('general.multiselect.no-options') }}
                              </span>
                            </m-select>
                            <invalid-feedback :error="errors[0]"></invalid-feedback>
                          </ValidationProvider>
                        </b-form-group>
                        <b-form-group
                          label-for="menu-order-no"
                          :label="$t('menu.form.field.order_no.label')"
                        >
                          <ValidationProvider
                            rules="required|numeric|min:1|max:6"
                            v-slot="{ valid, errors }"
                            :name="$t('menu.form.field.order_no.label')"
                          >
                            <b-form-input
                              v-model="form.order_no"
                              :state="errors[0] ? false : (valid ? true : null)"
                              :placeholder="$t('menu.form.field.order_no.placeholder')"
                            >
                            </b-form-input>
                            <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
                          </ValidationProvider>
                        </b-form-group>

                        <b-form-group
                          label-for="menu-visible"
                        >
                          <b-form-checkbox
                            v-model="form.visible"
                            :value="true"
                            :unchecked-value="false"
                            class="custom-checkbox-circle"
                          >
                            {{ $t('menu.form.field.visible.label') }}
                          </b-form-checkbox>
                        </b-form-group>
                      </div>
                    </div>

                    <div class="text-right mt-4">
                      <b-button variant="default" @click="onCancel">
                        {{ $t('general.form.button_cancel') }}
                      </b-button>
                      <b-button variant="danger" @click="handleDelete" v-if="mode != 'add'" class="ml-1">
                        {{ $t('menu.button.button_delete') }}
                      </b-button>
                      <b-button type="submit" variant="primary" class="ml-1">
                        {{ $t('general.form.button_add') }}
                      </b-button>
                    </div>
                  </form>
                </validation-observer>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
import { extend } from 'vee-validate'
import { moduleRoutes } from '@js/router/routes'
import permissions from '@components/mixins/permissions'
export default {
  name: 'SettingsMenu',
  filters: {
    humanReadable(value) {
      return value.replace(/-/g, ' ').split(' ').pop().trim()
    }
  },
  mixins: [permissions],
  data() {
    return {
      mode: "add",
      show: false,
      form: {
        id: null,
        group: null,
        parent: null,
        label: '',
        icon: null,
        tags: '',
        route: null,
        permission: null,
        order_no: '',
        visible: true,
      },
      items: [],
      groups: [],
      routes: [],
      parents: [],
      searchText: '',
      rulesForRoute: '',
      popoverShow: true,
    }
  },
  computed: {
    ...mapGetters({ getFaIconList: 'getFaIconList' }),
    iconDisabled() {
      return this.form.parent ? true : false
    },
    rulesForIcon() {
      return this.form.parent ? '' : 'required'
    }
  },
  watch: {
    'show': function(n) {
      if (n) this.onPopperClose()
    }
  },
  created() {
    let vm = this
    extend("unique", {
      validate: async (value, [key]) => {
        const fmtMsg = key == 'route' ? value.path : value
        const fmtValue = key == 'route' ? value.name : value
        const fmtName = vm.$t(`menu.form.field.${key}.label`)

        const exist = async (value, key) => await vm.$http.post(vm.$app.route('menu.exist'), { [key]: value })
        const isUnique = await exist(fmtValue, key)
        return (! isUnique.data) ? true : vm.$t('menu.validation.unique', { name: fmtName, value: fmtMsg })
      },
    })
    extend("uniqueExclude", {
      params: ['key', 'target'],
      validate: async (value, { key, target }) => {
        const fmtMsg = key == 'route' ? value.path : value
        const fmtValue = key == 'route' ? value.name : value
        const fmtName = vm.$t(`menu.form.field.${key}.label`)

        const exclude = async value => await vm.$http.post(vm.$app.route('menu.exclude'), { id: target, [key]: value })
        const isUniqueExclude = await exclude(fmtValue)
        return (! isUniqueExclude.data) ? true : vm.$t('menu.validation.unique', { name: fmtName, value: fmtMsg })
      }
    })
  },
  beforeDestroy() {
    $(this.$refs.slimtest).slimScroll({ destroy: true })
  },
  mounted() {
    this.getRoutes()
    this.getParents()
    this.getGroupMenu()
    this.getItems()
    this.$refs.searchInput.focus()
    initApp.listFilter($(this.$refs.menuList), $(this.$refs.searchInput))
    $(this.$refs.slimtest).slimScroll({
      height: '390px',
      color: '#fff',
      size: '4px',
      distance: '4px',
      railOpacity: 0.4,
    })
  },
  methods: {
    ...mapActions({ update_structure_menu: 'updateLiveMenu', update_flat_menu: 'updateFlattenMenu' }),
    async getRoutes(exclude = null) {
      const all = moduleRoutes(this.$app, this.$app.i18n)
      const used = await this.$http.get(this.$app.route('menu.used-route'))
      const used_route = used.data || []
      const filtered_use_route = ! exclude
        ? used_route
        : used_route.filter(route => route != exclude)
      const routes = all.shift().children.filter(route => ! filtered_use_route.includes(route.name))
      this.routes = routes
      return routes
    },
    async getParents() {
      const parents = await this.$http.get(this.$app.route('menu.parents'))
      this.parents = parents.data
    },
    async getGroupMenu() {
      const group = await this.$http.get(this.$app.route('reference.type', { type: 'Grup Menu' }))
      this.groups = group.data
    },
    async getItems() {
      let vm = this
      const items = await vm.$http.get(vm.$app.route('menu.get'))
      vm.items = items.data
      vm.update_structure_menu(items.data)
      vm.flattenMenu(items.data)
    },
    flattenMenu(items) {
      let vm = this
      let parents = items.map(item => {
        let temp = []
        temp.push({
          key: item.key,
          route: item.route,
        })

        if (Array.isArray(item.child)) {
          item.child.forEach(child => {
            temp.push({
              key: child.key,
              route: child.route,
            })
          })
        }
        return temp
      })
      vm.update_flat_menu(window._.flatten(parents))
    },
    resetForm() {
      this.form.id = null,
      this.form.group = null,
      this.form.parent = null,
      this.form.label = '',
      this.form.icon = null,
      this.form.tags = '',
      this.form.route = null,
      this.form.order_no = '',
      this.form.permission = null
      this.form.visible = true
    },
    handleAdd() {
      this.getParents()
      this.resetForm()
      this.rulesForRoute = 'unique:route'
      this.mode = 'add'
      this.show = true
    },
    submit() {
      let vm = this
      let { id, group, parent, route, label, icon, tags, permission, order_no, visible } = vm.form
      let data =  {
        id: id,
        group: group ? group.value : null,
        parent: parent ? parent.id : null,
        route: route ? route.name : null,
        label: label,
        icon: icon ? icon.icon : null,
        tags: tags.toLowerCase(),
        permission_id: permission.id,
        order_no: order_no,
        visible: visible
      }

      let mode = id ? 'edit' : 'add'
      let url = vm.$app.route(id ? 'menu.edit' : 'menu.store')
      let method = id ? 'put' : 'post'

      vm.$app.confirm({
        text: vm.$t(`menu.alert.confirm.${mode}`),
        preConfirm: () => {
          return vm.$http
            [method](url, data)
            .then(response => {
              if (response.data.status == "error") {
                let errors = response.data.message
                throw new Error(response.data.message)
              } else {
                return response
              }
            })
            .catch(error => {
              vm.$app.alert.showValidationMessage(error)
            })
        }
      })
				.then(result => {
					if (result.isDismissed) return
					if (result.value.data.status == "success" || result.value.data.status == "info") {
						vm.$app.success(
              result.value.data.message,
              result.value.data.status,
              vm.$t(`menu.alert.${result.value.data.status}`)
            )
              .then(response => {
                if (response.value === true) {
                  vm.resetForm()
                  vm.getItems()
                  vm.getParents()
                  vm.show = false
                }
              })
					}
				})
    },
    handleDelete() {
      const vm = this
      vm.$app.confirm({
        text: vm.$t('menu.alert.confirm.drop', { label: vm.form.label }),
        preConfirm: () => {
          return vm.$http
            .delete(vm.$app.route('menu.drop'), {
              data: { id: vm.form.id }
            })
              .then(response => {
                if (response.data.status == "error") {
                  let errors = response.data.message
                  throw new Error(response.data.message)
                } else {
                  return response
                }
              })
              .catch(error => {
                vm.$app.alert.showValidationMessage(error)
              })
        }
      })
        .then(result => {
          if (result.isDismissed) return
          if (result.value.data.status == "success") {
            vm.$app.success(result.value.data.message)
            .then(response => {
              if (response.value === true) {
                vm.resetForm()
                vm.getItems()
                vm.getParents()
                vm.show = false
              }
            })
          }
        })
    },
    async handleClick(item) {
      let vm = this
      const groups = vm.groups.filter(group => group.value === item.group)
      const parents = vm.parents.filter(parent => parent.id === item.parent)
      const routes = await vm.getRoutes(item.route) || []
      const route = routes.filter(route => route.name === item.route)
      const permissions = await vm.asyncFind()
      const permission = permissions.filter(permission => permission.id === item.permission_id)
      const icons = vm.getFaIconList.map(icon => {
        return {
          'icon': `fal fa${icon}`,
          'name': icon.replace(/-/g, ' ').trim()
        }
      })
      const icon = icons.filter(icon => icon.icon === item.icon)
      vm.show = false
      vm.rulesForRoute = 'uniqueExclude:route,@menuid'
      vm.form.id = item.id
      vm.form.label = item.label
      vm.form.tags = item.tags
      vm.form.order_no = item.order_no
      vm.form.visible = item.visible
      vm.form.group = groups ? groups.shift() : null
      vm.form.parent = parents ? parents.shift() : null
      vm.form.route = route ? route.shift() : null
      vm.form.icon = icon ? icon.shift() : null
      vm.form.permission = permission ? permission.shift() : null
      vm.mode = 'view'
      vm.show = true
    },
    onCancel() {
      this.resetForm()
      this.show = false
    },
    onPopperClose() {
      this.popoverShow = false
      this.$root.$emit('bv::disable::popover', 'popover-reactive')
    },
    onSizeChange(e) {
      if (! this.searchText.length) {
        let element = {
          btnClear: {
            add: e.type == 'focus' ? 'go-show' : 'go-transparent',
            remove: e.type == 'focus' ? 'go-transparent' : 'go-show',
          }
        }

        Object.keys(element).forEach(ref => {
          Object.keys(element[ref]).forEach(action => {
            this.$refs[ref].classList[action](element[ref][action])
          })
        })
      }
    },
    onClear() {
      if (this.searchText.length) {
        // clear search term
        this.searchText = ''
        // when filter length is blank reset the classes
        $(this.$refs.menuList)
          .find('[data-filter-tags]')
          .parentsUntil($(this.$refs.menuList))
          .removeClass('js-filter-hide js-filter-show')
        // set focus to input
        this.$refs.searchInput.focus()
      }
    }
  }
}
</script>
