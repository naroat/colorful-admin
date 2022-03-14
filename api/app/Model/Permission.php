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

    public $timestamps = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'permission';

    protected $casts = [
        'type' => 'string'
    ];

    protected $hidden = [
        'is_on'
    ];

    /** @var int 菜单类型  */
    const TYPE_MENU = 0;
    /** @var int 按钮类型 */
    const TYPE_BUTTON = 1;
    /** @var int 其他 */
    const TYPE_OTHER = 2;
    /** @var array type转换text */
    public static $type = [
        self::TYPE_MENU => '菜单',
        self::TYPE_BUTTON => '按钮',
        self::TYPE_OTHER => '其他',
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

    /**
     * 角色
     *
     * @return \Hyperf\Database\Model\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(\App\Model\Role::class, 'role_permission', 'permission_id', 'role_id')->where('is_on', 1);
    }
}
