<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use DB;
use Hash;


class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('modules')->insert([
            [
                'name' => 'User',
                'parent' => 0,
            ],
            [
                'name' => 'User',
                'parent' => 1,
            ],
            [
                'name' => 'Role',
                'parent' => 0,
            ],
  
            [
                'name' => 'Role',
                'parent' => 3,
            ],
            [
                'name' => 'Invoices',
                'parent' => 0,
            ],
            [
                'name' => 'Invoices',
                'parent' => 5,
            ],
            [
                'name' => 'Estimates',
                'parent' => 0,
            ],
            [
                'name' => 'Estimates',
                'parent' => 7,
            ],
            [
                'name' => 'Seller',
                'parent' => 0,
            ],
            [
                'name' => 'Seller',
                'parent' => 9,
            ],
        ]);
    }
}
