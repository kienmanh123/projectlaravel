<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Hash;
class UserClass extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fake = Faker\Factory::create();
        DB::table('users')->insert(
            [
                'name' =>$fake->name,
                'email' => 'user1@admin.com',
                'email_verified_at' =>now(),
                'date_of_birth' => '1999-03-03',
                'password' => Hash::make('1233445'),
                'gender' =>'1',
                'number_phone'=>'08065366687',
                'address' =>$fake->address,
                'role' =>'2',

            ]
            );
    }
}
