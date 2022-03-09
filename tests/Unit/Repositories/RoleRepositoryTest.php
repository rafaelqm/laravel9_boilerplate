<?php namespace Tests\Unit\Repositories;

use App\Models\Role;
use App\Repositories\RoleRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class RoleRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var RoleRepository
     */
    protected $roleRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->roleRepo = \App::make(RoleRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_role()
    {
        $role = Role::factory()->make()->toArray();

        $createdRole = $this->roleRepo->create($role);

        $createdRole = $createdRole->toArray();
        $this->assertArrayHasKey('id', $createdRole);
        $this->assertNotNull($createdRole['id'], 'Created Role must have id specified');
        $this->assertNotNull(Role::find($createdRole['id']), 'Role with given id must be in DB');
        $this->assertModelData($role, $createdRole);
    }

    /**
     * @test read
     */
    public function test_read_role()
    {
        $role = Role::factory()->create();

        $dbRole = $this->roleRepo->find($role->id);

        $dbRole = $dbRole->toArray();
        $this->assertModelData($role->toArray(), $dbRole);
    }

    /**
     * @test update
     */
    public function test_update_role()
    {
        $role = Role::factory()->create();
        $fakeRole = Role::factory()->make()->toArray();

        $updatedRole = $this->roleRepo->update($fakeRole, $role->id);

        $this->assertModelData($fakeRole, $updatedRole->toArray());
        $dbRole = $this->roleRepo->find($role->id);
        $this->assertModelData($fakeRole, $dbRole->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_role()
    {
        $role = Role::factory()->create();

        $resp = $this->roleRepo->delete($role->id);

        $this->assertTrue($resp);
        $this->assertNull(Role::find($role->id), 'Role should not exist in DB');
    }

    public function test_getFieldsSearchable()
    {
        $obj = Role::factory()->create();

        $resp = $this->roleRepo->allQuery(['name' => $obj->name])->first();

        $this->assertNotEmpty($resp);
        $this->assertInstanceOf(Role::class, $resp);
    }
}
