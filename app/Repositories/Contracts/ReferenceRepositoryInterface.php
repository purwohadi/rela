<?php

namespace App\Repositories\Contracts;

use Illuminate\Http\Request;

interface ReferenceRepositoryInterface
{
  /**
   * Get's all reference.
   *
   * @return mixed
   */
  public function all();

  /**
   * Get's a reference by it's ID
   *
   * @param int
   */
  public function get($reference_id);

  /**
   * Get's a reference by it's key
   *
   * @param string
   */
  public function getByKey($reference_key);

  /**
   * Get's a reference by it's value
   *
   * @param string
   */
  public function getByValue($reference_value);

  /**
   * Get's a reference by it's type
   *
   * @param string
   */
  public function getByType($reference_type);

  /**
   * Get's a reference by it's key and type
   *
   * @param string
   */
  public function getByKeyType($reference_key, $reference_type);

  /**
   * Get's references by specific condition.
   *
   * @return mixed
   */
  public function search(Request $request);

  /**
   * Save a reference
   *
   * @param array $input
   */
  public function save(array $input);

  /**
   * Updates a reference.
   *
   * @param string
   * @param array
   */
  public function update($reference_id, array $reference_data);

  /**
   * Deletes a reference.
   *
   * @param string
   */
  public function delete($reference_id);
}
