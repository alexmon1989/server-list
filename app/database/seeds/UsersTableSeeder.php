<?php

class UsersTableSeeder extends Seeder {

    public function run()
    {
        DB::table('users')->delete();
        
        DB::table('users')->insert(
            array(
                array(
                    'email' => 'a.monastyretsky@uipv.org',
                    'password' => Hash::make('admin1234'),
                    'username' => 'admin',
                    'created_at' => date('Y-m-d H:i:s'), 
                    'updated_at' => date('Y-m-d H:i:s')
                ),
            )
        );        
    }
}