<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_groups', function (Blueprint $table) {
            $table->id();
            $table->string('code', 32)->unique();
        });

        DB::table('user_groups')->insert([
            ['code' => 'super_admin'],
            ['code' => 'admin_user'],
            ['code' => 'teacher'],
            ['code' => 'parent'],
            ['code' => 'student'],
        ]);

        if (DB::table('users')->exists()) {
            throw new RuntimeException('Identity migration requires the approved empty Saffna user table.');
        }

        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('user_group_id')
                ->after('password')
                ->constrained('user_groups')
                ->restrictOnDelete();
            $table->string('status', 16)->default('active')->index();
            $table->string('preferred_language', 5)->default('ar');
            $table->string('phone', 32)->nullable();
            $table->boolean('must_change_password')->default(false);
            $table->index(['user_group_id', 'status']);
        });

        Schema::create('audit_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('actor_user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->foreignId('subject_user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->string('event', 100);
            $table->json('metadata')->nullable();
            $table->timestamp('created_at');
            $table->index(['event', 'created_at']);
            $table->index(['subject_user_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_records');

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['user_group_id']);
            $table->dropIndex(['user_group_id', 'status']);
            $table->dropIndex(['status']);
            $table->dropColumn([
                'user_group_id',
                'status',
                'preferred_language',
                'phone',
                'must_change_password',
            ]);
        });

        Schema::dropIfExists('user_groups');
    }
};
