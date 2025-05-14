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
        // Tạo các vai trò
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $vendorRole = Role::firstOrCreate(['name' => 'vendor']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        // Danh sách quyền
        $permissions = [
            // Quyền chung
            'view_posts',
            'create_posts',
            'edit_own_posts',
            'delete_own_posts',
            'comment_posts',
            'like_posts',
            'share_posts',
            
            // Quyền nhóm
            'view_groups',
            'join_groups',
            'create_groups',
            'edit_own_groups',
            'delete_own_groups',
            'manage_group_members',
            
            // Quyền quản trị
            'manage_users',
            'manage_posts',
            'manage_groups',
            'manage_comments',
            'manage_reviews',
            
            // Quyền bán hàng
            'manage_products',
            'manage_orders',
            'manage_inventory',
            'view_sales_reports'
        ];

        foreach ($permissions as $permissionName) {
            // Tạo quyền nếu chưa có
            $permission = Permission::firstOrCreate(['name' => $permissionName]);

            // Gán quyền cho từng role
            if (in_array($permissionName, [
                'view_posts', 'create_posts', 'edit_own_posts', 'delete_own_posts',
                'comment_posts', 'like_posts', 'share_posts',
                'view_groups', 'join_groups'
            ])) {
                $userRole->givePermissionTo($permission);
            }

            if (in_array($permissionName, [
                'view_posts', 'create_posts', 'edit_own_posts', 'delete_own_posts',
                'comment_posts', 'like_posts', 'share_posts',
                'view_groups', 'join_groups', 'create_groups', 'edit_own_groups',
                'delete_own_groups', 'manage_group_members',
                'manage_products', 'manage_orders', 'manage_inventory', 'view_sales_reports'
            ])) {
                $vendorRole->givePermissionTo($permission);
            }

            // Admin có tất cả quyền
            $adminRole->givePermissionTo($permission);
        }

        // Gán vai trò Admin cho user có ID 1
        $user = User::find(1);
        $user?->assignRole($adminRole);
        // Gán vai trò mặc định cho user mới
        $defaultRole = $userRole;
        config(['permission.default_role' => $defaultRole->name]);
    }
}
