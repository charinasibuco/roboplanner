<?php
/**
 * Created by PhpStorm.
 * User: Jaime Handayan
 * Date: 7/20/2016
 * Time: 10:56 AM
 */

namespace RoboPlanner\Libraries;
class LifeExpectancy{
    const PATH = '/public/uploads/';
    public function getAllData(){
        /**
         * fetch data from Yahoo!
         * s = stock code
         * f = format
         * e = filetype
         */
        $line_of_text = [];
        $files = base_path() . self::PATH."docs/life_expectancy.csv";
        $file_handle = fopen($files, 'r');
        while (!feof($file_handle) ) {
            $line_of_text[] = fgetcsv($file_handle, 1024);
        }
        fclose($file_handle);
        $table = [];
        foreach($line_of_text as $key => $age_data){
            if($key >= 2 && ($age_data[0] != null)){
                $table[] = [
                    "sex" => "Male",
                    "exact_age" => $age_data[0],
                    "death_probability" => $age_data[1],
                    "number_of_lives" => $age_data[2],
                    "life_expectancy" => $age_data[3]
                ];
                $table[] = [
                    "sex" => "Female",
                    "exact_age" => $age_data[5],
                    "death_probability" => $age_data[6],
                    "number_of_lives" => $age_data[7],
                    "life_expectancy" => $age_data[8]
                ];
            }
        }

        return $table;
    }
}