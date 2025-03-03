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
        // for ($i = 1; $i < 20; $i++) {
        //     Permission::create(['name' => 'dashboard'.$i.'.index', 'guard_name' => 'web']);   
        // }
        Permission::create(['name' => 'dashboard.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'pengguna.create', 'guard_name' => 'web']);
        Permission::create(['name' => 'pengguna.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'pengguna.edit', 'guard_name' => 'web']);
        Permission::create(['name' => 'pengguna.delete', 'guard_name' => 'web']);
        Permission::create(['name' => 'role.create', 'guard_name' => 'web']);
        Permission::create(['name' => 'role.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'role.edit', 'guard_name' => 'web']);
        Permission::create(['name' => 'role.delete', 'guard_name' => 'web']);
        Permission::create(['name' => 'permission.create', 'guard_name' => 'web']);
        Permission::create(['name' => 'permission.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'permission.edit', 'guard_name' => 'web']);
        Permission::create(['name' => 'permission.delete', 'guard_name' => 'web']);
    }
}
