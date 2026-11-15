<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use LogicException;

class SaffnaAuditRecord extends Model
{
    public $timestamps = false;

    protected $table = 'audit_records';

    protected $fillable = [
        'actor_user_id',
        'subject_user_id',
        'event',
        'metadata',
        'created_at',
    ];

    protected function casts(): array
    {
        return [
            'metadata' => 'array',
            'created_at' => 'immutable_datetime',
        ];
    }

    protected static function booted(): void
    {
        static::updating(static function (): never {
            throw new LogicException('Saffna audit records are append-only.');
        });

        static::deleting(static function (): never {
            throw new LogicException('Saffna audit records are append-only.');
        });
    }
}
