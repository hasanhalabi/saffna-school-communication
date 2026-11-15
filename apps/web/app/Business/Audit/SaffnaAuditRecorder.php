<?php

namespace App\Business\Audit;

use App\Models\SaffnaAuditRecord;
use App\Models\User;

class SaffnaAuditRecorder
{
    /**
     * @param  array<string, mixed>  $metadata
     */
    public function record(
        string $event,
        ?User $actor = null,
        ?User $subject = null,
        array $metadata = [],
    ): SaffnaAuditRecord {
        return SaffnaAuditRecord::query()->create([
            'actor_user_id' => $actor?->getKey(),
            'subject_user_id' => $subject?->getKey(),
            'event' => $event,
            'metadata' => $metadata === [] ? null : $metadata,
            'created_at' => now(),
        ]);
    }

    /**
     * @param  array<int, mixed>  $arguments
     */
    public function authorizationDenied(User $actor, string $ability, array $arguments): void
    {
        $subject = collect($arguments)->first(
            static fn (mixed $argument): bool => $argument instanceof User,
        );

        $this->record(
            event: 'authorization.denied',
            actor: $actor,
            subject: $subject instanceof User ? $subject : null,
            metadata: ['ability' => $ability],
        );
    }
}
