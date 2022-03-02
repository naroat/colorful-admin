<?php


namespace App\Service;

use App\Model\ArticleArticleTag;
use Hyperf\DbConnection\Db;
use Hyperf\Di\Annotation\Inject;
use function Taoran\HyperfPackage\Helpers\set_save_data;


class ArticleService
{
    /**
     * @Inject()
     * @var \App\Model\Article
     */
    protected $articleModel;

    /**
     * @Inject()
     * @var \App\Service\ArticleCategoryService
     */
    protected $articleCategoryService;

    /**
     * @Inject()
     * @var \App\Model\ArticleTag
     */
    protected $articleTagModel;

    /**
     * @Inject()
     * @var \App\Model\ArticleArticleTag
     */
    protected $articleArticleTagModel;

    /**
     * 列表
     *
     * @param array $params
     * @return \Hyperf\Contract\LengthAwarePaginatorInterface
     */
    public function getList($params)
    {
        $list = $this->articleModel->getList(['id', 'title', 'desc', 'cover', 'click_num', 'content_html', 'cat_id', 'is_show', 'created_at', 'updated_at'], $params, function ($query) use ($params) {
            //with
            $query->with('articleCategory')->with('articleTags');
            //where
            if (isset($params['title']) && $params['title'] != '') {
                $query->where('title', 'like', "%{$params['title']}%");
            }
            if (isset($params['is_show']) && $params['is_show'] != '') {
                $query->where('is_show', $params['is_show']);
            }
        });

        $list->each(function ($item) {
            $item->cate_name = $item->articleCategory->name ?? '';
            $item->content_html = htmlspecialchars_decode($item->content_html);
            $item->is_show_text = $this->articleModel::IS_SHOW[$item->is_show];
            unset($item->articleCategory);
        });

        return $list;
    }

    /**
     * 单条
     *
     * @param int $id
     */
    public function getOne(int $id)
    {
        $data = $this->articleModel->getOne(['id', 'title', 'desc', 'cover', 'content_html', 'cat_id', 'is_show'], function ($query) use ($id) {
            //with
            $query->with('articleCategory')->with('articleTags')->where('id', $id);
        });

        if ($data) {
            $data->cat_name = $data->articleCategory->name ?? '';
            $data->content_html = htmlspecialchars_decode($data->content_html);
            unset($data->articleCategory);
        }

        return $data ?? [];
    }

    /**
     * 添加
     */
    public function add($params)
    {
        try {
            //检查分类
            $this->articleCategoryService->check($params['cat_id']);

            //添加文章
            $model = new \App\Model\Article();
            set_save_data($model, [
                'title' => $params['title'],
                'desc' => $params['desc'],
                'cover' => $params['cover'],
                'content' => $params['content'] ?? '',
                'content_html' => $params['content_html'],
                'cat_id' => $params['cat_id'],
                'is_show' => $params['is_show'] ?? 0,
                'type' => $params['type'] ?? 0,
            ])->save();

            //设置标签
            $this->setTags($params, $model->id);

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
    public function update(int $id, $params)
    {
        try {
            Db::beginTransaction();
            //检查分类
            $this->articleCategoryService->check($params['cat_id']);
            $data = $this->articleModel->getOneById($id, ['*']);
            set_save_data($data, $params)->save();
            //设置标签
            $this->setTags($params, $data->id);
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
            Db::beginTransaction();

            $data = $this->articleModel->getOneById($id, ['*']);
            $data->is_on = 0;
            $data->save();

            //清除tag绑定关系
            $this->articleArticleTagModel->where('article_id', $data->id)->delete();

            Db::commit();
        } catch (\Exception $e) {
            Db::rollBack();
            throw new \Exception($e->getMessage());
        }

        return true;
    }

    /**
     * 设置标签
     *
     * @param $params
     */
    public function setTags($params, $article_id)
    {
        $tags = (isset($params['tags']) && is_array($params['tags'])) ? array_filter($params['tags']) : [];

        //验证
        if (count($tags) == 0) {
            return true;
        }
        //设置标签
        $article_tag_save = [];
        foreach ($tags as $v) {
            $tag = $this->articleTagModel->getOne(['*'], function ($query) use ($v) {
                $query->where('name', $v);
            });

            if ($tag) {
                //已存在，绑定
                $article_tag_save[] = [
                    'article_id' => $article_id,
                    'tag_id' => $tag->id
                ];
            } else {
                //不存在，新增
                $tabObj = new \App\Model\ArticleTag();
                set_save_data($tabObj, [
                    'name' => $v
                ]);
                $tabObj->save();
                //绑定
                $article_tag_save[] = [
                    'article_id' => $article_id,
                    'tag_id' => $tabObj->id
                ];
            }
        }
        //清除tag绑定关系
        $this->articleArticleTagModel->where('article_id', $article_id)->delete();
        //写入tag绑定
        $this->articleArticleTagModel->insert($article_tag_save);
    }
}