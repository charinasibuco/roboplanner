<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 6/14/2016
 * Time: 11:36 AM
 */

namespace RoboPlanner\Repositories;

class RetirementPlanRepository extends Repository
{

    protected $listener;

    public function model()
    {
        // TODO: Implement model() method.
        return 'App\Investment';
    }

    public function setListener($listener){
        $this->listener = $listener;
    }

    public function unmask($number){
        $characters = ['$',','];
        foreach($characters as $row){
            $number = str_replace($row,"",$number);
        }
        return $number;
    }
    public function getAttributeNames($object){
        $attributes = get_object_vars($object);
        $data = [];
        foreach($attributes as $key => $value){
            if(is_object($value)){
                $value = get_object_vars($value);
                foreach($value as $subkey => $subvalue){
                    $data[] = $key."_".$subkey;
                }
            }else{
                $data[] = $key;
            }

        }
        return $data;
    }

    public function results($plan){

        $min_husband_age = 0;
        $max_husband_age = 0;
        $min_wife_age = 0;
        $max_wife_age = 0;

        $data = [];

        $data['categories'] = [];
        
        $wife_ages = [];
        $husband_ages = [];
        $tallied_ages = [];

        $data['series'] = [];

        if(!empty($plan)){
             $min_husband_age = $plan[0]->husband_age;
            $max_husband_age = $min_husband_age+count($plan);
            $min_wife_age = (isset($plan[0]->wife_age)) ? $plan[0]->wife_age : 0;
            $max_wife_age = 0;
            if(isset($plan[0]->wife_age)){
                $max_wife_age = ($min_wife_age > 0)?$min_wife_age+count($plan):0;
            }
             $max_chosen_age = $max_husband_age;
            $min_chosen_age = $min_husband_age;

            
            if($min_wife_age != "" || $min_wife_age != 0){
                $max_chosen_age = ($max_husband_age > $max_wife_age)?$max_husband_age:$max_wife_age;
                $min_chosen_age = ($min_husband_age < $min_wife_age)?$min_husband_age:$min_wife_age;

                for($z = $min_wife_age; $z <= $max_wife_age; $z++){
                    $wife_ages[] = $z;
                }
            }
            for($y = $min_husband_age; $y <= $max_husband_age; $y++){
                $husband_ages[] = $y;
            }

            for($x = $min_chosen_age; $x <= $max_chosen_age; $x++){
                $tallied_ages[] = $x;
            }
            
            foreach($tallied_ages as $key => $age){
                $data['categories'][] = ['name' => (isset($husband_ages[$key])?$husband_ages[$key]:''),
                    'categories' => [(isset($wife_ages[$key])?$wife_ages[$key]:'')]
                ];
            }
             $variables = $this->getAttributeNames($plan[0]);
            foreach($variables as $variable){
                $series_data = [];
                foreach($plan as $row){
                    $income = (array) $row;
                    foreach($income as $key => $value){
                        if(is_object($value)){
                            $value = (array) $value;
                            foreach($value as $subkey => $subvalue){
                                $income[$key."_".$subkey] = $subvalue;
                            }
                            unset($income[$key]);
                        }
                    }
                    $series_data[] = $this->unmask($income[$variable]);
                };
                $type = "column";
                if($variable == "pre_tax_target"){
                    $type = "line";
                }
                $data['series'][] = ['name' => $variable,'type' => $type,'data' => $series_data];
                foreach($data['series'] as $key => $row){
                    if($row['name'] == "year" || $row['name'] == "husband_age" || $row['name'] == "wife_age" || $row['name'] == "income_goal"){
                        unset($data['series'][$key]);
                    }
                }
            }
        }
        return $data;

    }

    public function getIllustrativeTable(){

    }

    public function create(){

    }

    public function edit($id)
    {
        // TODO: Implement edit() method.
    }

    public function destroy($id){

    }
}