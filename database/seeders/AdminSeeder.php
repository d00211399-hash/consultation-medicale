<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::firstOrNew(['email' => 'admin2004@gmail.com']);
        $admin->name = 'Admin';
        $admin->password = bcrypt('admin2004');
        $admin->role = 'admin';
        $admin->save();
    }
}
