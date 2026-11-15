<?php

namespace App\Models;

use App\Business\Authorization\SaffnaUserGroupCode;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SaffnaUserGroup extends Model
{
    public $timestamps = false;

    protected $table = 'user_groups';

    protected $fillable = [
        'code',
    ];

    protected function casts(): array
    {
        return [
            'code' => SaffnaUserGroupCode::class,
        ];
    }

    /** @return HasMany<User, $this> */
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'user_group_id');
    }
}
