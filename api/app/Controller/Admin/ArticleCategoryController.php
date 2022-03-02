<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Service\ArticleCategoryService;
use Hyperf\Di\Annotation\Inject;
use Taoran\HyperfPackage\Core\AbstractController;
use Taoran\HyperfPackage\Core\Code;

class ArticleCategoryController extends AbstractController
{
    /**
     * @Inject()
     * @var ArticleCategoryService
     */
    protected $articleCategoryService;

    public function index()
    {
        try {
            //过滤参数
            $params = $this->verify->requestParams([
                ['name', ''],
                ['is_tree', 0],
                ['is_all', 0],
            ], $this->request);

            //参数验证
            $this->verify->check(
                $params,
                [
                    'is_tree' => 'in:0,1',
                    'is_all' => 'in:0,1',
                ],
                [
                    'is_tree.in' => '参数错误',
                    'is_all.in' => '参数错误',
                ]
            );

            $list =  $this->articleCategoryService->getList($params);
            return $this->responseCore->success($list);
        } catch (\Exception $e) {
            return $this->responseCore->error($e->getMessage());
        }
    }

    public function show($id)
    {
        $data =  $this->articleCategoryService->getOne((int)$id);
        return $this->responseCore->success($data);
    }

    public function store()
    {
        try {
            $params = $this->verify->requestParams([
                ['name', ''],
                ['p_id', 0],
                ['sort', 0],
            ], $this->request);

            //参数验证
            $this->verify->check(
                $params,
                [
                    'name' => 'required',
                    'p_id' => 'integer',
                    'sort' => 'integer',
                ],
                [
                    'name.required' => '名称不能为空！',
                    'p_id.integer' => '参数错误！',
                    'sort.integer' => '参数错误！',
                ]
            );

            $this->articleCategoryService->add($params);
            return $this->responseCore->success("操作成功！");
        } catch (\Exception $e) {
            return $this->responseCore->error(Code::SAVE_DATA_ERROR, $e->getMessage());
        }
    }

    public function update($id)
    {
        try {
            //接收参数
            $params = $this->verify->requestParams([
                ['name', ''],
                ['p_id', 0],
                ['sort', 0],
            ], $this->request);

            //参数验证
            $this->verify->check(
                $params,
                [
                    'name' => 'required',
                    'p_id' => 'integer',
                    'sort' => 'integer',
                ],
                [
                    'name.required' => '名称不能为空！',
                    'p_id.integer' => '参数错误！',
                    'sort.integer' => '参数错误！',
                ]
            );

            $this->articleCategoryService->update((int)$id, $params);
            return $this->responseCore->success("操作成功！");
        } catch (\Exception $e) {
            return $this->responseCore->error(Code::SAVE_DATA_ERROR, $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $this->articleCategoryService->destroy((int)$id);
            return $this->responseCore->success('操作成功');
        } catch (\Exception $e) {
            return $this->responseCore->error($e->getMessage());
        }
    }

}
