<?php

declare (strict_types=1);
namespace App\Model;

use Taoran\HyperfPackage\Traits\RepositoryTrait;

/**
 */
class ArticleTag extends Model
{
    use RepositoryTrait;

    protected $dateFormat = 'Uv';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'article_tag';

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    public function articles()
    {
        return $this->hasMany(\App\Model\ArticleArticleTag::class, 'tag_id', 'id');
    }
}