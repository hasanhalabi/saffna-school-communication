<?php

namespace Database\Factories;

use App\Business\Authorization\SaffnaAccountStatus;
use App\Business\Authorization\SaffnaUserGroupCode;
use App\Models\SaffnaUserGroup;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => static::$password ??= Hash::make('password'),
            'user_group_id' => SaffnaUserGroup::query()->firstOrCreate([
                'code' => SaffnaUserGroupCode::Student->value,
            ])->getKey(),
            'status' => SaffnaAccountStatus::Active,
            'preferred_language' => 'ar',
            'phone' => null,
            'must_change_password' => false,
            'remember_token' => Str::random(10),
        ];
    }

    public function inGroup(SaffnaUserGroupCode $group): static
    {
        return $this->state(fn (): array => [
            'user_group_id' => SaffnaUserGroup::query()->where('code', $group->value)->value('id'),
        ]);
    }

    public function disabled(): static
    {
        return $this->state(fn (): array => [
            'status' => SaffnaAccountStatus::Disabled,
        ]);
    }
}
