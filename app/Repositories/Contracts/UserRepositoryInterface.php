<?php

namespace App\Repositories\Contracts;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

interface UserRepositoryInterface
{
  /**
   * Get's a user by it's ID
   *
   * @param int
   */
  public function get($user_id);

  /**
   * Get's all users.
   *
   * @return mixed
   */
  public function all();

  /**
   * Get's users by specific condition.
   *
   * @return mixed
   */
  public function search(Request $request);

  /**
   * Deletes a user.
   *
   * @param string
   */
  public function delete($slug_path);

  /**
   * Updates a user.
   *
   * @param int
   * @param array
   */
  public function update($user_id, array $user_data);

  /**
   * Save a user
   *
   * @param array $input
   */
  public function save(array $input);

  /**
   * Upload user's avatar.
   *
   * @param string $user_id
   * @param file $file
   */
  public function upload_avatar(String $user_id, UploadedFile $file);

  /**
   * Synchronization role to user
   *
   * @param String $username
   * @param String $role_name
   * @return Object|Boolean
   */
  public function sync_role(String $username, String $role_name);

  /**
   * Update password user
   *
   * @param String $username
   * @param String $role_name
   * @return Object|Boolean
   */
  public function updatePassword(Request $request);

  /**
   * Update password user
   *
   * @param String $username
   * @param String $role_name
   * @return Object|Boolean
   */
  public function updatePasswordAdminPdukpd(Request $request);
}
