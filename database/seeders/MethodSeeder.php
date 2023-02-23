<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use DB;
use Hash;


class MethodSeeder extends Seeder
{
    
    public function run()
    {
        DB::table('methods')->insert([
            [
                'module_id' => 2,
                'route_name' => 'user',
                'display_name' => 'List',
                'published' => true,
            ],
            [
                'module_id' => 2,
                'route_name' => 'user-add',
                'display_name' => 'Add',
                'published' => true,
            ],
            [
                'module_id' => 2,
                'route_name' => 'user-edit',
                'display_name' => 'Edit',
                'published' => true,
            ],
            [
                'module_id' => 2,
                'route_name' => 'user-delete',
                'display_name' => 'Delete',
                'published' => false,
            ],
            [
                'module_id' => 4,
                'route_name' => 'role',
                'display_name' => 'List',
                'published' => true,
            ],
            [
                'module_id' => 4,
                'route_name' => 'role-add',
                'display_name' => 'Add',
                'published' => true,
            ],

            [
                'module_id' => 4,
                'route_name' => 'role-edit',
                'display_name' => 'Edit',
                'published' => true,
            ],

            [
                'module_id' => 4,
                'route_name' => 'role-delete',
                'display_name' => 'Delete',
                'published' => true,
            ],

            [
                'module_id' => 6,
                'route_name' => 'invoice',
                'display_name' => 'List',
                'published' => true,
            ],
            [
                'module_id' => 6,
                'route_name' => 'invoice-add',
                'display_name' => 'Add',
                'published' => true,
            ],
            [
                'module_id' => 6,
                'route_name' => 'invoice-edit',
                'display_name' => 'Edit',
                'published' => true,
            ],
            [
                'module_id' => 6,
                'route_name' => 'invoice-delete',
                'display_name' => 'Delete',
                'published' => false,
            ],

            [
                'module_id' => 8,
                'route_name' => 'estimate',
                'display_name' => 'List',
                'published' => true,
            ],
            [
                'module_id' => 8,
                'route_name' => 'estimate-add',
                'display_name' => 'Add',
                'published' => true,
            ],
            [
                'module_id' => 8,
                'route_name' => 'estimate-edit',
                'display_name' => 'Edit',
                'published' => true,
            ],
            [
                'module_id' => 8,
                'route_name' => 'estimate-delete',
                'display_name' => 'Delete',
                'published' => false,
            ],
           
            [
                'module_id' => 10,
                'route_name' => 'seller',
                'display_name' => 'List',
                'published' => true,
            ],
            [
                'module_id' => 10,
                'route_name' => 'seller-add',
                'display_name' => 'Add',
                'published' => true,
            ],
            [
                'module_id' => 10,
                'route_name' => 'seller-edit',
                'display_name' => 'Edit',
                'published' => true,
            ],
            [
                'module_id' => 10,
                'route_name' => 'seller-delete',
                'display_name' => 'Delete',
                'published' => false,
            ],

        ]);
    }
}
