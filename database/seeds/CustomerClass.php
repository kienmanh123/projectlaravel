<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class CustomerClass extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fake = Faker\Factory::create();
        for ($i=0; $i < 100; $i++) { 
          DB::table('customers')->insert(
            ['name' =>$fake->name,
                'email' =>$fake->unique()->safeEmail,
                'phone'=>$fake->phoneNumber,
                'address' =>$fake->address,
                'note'=>'ahihihihihihi',
          ]);
        }
    }
}
