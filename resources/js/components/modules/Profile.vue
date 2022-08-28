<template>
  <b-row>
    <div class="col-12 col-lg-6">
      <user-card can-upload :users="users"></user-card>
    </div>
  </b-row>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
export default {
  	name: 'SettingsProfile',
	data(){
		return{	
			items: [],
			users: {
				username: '',
				lokasi_kerja: '',
				nama_jabatan: '',
			}
		}
	},
  	created() {
		this.loadProvider()
	},
	methods: {    
		async loadProvider() 
		{
			this.loading 			= true
			let promise 			= this.$http.get(this.$app.route('profil.data-pegawai.get', {
										nrk: this.$app.user.v_userid
									}))
			return promise.then((data) => {
				const items 		= data.data
				this.items 			= items.data
				this.users.username			= items.v_nama
				this.users.lokasi_kerja	= items.lokasi_kerja
				this.users.nama_jabatan   = items.nama_jabatan
				this.loading 		= false
				return this.items
			}).catch(error => {
				this.loading 		= false
				return []
			})			
		},
	},
}
</script>
