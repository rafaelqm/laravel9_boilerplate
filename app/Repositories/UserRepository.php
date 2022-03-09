<?php

namespace App\Repositories;

use App\Mail\NewUser;
use App\Models\Person;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

/**
 * Class UserRepository
 * @package App\Repositories
 * @version January 30, 2020, 11:04 pm -03
 */
class UserRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected array $fieldSearchable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'active',
        'remember_token'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model(): string
    {
        return User::class;
    }

    public function create(array $input, User $user_creating = null): Model
    {
        $input['password'] = bcrypt($input['password']);
        $input['active'] = $input['active'] ?? 0;

        $input_without_relations = $input;
        unset($input_without_relations['roles'], $input_without_relations['permissions']);
        $model = parent::create($input_without_relations);

        $person_id = $input['person_id'] ?? [];
        $model->userPeople()->syncWithoutDetaching($person_id);

        $this->addPermissions(
            $model,
            $input['roles'] ?? null,
            $input['permissions'] ?? null,
            $user_creating
        );
        return $model;
    }


    private function addPermissions(User $user, $roles = null, $permissions = null, User $user_updating = null): void
    {
        if (!$user_updating || (!($user_updating->level() >= 5))) {
            return;
        }
        if (!is_null($roles)) {
            $user->syncRoles($roles);
        }

        if (!is_null($permissions)) {
            $user->syncPermissions($permissions);
        }
    }

    public function update(array $input, $id, User $user_updating = null): Model|Collection|Builder|array
    {
        if (isset($input['password']) && $input['password'] !== '') {
            $input['password'] = bcrypt($input['password']);
        } else {
            unset($input['password']);
        }

        if ($user_updating && $user_updating->level() >= 5) {
            $input['active'] = (int)($input['active'] ?? 0);
        }

        $input_without_relations = $input;
        unset($input_without_relations['roles'], $input_without_relations['permissions']);
        $model = parent::update($input_without_relations, $id);

        $person_id = $input['person_id'] ?? [];
        $model->userPeople()->syncWithoutDetaching($person_id);

        $this->addPermissions(
            $model,
            $input['roles'] ?? null,
            $input['permissions'] ?? null,
            $user_updating
        );

        return $model;
    }

    public function associateUserPerson(Person $person, string $type, int $role_id): array
    {
        $user = $person->userPeople->first();

        $password = \Str::random(10);
        if (!$user) {
            $user = User::where('email', $person->email)->first();
            if (!$user) {
                $user_created = true;
                $user = $person->userPeople()->create(
                    [
                        'name' => $person->name,
                        'email' => $person->email,
                        'password' => bcrypt($password),
                        'active' => 1
                    ]
                );
            }
            $person->userPeople()->sync([$user->id]);
        }

        $user->roles()->attach($role_id);

        $messages = [];
        $messages[] = "Foi associado um usuário ao seu cadastro de $type, no Sistema Portal Exames Zix";
        $messages[] = 'Seu E-mail: <b>' . $person->email . '</b>';
        $messages[] = 'Sua Senha: <b>' . $password . '</b>';
        if (isset($user_created)) {
            Mail::to($user->email)->send(new NewUser($person, $messages));
        }

        return ['success' => true, 'user' => $user];
    }

    public function searchUsers(string $term, string $rule, ?int $role_id): LengthAwarePaginator
    {
        $users = User::select(
            [
                'users.id',
                DB::raw("CONCAT(name, ' - ', email) AS name")
            ]
        )
            ->where('active', 1)
            ->where(function ($subquery) use ($term) {
                $subquery->where('name', 'LIKE', '%' . $term . '%');
                $subquery->orWhere('email', 'LIKE', '%' . $term . '%');
                $subquery->orWhere('username', 'LIKE', '%' . $term . '%');
            });

        if ($rule == 'byRole') {
            $users->join('role_user', 'role_user.user_id', 'users.id')
                ->where('role_user.role_id', $role_id);
        }

        if ($rule == 'userPeople') {
            $users->whereRaw('NOT EXISTS
                (
                    SELECT 1 FROM user_person user_person WHERE user_person.user_id = users.id
                )'
            );
        }

        return $users->paginate();
    }
}
