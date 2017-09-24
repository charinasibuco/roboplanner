<?php

use Illuminate\Database\Seeder;

class NewWSCSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('wealth_score_comments')->insert( [
            'wealth_score' => 'liquidity',
            'list'  => 'why_did_i_get_this_score',
            'description' => 'You have less than $2000 in your emergency fund.',
            'trigger_score' => 'emergency_fund_2000_score',
            'trigger_scope' => 'low'
        ]);

        DB::table('wealth_score_comments')->insert( [
            'wealth_score' => 'liquidity',
            'list'  => 'what_can_i_do_to_improve',
            'description' => 'Add more into your emergency fund until you have at least $2000.',
            'trigger_score' => 'emergency_fund_2000_score',
            'trigger_scope' => 'low'
        ]);
    }
}
