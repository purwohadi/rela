<?php

namespace App\Repositories\Contracts;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

interface ManualBookRepositoryInterface
{
  /**
   * Get's all manual book.
   *
   * @return mixed
   */
  public function all();

  /**
   * Get's manual book by specific condition.
   *
   * @return mixed
   */
  public function search(Request $request);

  /**
   * Get's manual book by specific condition.
   *
   * @return mixed
   */
  public function allBook(Request $request);

  /**
   * Get's a manual book by it's ID
   *
   * @param int
   */
  public function get($id);

  /**
   * Get's a manual bookAccess induk
   *
   * @param int
   */
  public function get_parent($type);

  /**
   * Save a manual book
   *
   * @param array $input
   */
  public function save(array $input, UploadedFile $file);

  /**
   * Updates a manual book.
   *
   * @param int
   * @param array
   */
  public function update($id, array $data, UploadedFile $file);

  /**
   * Deletes a manual book.
   *
   * @param int
   */
  public function delete($id);
}
