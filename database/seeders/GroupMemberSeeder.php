<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Group;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class GroupMemberSeeder extends Seeder
{
    /**
     * Tạo dữ liệu mẫu thành viên tham gia các nhóm Vangxa
     */
    public function run()
    {
        // Lấy 3 nhóm Vangxa đã tạo
        $groups = Group::where('name', 'like', 'Vangxa%')->get();
        
        if ($groups->isEmpty()) {
            $this->command->error('Không tìm thấy nhóm Vangxa nào. Hãy chạy GroupSeeder trước!');
            return;
        }
        
        // Lấy danh sách người dùng để thêm vào nhóm
        $users = User::inRandomOrder()->limit(50)->get();
        
        $memberCount = 0;
        
        foreach ($groups as $group) {
            // Thêm chủ nhóm vào nhóm với vai trò admin (nếu chưa có)
            if (!$group->isMember($group->owner)) {
                DB::table('group_members')->insert([
                    'group_id' => $group->id,
                    'user_id' => $group->user_id,
                    'role' => 'admin',
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                $memberCount++;
            }
            
            // Số lượng thành viên mỗi nhóm (ngẫu nhiên từ 5-10)
            $membersPerGroup = rand(5, 10);
            
            // Chọn ngẫu nhiên người dùng để thêm vào nhóm
            $groupUsers = $users->random($membersPerGroup);
            
            foreach ($groupUsers as $user) {
                // Bỏ qua nếu là chủ nhóm (đã thêm ở trên)
                if ($user->id == $group->user_id) {
                    continue;
                }
                
                // Kiểm tra xem người dùng đã là thành viên của nhóm chưa
                $existingMember = DB::table('group_members')
                    ->where('group_id', $group->id)
                    ->where('user_id', $user->id)
                    ->exists();
                
                if (!$existingMember) {
                    // Xác định vai trò (chủ yếu là member, đôi khi là moderator)
                    $role = (rand(1, 10) <= 8) ? 'member' : 'moderator';
                    
                    DB::table('group_members')->insert([
                        'group_id' => $group->id,
                        'user_id' => $user->id,
                        'role' => $role,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                    
                    $memberCount++;
                }
            }
            
            // Cập nhật số lượng thành viên trong nhóm
            $actualMemberCount = DB::table('group_members')->where('group_id', $group->id)->count();
            $group->update(['member_count' => $actualMemberCount]);
        }
        
        $this->command->info("Đã thêm {$memberCount} thành viên vào các nhóm Vangxa!");
    }
}
