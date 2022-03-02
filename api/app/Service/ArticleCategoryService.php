<?php


namespace App\Service;

use Hyperf\Di\Annotation\Inject;
use function Taoran\HyperfPackage\Helpers\set_save_data;

class ArticleCategoryService
{
    /**
     * @Inject()
     * @var \App\Model\ArticleCategory
     */
    protected $articleCategoryModel;

    public function getList($params)
    {
        $list = $this->articleCategoryModel->getList(['id', 'name', 'p_id'], $params, function ($query) use ($params) {
            if (isset($params['name']) && $params['name'] != '') {
                $query->where('name', 'like', "%{$params['name']}%");
            }

            $query->orderBy('p_id', 'ASC')->orderBy('sort', 'DESC');
        });

        //分级显示
        if (isset($params['is_tree']) && $params['is_tree'] == 1) {
            $list = $this->tree($list);
        }

        $list = is_array($list) ? array_values($list) : $list;
        return $list;
    }

    public function getOne(int $id)
    {
        return $this->articleCategoryModel->getOneById($id, ['id', 'name', 'p_id']);
    }

    public function add($params)
    {
        $model = new \App\Model\ArticleCategory();
        set_save_data($model, [
            'name' => $params['name'],
            'p_id' => $params['p_id'],
            'sort' => $params['sort'],
        ])->save();

        return true;
    }

    public function update(int $id, $params)
    {
        $articleCategory = $this->articleCategoryModel->getOneById($id, ['*']);
        set_save_data($articleCategory, $params)->save();
        return true;
    }

    public function destroy(int $id)
    {
        $articleCategory = $this->articleCategoryModel->getOneById($id, ['*']);
        $articleCategory->is_on = 0;
        $articleCategory->save();
        return true;
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
     * 检查分类
     *
     * @param $cate_id
     * @throws \Exception
     */
    public function check($cate_id)
    {
        $exists = $this->articleCategoryModel->where('is_on', 1)->where('id', $cate_id)->exists();
        if (!$exists) {
            throw new \Exception("分类不存在！");
        }
    }
}