<?php

use Illuminate\Database\Seeder;
use RoboPlanner\Libraries\Csv;
//use App\Setting;

class SymbolFlagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $computations = new Csv();
        $data = DB::table("settings")->get();
        foreach ($data as $row) {
            /**==========================
             *  The additional conditions are their to find a bug.
            ======================**/
            $ticker = str_replace("#","",$row->name);
            $type = (strlen($ticker) < 5)?"Stock":"Mutual Fund";
            $description = $type.' '.$ticker.' is not diversified';
            DB::table("flag")->insert([
                'color' 	=> '1',
                'description' 	=> $description,
                'range'			=> (DB::table('flag')->count())+1,
                'wealth_score' => 'Investments'
            ]);
        }
    }
}
