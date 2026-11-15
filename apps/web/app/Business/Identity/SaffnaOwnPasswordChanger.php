<?php

namespace App\Business\Identity;

use App\Business\Audit\SaffnaAuditRecorder;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class SaffnaOwnPasswordChanger
{
    public function __construct(
        private readonly SaffnaAuditRecorder $auditRecorder,
    ) {}

    public function change(User $user, string $newPassword): void
    {
        $requiredChange = $user->must_change_password;

        DB::transaction(function () use ($user, $newPassword, $requiredChange): void {
            $user->forceFill([
                'password' => $newPassword,
                'must_change_password' => false,
            ])->save();

            $this->auditRecorder->record(
                event: 'account.password.changed',
                actor: $user,
                subject: $user,
                metadata: ['required_change' => $requiredChange],
            );
        });
    }
}
