<?php
/**
 * Created by PhpStorm.
 * User: Jaime Handayan
 * Date: 7/20/2016
 * Time: 10:56 AM
 */

namespace RoboPlanner\Libraries;
use RoboPlanner\Repositories\SettingRepository;
use App\Setting;
use App\Investment;

class Csv
{
    const PATH = '/public/uploads/';
    const YEAR_LIMIT = 10;
    const INFLATION = .03;
    const MAR = .04;
    const DATE_INDEX = 2; // 2 for the csv files
    const CLOSE_INDEX = 7;// 7 for the csv files
    const SYMBOL_INDEX = 0;

    protected $attributes;
    protected $labels;
    protected $maxDrawdown;
    protected $standardDeviation;
    protected $geometricReturn;
    protected $inflationRate;
    protected $growthRate;
    protected $data;

    private $csv;
    private $file_;
    private $settings;


    public function __construct()
    {
        if(!Setting::count() > 0){
            $this->getAllData();
        }
    }

    public function setInflationRate()
    {

    }

    public function getPath()
    {
        return self::PATH;
    }

    public function getBase()
    {
        return base_path();
    }

    public function getFullPath()
    {
        return $this->getBase() . self::getPath();
    }

    public function getCsv()
    {

    }

    public function getAllData(){
        /**
         * fetch data from Yahoo!
         * s = stock code
         * f = format
         * e = filetype
         */
        $files = glob(base_path() . self::PATH."docs/csvfiles/*");
        //$csv = 0;
        $symbols = [];
        foreach($files as $file){
            //$csv++;
            if (($handle = fopen($file, 'r')) !== FALSE) {
                $ctr = 0;
                $yrs = [];
                $keyTemp = '';
                $excelData = \PHPExcel_IOFactory::load($file);
                $excelData = $excelData->getActiveSheet()->toArray();
                $data = [];
                 foreach($excelData as $row){
                    $ctr++;
                    if ($ctr == 2) {
                        /**
                         * convert the comma separated data into array for the label
                         */
                        $label = $row;
                    }
                    /**
                     * convert the comma separated data into array for the data
                     */
                    $date = date('Y', strtotime($row[self::DATE_INDEX]));
                    if($ctr >= 2 && $date != '1970' && $date != ""){
                        if (!in_array($date, $yrs)) {
                            $yrs[] = $date;
                            $keyTemp = $date;
                        }
                        $data[$keyTemp][] = $row;
//                $data[]     = $csvData;
                    }
                }

                $annual_total_return = $this->getAnnualTotalReturn($data);
                $close_only = $this->getCloseOnly($annual_total_return);
                $max_drawdown = $this->getMaxDrawdown($close_only);
                $close_average = $this->getCloseAverage($close_only);
                $standard_deviation = $this->getStandardDeviation($close_average,$close_only);
                $absolute_value = $this->getAbsoluteValue($max_drawdown,$standard_deviation);
                $geometric_return = $this->getGeometricReturn($close_only);

                $symbols[] = [
                    'name' => $excelData['2']['0'],
                    'geometric_return' => $geometric_return-self::INFLATION,
                    'standard_deviation' => $standard_deviation,
                    'max_drawdown' => $max_drawdown,
                    'absolute_value' => $absolute_value,
                    'annual_return_rate' => "{}"
                ];

            //$true_risk_formula = $this->getTrueRiskFormula($mar,$geometric_return,$absolute_value);
            }



        }
        $this->symbols = $symbols;


        /**
         * populate result array with stock code as key
         */
        return $symbols;

    }


    /**
     * @return array
     */
    public function getData()
    {
        /**
         * fetch data from Yahoo!
         * s = stock code
         * f = format
         * e = filetype
         */
        $data = [];
        $label = [];

        if (($handle = fopen($this->csv, 'r')) !== FALSE) {
            $ctr = 0;
            $yrs = [];
            $keyTemp = '';
            while (!feof($handle)) {
                $ctr++;
                if ($ctr == 2) {
                    /**
                     * convert the comma separated data into array for the label
                     */
                    $label = fgetcsv($handle);
//                    $label = str_getcsv($handle, ',');
                }
                /**
                 * convert the comma separated data into array for the data
                 */

                $csvData = fgetcsv($handle);
                $date = date('Y', strtotime($csvData[self::DATE_INDEX]));
                if($ctr >= 2 && $date != '1970' && $date != ""){
                    if (!in_array($date, $yrs)) {
                        $yrs[] = $date;
                        $keyTemp = $date;
                    }
                    $data[$keyTemp][] = $csvData;
                }
            }
        }

        $this->labels = $label;
        $this->attributes = $data;
        //dd($data);
        /**
         * populate result array with stock code as key
         */

        return ['label' => $label, 'results' => $data];
    }


    /**
     * @return mixed
     */
    public function getAttributes()
    {
        return $this->attributes;
    }


    /**
     * @return mixed
     */
    public function getLabels()
    {
        return $this->labels;
    }



    /**
     *
     */
    public function getHistory()
    {

    }


    /**
     * @param $object
     * @return mixed
     */
    public function getClose($object)
    {
        return $object["close"];
    }


    /**
     * @return array
     */
    public function getAnnualTotalReturn($array)
    {
        $result = [];


        if(Setting::count() > 0){
            return $result = unserialize(Setting::where("option", "Annual Return Rate")->first()->value);
        }


        $i = 0;
        foreach ($array as $attribute) {
            $closeTotal = 0;
            $ctr = 0;
            $yr = '';
            $i++;
            if ($i <= self::YEAR_LIMIT) {
                $temp = [];
                foreach ($attribute as $key => $history) {
                        $value = $history[self::CLOSE_INDEX];

                        $closeTotal += $value;
                        $ctr++;
                        if ($ctr == 1) {
                            $yr = date('Y', strtotime($history[self::DATE_INDEX]));
                            $temp[] = $value;
                        }
                }
                /**
                 * updated object
                 */
                $average = $closeTotal / count($attribute);
                $result[] = [
                    'year' => $yr,
                    'close' => (round($average, 2))*.01,
                ];

            }


        }
        return $result;
    }



    /**
     * @return array
     */
    /*public function getCloseOnly(){
        return array_map(array($this, "getClose"), $this->getAnnualTotalReturn());
    }*/
    public function getCloseOnly($annualTotalReturn){
        return array_map(array($this, "getClose"), $annualTotalReturn);
    }



    /**
     * @return mixed
     */
    /*public function getMaxDrawdown(){
        return (min($this->getCloseOnly()) - max($this->getCloseOnly()) / max($this->getCloseOnly()));
    }*/
    public function getMaxDrawdown($closeOnly){
        return (min($closeOnly) - max($closeOnly) / max($closeOnly));
    }



    /**
     * @return mixed
     */
    /*public function getAbsoluteValue(){
        return $this->getMaxDrawdown() * $this->getStandardDeviation();
    }*/
    public function getAbsoluteValue($maxDrawdown,$standardDeviation){
        return $maxDrawdown * $standardDeviation;
    }


    /**
     * @return float
     */
   /* public function getCloseAverage(){
        $close_average = array_sum($this->getCloseOnly()) / count($this->getCloseOnly());
        return $close_average;
    }*/
    public function getCloseAverage($closeOnly){
        $close_average = array_sum($closeOnly) / count($closeOnly);
        return $close_average;
    }



    /**
     * @return number
     */
   /* public function getGeometricReturn()
    {
        $return = 1;
        $array = $this->getCloseOnly();
        foreach ($array as $row) {
            $return = $return * (1 + $row);
        }
        return pow($return, 1 / 3) - 1;
    }*/
    public function getGeometricReturn($closeOnly)
    {
        $return = 1;
        $array = $closeOnly;
        foreach ($array as $row) {
            $return = $return * (1 + $row);
        }
        return (pow($return, 1 / 3) - 1);
    }



    /** Rate of return
     * @param $array
     * @return array
     */
    /*public function getRateOfReturn($array)
    {
        $rate_of_returns = [];
        foreach ($array as $key => $row) {
            $rate_of_returns[] = (isset($array[$key - 1])) ? (($row - $array[$key - 1]) / $array[$key - 1]) : 0;
        }
        return $rate_of_returns;
    }*/
    public function getRateOfReturn($array)
    {
        $rate_of_returns = [];
        foreach ($array as $key => $row) {
            $rate_of_returns[] = (isset($array[$key - 1])) ? (($row - $array[$key - 1]) / $array[$key - 1]) : 0;
        }
        return $rate_of_returns;
    }



    /**
     * @param $geometric_return
     * @param $inflation
     * @param $mar
     * @param $absolute_value
     * @return float
     */
    /*public function getTrueRiskFormula($mar){
        $true_risk_formula = ($this->getGeometricReturn() - self::INFLATION - $mar) / $this->getAbsoluteValue();
        return $true_risk_formula;
    }*/
    public function getTrueRiskFormula($mar,$geometricReturn,$absoluteValue){
        $true_risk_formula = ($geometricReturn - self::INFLATION - $mar) / $absoluteValue;
        return $true_risk_formula;
    }



    /**
     * @param $value - average
     * @param $array
     * @return float
     */
   /* public function getStandardDeviation()
    {
        $average = $this->getCloseAverage();
        $array = $this->getCloseOnly();
        $deviations = [];
        foreach ($array as $row) {
            $deviations[] = pow($row["close"] - $average, 2);
        }
        return sqrt(array_sum($deviations) / count($deviations));
    }*/
    public function getStandardDeviation($closeAverage,$closeOnly)
    {
        $average = $closeAverage;
        $array = $closeOnly;
        $deviations = [];
        foreach ($array as $row) {
            $deviations[] = pow($row["close"] - $average, 2);
        }
        return sqrt(array_sum($deviations) / count($deviations));
    }



    /*public function getComputations(){
        $computations = [
            "Geometric Return" => $this->getGeometricReturn(),
            "Standard Deviation" => $this->getStandardDeviation(),
            "Max Drawdown" => $this->getMaxDrawdown(),
            "Absolute Value" => $this->getAbsoluteValue(),
            "Annual Return Rate" => serialize($this->getAnnualTotalReturn())
        ];

        return $computations;
    }*/
    /*public function storeSettings()
    {
        $data = $this->getComputations();
        if(Setting::count() > 0){
            dd(["settings already in database",$data]);
        }
        foreach ($data as $key => $row) {
            Setting::create(['option' => $key, 'value' => $row]);
        }

        dd(["settings saved in database",$data]);
    }*/
}

