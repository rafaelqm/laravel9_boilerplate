<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use jeremykenedy\LaravelRoles\Models\Role as JRole;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * @SWG\Definition(
 *      definition="Role",
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
 *          property="level",
 *          description="level",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="active",
 *          description="active",
 *          type="boolean"
 *      ),
 *      @SWG\Property(
 *          property="created_at",
 *          description="created_at",
 *          type="string",
 *          format="date-time"
 *      ),
 *      @SWG\Property(
 *          property="updated_at",
 *          description="updated_at",
 *          type="string",
 *          format="date-time"
 *      ),
 *      @SWG\Property(
 *          property="deleted_at",
 *          description="deleted_at",
 *          type="string",
 *          format="date-time"
 *      )
 * )
 */
class Role extends JRole
{
    use SoftDeletes, LogsActivity, HasFactory;

    public $table = 'roles';

    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';

    public const ADMIN_ID = 1;
    public const GERENTE_ID = 2;
    public const VISITANTE_ID = 5;


    public const ADMIN = 'admin';
    public const GERENTE = 'gerente';
    public const VISITANTE = 'visitante';

    public const NIVEIS = [
        0 => 'Não verificado',
        1 => 'Comum',
        2 => 'Supervisor',
        3 => 'Coordenador',
        4 => 'Gerente',
        5 => 'SuperAdmin',
    ];

    protected $dates = ['deleted_at'];



    public $fillable = [
        'id',
        'name',
        'slug',
        'description',
        'level',
        'active'
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
        'level' => 'integer',
        'active' => 'boolean'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'slug' => 'required|unique:roles,slug',
        'level' => 'required',
    ];

    public function getLogNameToUse($eventName = ''): string
    {
        return $this->table;
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(
                [
                    'name',
                    'slug',
                    'description',
                    'level',
                    'permissions'
                ]
            )
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
