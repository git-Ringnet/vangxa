<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạo vai trò
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);

        // Danh sách quyền
        $permissions = ['view', 'edit', 'delete'];

        foreach ($permissions as $permissionName) {
            // Tạo quyền nếu chưa có
            $permission = Permission::firstOrCreate(['name' => $permissionName]);

            // Gán tất cả quyền vào role Admin
            $adminRole->givePermissionTo($permission);
        }

        // Gán vai trò Admin cho user có ID 1
        $user = User::find(1);
        $user?->assignRole($adminRole);
    }

}
