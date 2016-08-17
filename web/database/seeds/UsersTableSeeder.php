<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();
        DB::statement('ALTER TABLE users AUTO_INCREMENT = 1;');
        DB::table('users')->insert([
            'email' => 'admin@admin.com',
            'password' => bcrypt('200552'),
            'name' => 'Admin',
            'status' => 1
        ]);
    }
}
