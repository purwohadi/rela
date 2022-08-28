<template>
  <b-card class="p-3">
    <ValidationObserver v-slot="{ passes }" :slim="true">
      <form @submit.prevent="passes(submit)">
        <template>
          <b-form-group
            label-for="nama"
            :label="$t('featureaccess.form.field.nama.label')"
          >
            <input type="hidden" v-model="form.name">
            <ValidationProvider
              rules="required|max:50"
              v-slot="{ valid, errors }"
              :name="$t('featureaccess.form.field.nama.label')"
              :debounce="250"
            >
              <b-form-input
                id="nama"
                v-model="form.name"
                :state="errors[0] ? false : (valid ? true : null)"
                :placeholder="$t('featureaccess.form.field.nama.placeholder')"
              >
              </b-form-input>
              <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
            </ValidationProvider>
          </b-form-group>

          <b-form-group
            label-for="alias"
            :label="$t('featureaccess.form.field.alias.label')"
          >
            <input type="hidden" v-model="form.alias">
            <ValidationProvider
              rules="required|max:100"
              v-slot="{ valid, errors }"
              :name="$t('featureaccess.form.field.alias.label')"
              :debounce="250"
            >
              <b-form-input
                id="alias"
                v-model="form.alias"
                :state="errors[0] ? false : (valid ? true : null)"
                :placeholder="$t('featureaccess.form.field.alias.placeholder')"
              >
              </b-form-input>
              <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
            </ValidationProvider>
          </b-form-group>

          <b-row>
            <b-col lg="6" sm="12" class="mb-3">
              <b-form-group
                label-for="type"
                :label="$t('featureaccess.form.field.type.label')"
              >
                <input type="hidden" v-model="form.type">
                <ValidationProvider
                  rules="required"
                  v-slot="{ valid, errors }"
                  :name="$t('featureaccess.form.field.type.label')"
                  :debounce="250"
                >
                  <m-select
                    id="type"
                    v-model="form.type"
                    :options="options_type"
                    :state="errors[0] ? false : (valid ? true : null)"
                    :placeholder="$t('featureaccess.form.field.type.placeholder')"
                    label="text"
                    track-by="value"
                  >
                  </m-select>
                  <invalid-feedback :error="errors[0]"></invalid-feedback>
                </ValidationProvider>
              </b-form-group>
            </b-col>
            <b-col lg="6" sm="12">
              <b-form-group
                label-for="parent_id"
                :label="$t('featureaccess.form.field.parent_id.label')"
              >
                <input type="hidden" v-model="form.type">
                <!-- <ValidationProvider
                                v-slot="{ valid, errors }"
                                :name="$t('featureaccess.form.field.parent_id.label')"
                                :debounce="250"
                            > -->
                <m-select
                  id="parent_id"
                  v-model="form.parent"
                  :options="parents"
                  :placeholder="$t('featureaccess.form.field.parent_id.placeholder')"
                  label="name"
                  track-by="id"
                  :searchable="true"
                >
                </m-select>
                <!-- <invalid-feedback :error="errors[0]"></invalid-feedback>
                            </ValidationProvider> -->
              </b-form-group>
            </b-col>
          </b-row>

          <b-card v-if="form.type ? form.type.value == 'menu' : false" class="mb-4 rounded">
            <b-card-title><h6 class="font-weight-bold">Menu</h6></b-card-title>
            <b-row>
              <b-col lg="6" sm="12">
                <b-form-group
                  label-for="route"
                  :label="$t('featureaccess.form.field.route.label')"
                  class="mb-1"
                >
                  <input type="hidden" v-model="form.route">
                  <ValidationProvider
                    rules=""
                    v-slot="{ valid, errors }"
                    :name="$t('featureaccess.form.field.route.label')"
                    :debounce="250"
                  >
                    <m-select
                      :placeholder="$t('featureaccess.form.field.route.placeholder')"
                      v-model="form.route"
                      label="path"
                      track-by="path"
                      open-direction="top"
                      :options="routes"
                      :searchable="true"
                      :clear-on-select="true"
                      :close-on-select="true"
                      :max-height="200"
                    >
                    </m-select>
                    <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
                  </ValidationProvider>
                </b-form-group>
                <b-form-group
                  label-for="params"
                  :label="$t('featureaccess.form.field.params.label')"
                >
                  <b-form-input
                    id="params"
                    v-model="form.params"
                    :placeholder="$t('featureaccess.form.field.params.placeholder')"
                  >
                  </b-form-input>
                </b-form-group>
              </b-col>
              <b-col lg="6" sm="12">
                <b-form-group
                  label-for="icon"
                  :label="$t('featureaccess.form.field.icon.label')"
                  class="mb-1"
                >
                  <icon-list v-model="form.icon"></icon-list>
                </b-form-group>
                <b-form-group
                  label-for="order"
                  :label="$t('featureaccess.form.field.order.label')"
                >
                  <b-form-input
                    id="order"
                    v-model="form.order"
                    :placeholder="$t('featureaccess.form.field.order.placeholder')"
                    type="number"
                    autocomplete="off"
                  >
                  </b-form-input>
                </b-form-group>
              </b-col>
            </b-row>
          </b-card>

          <b-form-group
            label-for="deskripsi"
            :label="$t('featureaccess.form.field.deskripsi.label')"
          >
            <b-form-textarea
              id="deskripsi"
              v-model="form.deskripsi"
              :placeholder="$t('featureaccess.form.field.deskripsi.placeholder')"
              rows="5"
              no-resize
            ></b-form-textarea>
          </b-form-group>
        </template>

        <div class="text-right mt-4 pt-3">
          <b-button type="submit" variant="primary">
            {{ $t('general.form.button_add') }}
          </b-button>
          <b-button ref="closebtn" variant="default" @click="$router.go(-1)">
            {{ $t('general.form.button_cancel') }}
          </b-button>
        </div>
      </form>
    </ValidationObserver>
  </b-card>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
import { moduleRoutes } from '@js/router/routes'

export default {
  name: 'FeatureAccessForm',
  props: {
      id: null
  },
  data() {
      let resourceName = 'feature-access';
      return {
          show: true,
          featureAccessLoading: false,
          title: '',
          isHovered: false,
          resourceName: resourceName,
          routeName: `${resourceName}`,
          form: {
              slug_path: '',
              name: null,
              alias: null,
              type: null,
              parent: null,
              deskripsi: null,
              route: '',
              params: '',
              icon: '',
              order: ''
          },
          options_type: [
              { value: null, text: 'Pilih Tipe Fitur Akses' },
              { value: 'menu', text: 'Menu' },
              { value: 'crud', text: 'CRUD' },
              { value: 'filter', text: 'Filter' },
              { value: 'link', text: 'Link' },
          ],
          routes: [],
          parents: []
      }
  },
  computed: {
    ...mapGetters({ getFaIconList: 'getFaIconList' }),
    isNew() {
      return this.id === undefined ? true : false
    },
  },
  created() {
    this.getRoutes()
    if(!this.isNew) {
      this.fetchData()
      this.getParent(this.id);
    } else {
      this.getParent(this.id);
    }
  },
  methods: {
    async getRoutes(exclude = null) {
      const all = moduleRoutes(this.$app, this.$app.i18n)
      const used = await this.$http.get(this.$app.route('feature-access.menu-used'))
      const used_route = used.data || []
      const filtered_use_route = ! exclude
        ? used_route
        : used_route.filter(route => route != exclude)
      const routes = all.shift().children.filter(route => ! filtered_use_route.includes(route.name))
      this.routes = routes
      return routes
    },
    async fetchData() {
      try {
        const action = this.$app.route(`${this.routeName}.show`, {id: this.id})
        const {data} = await this.$http.get(action)

        let type_val = data.data.type;
        let type_text = type_val.charAt(0).toUpperCase() + type_val.slice(1);

        const parents = this.parents.filter(parent => parent.id === data.data.parent)
        const routes = await this.getRoutes(data.data.route) || []
        const route = routes.filter(route => route.name === data.data.route)
        const icons = this.getFaIconList.map(icon => {
          return {
            'icon': `fal fa${icon}`,
            'name': icon.replace(/-/g, ' ').trim()
          }
        })
        const icon = icons.filter(icon => icon.icon === data.data.icon)

        this.getParentName(data.data.parent_id);

        this.form.slug_path = data.data.slug_path
        this.form.name = data.data.name,
        this.form.alias = data.data.alias,
        this.form.type = {value: type_val, text: type_text},
        this.form.parent = parents ? parents.shift() : null,
        this.form.deskripsi = data.data.description,
        this.form.route = route ? route.shift() : null,
        this.form.params = data.data.params,
        this.form.icon = icon ? icon.shift() : null,
        this.form.order = data.data.order
      } catch (e) {
        console.log(e);
      }
    },
    async submit() {
      let vm = this
      let mode = this.isNew ? 'add' : 'edit'

      let { slug_path, name, alias, type, parent, deskripsi, route, params, icon, order } = vm.form
      let data =  {
        slug_path: slug_path,
        name: name,
        alias: alias,
        type: type ? type.value : null,
        parent: parent ? parent.id : null,
        deskripsi: deskripsi,
        route: type.value == 'menu' ? (route ? route.name : null) : null,
        params: type.value == 'menu' ? params : null,
        icon: type.value == 'menu' ? (icon ? icon.icon : null) : null,
        order: type.value == 'menu' ? order : null
      }

      let formData = this.$app.objectToFormData(data)
      if(!this.isNew) {
        formData.append('_method', 'PUT')
      }
      let url = vm.$app.route(this.isNew ? `${this.routeName}.store` : `${this.routeName}.update`, {id:this.id})
      vm.$app.confirm({
          text: vm.$t(`featureaccess.alert.confirm.${mode}`, { name: vm.$data.form.nama }),
          preConfirm: () => {
          return vm.$http.post(url, formData)
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
                vm.$app.success(`${result.value.data.message}`)
                .then(response => {
                    if (response.value === true) {
                        this.$router.push({name: `settings.${this.resourceName}`})
                        vm.$root.$emit('bv::refresh::table', this.resourceName)
                    }
                })
            }
        })
    },
    getParent(id) {
        let vm = this
        vm.$http
        .get(vm.$app.route('feature-access.get_parent'), {
        params: {
            sort: 'asc',
            type: ['menu', 'link', 'filter']
        },
        })
        .then(response => {
            const parentID = [];
            $.each(response.data, function(key, value) {
                if (value.slug_path != id) {
                    parentID.push({id: value.i_id, name: value.v_name});
                }
            });

            vm.parents = parentID
        })
    },
    getParentName(parent_id) {
        let vm = this
        vm.$http
        .get(vm.$app.route('feature-access.get_parent'), {
        params: {
            sort: 'asc',
            type: ['menu', 'link', 'filter']
        },
        })
        .then(response => {
            $.each(response.data, function(key, value) {
                if (value.i_id == parent_id) {
                  vm.form.parent = {id: value.i_id, name: value.v_name}
                }
            });
        })
    }
  }
}
</script>

<style>
    .control_wrapper {
        display: block;
        max-width: 350px;
        max-height: 350px;
        margin: auto;
        overflow: auto;
        border: 1px solid #dddddd;
        border-radius: 3px;
    }

    .multiselect {
        /* width: 500px !important; */
    }
</style>
