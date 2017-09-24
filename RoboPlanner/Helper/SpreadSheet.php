<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 7/6/2016
 * Time: 10:38 AM
 */

namespace RoboPlanner\Helper;


class SpreadSheet
{
    protected $key;

    public function __construct($key = '1pl_sk67V9CgfNgf0TtJ3W256H8FwsgkzRnjh9zDF1m4')
    {
        $this->key = $key;
    }

    public function createSpreaSheet(){
        // Arrays we'll use later
        $keys               = [];
        $newArray           = [];
        $tLabels            = [];
        $feed               = 'https://docs.google.com/spreadsheets/d/' . $this->key . '/pub?output=csv';
        // Do it
        $data               = $this->csvToArray($feed, ',');

        // Set number of elements (minus 1 because we shift off the first row)
        $count              = count($data) - 1;

        //Use first row for names
        $labels             = array_shift($data);

        foreach ($labels as $label) {
            $keys[]         = str_replace(' ', '-', $label);
        }

        foreach($keys as $key){
            $tLabels[]      = ucfirst(str_replace('-', ' ', $key));
        }
        // Add Ids, just in case we want them later
        $keys[]             = 'id';

        for ($i = 0; $i < $count; $i++) {
            $data[$i][]     = $i;
        }

        // Bring it all together
        for ($j = 0; $j < $count; $j++) {
//            $d               = array_combine($keys, $data[$j]);
            $d               = $data[$j];
            $newArray[$j]   = $d;
        }

        return ['labels' => $tLabels, 'values' => $newArray];
    }

    public function csvToArray($file, $delimiter) {
        if (($handle = fopen($file, 'r')) !== FALSE) {
            $i = 0;
            while (($lineArray = fgetcsv($handle, 4000, $delimiter, '"')) !== FALSE) {
                for ($j = 0; $j < count($lineArray); $j++) {
                    $arr[$i][$j] = $lineArray[$j];
                }
                $i++;
            }
            fclose($handle);
        }
        return $arr;
    }
}