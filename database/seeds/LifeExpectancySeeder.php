<?php

use Illuminate\Database\Seeder;
use RoboPlanner\Libraries\LifeExpectancy;

class LifeExpectancySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = new LifeExpectancy();
        foreach($table->getAllData() as $data){
            DB::table("life_expectancy")->insert($data);
        }
    }
}
