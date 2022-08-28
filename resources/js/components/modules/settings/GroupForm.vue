<template>
  <b-card class="p-3" :title="isNew ? 'Tambah Group' : (isHakAkses ? 'Ubah Hak Akses' : 'Edit Group & Hak Akses')">
    <ValidationObserver v-slot="{ passes }" :slim="true">
      <form @submit.prevent="passes(submit)">
        <template>
          <b-form-group
            label-for="name"
            :label="$t(`${resourceName}.form.field.name.label`)"
          >
            <input type="hidden" v-model="form.id">
            <ValidationProvider
              rules="required"
              v-slot="{ valid, errors }"
              :name="$t(`${resourceName}.form.field.name.label`)"
              :debounce="250"
            >
              <b-form-input
                id="name"
                v-model="form.name"
                :state="errors[0] ? false : (valid ? true : null)"
                :placeholder="$t(`${resourceName}.form.field.name.placeholder`)"
                autofocus
                :disabled="featureAccessLoading ? true : false"
                :class="isHakAkses ? 'h5 pb-0' : ''"
                :plaintext="isHakAkses ? true : false"
              >
              </b-form-input>
              <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
            </ValidationProvider>
          </b-form-group>
          <b-form-group
            label-for="opd"
            :label="'OPD'"
          >
            <ValidationProvider
              v-slot="{ errors }"
              :name="'OPD'"
              :debounce="250"
            >
              <m-select
                id="list-opd"
                v-model="opd_selected"
                label="name"
                track-by="id"
                open-direction="bottom"
                :placeholder="$t('opd.form.field.placeholder')"
                :options="opdList"
                :searchable="true"
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
            label-for="status"
            :label="$t(`${resourceName}.form.field.status.label`)"
          >
            <input type="hidden" v-model="form.status">
            <ValidationProvider
              rules="required"
              v-slot="{ valid, errors }"
              :name="$t(`${resourceName}.form.field.status.label`)"
              :debounce="250"
            >
              <template v-if="!isHakAkses">
                <b-form-radio-group
                  v-model="form.status"
                  :options="statusOptions"
                  class="mb-3"
                  value-field="id"
                  text-field="name"
                  :disabled="featureAccessLoading ? true : false"
                  :state="errors[0] ? false : (valid ? true : null)"
                ></b-form-radio-group>
                <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
              </template>
              <template v-else>
                <h4>
                  <b-badge
                    :variant="form.status ? 'success' : 'danger'"
                  >
                    {{ form.status ? 'Aktif' : 'Tidak Aktif' }}
                  </b-badge>
                </h4>
              </template>
            </ValidationProvider>
          </b-form-group>
        </template>
        <div class="line-divider mb-4"></div>
        <b-form-group
          label-for="permissions"
          :label="$t(`${resourceName}.form.field.permissions.label`)"
        >
          <template slot="label">
            <h5 class="mb-0"><i class="fas fa-shield-check"></i> {{ $t(`${resourceName}.form.field.permissions.label`) }}</h5>
          </template>
          <template v-if="featureAccessLoading">
            Loading...
          </template>
          <div class="pt-2 pb-2" v-else>
            <ejs-treeview
              id="tree-feature"
              :fields="fields"
              :show-check-box="true"
              :checked-nodes="checkedNodes"
              :expanded-nodes="expandedNodes"
              :node-checked="checkedFeature"
              @nodeChecked="checkedProcess">
            </ejs-treeview>
          </div>
        </b-form-group>
        <div class="text-right mt-4 pt-3">
          <b-button ref="closebtn" variant="default" @click="$router.go(-1)">
            {{ $t('general.form.button_cancel') }}
          </b-button>
          <b-button type="submit" variant="primary">
            {{ $t('general.form.button_add') }}
          </b-button>
        </div>
      </form>
    </ValidationObserver>
  </b-card>
</template>

<script>
// import VJstree from 'vue-jstree'

export default {
  name: 'GroupForm',
  props: {
    id: null
  },
  data() {
    let resourceName = 'group';
    return {
      show: true,
      featureAccessLoading: false,
      opdLoading: false,
      opdList: [],
      title: '',
      querySearch: '',
      resourceName: resourceName,
      routeName: `${resourceName}`,
      fields: {
        id: 'id',
        parentID: 'parent_id',
        text: 'name',
        hasChildren: 'hasChild',
        dataSource: null,
      },
      expandedNodes: [0,1],
      checkedNodes: [],
      form: {
        slug_path: '',
        name: '',
        status: '',
        feature_access: [],
        opd_id: null
      },
      statusOptions: [
        { id: 1, name: 'Aktif' },
        { id: 0, name: 'Tidak' },
      ],
      currentSelected: [],
      opd_selected: null,
    }
  },
  computed: {
    isNew() {
      return this.id === undefined ? true : false
    },
    isHakAkses() {
      return this.$route.name === 'group-hak-akses' ? true : false
    }
  },
  watch: {
    currentSelected: {
      deep: true,
      immediate: true,
      handler: function(n) {
        this.form.feature_access = [...n]
      }
    },
    opd_selected: {
      deep: true,
      immediate: true,
      handler: function(n) {
        this.form.opd_id = n ? n.id : null
      }
    }
  },
  created() {
    this.getFeatureAccess()
    this.getOpdList()
  },
  methods: {
    checkedFeature: function(args) {
      let vm = this,
          { action, data } = args

      data.forEach(item => {
        let idx = vm.currentSelected.findIndex(n => n == parseInt(item.id))
        if (idx !== -1) {
          if (action == 'uncheck' && item.isChecked == 'false') vm.currentSelected.splice(idx, 1)
        } else {
          vm.currentSelected.push(parseInt(item.id))
        }
      })
      // vm.form.feature_access = [...vm.currentSelected]
    },
    checkedProcess(param) {},
    async getFeatureAccess() {
      let vm = this
      vm.featureAccessLoading = true
      vm.$http
      .get(vm.$app.route('feature-access.all'))
      .then(response => {
        if(!this.isNew) {
          this.fetchData(response.data.data)
        }
        else {
          vm.fields.dataSource = response.data.data
          vm.featureAccessLoading = false
        }
      })
    },
    async getOpdList() {
      let vm = this
      vm.opdLoading = true
      vm.$http
      .get(vm.$app.route('opd.all'))
      .then(response => {
        let opdID = []
        $.each(response.data, function(key, value) {
            opdID.push({id: value.opd_id, name: value.nama_opd});
        });
        vm.opdList = opdID

        vm.opdLoading = false
      })
    },
    async fetchData(allFeature) {
      try {
        const action = this.$app.route(`${this.routeName}.show`, {id: this.id})
        const {data} = await this.$http.get(action)

        this.form.name = data.data.nama
        this.form.status = data.data.status
        this.form.slug_path = data.data.slug_path
        this.form.opd_id = data.data.opd_id
        this.opd_selected = this.opdList.find(item => item.id == data.data.opd_id);


        // Set Feature
        let all = allFeature
        let features = data.data.features

        const selectedFeatures = new Set(features.map((item) => Number(item.i_feature_id)));
        // this.currentSelected = [...selectedFeatures]

        all.forEach((u) => u.isChecked = selectedFeatures.has(u.id));
        this.fields.dataSource = all
        // this.form.feature_access = [...this.currentSelected]
        this.featureAccessLoading = false
        setTimeout(this.populateSelectedNodes, 250)
      } catch (e) {
        console.log(e);
      }
    },
    populateSelectedNodes() {
      const treeView = document.getElementById('tree-feature').ej2_instances[0],
            treeData = treeView.treeData
      let nodes = treeView.checkedNodes, actualNodes = []

      nodes.forEach(node => {
        let find = treeData.find(data => data.id == parseInt(node))

        if (find.isChecked) {
          if (find.parent_id) {
            actualNodes.push(parseInt(find.parent_id))
          }

          actualNodes.push(parseInt(find.id))
        }
      })
      this.currentSelected = [...new Set(actualNodes)]
    },
    async submit() {
      // return false
      let vm = this
      // let data = Object.assign({}, vm.$data.form)
      let mode = this.isNew ? 'add' : 'edit'
      let formData = this.$app.objectToFormData(vm.$data.form)
      if(!this.isNew) {
        formData.append('_method', 'PUT')
      }
      let url = vm.$app.route(this.isNew ? `${this.routeName}.store` : `${this.routeName}.edit`, {id:this.id})
      console.log('form', formData)
      vm.$app.confirm({
        text: vm.$t(`${this.routeName}.alert.confirm.${mode}`),
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
						vm.$app.success(
              result.value.data.message,
              result.value.data.status,
              vm.$t(`${this.routeName}.alert.${result.value.data.status}`)
            )
              .then(response => {
                if (response.value === true) {
                  this.$router.push({name: 'settings.group'})
                  vm.$root.$emit('bv::refresh::table', this.resourceName)
                  // vm.$bvModal.hide(`${this.resourceName}-add`)
                }
              })
					}
				})
    }
  }
}
</script>

<style lang="scss">
@import '~@syncfusion/ej2-base/styles/bootstrap4.css';
@import "~@syncfusion/ej2-buttons/styles/bootstrap4.css";
@import "~@syncfusion/ej2-vue-navigations/styles/bootstrap4.css";
  #tree-feature {
    margin-left: -1rem;
    margin-right: -1rem;
    font-family: "Poppins", sans-serif;
    .e-list-text {
      font-size: 13px;
    }
  }
</style>
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
</style>
