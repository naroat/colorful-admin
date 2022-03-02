<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
namespace App\Model;

use Hyperf\Di\Annotation\Inject;
use Taoran\HyperfPackage\Traits\RepositoryTrait;

class Permission extends Model
{
    use RepositoryTrait;

    protected $dateFormat = 'Uv';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'permission';

    protected $hidden = [
        'is_on'
    ];

    /**
     * 菜单表
     *
     * @return \Hyperf\Database\Model\Relations\BelongsToMany
     */
    public function menus()
    {
        return $this->belongsToMany(\App\Model\Menu::class, 'permission_menu', 'permission_id', 'menu_id')->where('is_on', 1);
    }
}
