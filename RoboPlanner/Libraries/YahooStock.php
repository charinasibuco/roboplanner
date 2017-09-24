<?php

/**
 * Created by PhpStorm.
 * User: Jaime Handayan
 * Date: 7/14/2016
 * Time: 1:49 PM
 */
namespace RoboPlanner\Libraries;

class YahooStock
{

    const BASE_URL          = 'http://download.finance.yahoo.com/d/quotes.csv?s=';
    const HISTORICAL_URL    = 'http://ichart.yahoo.com/table.csv?s=';
//    const HISTORICAL_URL    = 'http://finance.yahoo.com/q/hp?s=WU&a=01&b=19&c=2005&d=01&e=19&f=2016&g=d';
    const STATIC_END        = '&e=.csv';
    const STATIC_HISTORICAL = '&ignore=.csv';
    const PATH              = '';
    /**
     * Array of stock code
     */
    private $stocks = array();

    /**
     * Parameters string to be fetched
     */
    private $format;

    /**
     * Populate stock array with stock code
     *
     * @param string $stock Stock code of company
     * @return void
     */
    public function addStock($stock)
    {
        $this->stocks[] = $stock;
    }

    /**
     * Populate parameters/format to be fetched
     *
     * @param string $param Parameters/Format to be fetched
     * @return void
     */
    public function addFormat($format)
    {
        $this->format = $format;
    }

    /**
     * Get Stock Data
     *
     * @return array
     */
    public function getQuotes($from = '', $to = '')
    {
        $result = array();
        $format = $this->format;

        $return = '';
        foreach ($this->stocks as $stock)
        {

//            $url                = self::HISTORICAL_URL . $stock . "&a=01&b=01&c=2005&d=01&e=01&f=2016&atr&ltr=1&g=d" . self::STATIC_HISTORICAL;
            $url                = self::HISTORICAL_URL . $stock . "&a=01&b=01&c=2005&d=01&e=01&f=2016&atr&ltr=1&g=d";
//            $url                = "http://finance.yahoo.com/d/quotes.csv?s=GE+PTR+MSFT&f=snd1l1yr";
            /**
             * fetch data from Yahoo!
             * s = stock code
             * f = format
             * e = filetype
             */
            $data               = [];
            $label              = [];
//            $s                  = file_get_contents($url);
//            $s = file_get_contents("http://ichart.finance.yahoo.com/table.csv?s=".$stock."&a=01&b=01&c=2005&d=01&e=01&f=2015&g=d");
//            $s = file_get_contents("http://finance.yahoo.com/d/quotes.csv?s=$stock&f=$format&e=.csv");
            if (($handle = fopen($url, 'r')) !== FALSE ) {
                $ctr            = 0;
                while (!feof($handle)) {
                    $ctr++;
                    if($ctr == 1){
                        /**
                         * convert the comma separated data into array for the label
                         */
                        $label = fgetcsv($handle);
                    }
                    /**
                     * convert the comma separated data into array for the data
                     */
                    $csvData    = fgetcsv($handle);
                    $data[]     = $csvData;
                }
            }




            /**
             * populate result array with stock code as key
             */
            $result[]     = ['stock' => $stock, 'data' => $data];
        }
        return ['label' => $label, 'results' => $result];
    }
}

/*
 * $objYahooStock = new YahooStock;

/**

// Add format/parameters to be fetched

// s = Symbol
// n = Name
// l1 = Last Trade (Price Only)
// d1 = Last Trade Date
// t1 = Last Trade Time
// c = Change and Percent Change
// v = Volume

$objYahooStock->addFormat("snl1d1t1cv");

//Add company stock code to be fetched

//msft = Microsoft
//amzn = Amazon
//yhoo = Yahoo
//goog = Google
//aapl = Apple

$objYahooStock->addStock("msft");
$objYahooStock->addStock("amzn");
$objYahooStock->addStock("yhoo");
$objYahooStock->addStock("goog");
$objYahooStock->addStock("vgz");

// Printing out the data

foreach( $objYahooStock->getQuotes() as $code => $stock)
{
    Code: <?php echo $stock[0]; ?> <br />
    Name: <?php echo $stock[1]; ?> <br />
    Last Trade Price: <?php echo $stock[2]; ?> <br />
    Last Trade Date: <?php echo $stock[3]; ?> <br />
    Last Trade Time: <?php echo $stock[4]; ?> <br />
    Change and Percent Change: <?php echo $stock[5]; ?> <br />
    Volume: <?php echo $stock[6]; ?> <br /><br />
    <?php
}
 * */