<?php

namespace App\Console\Commands;

use App\Business\Audit\SaffnaAuditRecorder;
use App\Business\Authorization\SaffnaAccountStatus;
use App\Business\Authorization\SaffnaUserGroupCode;
use App\Business\Identity\SaffnaTemporaryPasswordGenerator;
use App\Models\SaffnaUserGroup;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Throwable;

class SaffnaProvisionSuperAdmin extends Command
{
    protected $signature = 'saffna:provision-super-admin';

    protected $description = 'Provision the first Saffna Super Admin in Local DEV';

    public function handle(
        SaffnaTemporaryPasswordGenerator $passwordGenerator,
        SaffnaAuditRecorder $auditRecorder,
    ): int {
        if (! app()->environment('local')) {
            $this->error('Super Admin provisioning is allowed only in Local DEV.');

            return self::FAILURE;
        }

        if (User::query()->exists()) {
            $this->error('Provisioning requires an empty user table.');

            return self::FAILURE;
        }

        $group = SaffnaUserGroup::query()
            ->where('code', SaffnaUserGroupCode::SuperAdmin->value)
            ->first();

        if ($group === null) {
            $this->error('The fixed Super Admin group is missing. Run the approved migrations first.');

            return self::FAILURE;
        }

        $password = $passwordGenerator->generate();

        try {
            DB::transaction(function () use ($group, $password, $auditRecorder): void {
                $user = User::query()->create([
                    'name' => 'Saffna Super Admin',
                    'email' => 'support@hasanhalabi.com',
                    'password' => $password,
                    'user_group_id' => $group->getKey(),
                    'status' => SaffnaAccountStatus::Active,
                    'preferred_language' => 'ar',
                    'phone' => null,
                    'must_change_password' => true,
                ]);

                $auditRecorder->record(
                    event: 'super_admin.provisioned',
                    subject: $user,
                    metadata: ['environment' => app()->environment()],
                );
            });
        } catch (Throwable $exception) {
            report($exception);
            $this->error('Super Admin provisioning failed and was rolled back.');

            return self::FAILURE;
        }

        $this->info('Saffna Super Admin provisioned successfully.');
        $this->line("Temporary password: {$password}");
        $this->warn('Copy this temporary password now. It will not be shown again.');

        return self::SUCCESS;
    }
}
