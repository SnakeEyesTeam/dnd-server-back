<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $users = [
            [
                'name' => 'Sanek',
                'email' => 'jopan.19@mail.ru',
                'password' => Hash::make('11111111D'),
                'role_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Sanek1',
                'email' => 'jopan1.19@mail.ru',
                'password' => Hash::make('11111111D'),
                'role_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Sanek2',
                'email' => 'jopan2.19@mail.ru',
                'password' => Hash::make('11111111D'),
                'role_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ];

        foreach ($users as $user) {
            DB::table('users')->insert($user);
        }
    }
}
