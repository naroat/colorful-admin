<?php


namespace App\Service;

use App\Model\Menu;
use App\Model\RolePermission;
use Hyperf\Di\Annotation\Inject;
use Psr\Http\Message\ServerRequestInterface;
use Taoran\HyperfPackage\Core\AbstractController;
use function Taoran\HyperfPackage\Helpers\set_save_data;


class MenuService extends AbstractController
{
    /**
     * @Inject()
     * @var Menu
     */
    protected $menuModel;

    /**
     * @Inject()
     * @var RolePermission
     */
    protected $rolePermissionModel;

    public function getList($params)
    {
        $list = (new \App\Model\Menu())->getList(['id', 'name', 'path', 'component', 'icon', 'p_id', 'sort', 'created_at'], $params, function ($orm) use ($params) {
            //筛选
            if ($params['name'] == true) {
                $orm->where('name', 'like', "%{$params['name']}%");
            }

            $orm->orderBy('p_id', 'ASC')->orderBy('sort', 'DESC');
        });

        //分级显示
        if (isset($params['is_tree']) && $params['is_tree'] == 1) {
            $list = $this->tree($list);
        }

        return is_array($list) ? array_values($list) : $list;
    }


    public function getOne(int $id)
    {
        return $this->menuModel->getOneById($id, ['*']);
    }

    public function add($params)
    {
        //检查上级
        if (!empty($params['p_id'])) {
            $parent_menu = $this->menuModel->where('is_on', 1)->find($params['p_id']);
            if (!$parent_menu) {
                throw new \Exception("上级菜单不存在！");
            }
        }

        //添加
        $menuModel = new \App\Model\Menu();
        set_save_data($menuModel, [
            'name' => $params['name'],
            'path' => $params['path'],
            'icon' => $params['icon'],
            'p_id' => $params['p_id'],
            'sort' => $params['sort'],
        ]);
        $menuModel->save();

        return true;
    }

    public function update(int $id, $params)
    {

        //检查是否存在
        $menu = $this->menuModel->getOneById($id, ['*']);

        //检查上级
        if (!empty($params['p_id'])) {
            $parent_menu = $this->menuModel->where('is_on', 1)->find($params['p_id']);
            if (!$parent_menu) {
                throw new \Exception("上级菜单不存在！");
            }
        }

        //添加
        set_save_data($menu, [
            'name' => $params['name'],
            'path' => $params['path'],
            'icon' => $params['icon'],
            'p_id' => $params['p_id'],
            'sort' => $params['sort'],
        ]);
        $menu->save();
        return true;
    }

    public function destroy(int $id)
    {
        //获取菜单
        $menu = (new \App\Model\Menu())->getOneById($id, ['*']);

        //如果有下级不允许删除
        if ($this->menuModel->where('is_on', 1)->where('p_id', $id)->exists()) {
            throw new \Exception("请先删除下级菜单！");
        }

        //删除
        $menu->is_on = 0;
        $menu->save();
        return true;
    }


    public function getAllowMenu($role_id)
    {
        if ($role_id == 1) {
            //管理员：返回所有菜单
            $menu = $this->menuModel->getList(['id', 'name', 'p_id', 'path', 'component', 'icon'], ['is_all' => 1], function ($query) {
                $query->orderBy('p_id', 'ASC')->orderBy('sort', 'DESC');
            });
        } else {
            //获取权限ids
            $permission_ids = $this->rolePermissionModel->where('role_id', $role_id)->pluck('permission_id');
            //获取菜单ids
            $menu_ids = $this->rolePermissionModel->whereIn('permission_id', $permission_ids)->pluck('menu_id');
            //获取菜单；这里获取全部一级菜单可以防止一级菜单缺失导致前端显示错误问题
            $menu = $this->menuModel->getList(['id', 'name', 'p_id', 'path', 'icon'], ['is_all' => 1], function ($query) use ($menu_ids) {
                $query->orderBy('p_id', 'ASC')
                    ->orderBy('sort', 'DESC')
                    ->orderBy('id', 'ASC')
                    ->where(function ($query) use ($menu_ids) {
                        $query->whereIn('id', $menu_ids)->orWhere("p_id", 0);
                    });
            });
        }

        //分级显示
        $treeMenu = $this->tree($menu);

        //过滤没有下级的上级菜单
        if (!empty($treeMenu)) {
            foreach ($treeMenu as $key => $val) {
                if (empty($val['children'])) {
                    unset($treeMenu[$key]);
                }
            }
        }

        $treeMenu = array_values($treeMenu);
        return $treeMenu;
    }

    /**
     * 分级显示
     *
     * @param $menu
     * @return array
     */
    public function tree($list)
    {
        $new_data = [];
        if (!$list->isEmpty()) {
            $list->each(function ($item) use (&$new_data) {
                $item_arr = $item->toArray();
                if ($item->p_id == 0) {
                    $new_data[$item->id] = $item_arr;
                } else {
                    $new_data[$item->p_id]['children'][] = $item_arr;
                }
            });
        }
        return $new_data;
    }
}