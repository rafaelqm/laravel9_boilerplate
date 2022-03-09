<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    public function test_index()
    {
        $user = User::factory()->create();
        $user->syncRoles([Role::ADMIN_ID]);
        $response = $this->actingAs($user)
            ->get('/users');

        $response->assertStatus(200);
    }

    public function test_store()
    {
        $email = 'fulano@teste.com';
        $user = User::factory()->create();
        $user->syncRoles([Role::ADMIN_ID]);
        $response = $this->actingAs($user)
            ->post(
                '/users',
                [
                    'name' => 'Fulano',
                    'email' => $email,
                    'username' => 'fulano123',
                    'password' => 'fulano123',
                    'active' => 1,
                    'roles' => [
                        Role::ADMIN_ID
                    ]
                ]
            );

        $user_created = User::where('email', $email)->first();

        self::assertNotEmpty($user_created);
        $this->assertEquals('Usuário salvo com sucesso.', session()->get('flash_notification')[0]->message);
        $response->assertStatus(302);
    }


    public function test_store_without_permissions()
    {
        $email = 'fulano@teste.com';
        $user = User::factory()->create();
        $user->syncRoles([Role::VISITANTE_ID]);
        $response = $this->actingAs($user)
            ->post(
                '/users',
                [
                    'name' => 'Fulano',
                    'email' => $email,
                    'username' => 'fulano123',
                    'password' => 'fulano123',
                    'active' => 1,
                    'roles' => [
                        Role::ADMIN_ID
                    ]
                ]
            );

        $user_created = User::where('email', $email)->first();

        self::assertEmpty($user_created);
        $this->assertEquals(
            '<i class="fa fa-ban"></i> Você não tem permissão para acessar esta área',
            session()->get('flash_notification')[0]->message
        );
        $response->assertStatus(302);
    }

    public function test_show()
    {
        $email = 'fulano@teste.com';
        $user = User::factory()->create();
        $user->syncRoles([Role::ADMIN_ID]);
        $response = $this->actingAs($user)
            ->get(
                '/users/' . $user->id
            );

        $response->assertStatus(200);
    }

    public function test_create()
    {
        $email = 'fulano@teste.com';
        $user = User::factory()->create();
        $user->syncRoles([Role::ADMIN_ID]);
        $response = $this->actingAs($user)
            ->get('/users/create');

        $response->assertStatus(200);
    }

    public function test_show_not_found()
    {
        $email = 'fulano@teste.com';
        $user = User::factory()->create();
        $user->syncRoles([Role::ADMIN_ID]);
        $response = $this->actingAs($user)
            ->get(
                '/users/' . 0
            );

        $response->assertStatus(302);
    }


    public function test_edit()
    {
        $email = 'fulano@teste.com';
        $user = User::factory()->create();
        $user->syncRoles([Role::ADMIN_ID]);
        $response = $this->actingAs($user)
            ->get('/users/' . $user->id . '/edit');

        $response->assertStatus(200);
    }

    public function test_edit_not_found()
    {
        $email = 'fulano@teste.com';
        $user = User::factory()->create();
        $user->syncRoles([Role::ADMIN_ID]);
        $response = $this->actingAs($user)
            ->get('/users/' . 0 . '/edit');

        $response->assertStatus(302);
    }

    public function test_edit_not_same()
    {
        $email = 'fulano@teste.com';
        $user = User::factory()->create();
        $user->syncRoles([Role::VISITANTE_ID]);
        $response = $this->actingAs($user)
            ->get('/users/' . 1 . '/edit');

        $response->assertStatus(302);
        $this->assertEquals(
            'Você não tem permissão de editar este usuário.',
            session()->get('flash_notification')[0]->message
        );
    }

    public function test_update()
    {
        $email = 'fulano@teste.com';
        $user = User::factory()->create();
        $user->syncRoles([Role::ADMIN_ID]);
        $response = $this->actingAs($user)
            ->patch(
                '/users/' . $user->id,
                [
                    'name' => 'Fulano Alterado',
                    'email' => $email,
                    'roles' => [
                        Role::ADMIN_ID
                    ]
                ]
            );

        $user_updated = User::where('email', $email)->first();

        self::assertNotEmpty($user_updated);
        self::assertEquals('Fulano Alterado', $user_updated->name);
        $this->assertEquals(
            "Usuário {$user_updated->name} atualizado com sucesso.",
            session()->get('flash_notification')[0]->message
        );
        $response->assertStatus(302);
    }

    public function test_update_as_patient()
    {
        $email = 'fulano@teste.com';
        $user = User::factory()->create();
        $user->syncRoles([Role::VISITANTE_ID]);
        $response = $this->actingAs($user)
            ->patch(
                '/users/' . $user->id,
                [
                    'name' => 'Fulano Alterado',
                    'email' => $email,
                ]
            );

        $user_updated = User::where('email', $email)->first();

        self::assertNotEmpty($user_updated);
        self::assertEquals('Fulano Alterado', $user_updated->name);
        $this->assertEquals(
            "Usuário {$user_updated->name} atualizado com sucesso.",
            session()->get('flash_notification')[0]->message
        );
        $response->assertStatus(302);
    }

    public function test_update_not_found()
    {
        $email = 'fulano@teste.com';
        $user = User::factory()->create();
        $user->syncRoles([Role::ADMIN_ID]);
        $response = $this->actingAs($user)
            ->patch(
                '/users/' . 0,
                [
                    'name' => 'Fulano Alterado',
                    'email' => $email,
                    'roles' => [
                        Role::ADMIN_ID
                    ]
                ]
            );

        $response->assertStatus(302);
    }

    public function test_update_not_allowed()
    {
        $email = 'fulano@teste.com';
        $user_updated = User::factory()->create();
        $user = User::factory()->create();
        $user->syncRoles([Role::VISITANTE_ID]);
        $response = $this->actingAs($user)
            ->patch(
                '/users/' . $user_updated->id,
                [
                    'name' => 'Fulano Alterado',
                    'email' => $email,
                    'roles' => [
                        Role::VISITANTE_ID
                    ]
                ]
            );

        $response->assertStatus(302);
        $this->assertEquals(
            'Você não tem permissão de editar este usuário.',
            session()->get('flash_notification')[0]->message
        );
    }



    public function test_destroy()
    {
        $user_to_be_deleted = User::factory()->create();
        $user = User::factory()->create();
        $user->syncRoles([Role::ADMIN_ID]);
        $response = $this->actingAs($user)
            ->delete('/users/' . $user_to_be_deleted->id);

        $user_deleted = User::where('id', $user_to_be_deleted->id)->first();

        self::assertEmpty($user_deleted);
        $this->assertEquals(
            "Usuário removido.",
            session()->get('flash_notification')[0]->message
        );
        $response->assertStatus(302);
    }
    public function test_destroy_as_ajax()
    {
        $user_to_be_deleted = User::factory()->create();
        $user = User::factory()->create();
        $user->syncRoles([Role::ADMIN_ID]);
        $response = $this->actingAs($user)
            ->delete(
                '/users/' . $user_to_be_deleted->id,
                [],
                [
                    'HTTP_X-Requested-With' => 'XMLHttpRequest'
                ]
            );

        $user_deleted = User::where('id', $user_to_be_deleted->id)->first();

        self::assertEmpty($user_deleted);
        $this->assertEquals(
            "Usuário removido com sucesso",
            $response->json('message')
        );
        $response->assertStatus(200);
    }

    public function test_searchUsers()
    {
        $user = User::factory()->create();
        $user->syncRoles([Role::ADMIN_ID]);
        $response = $this->actingAs($user)
            ->get(
                '/users/search/users?q=' . $user->email. '&rule=byRole&role_id=' . Role::ADMIN_ID,
                [
                    'HTTP_X-Requested-With' => 'XMLHttpRequest'
                ]
            );

        self::assertNotEmpty($response);
        $response->assertStatus(200);
    }
}
