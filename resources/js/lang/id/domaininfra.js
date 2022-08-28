export default {
	"meta": {
		"label": "Domain ",
		"label_domain": "Domain {domain}",
		"label_layanan_tambah": "Tambah Layanan",
		"label_layanan_ubah": "Ubah Layanan",
		"label_layanan_detil": "Detil Layanan",
	},
	"datatable": {
		"actions": {
			"edit_user": "Ubah Data Pengguna",
			"detil_user": "Detil Data Pengguna",
			"hapus_user": "Hapus Data Pengguna",
		},
		"title": "Daftar Domain {domain}",
		"column": {
			"action": "Aksi",
			"opdid": "OPD ID",
			"unit_oper": "Unit Pengelola",
			"rai_l1": "RAI Level 1",
			"rai_l2": "RAI Level 2",
			"rai_l3": "RAI Level 3",
			"rai_l4": "RAI Level 4",
			"instansi": "Instansi",
			"name": "Nama {name}",
			"id": "ID",
			"domain_code": "Kode Domain",
			"id_metadata_terkait": "ID Metadata Terkait",
		},
	},
	"alert": {
		"success": "Sukses",
		"info": "Info",
		"error": "Kesalahan",
		"warning": "Peringatan",
		"confirm": {
			"add": "Apakah anda yakin akan menambah Domain Infra Server {name}?",
			"edit": "Apakah anda yakin akan mengubah Domain Infra Server {name}?",
			"drop": "Apakah anda yakin akan menghapus Domain Infra Server {name}?",
			"password": "Apakah anda yakin akan mengubah password?"
		},
		"actions": {
			"store": {
				"success": "Data Domain Infra Server Berhasil Disimpan",
				"error": "Data Domain Infra Server Gagal Disimpan",
			},
			"update": {
				"success": "Data Domain Infra Server Berhasil Diperbaharui",
				"error": "Data Domain Infra Server Gagal Diperbaharui",
			},
			"drop": {
				"success": "Data Domain Infra Server Berhasil Dihapus",
				"error": "Data Domain Infra Server Gagal Dihapus",
			},
		},
	},
	"validation": {
		"unique": "{field} {value} sudah digunakan",
		"special": "Password harus mengandung: 1 huruf besar, 1 huruf kecil, 1 angka, and karakter spesial (Contoh. , . _ & ? dll"
	},
	"form": {
		"title": {
			"add": "Tambah Domain Infra Server",
			"edit": "Edit Domain Infra Server",
			"detil": "Detil Domain Infra Server"
		},
		"field": {
			"rai_l1": {
				"label": "Referensi Arsitektur Infrastruktur Level 1",
				"placeholder": "Pilih RAI Level 1"
			},
			"rai_l2": {
				"label": "Referensi Arsitektur Infrastruktur Level 2",
				"placeholder": "Pilih RAI Level 2"
			},
			"rai_l3": {
				"label": "Referensi Arsitektur Infrastruktur Level 3",
				"placeholder": "Pilih RAI Level 3"
			},
			"rai_l4": {
				"label": "Referensi Arsitektur Infrastruktur Level 4",
				"placeholder": "Pilih RAI Level 4"
			},
			"name": {
				"label": "Nama {domain}",
				"placeholder": "Masukkan Nama {domain}"
			},
			"tipe_pl": {
				"label": "Tipe Perangkat Lunak",
				"placeholder": "Pilih Tipe Perangkat Lunak"
			},
			"os_name": {
				"label": "Nama Sistem Operasi",
				"placeholder": "Pilih Sistem Operasi"
			},
			"instansi": {
				"label": "Instansi",
				"placeholder": "Pilih Instansi"
			},
			"description": {
				"label": "Deskripsi {domain}",
				"placeholder": "Masukkan Deskripsi {domain}"
			},
			"utility_system_name": {
				"label": "Nama Sistem Utilitas",
				"placeholder": "Masukkan Sistem Utilitas"
			},
			"db_system_name": {
				"label": "Jenis Database",
				"placeholder": "Pilih Jenis Database"
			},
			"use_type": {
				"label": "Jenis Penggunaan",
				"placeholder": "Masukkan Jenis Penggunaan"
			},
			"owner_name": {
				"label": "Nama Pemilik",
				"placeholder": "Masukkan Nama Pemilik"
			},
			"ownership_status": {
				"label": "Status Kepemilikan",
				"placeholder": "Masukkan Status Kepemilikan"
			},
			"operation_unit": {
				"label": "Unit Pengelola",
				"placeholder": "Masukkan Unit Pengelola"
			},
			"location": {
				"label": "Lokasi",
				"placeholder": "Masukkan Lokasi"
			},
			"software_used": {
				"label": "Perangkat Lunak Digunakan",
				"placeholder": "Masukkan Perangkat Lunak Digunakan"
			},
			"memory_capacity": {
				"label": "Kapasitas Memori",
				"placeholder": "Masukkan Kapasitas Memori"
			},
			"storage_capacity": {
				"label": "Kapasitas Penyimpanan",
				"placeholder": "Masukkan Kapasitas Penyimpanan"
			},
			"infra_reference_code": {
				"label": "Kode Referensi Infrastruktur",
				"placeholder": "Masukkan Kode Referensi Infrastruktur"
			},
			"storage_technic": {
				"label": "Teknik Penyimpanan",
				"placeholder": "Masukkan Teknik Penyimpanan"
			},
			"processor_type": {
				"label": "Jenis Prosesor",
				"placeholder": "Masukkan Jenis Prosesor"
			},
			"license_type": {
				"label": "Jenis Lisensi",
				"placeholder": "Masukkan Jenis Lisensi"
			},
			"license_owner": {
				"label": "Pemilik Lisensi",
				"placeholder": "Masukkan Pemilik Lisensi"
			},
			"license_validity": {
				"label": "Validitas Lisensi",
				"placeholder": "Masukkan Validitas Lisensi"
			},
			"metadata_id_related": {
				"label": "ID Metadata Terkait",
				"placeholder": "Masukkan ID Metadata Terkait"
			},
			"metadata_id_related_server": {
				"label": "ID Metadata Terkait (Perangkat Keamanan)",
				"placeholder": "Masukkan ID Metadata Terkait (Perangkat Keamanan)"
			}
		}
	}
}
