<?php

namespace App\Models;

use jeremykenedy\LaravelRoles\Models\Permission as Model;

/**
 * @SWG\Definition(
 *      definition="Permission",
 *      required={""},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="name",
 *          description="name",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="slug",
 *          description="slug",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="description",
 *          description="description",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="model",
 *          description="model",
 *          type="string"
 *      )
 * )
 */
class Permission extends Model
{
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    public $table = 'permissions';
    public $fillable = [
        'name',
        'slug',
        'description',
        'model'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'slug' => 'string',
        'description' => 'string',
        'model' => 'string'
    ];

    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = $value;
    }
}
