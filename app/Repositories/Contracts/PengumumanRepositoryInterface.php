<?php

namespace App\Repositories\Contracts;

use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

interface PengumumanRepositoryInterface extends BaseRepositoryInterface
{

  /**
   * Get's pengumuman by specific condition.
   *
   * @return mixed
   */
  public function search(Request $request);

  /**
   * Save a role
   *
   * @param array $input
   */
  public function save(array $input);


  /**
   * Updates a pengumuman.
   *
   * @param int
   * @param array
   */
  public function edit($slug, array $data);

  public function save_image(Pengumuman $post, array $input, UploadedFile $image = null);

  public function getListPengumuman($params);
}
