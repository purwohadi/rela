export default {
    "meta": {
      "label": "Manajemen Akses Fitur",
    },
    "datatable": {
      "actions": {
        "edit_fitur_akses": "Ubah Data Akses Fitur",
        "detil_fitur_akses": "Detil Data Akses Fitur",
        "hapus_fitur_akses": "Hapus Data Akses Fitur",
      },
      "title": "Daftar Akses Fitur",
      "column": {
        "action": "Aksi",
        "id": "ID",
        "name": "Nama",
        "alias": "Alias",
        "type": "Tipe",
        "parent_id": "Induk",
        "description": "Deskripsi",
        "order": "Urutan",
        "icon": "Icon",
        "route": "Route",
        "params": "Parameter",
      },
    },
    "alert": {
      "success": "Sukses",
      "info": "Info",
      "error": "Kesalahan",
      "warning": "Peringatan",
      "confirm": {
        "add": "Apakah anda yakin akan menambah akses fitur {name}?",
        "edit": "Apakah anda yakin akan mengubah akses fitur {name}?",
        "drop": "Apakah anda yakin akan menghapus akses fitur {name}?"
      },
      "actions": {
        "store": {
          "success": "Data Akses Fitur Berhasil Disimpan",
          "error": "Data Akses Fitur Gagal Disimpan",
        },
        "update": {
          "success": "Data Akses Fitur Berhasil Diperbaharui",
          "error": "Data Akses Fitur Gagal Diperbaharui",
        },
        "drop": {
          "success": "Data Akses Fitur Berhasil Dihapus",
          "error": "Data Akses Fitur Gagal Dihapus",
        }
      },
    },
    "validation": {
      "unique": "{field} {value} sudah digunakan"
    },
    "form": {
      "title": {
        "add": "Tambah Akses Fitur",
        "edit": "Edit Akses Fitur",
        "detil": "Detil Akses Fitur"
      },
      "field": {
        "nama": {
          "label": "Nama Fitur",
          "placeholder": "Masukkan Nama Fitur"
        },
        "alias": {
          "label": "Alias",
          "placeholder": "Masukkan Alias"
        },
        "type": {
          "label": "Tipe",
          "placeholder": "Pilih Tipe Fitur"
        },
        "parent_id": {
          "label": "Fitur Induk",
          "placeholder": "Pilih Fitur Induk"
        },
        "deskripsi": {
          "label": "Deskripsi",
          "placeholder": "Masukan Deskripsi"
        },
        "order": {
          "label": "Urutan",
          "placeholder": "Masukan Urutan Menu"
        },
        "icon": {
          "label": "Icon",
          "placeholder": "Pilih Icon"
        },
        "route": {
          "label": "Route",
          "placeholder": "Pilih Route"
        },
        "params": {
          "label": "Parameter",
          "placeholder": "Masukkan Parameter"
        }
      }
    }
  }
