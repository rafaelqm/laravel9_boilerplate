<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use jeremykenedy\LaravelRoles\Traits\HasRoleAndPermission;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoleAndPermission, LogsActivity;

    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'email_verified_at',
        'password',
        'active'
    ];

    protected static array $logAttributes = [
        'name',
        'email',
        'username',
        'active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'email' => 'required|unique:users,email',
        'username' => 'unique:users,username',
        'password' => 'required',
        'roles' => 'required',
        'roles.*' => 'sometimes|exists:roles,id'
    ];

    public static $messages = [
        'roles.required' => 'Escolha pelo menos um papel/cargo',
    ];

    public function permissions()
    {
        return $this->belongsToMany(config('roles.models.permission'))->withTimestamps();
    }

    public function getLogNameToUse($eventName = ''): string
    {
        return $this->table;
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(self::$logAttributes)
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function userPeople()
    {
        return $this->belongsToMany(Person::class, 'user_person')->withTimestamps();
    }

    public function healthUnits()
    {
        return $this->belongsToMany(HealthUnit::class, 'health_unit_user')
            ->withTimestamps();
    }
}
