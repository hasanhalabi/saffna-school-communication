<?php

namespace App\Models;

use App\Business\Authorization\SaffnaAccountStatus;
use App\Business\Authorization\SaffnaUserGroupCode;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use LogicException;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_group_id',
        'status',
        'preferred_language',
        'phone',
        'must_change_password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'status' => SaffnaAccountStatus::class,
            'must_change_password' => 'boolean',
        ];
    }

    /** @return BelongsTo<SaffnaUserGroup, $this> */
    public function userGroup(): BelongsTo
    {
        return $this->belongsTo(SaffnaUserGroup::class, 'user_group_id');
    }

    public function groupCode(): ?SaffnaUserGroupCode
    {
        $code = $this->userGroup?->code;

        return $code instanceof SaffnaUserGroupCode ? $code : null;
    }

    public function isActive(): bool
    {
        return $this->status === SaffnaAccountStatus::Active;
    }

    protected static function booted(): void
    {
        static::deleting(static function (): never {
            throw new LogicException('Saffna user accounts cannot be hard-deleted.');
        });
    }
}
