<?php

use Illuminate\Database\Seeder;
class InvestmentSeeder extends Seeder
{

    public function run()
    {
        /**
         * Run the database seeds.
         *
         * @return void
         */
        $data = [];
        $data["x_axis_min"] = 31;
        $data["x_axis_max"] = 100;
        //$data["series"] = [];
       /* $data["type"] = $type;*/

        /**
         * constants
         */
        $inflation = .03;
        //$type = is_null($type)?"":$type;


        /**
         * Income Goal Series
         */
        $income_goal = [];
        $income_goal['data'] = [];
        //$income_goal->type = $type;
        $income_goal['name'] = "Income Goal - Husband";
        $income_goal['point_start'] = 31;
        $income_goal['initial'] = 100000;
        $income_goal['current'] = $income_goal['initial'];
        for($x=$income_goal['point_start'];$x<=$data["x_axis_max"];$x++) {
            $income_goal['current'] = ($income_goal['current']*(1+$inflation));
            $income_goal['data'][$x] = round($income_goal['current'],2);
        }

        /**
         * Income Goal Wife Series
         */
        $income_goal_wife =  [];
        $income_goal_wife['data'] = [];
        $income_goal_wife['name'] = "Income Goal - Wife";
        //$income_goal_wife->type = $type;
        $income_goal_wife['point_start'] = 29;
        $income_goal_wife['initial'] = 100000;
        $income_goal_wife['current'] = $income_goal['initial'];
        for($x=$income_goal_wife['point_start'];$x<=$data["x_axis_max"];$x++) {
            $income_goal_wife['current'] = ($income_goal_wife['current']*(1+$inflation));
            $income_goal_wife['data'][$x] = round($income_goal_wife['current'],2);
        }


        /**
         * Rental Series
         */
        $rental =  [];
        $rental['data'] = [];
        $rental['name'] = "Rental";
        //$rental->type = $type;
        $rental['point_start'] = 31;
        $rental['initial'] = 7500;
        $rental['current'] = $rental['initial'];
        for($x=$rental['point_start'];$x<=$data["x_axis_max"];$x++) {
            $rental['current'] = ($x==$rental['point_start'])?$rental['initial']:(($rental['current']*$inflation)+$rental['current']);
            $rental['data'][$x] = round($rental['current'],2);
        }

        /**
         * Wife 401(k)
         */
        $wife401k =  [];
        $wife401k['data'] = [];
        $wife401k['name'] = "Wife 401(k)";
        //$wife401k->type = $type;
        $wife401k['point_start'] = 31;
        $wife401k['initial'] = 10000;
        $wife401k['current'] = $wife401k['initial'];
        for($x=$wife401k['point_start'];$x<=$data["x_axis_max"];$x++) {
            if($x>=61){
                if($x <= 66 || $x >= 72){
                    $wife401k['data'][$x] = 0;
                }else if($x==67){
                    $wife401k['data'][$x] = -263532.44;
                }else if($x==68){
                    $wife401k['data'][$x] = -287489.15;
                }else if($x==69){
                    $wife401k['data'][$x] = -296041.82;
                }else if($x==70){
                    $wife401k['data'][$x] = -220622.33;
                }else if($x==71){
                    $wife401k['data'][$x] = -204820.7;
                }
            }else{
                $wife401k['data'][$x] = $wife401k['current'];
            }
        }


        /**
         * Husband 401(k)
         */
        $husband401k =  [];
        $husband401k['data'] = [];
        $husband401k['name'] = "Husband 401(k)";
        //$husband401k->type = $type;
        $husband401k['point_start'] = 31;
        $husband401k['initial'] = 13500;
        $husband401k['current'] = $husband401k['initial'];
        for($x=$husband401k['point_start'];$x<=$data["x_axis_max"];$x++) {
            if($x>=61){
                if($x >= 68){
                    $husband401k['data'][$x] = 0;
                }else if($x==61){
                    $husband401k['data'][$x] = -231803.57;
                }else if($x==62){
                    $husband401k['data'][$x] = -238757.67;
                }else if($x==63){
                    $husband401k['data'][$x] = -248320.4;
                }else if($x==64){
                    $husband401k['data'][$x] = -255698.02;
                }else if($x==65){
                    $husband401k['data'][$x] = -263296.96;
                }else if($x==66){
                    $husband401k['data'][$x] = -271123.86;
                }else if($x==67){
                    $husband401k['data'][$x] = -15653.14;
                }
            }else{
                $husband401k['data'][$x] = $husband401k['current'];
            }
        }


        /**
         * Husband IRA series
         */
        $husband_ira = [];
        $husband_ira['name'] = "Husband IRA";
        $husband_ira['data'] = [];
        //$husband_ira->type = $type;
        $husband_ira['point_start'] = 29;
        $husband_ira['initial'] = 2400;
        $husband_ira['current'] = $husband_ira['initial'];
        for($x=$husband_ira['point_start'];$x<=$data["x_axis_max"];$x++) {
            if (($x >= 29 && $x <= 30) || ($x >= 61 && $x <= 70) || $x >= 72){
                $husband_ira['data'][$x] = 0;
            }else if($x >= 31 && $x <= 60){
                $husband_ira['data'][$x] = round($husband_ira['initial'],2);
            }else if($x == 71){
                $husband_ira['data'][$x] = -22348.3;
            }
        }

        /**
         * Social Security 1 series
         */
        $social_security1 = [];
        $social_security1['name'] = "Social Security 1";
        $social_security1['data'] = [];
        //$social_security1->type = $type;
        $social_security1['point_start'] = 61;
        $social_security1['initial'] = -112305*0.75;
        $social_security1['current'] = $social_security1['initial'];
        for($x=$social_security1['point_start'];$x<=$data["x_axis_max"];$x++) {
            if($x == 70){
                $social_security1['data'][$x] = $social_security1['current'];
            }else if($x >= 71){
                $social_security1['current'] = (($social_security1['current']*$inflation)+$social_security1['current']);
                $social_security1['data'][$x] = round($social_security1['current'],2);
            }else{
                $social_security1['data'][$x] = 0;
            }
        }


        /**
         * Social Security 2 series
         */
        $social_security2 = [];
        $social_security2['name'] = "Social Security 2";
        $social_security2['data'] = [];
        //$social_security2->type = $type;
        $social_security2['point_start'] = 61;
        $social_security2['initial'] = -141717.98*0.75;
        $social_security2['current'] = $social_security2['initial'];
        for($x=$social_security2['point_start'];$x<=$data["x_axis_max"];$x++) {
            if ($x == 72) {
                $social_security2['data'][$x] = $social_security2['current'];
            } else if ($x >= 73) {
                $social_security2['current'] = (($social_security2['current'] * $inflation) + $social_security2['current']);
                $social_security2['data'][$x] = round($social_security2['current'], 2);
            } else {
                $social_security2['data'][$x] = 0;
            }
        }

        /**
         * Wife Roth series
         */
        $wife_roth = [];
        $wife_roth['name'] = "Wife Roth";
        $wife_roth['data'] = [];
        //$wife_roth->type = $type;
        $wife_roth['point_start'] = 32;
        $wife_roth['initial'] = 5500;
        $wife_roth['current'] = $wife_roth['initial'];
        for($x=$wife_roth['point_start'];$x<=$data["x_axis_max"];$x++) {
            if($x>=61){
                if($x >= 32 && $x <= 60) {
                    $wife_roth['data'][$x] = $wife_roth['current'];
                }else if($x==72){
                    $wife_roth['data'][$x] = -127623.58;
                }else if($x==73){
                    $wife_roth['data'][$x] = -131380.29;
                }else if($x==74){
                    $wife_roth['data'][$x] = -135249.7;
                }else if($x==75){
                    $wife_roth['data'][$x] = -139235.19;
                }else if($x==76){
                    $wife_roth['data'][$x] = -143340.24;
                }else if($x==77){
                    $wife_roth['data'][$x] = -147568.45;
                }else if($x==78){
                    $wife_roth['data'][$x] = -151923.51;
                }else if($x==79){
                    $wife_roth['data'][$x] = -156409.21;
                } else if($x==80){
                    $wife_roth['data'][$x] = -161029.49;
                }else if($x==81){
                    $wife_roth['data'][$x] = -66554.18;
                }
            }else{
                $wife_roth['data'][$x] = 0;
            }
        }


        /**
         * Total Income series
         */
        $total_income = [];
        $total_income['name'] = "Total Income";
        //$total_income->type = $type;
        $total_income['data'] = [];
        $total_income['point_start'] = 61;
        for($x=$total_income['point_start'];$x<=$data["x_axis_max"];$x++) {
            $total_income['data'][$x] = $rental['data'][$x] - $wife401k['data'][$x] - $husband_ira['data'][$x-32] - $social_security1['data'][$x] - $social_security2['data'][$x] - $husband401k['data'][$x];
            if($x >= 71){
                $total_income['data'][$x] = $total_income['data'][$x] - $husband_ira['data'][$x] - @$wife_roth['data'][$x];
            }
        }



        $income_goal['data'] = serialize($income_goal['data']);
        $income_goal_wife['data'] = serialize($income_goal_wife['data']);
        $rental['data'] = serialize($rental['data']);
        $wife401k['data'] = serialize($wife401k['data']);
        $husband401k['data'] = serialize($husband401k['data']);
        $husband_ira['data'] = serialize($husband_ira['data']);
        $social_security1['data'] = serialize($social_security1['data']);
        $social_security2['data'] = serialize($social_security2['data']);
        $wife_roth['data'] = serialize($wife_roth['data']);
        $total_income['data'] = serialize($total_income['data']);

        //dd($income_goal);
        DB::table('investments')->insert([$income_goal]);
        DB::table('investments')->insert([$income_goal_wife]);
        DB::table('investments')->insert([$rental]);
        DB::table('investments')->insert([$wife401k]);
        DB::table('investments')->insert([$husband401k]);
        DB::table('investments')->insert([$husband_ira]);
        DB::table('investments')->insert([$social_security1]);
        DB::table('investments')->insert([$social_security2]);
        DB::table('investments')->insert([$wife_roth]);
        DB::table('investments')->insert([$total_income]);


        //$data["y_axis_min"] = $income_goal['initial'];
        //$data["y_axis_max"] = $income_goal['current'];

        /*if($type == "area"){
            //$data['series'][] = $rental;


            $data['series'][] = $husband_ira;
            $data['series'][] = $husband401k;


            $data['series'][] = $wife_roth;

            $data['series'][] = $rental;

            $data['series'][] = $social_security1;
            $data['series'][] = $social_security2;

            $data['series'][] = $wife401k;

            $total_income->type = "";
            $data['series'][] = $total_income;

            $data["x_axis_min"] = 61;
            $data["y_axis_min"] = 0;
            $data["y_axis_max"] = $total_income['data'][100];
        }else{
            $data['series'][] = $income_goal;
            $data['series'][] = $income_goal_wife;
            $data['series'][] = $total_income;
        }*/

    }
}
