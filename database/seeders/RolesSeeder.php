<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $roles = [
            ['name' => 'user'],
            ['name' => 'admin'],
            ['name' => 'moder'],
        ];

        foreach ($roles as $role) {
            DB::table('roles')->insert($role);
        }
    }
}
