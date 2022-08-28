<?php

namespace App\Utils;

use App\Http\Resources\UserWithFlattenGroupAndFeatureResources;

class UserInfo
{
  /**
   * logged in user variable.
   *
   * @var \Illuminate\Contracts\Auth\Authenticatable
   */
  protected $loggedInUser;

  /**
   * Create a new User Info instance.
   *
   * @param \Illuminate\Contracts\Auth\Authenticatable $auth_user
   */
  public function __construct(\Illuminate\Contracts\Auth\Authenticatable $auth_user)
  {
    $this->loggedInUser = $auth_user;
  }

  /**
   * Get all info for user with flatten resources.
   *
   * @return mixed
   */
  public function get()
  {
    return new UserWithFlattenGroupAndFeatureResources($this->loggedInUser);
  }

  /**
   * Get user groups.
   *
   * @return object|collection
   */
  public function groups()
  {
    $user = $this->loggedInUser->load('groups');
    return $user->groups;
  }

  /**
   * Get user features.
   *
   * @return object|collection
   */
  public function features()
  {
    $features = collect([]);
    $user = $this->loggedInUser->load('groups.features');
    if ($groups = $user->groups) {
      $groups->each(function($group) use (&$features) {
        $features = $features->merge($group->features);
      });
    }
    return $features;
  }

  /**
   * Get current thbl for user.
   *
   * @return string
   */
  public function latestThbl()
  {
    if (!$this->loggedInUser->is_common_user) {
      return null;
    }

    return $this->getLatestDataPegawaiForCommonUser()->v_thbl;
  }

  /**
   * Getting the latest thbl for only common user.
   *
   * @return object|collection
   */
  protected function getLatestDataPegawaiForCommonUser()
  {
    $commonUser = $this->loggedInUser->load('pegawai');
    if ($hasDataPegawai = $commonUser->pegawai) {
      return $hasDataPegawai
        ->sortByDesc('v_thbl')
        ->shift();
    }

    return null;
  }

  /**
   * Getting data pegawai by given thbl.
   *
   * @param string $thbl
   * @return object|collection
   */
  protected function getDataPegawaiForCommonUserByThbl($thbl)
  {
    $user = $this->loggedInUser->load('pegawai');
    $user->whereHas('pegawai', function ($query) use ($thbl) {
      $query->where('v_thbl', $thbl);
    });

    if ($hasPegawai = $user->pegawai) {
      return $hasPegawai->shift();
    }

    return null;
  }

  /**
   * Get kode lokasi for user.
   *
   * @param string $thbl
   * @return mixed
   */
  public function getKodeLokasi($thbl = null)
  {
    // kalo common user butuh thbl, untuk mendapatkan kolok.
    // tanpa thbl maka dianggap thbl yang terakhir
    if ($this->loggedInUser->is_common_user) {
      if (is_null($thbl)) {
        return $this->getLatestDataPegawaiForCommonUser()->v_kolok;
      }

      return $this->getDataPegawaiForCommonUserByThbl($thbl)->v_kolok ?? null;
    }

    if (
      $this->loggedInUser->is_admin_skpd
      || $this->loggedInUser->is_admin_ukpd
    ) {
      return $this->loggedInUser->skpd->v_kode_skpd;
    }

    return null;
  }

  /**
   * Get Kode SPM (Surat Perintah Membayar) for user.
   *
   * @param string $thbl
   * @return string
   */
  public function getKodeSpm($thbl = null)
  {
    // kalo common user butuh thbl, untuk mendapatkan kolok.
    // tanpa thbl maka dianggap thbl yang terakhir
    if ($this->loggedInUser->is_common_user) {
      if (is_null($thbl)) {
        return $this->getLatestDataPegawaiForCommonUser()->v_spmu;
      }

      return $this->getDataPegawaiForCommonUserByThbl($thbl)->v_spmu ?? null;
    }

    if (
      $this->loggedInUser->is_admin_skpd
      || $this->loggedInUser->is_admin_ukpd
    ) {
      $user = $this->loggedInUser->load('skpd.kodeSpm');
      if ($haskodeSpm = $user->skpd->kodeSpm) {
        return $haskodeSpm->spmu;
      }
    }

    return null;
  }

    /**
   * Get kode jabatan for user.
   *
   * @param string $kojab
   * @return mixed
   */
  public function getCurrentKodeJabatan()
  {
    return ($this->loggedInUser->is_common_user) ? $this->getLatestDataPegawaiForCommonUser()->v_kojab : null;
  }

    /**
   * Get eselon for user.
   *
   * @param string $eselon
   * @return mixed
   */
  public function getCurrentEselon()
  {
    return ($this->loggedInUser->is_common_user) ? $this->getLatestDataPegawaiForCommonUser()->v_eselon : null;
  }

  /**
   * Get kode jabatan for user.
   *
   * @param string $kojab
   * @return mixed
   */
  public function getCurrentNama()
  {
    return ($this->loggedInUser->is_common_user) ? $this->getLatestDataPegawaiForCommonUser()->v_nama : null;
  }

  /**
   * Get kode jabatan for user.
   *
   * @param string $kojab
   * @return mixed
   */
  public function getCurrentNIP()
  {
    return ($this->loggedInUser->is_common_user) ? $this->getLatestDataPegawaiForCommonUser()->v_nip18 : null;
  }
}
