<?php

declare (strict_types=1);
namespace App\Model;

use Taoran\HyperfPackage\Traits\RepositoryTrait;

/**
 */
class AdminUser extends Model
{
    use RepositoryTrait;

    protected $dateFormat = 'Uv';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'admin_user';
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
     * 角色表
     *
     * @return \Hyperf\Database\Model\Relations\HasOne
     */
    public function role()
    {
        return $this->hasOne(\App\Model\Role::class, 'id', 'role_id')->where('is_on', 1);
    }
}