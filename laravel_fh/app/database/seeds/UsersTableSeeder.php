<?php

class UsersTableSeeder extends Seeder {

    public function run()
    {
        # DB::table('users')->truncate();

        $users = [
            [
                'username' => 'msurguy',
                'email'    => 'user1@example.com',
                'password' => Hash::make('password'),
                'is_online' => '0',
                'is_admin' => '1'
            ],
            [
                'username' => 'stidges',
                'email'    => 'user2@example.com',
                'password' => Hash::make('password'),
                'is_admin' => '1',
                'is_online' => '0',
            ],
            [
            	'username' => 'demo',
            	'email'    => 'demo@example.com',
            	'password' => Hash::make('demo'),
            	'is_admin' => '1',
            	'is_online' => '0',
            ]
        ];

        DB::table('users')->insert($users);
    }

}
