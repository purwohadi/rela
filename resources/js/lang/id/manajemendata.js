export default {
	"meta": {
		"label": "Jumlah Hari Kerja",
		"label_validasi": "Daftar Arahan Gubernur Validasi",
	},
	"datatable": {
		"jam_hari_kerja" : {
			"title": "Daftar Jumlah Hari Kerja",
			"column": {
				"tahun": "Tahun",
				"bulan": "Bulan",
				"jumlah_hari_kerja_nonguru": "Jumlah Hari Kerja Non Guru",
				"jumlah_hari_kerja_guru": "Jumlah Hari Kerja Guru",
			},
		},
		"action": {
			"jum_harikerja" :{
				"add": "Tambah",
				"edit": "Detil"
			},
		},
		"filter": {
			"tahun": "Tahun",
			"fields": "Semua Kolom",
			"search": "Cari"
		}
	},
	"alert": {
		"success": "Sukses",
		"info": "Info",
		"error": "Kesalahan",
		"warning": "Peringatan",
		"confirm": 
		{
		"jum_harikerja" : {"add": "Apakah anda yakin untuk menambah Jumlah Hari kerja",
							"edit": "Apakah anda yakin untuk mengubah Jumlah Hari kerja",
							"drop": "Apakah anda yakin untuk menghapus Jumlah Hari kerja {name}?",
							}
		},
	},
	"actions": {
		"store": {
			"success": "Data Jumlah Hari Kerja Berhasil Disimpan",
			"error": "Data Jumlah Hari Kerja Gagal Disimpan",
		},
		"update": {
			"success": "Data Jumlah Hari Kerja Berhasil Diperbaharui",
			"error": "Data Jumlah Hari Kerja Gagal Diperbaharui",
		},
		"drop": {
			"success": "Data Jumlah Hari Kerja Berhasil Dihapus",
			"error": "Data Jumlah Hari Kerja Gagal Dihapus",
		}
	},
}
