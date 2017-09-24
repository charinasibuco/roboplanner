<?php

use Illuminate\Database\Seeder;

class FlagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $data = [
       		[
       			'color' 	=> '1',
       			'description' 	=> 'Married and no will',
       			'range'			=> '1',
				'wealth_score' => 'Legacy'

       		],
       		[
       			'color' 	=> '1',
       			'description' 	=> 'Kids and no will',
       			'range'			=> '2',
				'wealth_score' => 'Legacy'

       		],
       		[
       			'color' 	=> '1',
       			'description' 	=> 'Married and kids with no will',
       			'range'			=> '3',
				'wealth_score' => 'Legacy'

       		],
       		[
       			'color' 	=> '1',
       			'description' 	=> 'Special needs child: Your child must have a special needs trust or they risk losing government assistance.',
       			'range'			=> '4',
				'wealth_score' => 'Legacy'

       		],
       		[
       			'color' 	=> '2',
       			'description' 	=> 'High Net Worth and no trust',
       			'range'			=> '1',
				'wealth_score' => 'Legacy'

       		],
       		[
       			'color' 	=> '2',
       			'description' 	=> 'Single and no will',
       			'range'			=> '2',
				'wealth_score' => 'Legacy'

       		],
       		[
       			'color' 	=> '2',
       			'description' 	=> 'Anytime someone doesn’t have a health care proxy or POA',
       			'range'			=> '3',
				'wealth_score' => 'Legacy'

       		],
       		[
       			'color' 	=> '1',
       			'description' 	=> 'You have high interest debt (Double mortgage rate)',
       			'range'			=> '1',
				'wealth_score' => 'Liquidity'

       		],
       		[
       			'color' 	=> '1',
       			'description' 	=> 'Debt payments are a greater than 1/3 of income',
       			'range'			=> '2',
				'wealth_score' => 'Liquidity'

       		],
       		[
       			'color' 	=> '1',
       			'description' 	=> 'Less than $2,000 in an emergency fund',
       			'range'			=> '3',
				'wealth_score' => 'Liquidity'

       		],
       		[
       			'color' 	=> '2',
       			'description' 	=> 'Less than 6 months of income in emergency fund',
       			'range'			=> '1',
				'wealth_score' => 'Liquidity'

       		],
       		[
       			'color' 	=> '2',
       			'description' 	=> 'Debt payments are greater than 20% of income',
       			'range'			=> '2',
				'wealth_score' => 'Liquidity'

       		],
       		[
       			'color' 	=> '1',
       			'description' 	=> 'Your risk tolerance and allocation don’t align (max drawdown, time horizon )',
       			'range'			=> '1',
				'wealth_score' => 'Investments'

       		],
       		[
       			'color' 	=> '1',
       			'description' 	=> 'Poor diversification = will define',
       			'range'			=> '2',
				'wealth_score' => 'Investments'

       		],
       		[
       			'color' 	=> '1',
       			'description' 	=> 'Expected return > than historical portfolio return ',
       			'range'			=> '3',
				'wealth_score' => 'Investments'

       		],
       		[
       			'color' 	=> '2',
       			'description' 	=> 'There is a cheaper alternative to invest in unless True Risk Formula is higher with current allocation',
       			'range'			=> '1',
				'wealth_score' => 'Investments'

       		],
       		[
       			'color' 	=> '2',
       			'description' 	=> 'Possible investment upgrade ',
       			'range'			=> '2',
				'wealth_score' => 'Investments'

       		],
       		[
       			'color' 	=> '1',
       			'description' 	=> 'Your income will not last to life expectancy because your retirement is too early',
       			'range'			=> '1',
				'wealth_score' => 'Retirement'

       		],
       		[
       			'color' 	=> '1',
       			'description' 	=> 'Your income will not last to life expectancy because you don’t save enough',
       			'range'			=> '2',
				'wealth_score' => 'Retirement'

       		],
       		[
       			'color' 	=> '1',
       			'description' 	=> 'Your income will not last to life expectancy because your growth rate is poor',
       			'range'			=> '3',
				'wealth_score' => 'Retirement'

       		],
       		[
       			'color' 	=> '1',
       			'description' 	=> 'At your current rate of savings, you will never be able to reach your retirement goal.',
       			'range'			=> '4',
				'wealth_score' => 'Retirement'

       		],
       		[
       			'color' 	=> '2',
       			'description' 	=> 'There may be a more advanced way to plan social security',
       			'range'			=> '1',
				'wealth_score' => 'Retirement'

       		],
       		[
       			'color' 	=> '2',
       			'description' 	=> 'Your investment income is >70% of your target income, you may want to consider income guarantees.',
       			'range'			=> '2',
				'wealth_score' => 'Retirement'

       		],
       		[
       			'color' 	=> '2',
       			'description' 	=> 'You may benefit from taking RMD ’s earlier than age 70 1/2 please consult a CPA.',
       			'range'			=> '3',
				'wealth_score' => 'Retirement'

       		],
		   [
			   'color' 	=> '1',
			   'description' 	=> 'Missing Homeowners Insurance',
			   'range'			=> '1',
			   'wealth_score' => 'Insurance'
		   ],
		   [
			   'color' 	=> '1',
			   'description' 	=> 'Missing Disability Insurance',
			   'range'			=> '2',
			   'wealth_score' => 'Insurance'
		   ],
		   [
			   'color' 	=> '1',
			   'description' 	=> 'Missing Auto Insurance',
			   'range'			=> '3',
			   'wealth_score' => 'Insurance'
		   ],
		   [
			   'color' 	=> '1',
			   'description' 	=> 'Missing Health Insurance',
			   'range'			=> '4',
			   'wealth_score' => 'Insurance'
		   ],
       ];

       foreach ($data as $key) {
       		DB::table('flag')->insert([
                'color'    => $key['color'],
                'description'     => $key['description'],
                'range'         => $key['range'],
				'wealth_score'	=> $key['wealth_score']
            ]);
       }
    }
}
