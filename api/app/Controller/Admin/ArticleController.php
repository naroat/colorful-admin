<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Service\ArticleService;
use Hyperf\Di\Annotation\Inject;
use Taoran\HyperfPackage\Core\AbstractController;

class ArticleController extends AbstractController
{

    /**
     * @Inject()
     * @var ArticleService
     */
    protected $articleService;

    public function index()
    {
        try {
            $params = $this->verify->requestParams([
                ['title', ''],
                ['is_all', 0],
                ['is_show', ''],
            ], $this->request);

            $list =  $this->articleService->getList($params);
            return $this->responseCore->success($list);
        } catch (\Exception $e) {
            return $this->responseCore->error($e->getMessage());
        }
    }

    public function show($id)
    {
        $data =  $this->articleService->getOne((int)$id);
        return $this->responseCore->success($data);
    }

    public function store()
    {
        try {
            $params = $this->verify->requestParams([
                ['title', ''],
                ['desc', ''],
                ['cover', ''],
                ['content', ''],
                ['content_html', ''],
                ['cat_id', ''],
                ['is_show', ''],
                ['type', 0],
                ['tags', ''],
            ], $this->request);

            //参数验证
            $this->verify->check(
                $params,
                [
                    'title' => 'required',
                    'desc' => '',
                    'cover' => '',
                    'content' => '',
                    'content_html' => '',
                    'cat_id' => 'required|integer',
                    'type' => 'integer',
                    'tags.*' => ''
                ],
                [
                    'title.required' => '标题不能为空！',
                    'cat_id.integer' => '分类参数错误！',
                    'type.integer' => '类型参数错误！',
                ]
            );

            $this->articleService->add($params);
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
                ['title', ''],
                ['desc', ''],
                ['cover', ''],
                ['content', ''],
                ['content_html', ''],
                ['cat_id', ''],
                ['is_show', ''],
                ['type', 0],
                ['tags', ''],
            ], $this->request);

            //参数验证
            $this->verify->check(
                $params,
                [
                    'title' => 'required',
                    'desc' => '',
                    'cover' => '',
                    'cover' => '',
                    'content' => '',
                    'content_html' => '',
                    'cat_id' => 'required|integer',
                    'type' => 'integer',
                    'tags.*' => ''
                ],
                [
                    'title.required' => '标题不能为空！',
                    'cat_id.integer' => '分类参数错误！',
                    'type.integer' => '类型参数错误！',
                ]
            );

            $this->articleService->update((int)$id, $params);
            return $this->responseCore->success("操作成功！");
        } catch (\Exception $e) {
            return $this->responseCore->error($e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $this->articleService->destroy((int)$id);
            return $this->responseCore->success('操作成功');
        } catch (\Exception $e) {
            return $this->responseCore->error($e->getMessage());
        }
    }
}
