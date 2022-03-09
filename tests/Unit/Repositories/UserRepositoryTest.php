<?php

    namespace Tests\Unit\Repositories;

    use App\Models\Permission;
    use App\Models\Role;
    use App\Models\User;
    use App\Repositories\UserRepository;
    use Tests\ApiTestTrait;
    use Tests\TestCase;

    class UserRepositoryTest extends TestCase {
        use ApiTestTrait;

        /**
         * @var UserRepository
         */
        protected $userRepo;

        public function setUp(): void {
            parent::setUp();
            $this->userRepo = app(UserRepository::class);
        }

        /**
         * @test create
         */
        public function test_create_user() {
            $user = User::factory()->make()->toArray();
            $user['password'] = '1x23x1x23';

            $createdUser = $this->userRepo->create($user);

            $createdUser = $createdUser->toArray();
            $this->assertArrayHasKey('id', $createdUser);
            $this->assertNotNull($createdUser['id'], 'Created User must have id specified');
            $this->assertNotNull(User::find($createdUser['id']), 'User with given id must be in DB');
            $this->assertModelData($user, $createdUser);
        }

        public function test_create_user_with_permissions() {
            $user = User::factory()->make()->toArray();
            $user['permissions'] = [
                Permission::first()->id
            ];
            $user['password'] = '1x23x1x23';

            $createdUser = $this->userRepo->create($user);

            $createdUser = $createdUser->toArray();
            $this->assertArrayHasKey('id', $createdUser);
            $this->assertNotNull($createdUser['id'], 'Created User must have id specified');
            $this->assertNotNull(User::find($createdUser['id']), 'User with given id must be in DB');
            unset($user['permissions']);
            $this->assertModelData($user, $createdUser);
        }

        /**
         * @test read
         */
        public function test_read_user() {
            $user = User::factory()->create();

            $dbUser = $this->userRepo->find($user->id);

            $dbUser = $dbUser->toArray();
            $this->assertModelData($user->toArray(), $dbUser);
        }

        /**
         * @test read
         */
        public function test_search_user() {
            $user = User::factory()->create();

            $dbUser = $this->userRepo->allQuery(['name' => $user->name])->first();

            $dbUser = $dbUser->toArray();
            $this->assertModelData($user->toArray(), $dbUser);
        }

        /**
         * @test update
         */
        public function test_update_user() {
            $user = User::factory()->create();
            $user->attachRole(Role::find(Role::VISITANTE_ID));
            $UpdatedUserArray = User::factory()->make()->toArray();
            $UpdatedUserArray['roles'] = [Role::ADMIN_ID];
            $UpdatedUserArray['password'] = '123456abc';
            $userAdmin = User::factory()->create();
            $adminRole = Role::find(Role::ADMIN_ID);
            $userAdmin->attachRole($adminRole);

            $updatedUser = $this->userRepo->update($UpdatedUserArray, $user->id, $userAdmin);

            $UpdatedUserArrayWithoutRoles = $UpdatedUserArray;
            unset($UpdatedUserArrayWithoutRoles['roles']);
            $this->assertModelData($UpdatedUserArrayWithoutRoles, $updatedUser->toArray());
            $this->assertEquals(Role::ADMIN_ID, $updatedUser->roles->toArray()[0]['id']);

            $dbUser = $this->userRepo->find($user->id);
            $this->assertModelData($UpdatedUserArrayWithoutRoles, $dbUser->toArray());
        }

        public function test_update_user_without_permissions_to_change_roles() {
            $user = User::factory()->create();
            $user->attachRole(Role::find(Role::VISITANTE_ID));
            $UpdatedUserArray = User::factory()->make()->toArray();
            $UpdatedUserArray['roles'] = [Role::ADMIN_ID];
            $userNotAdmin = User::factory()->create();
            $userNotAdmin->attachRole(Role::find(Role::GERENTE_ID));

            $updatedUser = $this->userRepo->update($UpdatedUserArray, $user->id, $userNotAdmin);

            $UpdatedUserArrayWithoutRoles = $UpdatedUserArray;
            unset($UpdatedUserArrayWithoutRoles['roles']);
            $this->assertModelData($UpdatedUserArrayWithoutRoles, $updatedUser->toArray());
            $this->assertNotEquals(Role::ADMIN_ID, $updatedUser->roles->toArray()[0]['id']);

            $dbUser = $this->userRepo->find($user->id);
            $this->assertModelData($UpdatedUserArrayWithoutRoles, $dbUser->toArray());
        }

        /**
         * @test delete
         */
        public function test_delete_user() {
            $user = User::factory()->create();

            $resp = $this->userRepo->delete($user->id);

            $this->assertTrue($resp);
            $this->assertNull(User::find($user->id), 'User should not exist in DB');
        }

        public function test_getFieldsSearchable() {
            $obj = User::factory()->create();

            $resp = $this->userRepo->allQuery(['name' => $obj->name])->first();

            $this->assertNotEmpty($resp);
            $this->assertInstanceOf(User::class, $resp);
        }

        public function test_searchUsers() {
            $user = User::factory()->create();

            $resp = $this->userRepo->searchUsers($user->name, '', null);

            $this->assertNotEmpty($resp);
            $this->assertCount(1, $resp->items());
        }

        public function test_searchUsers_byRole() {
            $user = User::factory()->create();
            $user->attachRole(Role::VISITANTE_ID);

            $resp = $this->userRepo->searchUsers($user->name, 'byRole', Role::VISITANTE_ID);

            $this->assertNotEmpty($resp);
            $this->assertCount(1, $resp->items());
        }
    }
