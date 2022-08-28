<template>
  <!-- begin form add -->
  <b-modal
    :id="mId"
    :ref="mId"
    :title="title"
    size="lg"
    hide-footer
    no-close-on-backdrop
    no-close-on-esc
  >
    <validation-observer v-slot="{ passes }" :slim="true">
      <form @submit.prevent="passes(submit)">
        <b-form-group
          label-cols="2"
          label-cols-lg="2"
          label-for="kategori"
          label="Kategori"
        >
          <input type="hidden" v-model="model.kategori">
          <ValidationProvider
            rules="required"
            v-slot="{ valid, errors }"
            name="kategori"
            :debounce="250"
          >
            <b-form-select
              :options="options"
              id="kategori"
              v-model="model.kategori"
              :state="errors[0] ? false : (valid ? true : null)"
              autofocus
            >
            </b-form-select>
            <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
          </ValidationProvider>
        </b-form-group>

        <template v-if="showForm">
          <template v-if="model.kategori == 1">
            <b-form-group
              label="Isi Pengumuman"
              label-for="pengumuman"
            >
              <ValidationProvider
                :rules="model.kategori == 1 ? 'required' : ''"
                v-slot="{ valid, errors }"
                name="pengumuman"
                :debounce="250"
              >
                <rich-editor
                  id="pengumuman"
                  refs="formSummernote"
                  :state="errors[0] ? false : (valid ? true : null)"
                  debounce="250"
                  v-model="model.pengumuman"
                ></rich-editor>
                <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
              </ValidationProvider>
            </b-form-group>
          </template>

          <template v-if="model.kategori == 2">
            <b-form-group
              label="Gambar"
              label-for="image"
              :label-cols="2"
            >
              <image-uploader
                size="md"
                quality="med"
                @process="onProcess"
              >
                <b-img
                  class="image-preview"
                  :src="image_preview"
                  variant="secondary"
                ></b-img>
              </image-uploader>
            </b-form-group>
          </template>
        </template>

        <div class="text-right mt-4">
          <b-button ref="closebtn" variant="default" @click="onCloseModal" class="mr-2">
            <i class="fal fa-times"></i>
            {{ $t('general.form.button_cancel') }}
          </b-button>
          <b-button type="submit" variant="primary">
            <i class="fal fa-save"></i>
            {{ $t('general.form.button_add') }}
          </b-button>
        </div>
      </form>
    </validation-observer>
  </b-modal>
</template>

<script>
import RichEditor from '@components/bootstraps/base/RichEditor.vue'
import ImageUploader from '../../../bootstraps/base/ImageUploader.vue'

export default {
  name: 'TambahPengumuman',
  components: {
    ImageUploader,
    RichEditor
  },
  props: {
    mId: {
      type: String,
      required: true,
    },
    title: {
      type: String,
      required: false,
      default: ''
    },
    item: {
      type: Object,
      require: false,
      default: () => {}
    }
  },
  data(){
    return{
      modelName: 'slug',
      resourceRoute: 'manajemen-pengumuman',
      image: null,
      image_preview: null,
      showForm: false,
      isEdit: false,
      model:{
        kategori: '',
        pengumuman: '',
        // highlight: false,
        has_banner_image: false,
        thumbnail_image_path: '',
        username: null,
        slug_path: null,
      },
      options: [
        { value: '', text: 'Silahkan Pilih' },
        { value: 1, text: 'Info Depan' },
        { value: 2, text: 'Banner' },
      ],
    }
  },
  watch: {
    'model.has_banner_image': function(n, o) {
      if(n) {
        this.image_preview = this.model.thumbnail_image_path
      }
    },
    'image': function(n, o) {
      if(n) {
        this.image_preview = n.inputURL
      }
    },
    'model.kategori': function(n, o) {
      if(n == 1) {
        this.showForm = true
        this.image = null
        this.image_preview = null
      }
      if(n == 2) {
        this.showForm = true
        this.model.pengumuman = ''
        // this.model.highlight = null
        if (!this.isEdit) {
          this.image_preview = '/img/placeholder.png'
        }
      }
    },
    'item': {
      handler: function(n) {
        this.isEdit = n && n.hasOwnProperty('slug_path')
        if (n && Object.keys(n).length) {
          this.model.slug_path = n.slug_path
          this.model.kategori = n.e_kat_pengumuman
          if (n.e_kat_pengumuman == 1) {
            this.model.pengumuman = n.tx_isi_pengumuman
            // this.model.highlight = n.e_highlight
          }
          if (n.e_kat_pengumuman == 2) {
            this.image_preview = n.thumbnail_image_path
          }
        }
      }
    }
  },
  methods:{
    onCloseModal() {
      this.$bvModal.hide(this.mId)
      this.model.pengumuman = '',
      this.model.kategori= '',
      // this.model.highlight= null,
      this.image_preview = '/img/placeholder.png'
    },
    async submit(){
      this.model.username = this.$app.user.v_userid

      let action = this.isEdit
        ? this.$app.route(`${this.resourceRoute}.update`, {
            [this.modelName]: this.model.slug_path
          })
        : this.$app.route(`${this.resourceRoute}.store`)

      let frm = new FormData()
      if (this.isEdit) {
        frm.append('_method', 'PATCH')
      }

      let formData = this.$app.objectToFormData(this.model, frm)
      if(this.image) {
        formData.append('image', this.image.output, this.image.output.name)
      }

      let msgEdit = 'Apakah anda yakin untuk mengubah data'
      let msgAdd = 'Apakah anda yakin untuk menambah data'
      this.$app.confirm({
      text: this.isEdit ? msgEdit : msgAdd,
      preConfirm: () => {
        return this.$http.post(action, formData)
          .then(response => {
            if (response.data.status == "error") {
              let errors = response.data.message
              throw new Error(response.data.message)
            } else {
              return response
            }
          })
          .catch(error => {
            this.$app.alert.showValidationMessage(error)
          })
        }
      })
      .then(result => {
        if (result.isDismissed) return
        if (result.value.data.status == "success" || result.value.data.status == "info") {
          this.$app.success(
            result.value.data.message,
            result.value.data.status,
          )
            .then(response => {
              if (response.value === true) {
                this.$root.$emit('bv::refresh::table', 'pengumuman_table')
                this.onCloseModal()
              }
            })
        }
      })
    },
    async onProcess(result) {
      this.image = result
    },
  }
}
</script>

<style lang="scss">
  .image-preview {
    border-radius: .35rem;
    margin: .7rem 0;
    width: 200px;
    height: auto;
    transition: ease-in-out 0.3s;
    img {
      border-radius: .35rem;
      width: 350px;
      height: auto;
      &.image-cover {
        object-fit: cover;
        object-position: right top;
      }
    }
  }
</style>
