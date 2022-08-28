<template>
  <div class="p-3">
    <video id="myVideo" controls="" width="100%" height="auto" autoplay="autoplay" loop="loop" :src="url">
      Your browser does not support the video tag.
    </video>
    <div class="text-right mt-4 pt-3">
      <b-button ref="closebtn" variant="default" @click="onClose()">
        {{ $t('general.form.button_close') }}
      </b-button>
    </div>
  </div>
</template>

<script>
export default {
  name: 'ManualBookVideo',
  props: {
    url: {
      type: String,
      require: false,
      default: ''
    }
  },
  data() {
    let resourceName = 'manualbook';
    return {
      show: true,
      title: '',
      resourceName: resourceName,
      routeName: `${resourceName}`,
    }
  },
  created() {
  },
  methods: {
    onClose() {
      this.$bvModal.hide(`${this.resourceName}-view-video`)
    }
  }
}
</script>