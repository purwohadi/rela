<template>
  <div>
    <b-alert class="mb-2 p-2" show>
        <h5>Domain Peta Rencana</h5>
        <p class="mb-0">
          <strong>TATA KELOLA</strong>: 1 Inisiatif,
          <strong>MANAJEMEN</strong>: 1 Inisiatif, 
          <strong>LAYANAN</strong>: 1 Inisiatif, 
          <strong>APLIKASI</strong>: 1 Inisiatif, 
          <strong>INFRASTRUKTUR</strong>: 1 Inisiatif,
          <strong>KEAMANAN</strong>: 1 Inisiatif, 
          <strong>AUDIT TIK</strong>: 1 Inisiatif
        </p>
    </b-alert>
    <div class="mb-4">
      <ul class="nav nav-tabs nav-fill" role="tablist" style="margin-left: 4px; margin-right: 15px;">
          <li class="nav-item" v-for="(item, index) in domain_arsitektur" :key="index" @click="changeActive(item)">
              <a 
                class="nav-link" 
                :class="[index==0 ? 'active' : '']" 
                data-toggle="tab" 
                :href="`#tab_domain-${index}`" 
                role="tab"
              >
                  {{ item }}
              </a>
          </li>
      </ul>
    </div>
    <div class="tab-content p-3" style="margin-top: -15px">
      <div v-for="(item, index) in domain_arsitektur" :key="index"
          class=" tab-pane fade" :class="[index==0 ? 'show active' : '']" 
          :id="`tab_domain-${index}`" 
          role="tabpanel"
      >
        <b-btn class="mb-3" size="sm" variant="primary" @click="addInisiatif(item)" type="submit">
          <i class="fal fa-cog"></i>
          Kelola Inisiatif
        </b-btn>
        <kegiatan-list :kegiatan="optionsKegiatan" :domain="domain" :opd="opd"></kegiatan-list>
      </div>
    </div>
  </div>
</template>

<script>
import KegiatanList from "./KegiatanList";
export default {
  name: 'PetaRencanaTree',
  components: {
    KegiatanList
  },
  props: {
    opd: {
      type: String
    }
  },
  data() {
    return {
      resourceName: 'peta-rencana',
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
      },
      domain_arsitektur: [
        'TATA KELOLA', 'MANAJEMEN', 'LAYANAN', 'APLIKASI', 'INFRASTRUKTUR', 'KEAMANAN', 'AUDIT TIK'
      ],
      domain: 'TATA KELOLA',
      isInitiate: true,
      optionsKegiatan: []
    }
  },
  created() {
    this.resPerangkatDaerah()
    this.loadInisiatif()
  },
  methods: {
    addInisiatif(item) {
      this.$emit('add', item)
    },
    async resPerangkatDaerah(){
        const res = await this.$http.get(this.$app.route('domain.data-perangkat-daerah.get', {}))
        this.optionsPerangkatDaerah = res.data 
    },
    changeActive(item) {
      this.domain = item
      this.loadInisiatif()
    },
    async loadInisiatif() {
      const res = await this.$http.get(this.$app.route('peta-rencana.get-kegiatan-tree', {domain : this.domain}))
      this.optionsKegiatan = res.data 
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
