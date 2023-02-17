<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        DB::table('model_has_permissions')->truncate();
        DB::table('model_has_roles')->truncate();
        DB::table('role_has_permissions')->truncate();
        DB::table('permissions')->truncate();
        DB::table('roles')->truncate();

        $listPermissions = [];
        foreach (config('role') as $key => $value) {
            foreach ($value['permissions'] as $index => $permission) {
                $listPermissions[] = [
                    'name' => $index,
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }
        }
        DB::table('permissions')->insert($listPermissions);
        DB::table('roles')->insert([
            'name' => 'super-admin',
            'guard_name' => 'web',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $roleSuperAdmin = Role::where('name', 'super-admin')->first();
        $roleSuperAdmin->givePermissionTo(Permission::all());
    }
}
