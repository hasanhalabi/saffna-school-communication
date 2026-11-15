<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class SaffnaFoundationConfigurationTest extends TestCase
{
    use RefreshDatabase;

    public function test_foundation_configuration_and_test_isolation_are_available(): void
    {
        $this->assertSame('Saffna', config('app.name'));
        $this->assertSame('Asia/Amman', config('app.timezone'));
        $this->assertSame('ar', config('app.locale'));
        $this->assertSame('en', config('app.fallback_locale'));
        $this->assertSame('sqlite', config('database.default'));
        $this->assertSame(':memory:', config('database.connections.sqlite.database'));
        $this->assertSame(120, config('session.lifetime'));
    }

    public function test_identity_routes_are_exposed_without_public_account_routes(): void
    {
        $routes = collect(app('router')->getRoutes()->getRoutes())
            ->map(fn ($route): string => implode('|', $route->methods()).' '.$route->uri())
            ->all();

        $this->assertContains('GET|HEAD /', $routes);
        $this->assertContains('POST login', $routes);
        $this->assertContains('POST logout', $routes);
        $this->assertContains('GET|HEAD api/v1/me', $routes);
        $this->assertContains('PATCH api/v1/account/password', $routes);
        $this->assertNotContains('POST register', $routes);
        $this->assertNotContains('POST forgot-password', $routes);
    }

    public function test_identity_baseline_contains_only_approved_framework_fields(): void
    {
        $this->assertTrue(Schema::hasColumns('users', [
            'id',
            'name',
            'email',
            'password',
            'user_group_id',
            'status',
            'preferred_language',
            'phone',
            'must_change_password',
            'remember_token',
            'created_at',
            'updated_at',
        ]));
        $this->assertFalse(Schema::hasColumn('users', 'email_verified_at'));
        $this->assertFalse(Schema::hasTable('password_reset_tokens'));
        $this->assertTrue(Schema::hasTable('user_groups'));
        $this->assertTrue(Schema::hasTable('audit_records'));
        $this->assertArrayNotHasKey('passwords', config('auth.defaults'));
    }
}
