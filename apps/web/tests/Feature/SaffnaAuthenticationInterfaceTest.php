<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SaffnaAuthenticationInterfaceTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_only_guest_application_interface_is_the_login_shell(): void
    {
        foreach (['/', '/login'] as $path) {
            $this->get($path)
                ->assertOk()
                ->assertSee('<saffna-identity-app></saffna-identity-app>', false)
                ->assertSee('name="csrf-token"', false);
        }
    }

    public function test_no_public_registration_recovery_or_bootstrap_route_exists(): void
    {
        foreach (['/register', '/forgot-password', '/bootstrap', '/provision-super-admin'] as $path) {
            $this->postJson($path)->assertNotFound();
        }

        $this->postJson('/api/register')
            ->assertUnauthorized()
            ->assertJsonPath('code', 'unauthenticated');
    }
}
