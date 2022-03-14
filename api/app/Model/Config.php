<?php

declare (strict_types=1);
namespace App\Model;

use Taoran\HyperfPackage\Traits\RepositoryTrait;

/**
 */
class Config extends Model
{
    use RepositoryTrait;

    public $timestamps = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'config';
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
}