<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Group;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class InitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // ✅ إنشاء صلاحيات افتراضية
        $permissions = [
            'view_users','create_users','edit_users','delete_users','assign_roles',
            'view_groups','create_groups','edit_groups','delete_groups','assign_permissions',
            'view_permissions','create_permissions','edit_permissions','delete_permissions',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm], [
                'description' => ucfirst(str_replace('_', ' ', $perm))
            ]);
        }

        // ✅ إنشاء جروب Admin
        $adminGroup = Group::firstOrCreate(
            ['name' => 'Admin'],
            ['description' => 'Full access admin group']
        );

        // ✅ ربط كل الصلاحيات بالجروب
        $adminGroup->permissions()->sync(Permission::pluck('id')->toArray());

        // ✅ إنشاء يوزر أدمن
        $adminUser = User::firstOrCreate(
            ['email' => 'admin2@example.com'],
            [
                'name' => 'Admin',
                'phone' => '01000000000',
                'password' => Hash::make('123456'),
                'role' => 'admin',
            ]
        );

        // ✅ ربط اليوزر بالجروب
        $adminUser->groups()->sync([$adminGroup->id]);
    }
    
}
