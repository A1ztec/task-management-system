<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class Userseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('users')->delete();
        $data = json_decode(file_get_contents(database_path() . '/data/users.json'), true);

        foreach ($data['users'] as $user) {
            $user['password'] = bcrypt('password');
            $user['email_verified_at'] = now();
            User::create($user);
        }
    }
}
