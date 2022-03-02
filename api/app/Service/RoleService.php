<?php


namespace App\Service;

use App\Model\Menu;
use App\Model\Role;
use App\Model\RolePermission;
use Hyperf\DbConnection\Db;
use Hyperf\Di\Annotation\Inject;
use Psr\Http\Message\ServerRequestInterface;
use function Taoran\HyperfPackage\Helpers\set_save_data;

class RoleService
{
    /**
     * @Inject()
     * @var Role
     */
    protected $roleModel;

    /**
     * @Inject()
     * @var RolePermission
     */
    protected $rolePermissionModel;

    public function getList($params)
    {
        $list = $this->roleModel->getList(['id', 'name', 'created_at'], $params, function ($orm) use ($params) {
            //with
            $orm->with('permissions');
            //筛选
            if (isset($params['name']) && $params['name'] != "") {
                $orm->where('name', 'like', "%{$params['name']}%");
            }
        });

        $list->each(function ($item) {
            $item->permission_ids = $item->permissions->pluck('id');
            unset($item->permissions);
        });

        return $list;
    }

    public function getOne(int $id)
    {
        return $this->roleModel->getOneById($id, ['id', 'name']);
    }

    public function add($params)
    {
        try {
            //检查角色是否存在
            $role = $this->roleModel->getOne(['*'], function ($query) use ($params) {
                $query->where('name', $params['name']);
            });
            if ($role) {
                throw new \Exception("该角色已存在！");
            }

            Db::beginTransaction();

            //添加角色
            $roleModel = new \App\Model\Role();
            set_save_data($roleModel, [
                'name' => $params['name'],
            ]);
            $roleModel->save();

            //绑定操作权限
            $this->bindRolePermission($roleModel->id, $params['permission_ids']);

            Db::commit();
        } catch (\Exception $e) {
            Db::rollBack();
            throw new \Exception($e->getMessage());
        }
    }

    public function update(int $id, $params)
    {
        try {
            $this->checkAdmin($id);

            //获取角色
            $role = $this->roleModel->getOneById($id, ['*']);

            Db::beginTransaction();

            //更新角色
            set_save_data($role, [
                'name' => $params['name'],
            ]);
            $role->save();

            //绑定角色和权限
            if (!empty($params['permission_ids'])) {
                $this->bindRolePermission($role->id, $params['permission_ids'], true);
            }

            Db::commit();
        } catch (\Exception $e) {
            Db::rollBack();
            throw new \Exception($e->getMessage());
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->checkAdmin($id);

            //获取角色
            $role = $this->roleModel->getOneById($id, ['*']);

            Db::beginTransaction();

            //删除
            $role->is_on = 0;
            $role->save();

            //删除角色对应权限关系
            $this->rolePermissionModel->where('role_id', $role->id)->delete();

            Db::commit();
        } catch (\Exception $e) {
            Db::rollBack();
            throw new \Exception($e->getMessage());
        }
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
                    $new_data[$item->p_id]['child'][] = $item_arr;
                }
            });
        }
        return $new_data;
    }

    /**
     * 绑定角色和权限
     *
     * @param $role_id
     * @param $permission_ids
     */
    public function bindRolePermission($role_id, $permission_ids, $is_update = false)
    {
        if (!(is_array($permission_ids) && count($permission_ids) > 0)) {
            return true;
        }

        $this->checkAdmin($role_id);

        if ($is_update == true) {
            //更新操作，先清除旧的绑定信息
            $this->rolePermissionModel->where('role_id', $role_id)->delete();
        }

        $insert_data = [];
        foreach ($permission_ids as $key => $val) {
            $insert_data[] = [
                'role_id' => $role_id,
                'permission_id' => $val,
            ];
        }
        $this->rolePermissionModel->insert($insert_data);
    }

    /**
     * 验证是否允许操作管理员（默认管理员不能被修改和删除）
     *
     * @param $id
     * @throws \Exception
     */
    public function checkAdmin($id, $msg = '无法对超级管理员执行该操作！')
    {
        if ($id == 1) {
            throw new \Exception($msg);
        }
    }

    /**
     * 检查角色
     *
     * @param $role_id
     * @throws \Exception
     */
    public function roleCheck($role_id)
    {
        $role = $this->roleModel->getOne(['*'], function ($query) use ($role_id) {
            $query->where('id', $role_id);
        });
        if (!$role) {
            throw new \Exception('角色不存在！');
        }
    }
}