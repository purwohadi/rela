<template>
  <section class="image-editor">
    <label for="input-for-image-uploader" class="change-icon">
      <i class="fas fa-camera"></i>
      <slot></slot>
      <b-modal
        id="modal-image"
        :size="size"
        hide-header
        no-close-on-esc
        no-close-on-backdrop
        @hidden="reset"
      >
        <template v-if="isLoading && !done">
          <spinner>
            <template slot="text">
              {{ $t('general.image.loading') }}
            </template>
          </spinner>
        </template>
        <template v-else>
          <div class="d-flex flex-column align-items-center justify-content-center">
            <vue-cropper
              ref="cropTarget"
              class="img-fluid"
              :src="outputURL"
              :aspect-ratio="aspectRatio"
              :auto-crop-area="autoCropArea"
            >
            </vue-cropper>
          </div>
        </template>
        <template #modal-footer="{ cancel }">
          <b-button variant="secondary" @click="cancel()" :disabled="isLoading">
            {{ $t('general.button.cancel') }}
          </b-button>
          <b-button variant="primary" @click="onSubmit" :disabled="isLoading">
            <template v-if="isLoading">
              <b-spinner small variant="light" label="Spinning"></b-spinner>
            </template>
            <template v-else>{{ $t('general.button.upload') }}</template>
          </b-button>
        </template>
      </b-modal>
    </label>
    <input
      id="input-for-image-uploader"
      ref="input"
      type="file"
      class="d-none"
      accept="image/*"
      @change="onChange">
  </section>
</template>

<script>
import Compressor from 'compressorjs'
import VueCropper from 'vue-cropperjs'
import 'cropperjs/dist/cropper.css'

// import { reverseGeocode } from 'esri-leaflet-geocoder'

let URL = window.URL || window.webkitURL

export default {
  name: 'ImageUploader',
  components: { VueCropper },
  props: {
    quality: {
      type: String,
      required: false,
      default: 'med',
      description: 'low|medium|high'
    },
    aspectRatio: {
      type: Number,
      required: false,
      default: () => 1 / 1
    },
    autoCropArea: {
      type: Number,
      required: false,
      default: 0.5
    },
    size: {
      type: String,
      required: false,
      default: ' '
    },
    maxWidth: {
      type: Number,
      required: false,
      default: 1024
    },
    minWidth: {
      type: Number,
      required: false,
      default: 32
    },
    strict: {
      type: Boolean,
      required: false,
      default: true
    },
    checkOrientation: {
      type: Boolean,
      required: false,
      default: true
    },
    width: {
      type: Number,
      required: false,
      default: undefined
    },
    height: {
      type: Number,
      required: false,
      default: undefined
    },
    mimeType: {
      type: String,
      required: false,
      default: ''
    },
    convertSize: {
      type: Number,
      required: false,
      default: 1024000
    },
    useWatermark: {
      type: Boolean,
      required: false,
      default: false,
    },
    watermark: {
      type: Object,
      required: false,
      default: () => {}
    },
    onlyFillText: {
      Type: Boolean,
      required: false,
      default: false,
    },
  },
  data() {
    let vm = this
    return {
      options: {
        strict: vm.strict,
        checkOrientation: vm.checkOrientation,
        maxWidth: vm.maxWidth,
        maxHeight: vm.getMaxHeight,
        minWidth: vm.minWidth,
        minHeight: vm.getMinHeight,
        width: vm.width,
        height: vm.height,
        quality: vm.getQuality,
        mimeType: vm.mimeType,
        convertSize: vm.convertSize,
        success: vm.onSuccess,
        drew: vm.onDrew,
        error: vm.onError,
      },
      defaultWatermark: {
        fillStyle: '#fff',
        font: '2rem serif',
        fillText: '',
        left: 20,
        bottom: 20,
      },
      inputURL: '',
      outputURL: '',
      input: {},
      output: {},
      isLoading: false,
      done: false,
      latLng: {
        lat: -6.2237176,
        lng: 106.7364678,
      },
      address: {},
      timestamp: '',
      fillText: '',
    }
  },
  computed: {
    getQuality() {
      let vm = this
      let quality = vm.quality.toLowerCase()
      if (quality == 'low') {
        return 0.2
      } else if (quality == 'high') {
        return 0.6
      } else {
        return 0.4
      }
    },
    getMaxHeight() {
      return this.aspectRatio != 'free'
        ? this.aspectRatio * this.maxWidth
        : this.maxWidth
    },
    getMinHeight() {
      return this.aspectRatio != 'free'
        ? this.aspectRatio * this.minWidth
        : this.minWidth
    }
  },
  beforeDestroy() {
    if (this.$refs.cropTarget) this.$refs.cropTarget.destroy()
  },
  mounted() {
    let vm = this
    // reverseGeocode().latlng(vm.latLng).run(function(error, result, response) {
    //   if (error) return
    //   vm.address = response.address
    // })
  },
  methods: {
    compress: function (file) {
      if (!file) return
      if (URL) this.inputURL = URL.createObjectURL(file)

      this.input = file
      let newOptions = window._.merge({ quality: this.getQuality }, this.options)
      new Compressor(file, newOptions)
    },
    onChange(e) {
      if (! e.target.files) return
      if (! URL) return
      this.output = e.target.files[0]
      if (this.output.type.includes('image')) {
        this.outputURL = URL.createObjectURL(e.target.files[0])
        this.$bvModal.show('modal-image')
      } else {
        this.$app.error('File gambar tidak valid')
      }
    },
    onSuccess(result) {
      this.isLoading = false
      if (URL) this.outputURL = URL.createObjectURL(result)
      this.output = result
      this.$refs.input.value = ''
      this.onProcess()
    },
    onDrew(context, canvas) {
      let vm = this
      if (! vm.useWatermark) return
      let prop = Object.assign({}, vm.defaultWatermark, vm.watermark)
      context.fillStyle = prop.fillStyle
      context.font = prop.font
      if (! vm.onlyFillText) {
        context.fillText(prop.fillText, prop.left, canvas.height - (prop.bottom + 120))
        context.fillText(vm.timestamp, prop.left, canvas.height - (prop.bottom + 80))
        context.fillText(vm.address.ShortLabel, prop.left, canvas.height - (prop.bottom + 40))
        context.fillText(
          `${ vm.address.City }, ${ vm.address.Subregion }, ${ vm.address.Region }, ${ vm.address.Postal }`,
          prop.left,
          canvas.height - prop.bottom
        )
      } else {
        context.fillText(prop.fillText, prop.left, canvas.height - prop.bottom)
      }
    },
    onError(err) {
      this.$app.error(err.message)
    },
    async getTimestamp() {
      let vm = this
      const timestamp = await this.$http.get(this.$app.route('timestamp'))
      vm.timestamp = timestamp.data
    },
    reset() {
      let vm = this
      vm.$refs.input.value = ''
      vm.input = {}
      vm.output = {}
      vm.inputURL = ''
      vm.outputURL = ''
      vm.isLoading = false
      vm.options.quality = 0.6
      vm.done = false
    },
    onSubmit() {
      let vm = this
      vm.done = true
      vm.isLoading = true
      vm.$refs.cropTarget.disable()
      vm.getTimestamp()
      let tes = vm.$refs.cropTarget.getCroppedCanvas().toBlob(result => {
        result.name = vm.output.name
        result.lastModified = vm.output.lastModified
        result.lastModifiedDate = vm.output.lastModifiedDate
        vm.compress(result)
      })
    },
    onProcess() {
      let vm = this
      const data = {
        input: vm.input,
        output: vm.output,
        inputURL: vm.inputURL,
        outputUrl: vm.outputURL,
      }
      vm.$emit('process', data)
      if (vm.done) {
        vm.$bvModal.hide('modal-image')
        vm.reset()
      }
    }
  }
}
</script>

<style lang="scss">
.change-icon {
  cursor: pointer;
  i {
    position: relative;
    font-size: 1.5rem;
    top: 5px;
    left: 50%;
    opacity: 0;
  }
  .avatar {
    margin-top: 0px;
    width: 100px;
    height: 100px;
    object-fit: cover;
    object-position: center top;
  }
  &:hover {
    opacity: .8;
    i {
      opacity: 1 !important;
      z-index: 2;
    }
  }
}
</style>
