import { encrypt, decrypt } from '@js/helpers/hash-id.js'

export default {
  data() {
    return {}
  },
  methods: {
    encrPrms(str) {
      return encrypt(str)
    },
    dcrParams(str) {
      return decrypt(str)
    }
  }
}
