<template>
  <div class="p-3">
    <validation-observer v-slot="{ passes }" :slim="true">
      <form @submit.prevent="passes(submit)">
        <b-form-group
          label-for="type"
          :label="$t(`${resourceName}.form.field.type.label`)"
        >
          <input type="hidden" v-model="form.type">
          <ValidationProvider
            rules="required"
            v-slot="{ valid, errors }"
            :name="$t(`${resourceName}.form.field.type.label`)"
            :debounce="250"
          >
            <m-select
              id="type"
              v-model="form.type"
              :options="options_type"
              :state="errors[0] ? false : (valid ? true : null)"
              :placeholder="$t(`${resourceName}.form.field.type.placeholder`)"
              label="text"
              track-by="value"
            >
              <template slot="singleLabel" slot-scope="props">
                <div class="d-flex">
                  <div style="width:20px;font-size:1rem;">
                    <i :class="props.option.icon"></i>
                  </div>
                  {{ props.option.text }}
                </div>
              </template>
              <template slot="option" slot-scope="props">
                <div class="d-flex">
                  <div style="width:20px;font-size:1rem;">
                    <i :class="props.option.icon"></i>
                  </div>
                  {{ props.option.text }}
                </div>
              </template>
            </m-select>
            <invalid-feedback :error="errors[0]"></invalid-feedback>
          </ValidationProvider>
        </b-form-group>
        <b-form-group
          label-for="judul"
          :label="$t(`${resourceName}.form.field.${labelTitle}.label`)"
        >
          <input type="hidden" v-model="form.judul">
          <ValidationProvider
            rules="required|max:50"
            v-slot="{ valid, errors }"
            :name="$t(`${resourceName}.form.field.${labelTitle}.label`)"
            :debounce="250"
          >
            <b-form-input
              id="judul"
              v-model="form.judul"
              :state="errors[0] ? false : (valid ? true : null)"
              :placeholder="$t(`${resourceName}.form.field.${labelTitle}.placeholder`)"
            >
            </b-form-input>
            <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
          </ValidationProvider>
        </b-form-group>
        <template v-if="isFile">
          <b-form-group
            label-for="parent"
            :label="$t(`${resourceName}.form.field.parent.label`)"
          >
            <input type="hidden" v-model="form.parent">
            <ValidationProvider
              rules="required"
              v-slot="{ valid, errors }"
              :name="$t(`${resourceName}.form.field.parent.label`)"
              :debounce="250"
            >
              <m-select
                id="parent"
                v-model="form.parent"
                :options="options_parent"
                :state="errors[0] ? false : (valid ? true : null)"
                :placeholder="$t(`${resourceName}.form.field.parent.placeholder`)"
                label="nama_folder"
                track-by="value"
              >
                <template slot="singleLabel" slot-scope="props">
                  <div class="d-flex">
                    <div style="width:20px;font-size:1rem;">
                      <i :class="`far fa-${props.option.type}`"></i>
                    </div>
                    {{ props.option.nama_folder }}
                  </div>
                </template>
                <template slot="option" slot-scope="props">
                  <div class="d-flex">
                    <div style="width:20px;font-size:1rem;">
                      <i :class="`far fa-${props.option.type}`"></i>
                    </div>
                    {{ props.option.nama_folder }}
                  </div>
                </template>
              </m-select>
              <invalid-feedback :error="errors[0]"></invalid-feedback>
            </ValidationProvider>
          </b-form-group>
          <b-form-group
            label-for="nama_file"
            :label="$t(`${resourceName}.form.field.nama_file.label`)"
          >
            <input type="hidden" v-model="form.nama_file">
            <ValidationProvider
              rules="required|max:50"
              v-slot="{ valid, errors }"
              :name="$t(`${resourceName}.form.field.nama_file.label`)"
              :debounce="250"
            >
              <b-form-input
                id="nama_file"
                v-model="form.nama_file"
                :state="errors[0] ? false : (valid ? true : null)"
                :placeholder="$t(`${resourceName}.form.field.nama_file.placeholder`)"
              >
              </b-form-input>
              <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
            </ValidationProvider>
          </b-form-group>
          <b-form-group
            label-for="file"
            :label="$t(`${resourceName}.form.field.file_.label`)"
          >
            <input type="hidden" v-model="form.file">
            <ValidationProvider
              rules="required|max:50"
              v-slot="{ valid, errors }"
              :name="$t(`${resourceName}.form.field.file_.label`)"
              :debounce="250"
            >
              <b-form-file
                id="file"
                accept=".pdf, .doc, .docx"
                v-model="form.file"
                :state="errors[0] ? false : (valid ? true : null)"
                :placeholder="form.file ? 
                  form.file 
                  : $t(`${resourceName}.form.field.file_.placeholder`)"
              >
              </b-form-file>
              <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
            </ValidationProvider>
          </b-form-group>
          <b-form-group
            label-for="video"
            :label="$t(`${resourceName}.form.field.video.label`)"
          >
            <input type="hidden" v-model="form.video">
            <ValidationProvider
              rules="max:500"
              v-slot="{ valid, errors }"
              :name="$t(`${resourceName}.form.field.video.label`)"
              :debounce="250"
            >
              <b-form-input
                id="video"
                v-model="form.video"
                :state="errors[0] ? false : (valid ? true : null)"
                :placeholder="$t(`${resourceName}.form.field.video.placeholder`)"
              >
              </b-form-input>
              <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
            </ValidationProvider>
          </b-form-group>
        </template>
        <b-form-group
          label-for="urutan"
          :label="$t(`${resourceName}.form.field.urutan.label`)"
        >
          <input type="hidden" v-model="form.urutan">
          <ValidationProvider
            rules="required|max:50"
            v-slot="{ valid, errors }"
            :name="$t(`${resourceName}.form.field.urutan.label`)"
            :debounce="250"
          >
            <b-form-input
              id="urutan"
              type="number"
              v-model="form.urutan"
              :state="errors[0] ? false : (valid ? true : null)"
              :placeholder="$t(`${resourceName}.form.field.urutan.placeholder`)"
            >
            </b-form-input>
            <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
          </ValidationProvider>
        </b-form-group>

        <div class="text-right mt-4 pt-3">
          <b-button ref="closebtn" variant="default" @click="onCancel()">
            {{ $t('general.form.button_cancel') }}
          </b-button>
          <b-button type="submit" variant="primary" class="ml-2">
            {{ $t('general.form.button_add') }}
          </b-button>
        </div>
      </form>
    </validation-observer>
  </div>
</template>

<script>
export default {
  name: 'ManualBookForm',
  props: {
    id: null
  },
  data() {
    let resourceName = 'manualbook';
    return {
      show: true,
      loading: false,
      title: '',
      resourceName: resourceName,
      routeName: `${resourceName}`,
      form: {
        slug_path: '',
        type: null,
        parent: null,
        judul: null,
        urutan: 0,
        nama_file: null,
        file: null,
        video: ''
      },
      options_parent: [],
      options_type: [
        { value: 'file', text: 'File', icon: 'far fa-file-alt' },
        { value: 'folder', text: 'Folder', icon: 'far fa-folder' },
      ],
      routes: [],
      parents: []
    }
  },
  computed: {
    isNew() {
      return this.id === undefined || this.id === null ? true : false
    },
    isFile() {
      return this.form.type ? (this.form.type.value == 'file' ? true : false) : false
    },
    labelTitle() {
      return this.form.type != undefined ? this.form.type.value : 'file'
    },
  },
  created() {
    this.getParentsFolder()
    if(!this.isNew) {
      this.fetchData()
    }
  },
  methods: {
    onCancel() {
      this.$bvModal.hide(`${this.resourceName}-add`)
    },
    async fetchData() {
      try {
        const action = this.$app.route(`${this.routeName}.show`, {id: this.id})
        const {data} = await this.$http.get(action)

        const type = this.options_type.filter(type => type.value === data.data.type)

        this.form.slug_path = data.data.slug_path
        this.form.judul = data.data.nama_judul
        this.form.urutan = data.data.urutan
        this.form.nama_file = data.data.nama_file
        this.form.file = data.data.nama_judul
        this.form.type = type ? type.shift() : null
        this.form.parent = data.data.folder
        this.form.video = data.data.url_video
      } catch (e) {
        console.log(e);
      }
    },
    getParentsFolder(id) {
      let vm = this
      vm.$http
      .get(vm.$app.route(`${this.routeName}.get_parent`), {
        params: {
          sort: 'asc',
          type: ['folder']
        },
      })
      .then(response => {
        vm.options_parent = response.data.data
      })
    },
    submit() {
      let vm = this
      let mode = this.isNew ? 'add' : 'edit'

      let { slug_path, type, parent, judul, urutan, nama_file, file, video } = vm.form
      let data =  {
        slug_path: slug_path,
        type: type ? type.value : null,
        parent: parent ? parent.id : null,
        judul: judul,
        urutan: urutan,
        nama_file: nama_file,
        file: file,
        url_video: video
      }

      let formData = this.$app.objectToFormData(data)
      if(!this.isNew) {
        formData.append('_method', 'PUT')
      }
      let url = vm.$app.route(this.isNew ? `${this.routeName}.store` : `${this.routeName}.update`, {id:this.id})

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
                // this.$router.push({name: 'settings.group'})
                vm.$root.$emit('bv::refresh::table', `${this.resourceName}-table`)
                vm.$bvModal.hide(`${this.resourceName}-add`)
              }
            })
        }
      })
    },
  }
}
</script>

<style lang="scss">
</style>
