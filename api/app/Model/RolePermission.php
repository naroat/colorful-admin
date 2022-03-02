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

class RolePermission extends Model
{
    protected $dateFormat = 'Uv';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'role_permission';

}
