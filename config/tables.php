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
    
    //-------Relawan---------------------------
    'dpt2019' => 'rekapulasi_dpt_2019',
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
  ],

  /**
   * memuat dblink table
   *
   * kode table: @
   */
  'dblink' => [
  ],
];
