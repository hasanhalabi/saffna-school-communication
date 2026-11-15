<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class SaffnaLayerBoundaryTest extends TestCase
{
    public function test_approved_runtime_boundaries_exist(): void
    {
        $applicationRoot = dirname(__DIR__, 2);

        $this->assertDirectoryExists($applicationRoot.'/app/Business');
        $this->assertDirectoryExists($applicationRoot.'/app/Http/Controllers/Api');
        $this->assertDirectoryExists($applicationRoot.'/resources/js/components');
    }

    public function test_disallowed_frontend_frameworks_are_not_declared(): void
    {
        $applicationRoot = dirname(__DIR__, 2);
        $package = json_decode(
            file_get_contents($applicationRoot.'/package.json'),
            true,
            flags: JSON_THROW_ON_ERROR,
        );
        $declared = array_merge($package['dependencies'] ?? [], $package['devDependencies'] ?? []);

        foreach (['@tailwindcss/vite', 'tailwindcss', 'react', 'vue', 'livewire'] as $disallowed) {
            $this->assertArrayNotHasKey($disallowed, $declared);
        }
    }

    public function test_local_dev_uses_the_default_sqlite_file(): void
    {
        $applicationRoot = dirname(__DIR__, 2);
        $environmentExample = file_get_contents($applicationRoot.'/.env.example');
        $databaseConfig = file_get_contents($applicationRoot.'/config/database.php');

        $this->assertStringContainsString('DB_CONNECTION=sqlite', $environmentExample);
        $this->assertStringNotContainsString("\nDB_DATABASE=", $environmentExample);
        $this->assertStringContainsString("database_path('database.sqlite')", $databaseConfig);
    }
}
