<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'dashboard.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'dashboard2.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'dashboard3.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'dashboard4.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'dashboard5.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'dashboard6.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'dashboard7.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'dashboard8.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'dashboard9.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'dashboard10.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'dashboard11.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'dashboard12.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'dashboard13.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'dashboard14.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'dashboard15.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'dashboard16.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'dashboard17.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'dashboard18.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'dashboard19.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'dashboard20.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'dashboard21.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'dashboard22.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'dashboard23.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'dashboard24.index', 'guard_name' => 'web']);
    }
}
