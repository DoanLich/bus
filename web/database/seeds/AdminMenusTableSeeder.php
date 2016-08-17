<?php

use Illuminate\Database\Seeder;

class AdminMenusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admin_menus')->delete();
        DB::unprepared('ALTER TABLE admin_menus AUTO_INCREMENT = 1');

        $menus = [
            [
                'id'            => 1,
                'index'         => 'home',
                'permission_id' => 1,
                'name'          => 'Dashboard',
                'icon'          => 'tachometer',
                'route'         => 'admin.home',
                'level'         => 1,
                'parent_id'     => null,
                'order'         => 1
            ],
            [
                'id'            => 2,
                'index'         => 'permissions',
                'permission_id' => null,
                'name'          => 'Permission management',
                'icon'          => 'rocket',
                'route'         => null,
                'level'         => 1,
                'parent_id'     => null,
                'order'         => 2
            ],
            [
                'id'            => 3,
                'index'         => 'permissions.list',
                'permission_id' => 3,
                'name'          => 'Permission list',
                'icon'          => 'list',
                'route'         => 'admin.permissions.index',
                'level'         => 2,
                'parent_id'     => 2,
                'order'         => 1
            ],
            [
                'id'            => 4,
                'index'         => 'permissions.add',
                'permission_id' => 4,
                'name'          => 'Add permisison',
                'icon'          => 'plus',
                'route'         => 'admin.permissions.add',
                'level'         => 2,
                'parent_id'     => 2,
                'order'         => 2
            ],
            [
                'id'            => 5,
                'index'         => 'roles',
                'permission_id' => null,
                'name'          => 'Role management',
                'icon'          => 'user-secret',
                'route'         => null,
                'level'         => 1,
                'parent_id'     => null,
                'order'         => 3
            ],
            [
                'id'            => 6,
                'index'         => 'roles.list',
                'permission_id' => 8,
                'name'          => 'Role list',
                'icon'          => 'list',
                'route'         => 'admin.roles.index',
                'level'         => 2,
                'parent_id'     => 5,
                'order'         => 1
            ],
            [
                'id'            => 7,
                'index'         => 'roles.add',
                'permission_id' => 9,
                'name'          => 'Add role',
                'icon'          => 'plus',
                'route'         => 'admin.roles.add',
                'level'         => 2,
                'parent_id'     => 5,
                'order'         => 2
            ],
            [
                'id'            => 8,
                'index'         => 'admin_users',
                'permission_id' => null,
                'name'          => 'Admin user management',
                'icon'          => 'user-md',
                'route'         => null,
                'level'         => 1,
                'parent_id'     => null,
                'order'         => 4
            ],
            [
                'id'            => 9,
                'index'         => 'admin_users.list',
                'permission_id' => 13,
                'name'          => 'Admin user list',
                'icon'          => 'list',
                'route'         => 'admin.admin_users.index',
                'level'         => 2,
                'parent_id'     => 8,
                'order'         => 1
            ],
            [
                'id'            => 10,
                'index'         => 'admin_users.add',
                'permission_id' => 14,
                'name'          => 'Add admin user',
                'icon'          => 'plus',
                'route'         => 'admin.admin_users.add',
                'level'         => 2,
                'parent_id'     => 8,
                'order'         => 2
            ],
        ];

        DB::table('admin_menus')->insert($menus);
    }
}
