<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insert role
        DB::table('roles')->delete();
        DB::unprepared('ALTER TABLE roles AUTO_INCREMENT = 1');

        $roles = [
            [
                'id'          => 1,
                'name'        => 'Admin',
                'description' => '',
                'status'      => true,
                'system'      => true
            ]
        ];

        DB::table('roles')->insert($roles);

        // Insert role permission
        DB::table('role_permissions')->delete();
        DB::unprepared('ALTER TABLE role_permissions AUTO_INCREMENT = 1');

        $systemRoles = DB::table('roles')->where('system', true)->get();

        if(!empty($systemRoles)) {
            foreach ($systemRoles as $role) {
                $permissions = DB::table('permissions')->lists('id');
                if(!empty($permissions)) {
                    foreach ($permissions as $permissionID) {
                        DB::table('role_permissions')->insert([
                            'role_id'       => $role->id,
                            'permission_id' => $permissionID
                        ]);
                    }
                }
            }
        }
    }
}
