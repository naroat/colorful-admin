<?php


namespace App\Service;

use App\Model\AdminUser;
use Carbon\Carbon;
use Hyperf\DbConnection\Db;
use Hyperf\Di\Annotation\Inject;
use Phper666\JwtAuth\Jwt;
use function Taoran\HyperfPackage\Helpers\get_msectime;
use function Taoran\HyperfPackage\Helpers\Password\create_password;
use function Taoran\HyperfPackage\Helpers\Password\eq_password;
use function Taoran\HyperfPackage\Helpers\set_save_data;
use Taoran\HyperfPackage\Traits\NetworkTrait;

class AdminUserService
{
    use NetworkTrait;

    /**
     * @Inject()
     * @var Jwt
     */
    protected $jwt;

    /**
     * @Inject()
     * @var AdminUser
     */
    protected $adminUserModel;

    /**
     * @Inject()
     * @var RoleService
     */
    protected $roleService;

    /**
     * @Inject()
     * @var MenuService
     */
    protected $menuService;

    /**
     * 列表
     *
     * @param array $params
     * @return \Hyperf\Contract\LengthAwarePaginatorInterface
     */
    public function getList($params)
    {
        $list = $this->adminUserModel->getList(['id', 'account', 'name', 'headimg', 'created_at'], $params, function ($query) use ($params) {
            //with
            $query->with(['role' => function ($query) {
                $query->select(['id', 'name']);
            }]);
            //where
            if (isset($params['account']) && $params['account'] != '') {
                $query->where('account', 'like', "%{$params['account']}%");
            }
        });
        $list->roles = ['admin'];
        return $list;
    }

    /**
     * 单条
     *
     * @param int $id
     */
    public function getOne(int $id)
    {
        $data = $this->adminUserModel->getOne(['id', 'account', 'name', 'headimg', 'created_at'], function ($query) use ($id) {
            $query->with(['role' => function ($query) {
                $query->select(['id', 'name']);
            }]);
        });

        return $data ?? [];
    }

    /**
     * 添加
     */
    public function add($params)
    {
        try {
            //检查角色
            $this->roleService->roleCheck($params['role_id']);

            if ($this->adminUserModel->where('account', $params['account'])->exists()) {
                throw new \Exception("该账号已存在！");
            }

            if ($this->adminUserModel->where('name', $params['name'])->exists()) {
                throw new \Exception("该名称已经被使用！");
            }

            Db::beginTransaction();

            //创建密码
            $password = create_password($params['password'], $salt);
            //添加
            $model = new \App\Model\AdminUser();
            set_save_data($model, [
                'account' => $params['account'],
                'name' => $params['name'],
                'password' => $password,
                'salt' => $salt,
                'headimg' => $params['headimg'] ?? '',
                'role_id' => $params['role_id'],
            ])->save();

            Db::commit();
        } catch (\Exception $e) {
            Db::rollBack();
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * 更新
     *
     * @param int $id
     */
    public function update($id, $params)
    {
        try {
            //检查角色
            $this->roleService->roleCheck($params['role_id']);

            //获取管理员信息
            $adminUser = $this->adminUserModel->getOneById($id);

            if ($this->adminUserModel->where('account', $params['account'])->where('id', '!=', $id)->exists()) {
                throw new \Exception("该账号已存在！");
            }

            if ($this->adminUserModel->where('name', $params['name'])->where('id', '!=', $id)->exists()) {
                throw new \Exception("该名称已经被使用！");
            }

            Db::beginTransaction();

            if (!empty($params['password'])) {
                //创建密码
                $params['password'] = create_password($params['password'], $salt);
                $params['salt'] = $salt;
            }

            set_save_data($adminUser, $params)->save();

            Db::commit();
        } catch (\Exception $e) {
            Db::rollBack();
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * 删除
     *
     * @param int $id
     */
    public function destroy(int $id)
    {
        try {
            //获取 & 验证
            $this->roleService->checkAdmin($id);
            $adminUser = $this->adminUserModel->getOneById($id);
            //删除
            $adminUser->is_on = 0;
            $adminUser->save();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        return true;
    }

    public function getCurrentUser($params)
    {
        if (empty($params)) {
            throw new \Exception('用户信息错误！');
        }

        //获取数据
        $data = $this->adminUserModel->getOneById($params['admin_user_id'], ['id', 'account', 'name', 'role_id']);
        $data->role_id = $data->role->id ?? '';
        $data->role_name = $data->role->name ?? '';
        unset($data->role);

        //角色检查
        $this->roleService->roleCheck($data->role_id);

        //获取允许访问的菜单
        $data->menu = $this->menuService->getAllowMenu($data->role_id);
        $data->roles = [$data->role_name];
        return $data;
    }

    public function login($params)
    {
        //查询用户信息
        $adminUser = $this->adminUserModel->where('is_on', 1)->where('account', '=', $params['account'])->first();
        if (!$adminUser) {
            throw new \Exception("管理员不存在！");
        }
        //判断用户名密码
        if (!eq_password($adminUser->password, $params['password'], $adminUser->salt)) {
            throw new \Exception("账号或密码错误！");
        }

        $adminUser->last_login_time = get_msectime();
        $adminUser->last_login_ip = $this->getClientIp();
        $adminUser->save();

        //创建token
        $token = (string) $this->jwt->getToken(['admin_user_id' => $adminUser->id, 'role_id' => $adminUser->role_id]);
        return ['token' => $token, 'admin_user_name' => $adminUser->name,'expires' => $this->jwt->getTTL()];
    }

    public function logout()
    {
        $this->jwt->logout();
        return true;
    }
}