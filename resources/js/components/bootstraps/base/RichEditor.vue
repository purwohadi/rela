<template>
  <div>
    <div
      :ref="refs"
      class="js-summernote"
      id="saveToLocal"
    ></div>
  </div>
</template>

<script>
  export default {
    name: 'RichEditor',
    props: {
      refs: {
        Type: String,
        default: null
      },
      value: {
        type: String,
        required: true,
      },
    },
    data() {
      let vm = this
      return {
        summernoteConfigs: {
          height: 200,
          tabsize: 2,
          placeholder: "Type here...",
          dialogsFade: true,
          toolbar: [
            ['style', ['style']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['font', ['bold', 'italic', 'underline', 'clear']],
            ['fontsize', ['fontsize']],
            ['fontname', ['fontname']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']]
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['fullscreen', 'codeview', 'help']]
          ],
          callbacks: {
            //restore from localStorage
            onInit: vm.onInit,
            onChange: vm.onChange,
          },
          tes: null,
        },
        content: null,
      }
    },
    created() {
      if (this.value) {
        this.onChange(this.value)
      }
    },
    mounted() {
      $(this.$refs[this.refs]).summernote(
        this.summernoteConfigs
      )
    },
    methods: {
      onChange(params) {
        this.$emit('input', params)
      },
      onInit(e) {
        $(this.$refs[this.refs]).summernote("code", this.value);
      }
    }
  }
</script>

<style lang="scss" scoped>

</style>
