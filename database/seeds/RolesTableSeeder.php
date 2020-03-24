<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_roles')->insert([
            [
                'role_id' => 1,
                'name'=>'Administrator'
            ],
            [
                'role_id' => 2,
                'name'=>'Mechanic'
            ],
            [
                'role_id' => 3,
                'name'=>'User'
            ]
        ]);
    }
}
