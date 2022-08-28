<?php

return [
  /**
   * memuat data-data utama yang akan diacu oleh
   * table-table lain yang terkait pada suatu sistem
   *
   * kode table: tm
   */
  'master' => [
    'users' => 'tm_users',
    'profiles' => 'tm_profiles',
    'menu' => 'tm_menu',
    'user_group' => 'tm_user_group',
    'group' => 'tm_group',
    'feature_access' => 'tm_feature_access',
    'feature_access_group' => 'tm_feature_access_group',
    'atasan_pelaksana' => 'tm_atasan_pelaksana',
    'jadwal' => 'tm_jadwal',
    'pegawai' => 'tm_pegawai',
    'jabatan_pegawai' => 'tm_jabatan_pegawai',
    'pengumuman' => 'tm_pengumuman',
    'cronjob' => 'tm_cronjob',
    'buku_manual' => 'tm_buku_manual',

    //-------SPBE---------------------------
    'domain_layanan' => 'domain_layanan',
    'domain_proses' => 'domain_proses',
    'domain_infra_jip' => 'domain_infra_jip',
    'domain_infra_software' => 'domain_infra_software',
    'domain_infra_server' => 'domain_infra_server',
    'domain_infra_cloud' => 'domain_infra_cloud',
    'domain_infra_splp' => 'domain_infra_splp',
    'domain_aplikasi' => 'domain_aplikasi',
    'domain_infra_pheri' => 'domain_infra_pheri',
    'domain_infra_fasilitas' => 'domain_infra_fasilitas',
    'domain_infra_cloud' => 'domain_infra_cloud',
    'domain_infra_storage' => 'domain_infra_storage',
    'domain_infra_splp' => 'domain_infra_splp',
    'domain_infra_netdev' => 'domain_infra_netdev',
    'domain_standar_keamanan' => 'domain_standar_keamanan',
    'domain_peningkatan_keamanan' => 'domain_peningkatan_keamanan',
    'domain_edukasi_keamanan' => 'domain_edukasi_keamanan',
    'domain_audit_keamanan' => 'domain_audit_keamanan',
    'roadmap' => 'roadmap_harmonisasi',
    'domain_infra_keamanan' => 'domain_infra_keamanan',
    'vw_domain_proses' => 'vw_domain_proses',
    'roadmap' => 'roadmap_harmonisasi',

    'tm_informasi' => 'tm_informasi',
    'tm_informasi_detail' => 'tm_informasi_detail',
    'tm_proses_info' => 'tm_proses_info',
    'tm_proses' => 'tm_proses',
    'tm_proses_tupoksi' => 'tm_proses_tupoksi',
    'layanan' => 'tm_layanan',
    'layanan_proses' => 'tm_layanan_proses',
    'layanan_detail' => 'tm_layanan_detail',
    'tm_roadmap' => 'tm_roadmap',
    'tm_program_roadmap' => 'tm_program_roadmap',
    'tm_infra_splp' => 'tm_infra_splp',
    'tm_infra_keamanan' => 'tm_infra_keamanan',
    'tm_metadata_terkait' => 'tm_metadata_terkait',
    'tm_infra_storage' => 'tm_infra_storage',
    'infra_jip' => 'tm_infra_jip',
    'metadata_terkait' => 'tm_metadata_terkait',
    'tm_aplikasi' => 'tm_aplikasi',
    'infra_fasilitas' => 'tm_infra_fasilitas',
    'tm_infra_cloud' => 'tm_infra_cloud',
    'infra_pheri'  => 'tm_infra_pheri',
    'aplikasi_detail' => 'tm_aplikasi_detail',
    'aplikasi_data' => 'tm_aplikasi_data',
    'aplikasi_layanan' => 'tm_aplikasi_layanan',
    'tm_infra_netdev' => 'tm_infra_netdev',
    'aplikasi_basis' => 'tm_aplikasi_basis',
    'aplikasi_luaran' => 'tm_aplikasi_luaran',
    'tm_informasi_interoperabilitas' => 'tm_informasi_interoperabilitas'
  ],

  /**
   * memuat data referensi yang akan diacu
   * baik oleh table pada satu aplikasi
   * maupun table dari database lainnya
   *
   * kode table: tr
   */
  'reference' => [
    'references' => 'tr_references',
    'atasan_bawahan' => 'tr_atasan_bawahan',
    'skpd' => 'tr_skpd',
    'jenis_jadwal' => 'tr_jenis_jadwal',
    'referensi_umum' => 'tr_referensi_umum',
    'jumlah_hari_kerja' => 'tr_jumlah_hari_kerja',
    'aktivitas' => 'tr_aktivitas',

    //-------SPBE---------------------------
    'opd' => 'tr_opd',
    'ars_spbe' => 'tr_ars_spbe',
    'kode_kepmen' => 'tr_kode_kepmen',
    'tupoksi' => 'tr_tupoksi'
  ],

  /**
   * memuat data-data transaksi pada sistem,
   * yang sifatnya cepat berubah
   *
   * kode table: tt
   */
  'transaction' => [
    'media' => 'tt_media',
  ],

  /**
   * memuat data yang masih tetap disimpan,
   * yang terjadi akibat perubahan atau
   * modifikasi data pada table asalnya.
   *
   * kode table: th
   */
  'history' => [
    'password_resets' => 'th_password_resets',
  ],

  /**
   * memuat data-data log akses atau
   * modifikasi sistem
   *
   * kode table: tl
   */
  'log' => [
    'audit_trail' => 'tl_audit_trail',
  ],

  /**
   * memuat view table
   *
   * kode table: vw
   */
  'view' => [
    'pegawai' => 'vw_pegawai',
    'atasan_bawahan' => 'vw_atasan_bawahan',
    'klogad' => 'vw_pers_klogad3',
    'scorecard' => 'vw_scorecard',
    'pegawai_ekp' => 'vw_pegawai_ekp',

    /**SPBE */
    'vw_domain_layanan' => 'vw_domain_layanan',
    'vw_infra_jip' => 'vw_infra_jip',
    'vw_infra_pheri' => 'vw_infra_pheri',
    'vw_aplikasi' => 'vw_domain_aplikasi',
    'vw_infra_fasilitas' => 'vw_infra_fasilitas',
    'vw_domain_aplikasi_layanan' => 'vw_domain_aplikasi_layanan',
    'vw_jabatan_tropd' => 'vw_jabatan_tropd'
  ],

  /**
   * memuat dblink table
   *
   * kode table: @
   */
  'dblink' => [
  ],
];
