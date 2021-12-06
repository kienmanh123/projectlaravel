<?php
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Seeder;

class ProductClass extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fake = Faker\Factory::create();

        for ($i=0; $i < 500; $i++) { 
            $name = $fake->name;
            $id = DB::table('product')->insertGetId(
              [   'code' => $this->generateRandomString(),
                  'name' =>$name,
                  'slug'=>Str::slug($name,'-'),
                  'status' => '1',
                  'category_id' =>'1',
                  'number' =>'10',
                  'price'=>'1000000',
                  'status_hight_light'=>'2',
                  'user_id' =>'1'
            ]);
            DB::table('images')->insert([
                [
                    'name' =>'163314.sp.jpg',
                    'product_id' =>$id
                ],
                [
                    'name' =>'163314123314.sp.jpg',
                    'product_id' =>$id
                ],
                [
                    'name' =>'16331121423235.2342344.sp.jpg',
                    'product_id' =>$id
                ]
            ]);
            }
    }
    function generateRandomString($length = 10 ){
        $characters ='0123456789abcdefsjkhuyotgmflxw';
        $charactersLength =strlen($characters);
        $randomString ='';
        for ($i=0; $i < $length ; $i++) { 
            $randomString .=$characters[rand(0,$charactersLength -1)];
        }
        return '#'.strtoupper($randomString);
    }
}
