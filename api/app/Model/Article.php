<?php

declare (strict_types=1);
namespace App\Model;

use Taoran\HyperfPackage\Traits\RepositoryTrait;

/**
 */
class Article extends Model
{
    use RepositoryTrait;

    protected $dateFormat = 'Uv';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'article';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * field is_show
     */
    const IS_SHOW_FALSE = 0;
    const IS_SHOW_TRUE = 1;
    const IS_SHOW = [
        self::IS_SHOW_FALSE => '隐藏',
        self::IS_SHOW_TRUE => '显示'
    ];

    /**
     * 文章分类表
     *
     * @return \Hyperf\Database\Model\Relations\HasOne
     */
    public function articleCategory()
    {
        return $this->hasOne(\App\Model\ArticleCategory::class, 'id', 'cat_id')->where('is_on', 1);
    }

    /**
     * 文章标签表
     *
     * @return \Hyperf\Database\Model\Relations\HasOne
     */
    public function articleTags()
    {
        return $this->belongsToMany(\App\Model\ArticleTag::class, 'article_article_tag', 'article_id', 'tag_id')->where('is_on', 1);
    }
}