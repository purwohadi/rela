<?php

namespace App\Repositories\Contracts;

use Illuminate\Http\Request;

interface FeatureAccessRepositoryInterface
{
  /**
   * Get's all feature.
   *
   * @return mixed
   */
  public function all();

  /**
   * Get's feature by specific condition.
   *
   * @return mixed
   */
  public function search(Request $request);

  /**
   * Get's a feature by it's ID
   *
   * @param int
   */
  public function get($feature_id);

  /**
   * Get's a featureAccess induk
   *
   * @param int
   */
  public function get_parent($type);

  /**
   * Save a feature
   *
   * @param array $input
   */
  public function save(array $input);

  /**
   * Updates a feature.
   *
   * @param int
   * @param array
   */
  public function update($feature_id, array $feature_data);

  /**
   * Deletes a feature.
   *
   * @param int
   */
  public function delete($feature_id);

  /**
   * Sync all permission from feature
   *
   * @param string $feature_name
   * @param array $permissions
   * @return mixed
   */
  public function syncPermissions($feature_name, array $permissions);
}
