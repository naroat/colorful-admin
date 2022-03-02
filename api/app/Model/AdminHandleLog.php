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

use Taoran\HyperfPackage\Traits\RepositoryTrait;

class AdminHandleLog extends Model
{
    use RepositoryTrait;

    protected $dateFormat = 'Uv';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'admin_handle_log';

    //隐藏字段
    protected $hidden = [
        'is_on'
    ];

    public function adminUser()
    {
        return $this->hasOne(\App\Model\AdminUser::class, 'id', 'admin_user_id');
    }
}
