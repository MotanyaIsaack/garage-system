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
        DB::table('tbl_users')->insert([
            [
                'user_id' => 1,
                'name'=>'Administrator',
                'email'=>'admin@gmail.com',
                'password'=>'$2y$12$rGLpOaLDdbddLlcB9oGaY.k8/Xm6VPr80FgZkemvw4jU7AUtMnbBu',
                'role_id'=>'1',
            ]
        ]);
    }
}
