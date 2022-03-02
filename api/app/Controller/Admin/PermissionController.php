<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Service\PermissionService;
use Hyperf\DbConnection\Db;
use Hyperf\Di\Annotation\Inject;

/**
 * 权限管理
 *
 * Class PermissionController
 * @package App\Controller
 */
class PermissionController extends \Taoran\HyperfPackage\Core\AbstractController
{
    /**
     * @Inject()
     * @var PermissionService
     */
    protected $permissionService;

    /**
     * 获取权限列表
     *
     * @return mixed
     */
    public function index()
    {
        try {
            //接收参数
            $params =$this->verify->requestParams([
                ['name', ""],
                ['p_id', ""],
                ['is_all', 0]
            ], $this->request);

            $list = $this->permissionService->getList($params);
            return $this->responseCore->success($list);
        } catch (\Exception $e) {
            return $this->responseCore->error($e->getMessage());
        }
    }

    /**
     * 获取权限详情
     *
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function show($id)
    {
        $role = $this->permissionService->getOne((int)$id);

        return $this->responseCore->success($role);
    }

    public function store()
    {
        try {
            //接收参数
            $params =$this->verify->requestParams([
                ['name', ""],
                ['code', ""],
                ['p_id', 0],
                ['menu_ids', ""],
            ], $this->request);

            //验证参数
            $this->verify->check(
                $params,
                [
                    "name" => "required",
                    "code" => '',
                    "p_id" => "integer",
                    "menu_ids.*" => "integer",
                ],
                [
                    "name:required" => "请填写权限名称！",
                    "menu_id.*:integer" => "请选择菜单！",
                    "p_id:integer" => "参数错误！",
                ]
            );

            $this->permissionService->add($params);
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
                ['name', ""],
                ['code', ""],
                ['p_id', 0],
                ['menu_ids', ""],
            ], $this->request);

            //验证参数
            $this->verify->check(
                $params,
                [
                    "name" => "required",
                    "code" => '',
                    "p_id" => "integer",
                    "menu_ids.*" => "integer",
                ],
                [
                    "name:required" => "请填写权限名称！",
                    "menu_id.*:integer" => "请选择菜单！",
                    "p_id:integer" => "参数错误！",
                ]
            );

            $this->permissionService->update((int)$id, $params);
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
            $this->permissionService->destroy((int)$id);
            return $this->responseCore->success("操作成功！");
        } catch (\Exception $e) {
            return $this->responseCore->error($e->getMessage());
        }
    }
}
