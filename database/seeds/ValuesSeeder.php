<?php

use Illuminate\Database\Seeder;

class ValuesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $values = [];
        
        $genworth_price = [
            "name" => "Genworth Semi Private Stay",
            "slug" => "genworth_semi_private_stay",
            "description" => "",
            "value" => 6844
        ];
        $values[] = $genworth_price; 


        $genworth_stay = [
            "name" => "Genworth Average Stay",
            "slug" => "genworth_average_stay",
            "description" => "Value is month",
            "value" => 0
        ];
        $values[] = $genworth_stay; 

        $discount_coverage = [
            "name" => "Brokerage Discount Coverage",
            "slug" => "brokerage_discount_coverage",
            "description" => "",
            "value" => 0
        ];
        $values[] = $discount_coverage;


        $assumed_interest_rate = [
            "name" => "Assumed Interest Rate",
            "slug" => "assumed_interest_rate",
            "description" => "",
            "value" => 0
        ];
        $values[] = $assumed_interest_rate;


        $inflation_rate = [
            "name" => "Inflation Rate",
            "slug" => "inflation_rate",
            "description" => "",
            "value" => 0.025
        ];
        $values[] = $inflation_rate;


        $life_expectancy_addon = [
            "name" => "Life Expectancy Addon",
            "slug" => "life_expectancy_addon",
            "description" => "Life Expectancy Addon",
            "value" => 5
        ];
        $values[] = $life_expectancy_addon;

        $ss_benefit_adjustment = [
            "name" => "Social Security Benefit Adjustment",
            "slug" => "ss_benefit_adjustment",
            "description" => "percentage of social security to be received",
            "value" => 0.8
        ];
        $values[] = $ss_benefit_adjustment;


        $ss_benefit_adjustment_spouse = [
            "name" => "Social Security Benefit Adjustment Spouse",
            "slug" => "ss_benefit_adjustment_spouse",
            "description" => "percentage of social security to be received by spouse",
            "value" => 0.75
        ];
        $values[] = $ss_benefit_adjustment_spouse;

        foreach($values as $value){
            DB::table('values')->insert($value);
        }
        
    }
}
