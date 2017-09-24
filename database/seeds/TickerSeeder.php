<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TickerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       	$url = "https://www.quandl.com/api/v3/datatables/WIKI/PRICES.json?date=20160912&qopts.columns=ticker&api_key=W11_2Viqa-YrP9oPzSVy";
        $json = file_get_contents($url);
        $json_data = json_decode($json, true);

        $datatable = $json_data['datatable'];
        $data      = $datatable['data'];
       foreach ($data as $key)
        {
            DB::table('ticker')->insert([
                'symbol'    => $key[0],
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
        }
    }
}
