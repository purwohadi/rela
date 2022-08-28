<template>
  <div class="accordion" id="kegiatanSPBE">
    <div class="card" v-for="(item, index) in kegiatan" :key="index">
        <div class="card-header" :id="`headingKegiatan${index}`">
          <h5>
            <a class="card-link p-2" @click="changeActive(index)" data-toggle="collapse" :href="`#kegiatan${index}`">
              {{ item.kegiatan }}
              <i class="float-right" :class="[indexActive == index ? 'fa fa-angle-up' : 'fa fa-angle-down']"></i>
            </a>
          </h5>
        </div>

        <div :id="`kegiatan${index}`" class="collapse" :aria-labelledby="`headingKegiatan${index}`" data-parent="#kegiatanSPBE">
        <div class="card-body">
            <sub-kegiatan-list v-if="indexActive == index" :subkegiatan="item.sub_kegiatan" :opd="opd" :domain="domain"></sub-kegiatan-list>
        </div>
        </div>
    </div>
  </div>
</template>

<script>
import SubKegiatanList from "./SubKegiatanList.vue";
export default {
  components: { SubKegiatanList },
  name: 'KegiatanList',
  props: {
    kegiatan: {
      type: Array,
      default: []
    },
    opd : {
      type: String
    },
    domain: {
      type: String
    }
  },
  data() {
    return {
      resourceName: 'kegiatan-list',
      indexActive: null,
      title: '',
      opd_id: this.$app.user.opd_id,
      title: '',
      model:{
        perangkatDaerah: []
      },
      optionsBidur: [],
      optionsPerangkatDaerah:[],
      optionsRefInisiatif: [],
      form: {
        id: null,
        bidur_kode: ''
      }
    }
  },
  methods: {
    changeActive(index) {
      this.indexActive = this.indexActive != index ? index : null 
    }
  }
}
</script>
<style lang="scss" scoped>
  .card-link { 
    display:inline-block;
    width: 100%;
    color: #666666;
  }

</style>
