<?php

namespace App\Utils;

use App\Models\Menu;
use App\Models\FeatureAccess;
use App\Http\Resources\MenuResources;

class MenuBuilder
{
  protected $permission_id;

  /**
   * Get Menu with format
   *
   * @param boolean $isFlat
   * @return Array|Collection
   */
  public function getMenus($isFlat = false)
  {
    $menuItems = [];

    auth()->user()->groups()->with([
      'features' => function($query) {
        $query->isMenu()
          ->orderBy(\DB::raw('to_number(i_order_no)'))
          ->orderBy('v_name');
      }
    ])->get()->each(function($item) use (&$menuItems) {
      $menuItems = array_merge($menuItems, $item->features->toArray());
    });

    $uniqueMenu = [];
    foreach ($menuItems as $menuItem) {
      $isExist = array_filter($uniqueMenu, function ($u) use ($menuItem) {
        return $u['slug_path'] == $menuItem['slug_path'];
      });
      if (count($isExist) == 0) {
        array_push($uniqueMenu, $menuItem);
      }
    }

    $menu = $this->buildMenu($uniqueMenu);

    if (!$isFlat) {
      return MenuResources::collection($menu);
    } else {
      return collect($this->flattenMenu($menu))->map(function ($data) {
        return ['key' => $data['slug_path'], 'route' => $data['v_route']];
      });
    }
  }

  /**
   * Build recursive menu
   *
   * @param array $elements
   * @param string|int|mixed $parentId
   * @return array
   *
   * @link https://stackoverflow.com/a/8587437
   */
  protected function buildMenu(array $elements, $parentId = null)
  {
    $branch = [];
    foreach ($elements as $element) {
      if ($element['i_parentid'] == $parentId) {
        $children = $this->buildMenu($elements, $element['i_id']);
        if ($children) {
          $element['children'] = $children;
        }
        $branch[] = $element;
      }
    }

    return $branch;
  }

  /**
   * Flatten recursive menu
   *
   * @param array $items
   * @param string $childKey
   * @return array
   *
   * @link https://stackoverflow.com/a/41562648/15689810
   */
  protected function flattenMenu($items, $only = ['slug_path', 'v_route'], $childKey = 'children')
  {
    $flatArray = [];
    foreach ($items as $node) {
      if (array_key_exists($childKey, $node)) {
        $flatArray = array_merge($flatArray, $this->flattenMenu($node[$childKey]));
        unset($node[$childKey]);
        $flatArray[] = collect($node)->only($only)->toArray();
      } else {
        $flatArray[] = collect($node)->only($only)->toArray();
      }
    }

    return $flatArray;
  }
}
