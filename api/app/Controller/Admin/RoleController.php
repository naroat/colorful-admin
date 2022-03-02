<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Service\RoleService;
use Hyperf\Di\Annotation\Inject;
use Taoran\HyperfPackage\Core\AbstractController;

/**
 * 角色管理
 *
 * Class RoleController
 * @package App\Controller
 */
class RoleController extends AbstractController
{
    /**
     * @Inject
     * @var RoleService
     */
    protected $roleService;

    public function index()
    {
        $params =$this->verify->requestParams([
            ['name', ""],
            ['is_all', 0]
        ], $this->request);
        $list = $this->roleService->getList($params);
        return $this->responseCore->success($list);
    }

    public function show($id)
    {
        $role = $this->roleService->getOne((int)$id);
        return $this->responseCore->success($role);
    }

    public function store()
    {
        //业务
        try {
            //接收参数
            $params = $this->verify->requestParams([
                ['name', ''],
                ['permission_ids', ''],
            ], $this->request);

            //验证参数
            $this->verify->check(
                $params,
                [
                    "name" => "required",
                    "permission_ids.*" => 'integer',
                ],
                [
                    "name:required" => "请填写角色名称！",
                    "permission_ids.*:integer" => "参数错误！",
                ]
            );

            $this->roleService->add($params);
            return $this->responseCore->success("操作成功！");
        } catch (\Exception $e) {
            return $this->responseCore->error($e->getMessage());
        }
    }

    public function update($id)
    {
        try {
            //接收参数
            $params =$this->verify->requestParams([
                ['name', ''],
                ['permission_ids', ''],
            ], $this->request);

            //验证参数
            $this->verify->check(
                $params,
                [
                    "name" => "required",
                    "permission_ids.*" => 'integer',
                ],
                [
                    "name:required" => "请填写角色名称！",
                    "permission_ids.*:integer" => "参数错误！",
                ]
            );
            $this->roleService->update((int)$id, $params);
            return $this->responseCore->success("操作成功！");
        } catch (\Exception $e) {
            return $this->responseCore->error($e->getMessage());
        }
    }

    /**
     * 删除角色
     *
     * @param $id
     */
    public function destroy($id)
    {
        try {
            $this->roleService->destroy((int)$id);
            return $this->responseCore->success("操作成功！");
        } catch (\Exception $e) {
            return $this->responseCore->error($e->getMessage());
        }
    }
}
