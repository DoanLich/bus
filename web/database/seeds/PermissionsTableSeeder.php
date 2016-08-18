<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->delete();
        DB::unprepared('ALTER TABLE permissions AUTO_INCREMENT = 1');

        $permissions = [
            // General
            [
                'id'          => 1,
                'parent_id'   => null,
                'index'       => 'dashboard',
                'name'        => 'Dashboard',
                'description' => 'Access dashboard screen',
                'status'      => true,
                'group'       => null
            ], [
                'id'          => 2,
                'parent_id'   => null,
                'index'       => 'profile',
                'name'        => 'Profile',
                'description' => 'Access profile screen',
                'status'      => true,
                'group'       => null
            ],
            // Permisisons
            [
                'id'          => 3,
                'parent_id'   => null,
                'index'       => 'permissions.list',
                'name'        => 'Permission list',
                'description' => 'Access permission list',
                'status'      => true,
                'group'       => 'permission'
            ], [
                'id'          => 4,
                'parent_id'   => 3,
                'index'       => 'permissions.add',
                'name'        => 'Add permission',
                'description' => 'Add permission',
                'status'      => true,
                'group'       => 'permission'
            ], [
                'id'          => 5,
                'parent_id'   => 3,
                'index'       => 'permissions.edit',
                'name'        => 'Edit permission',
                'description' => 'Edit permission',
                'status'      => true,
                'group'       => 'permission'
            ], [
                'id'          => 6,
                'parent_id'   => 3,
                'index'       => 'permissions.delete',
                'name'        => 'Delete permission',
                'description' => 'Delete permission',
                'status'      => true,
                'group'       => 'permission'
            ], [
                'id'          => 7,
                'parent_id'   => 3,
                'index'       => 'permissions.view',
                'name'        => 'View permission detail',
                'description' => 'View permission detail',
                'status'      => true,
                'group'       => 'permission'
            ],
            // Roles
            [
                'id'          => 8,
                'parent_id'   => null,
                'index'       => 'roles.list',
                'name'        => 'Role list',
                'description' => 'Access role list',
                'status'      => true,
                'group'       => 'role'
            ], [
                'id'          => 9,
                'parent_id'   => 8,
                'index'       => 'roles.add',
                'name'        => 'Add role',
                'description' => 'Add role',
                'status'      => true,
                'group'       => 'role'
            ], [
                'id'          => 10,
                'parent_id'   => 8,
                'index'       => 'roles.edit',
                'name'        => 'Edit role',
                'description' => 'Edit role',
                'status'      => true,
                'group'       => 'role'
            ], [
                'id'          => 11,
                'parent_id'   => 8,
                'index'       => 'roles.delete',
                'name'        => 'Delete role',
                'description' => 'Delete role',
                'status'      => true,
                'group'       => 'role'
            ], [
                'id'          => 12,
                'parent_id'   => 8,
                'index'       => 'roles.view',
                'name'        => 'View role detail',
                'description' => 'View role detail',
                'status'      => true,
                'group'       => 'role'
            ],
            // Admin users
            [
                'id'          => 13,
                'parent_id'   => null,
                'index'       => 'admin_users.list',
                'name'        => 'Admin user list',
                'description' => 'Access admin user list',
                'status'      => true,
                'group'       => 'admin_user'
            ], [
                'id'          => 14,
                'parent_id'   => 13,
                'index'       => 'admin_users.add',
                'name'        => 'Add admin user',
                'description' => 'Add admin user',
                'status'      => true,
                'group'       => 'admin_user'
            ], [
                'id'          => 15,
                'parent_id'   => 13,
                'index'       => 'admin_users.edit',
                'name'        => 'Edit admin user',
                'description' => 'Edit admin user',
                'status'      => true,
                'group'       => 'admin_user'
            ], [
                'id'          => 16,
                'parent_id'   => 13,
                'index'       => 'admin_users.delete',
                'name'        => 'Delete admin user',
                'description' => 'Delete admin user',
                'status'      => true,
                'group'       => 'admin_user'
            ], [
                'id'          => 17,
                'parent_id'   => 13,
                'index'       => 'admin_users.view',
                'name'        => 'View admin user detail',
                'description' => 'View admin user detail',
                'status'      => true,
                'group'       => 'admin_user'
            ],
            // Location
            [
                'id'          => 18,
                'parent_id'   => null,
                'index'       => 'locations.list',
                'name'        => 'Location list',
                'description' => 'Access location list',
                'status'      => true,
                'group'       => 'location'
            ], [
                'id'          => 19,
                'parent_id'   => 18,
                'index'       => 'locations.add',
                'name'        => 'Add location',
                'description' => 'Add location',
                'status'      => true,
                'group'       => 'location'
            ], [
                'id'          => 20,
                'parent_id'   => 18,
                'index'       => 'locations.edit',
                'name'        => 'Edit location',
                'description' => 'Edit location',
                'status'      => true,
                'group'       => 'location'
            ], [
                'id'          => 21,
                'parent_id'   => 18,
                'index'       => 'locations.delete',
                'name'        => 'Delete location',
                'description' => 'Delete location',
                'status'      => true,
                'group'       => 'location'
            ], [
                'id'          => 22,
                'parent_id'   => 18,
                'index'       => 'locations.view',
                'name'        => 'View location detail',
                'description' => 'View location detail',
                'status'      => true,
                'group'       => 'location'
            ]
        ];

        DB::table('permissions')->insert($permissions);
    }
}
