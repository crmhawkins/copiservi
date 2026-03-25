<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('admins')->updateOrInsert(
            ['id' => 1],
            ['usuario' => 'Copiservi', 'password' => md5('123456'), 'nivel' => 1]
        );

        DB::table('admins')->updateOrInsert(
            ['id' => 99],
            ['usuario' => 'admin', 'password' => Hash::make('admin'), 'nivel' => 1]
        );
    }
}
