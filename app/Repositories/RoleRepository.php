<?php

namespace App\Repositories;

use App\Models\Role;
use App\Repositories\BaseRepository;

/**
 * Class RoleRepository
 * @package App\Repositories
 * @version March 30, 2020, 1:17 am -03
*/

class RoleRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'slug',
        'description',
        'level',
        'active'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Role::class;
    }
}
