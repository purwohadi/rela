<?php

namespace App\Repositories\Contracts;

/**
 * Interface BaseRepository.
 */
interface BaseRepositoryInterface
{
  /**
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function query();

  // /**
  //  * @param      $query
  //  * @param null $callback
  //  *
  //  * @return \Laravel\Scout\Builder
  //  */
  // public function searchs($query, $callback = null);

  /**
   * @param array $columns
   *
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function select(array $columns = ['*']);

  /**
   * @param array $attributes
   *
   * @return \Illuminate\Database\Eloquent\Model
   */
  public function make(array $attributes = []);

  public function all(array $columns = ['*']);

  public function count();

  public function create(array $data);

  public function createMultiple(array $data);

  public function delete();

  public function deleteById($id);

  public function deleteMultipleById(array $ids);

  public function first(array $columns = ['*']);

  public function get(array $columns = ['*']);

  public function getById($id, array $columns = ['*']);

  public function getByColumn($item, $column, array $columns = ['*']);

  public function paginate($limit = 25, array $columns = ['*'], $pageName = 'page', $page = null);

  public function updateById($id, array $data, array $options = []);

  public function limit($limit);

  public function orderBy($column, $value);

  public function where($column, $value, $operator = '=');

  public function whereIn($column, $value);

  public function with($relations);
}
