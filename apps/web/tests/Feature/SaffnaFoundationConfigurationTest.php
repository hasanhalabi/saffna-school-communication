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

    public function test_no_product_route_is_exposed_by_the_foundation(): void
    {
        $this->assertCount(0, app('router')->getRoutes());
        $this->get('/')->assertNotFound();
    }

    public function test_identity_baseline_contains_only_approved_framework_fields(): void
    {
        $this->assertTrue(Schema::hasColumns('users', [
            'id',
            'name',
            'email',
            'password',
            'remember_token',
            'created_at',
            'updated_at',
        ]));
        $this->assertFalse(Schema::hasColumn('users', 'email_verified_at'));
        $this->assertFalse(Schema::hasTable('password_reset_tokens'));
        $this->assertArrayNotHasKey('passwords', config('auth.defaults'));
    }
}
