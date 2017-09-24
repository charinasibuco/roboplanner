<?php

use Illuminate\Database\Seeder;
use RoboPlanner\Libraries\Csv;
//use App\Setting;

class ComputationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $computations = new Csv();
        $data = $computations->getAllData();
        foreach ($data as $row) {
            /**==========================
             *  The additional conditions are their to find a bug.
             ======================**/
            DB::table("settings")->insert([
                "name" => $row["name"],
                "geometric_return" => $row["geometric_return"],
                "max_drawdown" => $row["max_drawdown"],
                "absolute_value" => $row["absolute_value"],
                "standard_deviation" => $row["standard_deviation"],
                "annual_return_rate" => $row["annual_return_rate"],
            ]);
            /*$setting = new Setting;
            $setting->name = $row["name"];
            $setting->geometric_return = $row["geometric_return"];
            $setting->max_drawdown = $row["max_drawdown"];
            $setting->absolute_value = $row["absolute_value"];
            $setting->annual_return_rate = $row["annual_return_rate"];
            $setting->save();*/

        }

    }
}
