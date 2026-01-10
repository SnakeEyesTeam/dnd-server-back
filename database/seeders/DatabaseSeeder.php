<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $roles = [
            ['name' => 'user'],
            ['name' => 'admin'],
            ['name' => 'moder'],
        ];

        foreach ($roles as $role) {
            DB::table('roles')->insert($role);
        }

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
            ],
        ];

        foreach ($users as $user) {
            DB::table('users')->insert($user);
        }

        $departaments = [
            ['name' => 'Dnd', 'img' => 'dnd.png'],
            ['name' => 'Web', 'img' => 'dnd.png'],
            ['name' => 'Прочее', 'img' => 'dnd.png'],
        ];

        foreach ($departaments as $departament) {
            DB::table('departaments')->insert($departament);
        }

        $posts = [
            [
                'title' => 'Первый пост',
                'content' => 'Это содержимое первого поста.',
                'tags' => 'тег1, тег2',
                'files' => 'file1.pdf',
                'user_id' => 1,
                'departament_id' => 1,
            ],
            [
                'title' => 'Второй пост',
                'content' => 'Это содержимое второго поста.',
                'tags' => 'тег3',
                'files' => null,
                'user_id' => 2,
                'departament_id' => 2,
            ],
        ];

        foreach ($posts as $post) {
            DB::table('posts')->insert($post);
        }

        $sources = [
            [
                'name'=> 'Кастомный',
            ],
            [
                'name'=> 'Новогодний набор',
            ],
            [
                'name'=> 'Хелуинский набор',
            ],
        ];

        foreach ($sources as $source) {
            DB::table('sources')->insert($source);
        }
    }
}