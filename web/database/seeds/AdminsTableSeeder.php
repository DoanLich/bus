<?php

use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->delete();
        DB::statement('ALTER TABLE admins AUTO_INCREMENT = 1;');
        DB::table('admins')->insert([
            'email'    => 'admin@admin.com',
            'password' => bcrypt('200552'),
            'name'     => 'Admin',
            'status'   => 1
        ]);

        $systemRoles = DB::table('roles')->where('system', true)->get();

        if(!empty($systemRoles)) {
            foreach ($systemRoles as $role) {
                DB::table('user_roles')->insert([
                    'user_id'       => 1,
                    'role_id' => $role->id
                ]);
            }
        }
    }
}
