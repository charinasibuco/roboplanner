<?php

use Illuminate\Database\Seeder;

class RetirementScoreCommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**==============================================
         *  Retirement Comments
        ===============================================*/
        DB::table('wealth_score_comments')->insert( [
            'wealth_score' => 'retirement',
            'list'  => 'why_did_i_get_this_score',
            'description' => 'You have 100% or more of your Lifetime Retirement Income Need.',
            'trigger_score' => '100_percent_lifetime_retirement_income_need',
            'trigger_scope' => 'high'
        ]);

        DB::table('wealth_score_comments')->insert( [
            'wealth_score' => 'retirement',
            'list'  => 'why_did_i_get_this_score',
            'description' => 'You have 90% or more Lifetime Retirement Income Need.',
            'trigger_score' => '90_percent_lifetime_retirement_income_need',
            'trigger_scope' => 'high'
        ]);

        DB::table('wealth_score_comments')->insert( [
            'wealth_score' => 'retirement',
            'list'  => 'why_did_i_get_this_score',
            'description' => 'You have 75% or more Lifetime Retirement Income Need.',
            'trigger_score' => '75_percent_lifetime_retirement_income_need',
            'trigger_scope' => 'high'
        ]);

        DB::table('wealth_score_comments')->insert( [
            'wealth_score' => 'retirement',
            'list'  => 'why_did_i_get_this_score',
            'description' => 'You have 50% or more Lifetime Retirement Income Need.',
            'trigger_score' => '50_percent_lifetime_retirement_income_need',
            'trigger_scope' => 'high'
        ]);

        DB::table('wealth_score_comments')->insert( [
            'wealth_score' => 'retirement',
            'list'  => 'why_did_i_get_this_score',
            'description' => 'You have less than 50% of your Lifetime Retirement Income Need.',
            'trigger_score' => '50_percent_lifetime_retirement_income_need',
            'trigger_scope' => 'low'
        ]);

        DB::table('wealth_score_comments')->insert( [
            'wealth_score' => 'retirement',
            'list'  => 'what_can_i_do_to_improve',
            'description' => 'With these assumptions, you should be able to retire on schedule!',
            'trigger_score' => '100_percent_lifetime_retirement_income_need',
            'trigger_scope' => 'high'
        ]);

        DB::table('wealth_score_comments')->insert( [
            'wealth_score' => 'retirement',
            'list'  => 'what_can_i_do_to_improve',
            'description' => 'You are very close to being on track for retirement, though minor changes to your plan are necessary.',
            'trigger_score' => '90_percent_lifetime_retirement_income_need',
            'trigger_scope' => 'high'
        ]);

        DB::table('wealth_score_comments')->insert( [
            'wealth_score' => 'retirement',
            'list'  => 'what_can_i_do_to_improve',
            'description' => 'With these assumptions, you will need to make some changes to your plan to meet your income needs on time.',
            'trigger_score' => '75_percent_lifetime_retirement_income_need',
            'trigger_scope' => 'high'
        ]);

        DB::table('wealth_score_comments')->insert( [
            'wealth_score' => 'retirement',
            'list'  => 'what_can_i_do_to_improve',
            'description' => 'With these assumptions, you willl have a retirement income that is more than 25% below your target.  Large changes to your plan are necessary.',
            'trigger_score' => '50_percent_lifetime_retirement_income_need',
            'trigger_scope' => 'high'
        ]);

        DB::table('wealth_score_comments')->insert( [
            'wealth_score' => 'retirement',
            'list'  => 'what_can_i_do_to_improve',
            'description' => 'With these assumptions, you will have a retirement income that is less than half of your target retirement income.  Large changes to your plan are necessary.',
            'trigger_score' => '50_percent_lifetime_retirement_income_need',
            'trigger_scope' => 'low'
        ]);

    }
}
