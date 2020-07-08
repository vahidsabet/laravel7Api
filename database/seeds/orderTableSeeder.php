<?php

use App\Orders;
use Illuminate\Database\Seeder;

class orderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Orders::truncate();

        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 50; $i++) {
            Orders::create([
                'orderNo' => $faker->numberBetween($min = 10000, $max = 99000),
                'tel' => $faker->phoneNumber,
                'cName' => $faker->name
                
            ]);
        }
        //
    }
}
