<?php

namespace Tests\Feature;

use App\Business\Audit\SaffnaAuditRecorder;
use App\Business\Authorization\SaffnaUserGroupCode;
use App\Business\Identity\SaffnaTemporaryPasswordGenerator;
use App\Models\SaffnaAuditRecord;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Mockery\MockInterface;
use RuntimeException;
use Tests\TestCase;

class SaffnaSuperAdminProvisioningTest extends TestCase
{
    use RefreshDatabase;

    private const TEMPORARY_PASSWORD = 'TemporaryPassword123!';

    protected function setUp(): void
    {
        parent::setUp();

        $this->app['env'] = 'local';
        $this->mock(SaffnaTemporaryPasswordGenerator::class, function (MockInterface $mock): void {
            $mock->shouldReceive('generate')->andReturn(self::TEMPORARY_PASSWORD);
        });
    }

    public function test_it_provisions_exactly_one_local_super_admin_and_audits_without_the_password(): void
    {
        $this->artisan('saffna:provision-super-admin')
            ->expectsOutput('Saffna Super Admin provisioned successfully.')
            ->expectsOutput('Temporary password: '.self::TEMPORARY_PASSWORD)
            ->assertSuccessful();

        $user = User::query()->with('userGroup')->sole();
        $this->assertSame('Saffna Super Admin', $user->name);
        $this->assertSame('support@hasanhalabi.com', $user->email);
        $this->assertSame(SaffnaUserGroupCode::SuperAdmin, $user->groupCode());
        $this->assertTrue($user->must_change_password);
        $this->assertTrue(Hash::check(self::TEMPORARY_PASSWORD, $user->password));

        $audit = SaffnaAuditRecord::query()->sole();
        $this->assertSame('super_admin.provisioned', $audit->event);
        $this->assertSame($user->getKey(), $audit->subject_user_id);
        $this->assertStringNotContainsString(self::TEMPORARY_PASSWORD, json_encode($audit->metadata, JSON_THROW_ON_ERROR));

        $this->artisan('saffna:provision-super-admin')
            ->expectsOutput('Provisioning requires an empty user table.')
            ->assertFailed();
        $this->assertSame(1, User::query()->count());
    }

    public function test_it_rejects_unsafe_environments(): void
    {
        $this->app['env'] = 'production';

        $this->artisan('saffna:provision-super-admin')
            ->expectsOutput('Super Admin provisioning is allowed only in Local DEV.')
            ->assertFailed();

        $this->assertDatabaseCount('users', 0);
    }

    public function test_it_rolls_back_when_audit_recording_fails(): void
    {
        $this->mock(SaffnaAuditRecorder::class, function (MockInterface $mock): void {
            $mock->shouldReceive('record')->andThrow(new RuntimeException('Audit unavailable'));
        });

        $this->artisan('saffna:provision-super-admin')
            ->expectsOutput('Super Admin provisioning failed and was rolled back.')
            ->assertFailed();

        $this->assertDatabaseCount('users', 0);
        $this->assertDatabaseCount('audit_records', 0);
    }
}
