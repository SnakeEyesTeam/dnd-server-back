<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
                'id_role' => 1
            ],
            [
                'name' => 'Sanek1',
                'email' => 'jopan1.19@mail.ru',
                'password' => Hash::make('11111111D'),
                'id_role' => 2
            ],
            [
                'name' => 'Sanek2',
                'email' => 'jopan2.19@mail.ru',
                'password' => Hash::make('11111111D'),
                'id_role' => 3
            ]
        ];

        foreach ($users as $user) {
            DB::table('users')->insert($user);
        }
    }
}
