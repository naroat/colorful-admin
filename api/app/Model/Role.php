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

class Role extends Model
{
    use RepositoryTrait;

    protected $dateFormat = 'Uv';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'role';

    //隐藏字段
    protected $hidden = [
        'is_on'
    ];

    /**
     * 角色权限
     *
     * @return \Hyperf\Database\Model\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(\App\Model\Permission::class, 'role_permission', 'role_id', 'permission_id')->where('is_on', 1);
    }
}
