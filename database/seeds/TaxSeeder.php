<?php

use Illuminate\Database\Seeder;

class TaxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $due_date       = '2017-04-17';
        $taxes          = [
            [
                'tax_rate'                          => 0.10,
                'due_date'                          => $due_date,
                'single_filters_from'               => 0.00,
                'single_filters_to'                 => 9275.00,
                'married_filling_jointly_from'      => 0.00,
                'married_filling_jointly_to'        => 18550.00,
                'married_filling_separately_from'   => 0.00,
                'married_filling_separately_to'     => 9275.00,
                'head_of_household_from'            => 0.00,
                'head_of_household_to'              => 13250.00,
            ],
            [
                'tax_rate'                          => 0.15,
                'due_date'                          => $due_date,
                'single_filters_from'               => 9276.00,
                'single_filters_to'                 => 37650.00,
                'married_filling_jointly_from'      => 18551.00,
                'married_filling_jointly_to'        => 75300.00,
                'married_filling_separately_from'   => 8276.00,
                'married_filling_separately_to'     => 37650.00,
                'head_of_household_from'            => 13251.00,
                'head_of_household_to'              => 50400.00,
            ],
            [
                'tax_rate'                          => 0.25,
                'due_date'                          => $due_date,
                'single_filters_from'               => 37651.00,
                'single_filters_to'                 => 91150.00,
                'married_filling_jointly_from'      => 75301.00,
                'married_filling_jointly_to'        => 151900.00,
                'married_filling_separately_from'   => 37651.00,
                'married_filling_separately_to'     => 75950.00,
                'head_of_household_from'            => 50401.00,
                'head_of_household_to'              => 130150.00,
            ],
            [
                'tax_rate'                          => 0.28,
                'due_date'                          => $due_date,
                'single_filters_from'               => 91151.00,
                'single_filters_to'                 => 190150.00,
                'married_filling_jointly_from'      => 151901.00,
                'married_filling_jointly_to'        => 231450.00,
                'married_filling_separately_from'   => 75951.00,
                'married_filling_separately_to'     => 115725.00,
                'head_of_household_from'            => 130151.00,
                'head_of_household_to'              => 210800.00,
            ],
            [
                'tax_rate'                          => 0.33,
                'due_date'                          => $due_date,
                'single_filters_from'               => 190151.00,
                'single_filters_to'                 => 413350.00,
                'married_filling_jointly_from'      => 231451.00,
                'married_filling_jointly_to'        => 413350.00,
                'married_filling_separately_from'   => 115726.00,
                'married_filling_separately_to'     => 206675.00,
                'head_of_household_from'            => 210801.00,
                'head_of_household_to'              => 413350.00,
            ],
            [
                'tax_rate'                          => 0.35,
                'due_date'                          => $due_date,
                'single_filters_from'               => 413351.00,
                'single_filters_to'                 => 415050.00,
                'married_filling_jointly_from'      => 413351.00,
                'married_filling_jointly_to'        => 466950.00,
                'married_filling_separately_from'   => 206676.00,
                'married_filling_separately_to'     => 233475.00,
                'head_of_household_from'            => 413351.00,
                'head_of_household_to'              => 441001.00,
            ],
            [
                'tax_rate'                          => 0.396,
                'due_date'                          => $due_date,
                'single_filters_from'               => 415051.00,
                'single_filters_to'                 => 'or more',
                'married_filling_jointly_from'      => 466951.00,
                'married_filling_jointly_to'        => 'or more',
                'married_filling_separately_from'   => 233476.00,
                'married_filling_separately_to'     => 'or more',
                'head_of_household_from'            => 441001.00,
                'head_of_household_to'              => 'or more',
            ]
        ];

        DB::table('taxes')->insert( $taxes);
    }
}
