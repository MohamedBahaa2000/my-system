<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Group;
use App\Models\Permission;


class AttachAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', 'admin2@example.com')->first();
        $group = Group::firstOrCreate(['name' => 'Admin'], ['description' => 'Full Admin Group']);

        // اربط كل الصلاحيات بالجروب
        $group->permissions()->sync(Permission::pluck('id')->toArray());

        // اربط اليوزر بالجروب
        $user->groups()->sync([$group->id]);
    }
}
