<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use DB;
use Hash;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            [
                'name' => 'Admin',
                'slug' => 'admin',
                'permissions' => json_encode([
                    'user' => true,
                    'user-add' => true,
                    'user-edit' => true,
                    'user-delete' => true,

                    'role' => true,
                    'role-add' => true,
                    'role-edit' => true,
                    'role-delete' => true,
                    'role-permissions' => true,

                    'invoice' => true,
                    'invoice-add' => true,
                    'invoice-edit' => true,
                    'invoice-delete' => true,

                    'estimate' => true,
                    'estimate-add' => true,
                    'estimate-edit' => true,
                    'estimate-delete' => true,


                    'seller' => true,
                    'seller-add' => true,
                    'seller-edit' => true,
                    'seller-delete' => true,

                    
                ]),
            ],
            [
                'name' => 'Tathasthu technology',
                'slug' => 'Tathasthu technology',
                'permissions' => json_encode([

                ]),
            ],
            [
                'name' => 'Tathasthu BMI',
                'slug' => 'Tathasthu BMI',
                'permissions' => json_encode([

                ]),
            ],
            
            

        ]);
    }
}
