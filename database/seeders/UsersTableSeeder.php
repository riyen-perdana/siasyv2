<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'nip' => '198111162011011010',
            'name' => 'Riyen Perdana',
            'glr_blk' => 'ST',
            'email' => 'riyenperdana@uin-suska.ac.id',
            'password' => Hash::make('198111162011011010'),
            'is_aktif' => 'Y',
            'jabatan' => 'tndk',
        ]);

        $permissions = Permission::all();

        //get role admin
        $role = Role::find(1);

        //assign permission to role
        $role->syncPermissions($permissions);

        //assign role to user
        $user->assignRole($role);

    }
}
