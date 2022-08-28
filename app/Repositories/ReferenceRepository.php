<?php

namespace App\Repositories;

use App\Models\Reference;
use Illuminate\Http\Request;
use App\Repositories\Contracts\ReferenceRepositoryInterface;

class ReferenceRepository implements ReferenceRepositoryInterface
{
  protected $reference;

  public function __construct(Reference $reference)
  {
    $this->reference = $reference;
  }

  /**
   * Get's all reference.
   *
   * @return mixed
   */
  public function all()
  {
    return $this->reference->all();
  }

  /**
   * Get's a reference by it's ID
   *
   * @param int
   */
  public function get($reference_id)
  {
    return $this->reference->find($reference_id);
  }

  /**
   * Get's a reference by it's key
   *
   * @param string
   */
  public function getByKey($reference_key)
  {
    return $this->reference->ofKey($reference_key)->get();
  }

  /**
   * Get's a reference by it's value
   *
   * @param string
   */
  public function getByValue($reference_value)
  {
    return $this->reference->ofValue($reference_value)->get();
  }

  /**
   * Get's a reference by it's type
   *
   * @param string
   */
  public function getByType($reference_type)
  {
    return $this->reference->ofType($reference_type)->get();
  }

  /**
   * Get's a reference by it's key and type
   *
   * @param string
   */
  public function getByKeyType($reference_key, $reference_type)
  {
    return $this->reference
      ->ofKey($reference_key)
      ->ofType($reference_type)
      ->first();
  }

  /**
   * Get's references by specific condition.
   *
   * @return mixed
   */
  public function search(Request $request)
  {
    return $request->has('limit')
      ? $this->reference->getPagingData()
      : $this->reference->getAllData();
  }

  /**
   * Save a reference
   *
   * @param array $input
   */
  public function save(array $input)
  {
    return $this->reference->firstOrCreate(
      [ 'key' => $input['key']
      , 'type' => $input['type']
      ],
      ['value' => $input['value']]
    );
  }

  /**
   * Updates a reference.
   *
   * @param string
   * @param array
   */
  public function update($reference_id, array $reference_data)
  {
    $reference = $this->get($reference_id);
    return $reference->update($reference_data);
  }

  /**
   * Deletes a reference.
   *
   * @param int
   */
  public function delete($reference_id)
  {
    $reference = $this->get($reference_id);
    return $reference->delete();
  }
}
