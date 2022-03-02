<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Service\MenuService;
use Hyperf\DbConnection\Db;
use Hyperf\Di\Annotation\Inject;
use Psr\Http\Message\ServerRequestInterface;
use Taoran\HyperfPackage\Core\AbstractController;

class MenuController extends AbstractController
{
    /**
     * @Inject()
     * @var MenuService
     */
    protected $menuService;

    /**
     * 获取列表
     *
     * @return mixed
     */
    public function index()
    {
        //接收参数
        $params = $this->verify->requestParams([
            ['name', ""],
            ['is_all', 0],
            ['is_tree', 0]
        ], $this->request);

        $list = $this->menuService->getList($params);

        return $this->responseCore->success($list);
    }

    /**
     * 获取详情
     *
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function show($id)
    {

        $data =  $this->menuService->getOne((int)$id);
        return $this->responseCore->success($data);
    }

    public function store()
    {
        try {
            //接收参数
            $params = $this->verify->requestParams([
                ['name', ""],
                ['path', ""],
                ['icon', ""],
                ['p_id', 0],
                ['sort', 0],
            ], $this->request);

            //验证参数
            $this->verify->check(
                $params,
                [
                    "name" => "required",
                    "path" => '',
                    "icon" => '',
                    "p_id" => "integer",
                    "sort" => "integer",
                ],
                [
                    "name:required" => "请填写菜单名称！",
                    "p_id:integer" => "参数错误！",
                    "sort:integer" => "参数错误！",
                ]
            );

            $this->menuService->add($params);
            return $this->responseCore->success("操作成功！");
        } catch (\Exception $e) {
            return $this->responseCore->error($e->getMessage());
        }
    }

    public function update($id)
    {
        try {
            //接收参数
            $params = $this->verify->requestParams([
                ['name', ""],
                ['path', ""],
                ['icon', ""],
                ['p_id', 0],
                ['sort', 0],
            ], $this->request);

            //验证参数
            $this->verify->check(
                $params,
                [
                    "name" => "required",
                    "path" => '',
                    "icon" => '',
                    "p_id" => "integer",
                    "sort" => "integer",
                ],
                [
                    "name:required" => "请填写菜单名称！",
                    "p_id:integer" => "参数错误！",
                    "sort:integer" => "参数错误！",
                ]
            );

            $this->menuService->update((int)$id, $params);

            return $this->responseCore->success("操作成功！");
        } catch (\Exception $e) {
            return $this->responseCore->error($e->getMessage());
        }
    }

    /**
     * 删除
     *
     * @param $id
     */
    public function destroy($id)
    {
        try {
            $this->menuService->destroy((int)$id);
            return $this->responseCore->success("操作成功！");
        } catch (\Exception $e) {
            Db::rollBack();
            return $this->responseCore->error($e->getMessage());
        }
    }

    /**
     * 获取用户对应的菜单
     *
     * @return array
     * @throws \Exception
     */
    public function getAllowMenu()
    {
        $treeMenu = $this->menuService->getAllowMenu();

        return $this->responseCore->success($treeMenu);
    }
}
