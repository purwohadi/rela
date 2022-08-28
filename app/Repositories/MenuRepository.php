<?php

namespace App\Repositories;

use App\Models\Menu;
use Illuminate\Http\Request;
use App\Repositories\Contracts\MenuRepositoryInterface;

class MenuRepository implements MenuRepositoryInterface
{
  protected $menu;

  public function __construct(Menu $menu)
  {
    $this->menu = $menu;
  }

  /**
   * Get's all menu.
   *
   * @return mixed
   */
  public function all()
  {
    return $this->menu->all();
  }

  /**
   * Get's a menu by it's ID
   *
   * @param int
   */
  public function get($menu)
  {
    return $this->menu->find($menu);
  }

  /**
   * Get's a menu by key
   *
   * @param int
   */
  public function findByKey($key, $value)
  {
    return $this->menu->where($key, $value)->first();
  }

  /**
   * Get's only menu parents
   *
   * @param int
   */
  public function getParents()
  {
    return $this->menu->isParent()->get();
  }

  /**
   * Get's menus by specific condition.
   *
   * @return mixed
   */
  public function search(Request $request)
  {
    return $this->menu
      ->isParent()
      ->isOrdered()
      ->with('child')
      ->get();
    // $query = $this->menu->with(['parent', 'permission']);
    // return $request->has('limit')
    //   ? $this->menu->getPagingData($query)
    //   : $this->menu->getAllData($query);
  }

  /**
   * Save a menu
   *
   * @param array $input
   */
  public function save(array $input)
  {
    return $this->menu->firstOrCreate(
      [ 'group' => $input['group']
      , 'parent' => $input['parent']
      , 'label' => $input['label']
      ],
      [ 'icon' => $input['icon']
      , 'tags' => $input['tags']
      , 'route' => $input['route']
      , 'order_no' => $input['order_no']
      , 'permission_id' => $input['permission_id']
      , 'visible' => $input['visible']
      ]
    );
  }

  /**
   * Updates a menu.
   *
   * @param int
   * @param array
   */
  public function update($menu_id, array $menu_data)
  {
    $menu = $this->menu->find($menu_id);
    return $menu->update($menu_data);
  }

  /**
   * Deletes a menu.
   *
   * @param int
   */
  public function delete($menu)
  {
    $menu = $this->get($menu);
    return $menu->delete();
  }

  /**
   * Get User Structure Menu
   *
   * @param Array $permission_id
   * @return Array|Collecion
   */
  public function getStructureMenu(Array $permission_id)
  {
    $menu = $this->menu
      ->isParent()
      ->isOrdered()
      ->isPermissions($permission_id)
      ->with(['child' => function ($query) use ($permission_id) {
        $query->whereIn('permission_id', $permission_id);
      }]);
    return $menu->get();
  }
}
