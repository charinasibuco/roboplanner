<?php

use Illuminate\Database\Seeder;

class WealthScoreCommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**==============================================
         *  Liquidity Comments
         =============================================*/
        DB::table('wealth_score_comments')->insert( [
            'wealth_score' => 'liquidity',
            'list'  => 'why_did_i_get_this_score',
            'description' => 'You received this score because your emergency fund was 6 months or more of your income.',
            'trigger_score' => 'emergency_fund_score',
            'trigger_scope' => 'high'
        ]);

        DB::table('wealth_score_comments')->insert( [
            'wealth_score' => 'liquidity',
            'list'  => 'why_did_i_get_this_score',
            'description' => 'You received this score because your emergency fund is less than 6 months of your income.',
            'trigger_score' => 'emergency_fund_score',
            'trigger_scope' => 'low'
        ]);

        DB::table('wealth_score_comments')->insert( [
            'wealth_score' => 'liquidity',
            'list'  => 'why_did_i_get_this_score',
            'description' => 'Your total monthly debt payments are too high.',
            'trigger_score' => 'debt_score',
            'trigger_scope' => 'high'
        ]);

        DB::table('wealth_score_comments')->insert( [
            'wealth_score' => 'liquidity',
            'list'  => 'why_did_i_get_this_score',
            'description' => 'In relation to your income, you hold too much debt which could be dangerous to your financial health.',
            'trigger_score' => 'debt_score',
            'trigger_scope' => 'high'
        ]);

        DB::table('wealth_score_comments')->insert( [
            'wealth_score' => 'liquidity',
            'list'  => 'what_can_i_do_to_improve',
            'description' => 'To fix this score you will want to start to add money to your emergency fund until it is greater than 6 months of income.',
            'trigger_score' => 'emergency_fund_score',
            'trigger_scope' => 'low'
        ]);

        DB::table('wealth_score_comments')->insert( [
            'wealth_score' => 'liquidity',
            'list'  => 'what_can_i_do_to_improve',
            'description' => 'You may keep adding to your emergency fund for assurance.',
            'trigger_score' => 'emergency_fund_score',
            'trigger_scope' => 'high'
        ]);

        DB::table('wealth_score_comments')->insert( [
            'wealth_score' => 'liquidity',
            'list'  => 'what_can_i_do_to_improve',
            'description' => ' You will want to work to pay off some of your debt in order to lower your payment.',
            'trigger_score' => 'debt_score',
            'trigger_scope' => 'high'
        ]);

        DB::table('wealth_score_comments')->insert( [
            'wealth_score' => 'liquidity',
            'list'  => 'what_can_i_do_to_improve',
            'description' => ' Remember, start paying off the debt that has a higher interest rate first.',
            'trigger_score' => 'debt_score',
            'trigger_scope' => 'high'
        ]);

        /**==============================================
         *  Legacy Comments
        ===============================================*/

        DB::table('wealth_score_comments')->insert( [
            'wealth_score' => 'legacy',
            'list'  => 'why_did_i_get_this_score',
            'description' => ' You have received this score because you have a trust.',
            'trigger_score' => 'have_trust',
            'trigger_scope' => 'high'
        ]);

        DB::table('wealth_score_comments')->insert( [
            'wealth_score' => 'legacy',
            'list'  => 'why_did_i_get_this_score',
            'description' => ' You received this score because you have a special needs trust.',
            'trigger_score' => 'have_special_needs_child',
            'trigger_scope' => 'high'
        ]);

        DB::table('wealth_score_comments')->insert( [
            'wealth_score' => 'legacy',
            'list'  => 'why_did_i_get_this_score',
            'description' => 'You received this score because you have significant assets.',
            'trigger_score' => 'high_net_worth',
            'trigger_scope' => 'high'
        ]);

        DB::table('wealth_score_comments')->insert( [
            'wealth_score' => 'legacy',
            'list'  => 'why_did_i_get_this_score',
            'description' => 'You received this score because you have no significant assets.',
            'trigger_score' => 'high_net_worth',
            'trigger_scope' => 'low'
        ]);

        DB::table('wealth_score_comments')->insert( [
            'wealth_score' => 'legacy',
            'list'  => 'why_did_i_get_this_score',
            'description' => 'You received this score because you have a will.',
            'trigger_score' => 'have_will',
            'trigger_scope' => 'high'
        ]);

        DB::table('wealth_score_comments')->insert( [
            'wealth_score' => 'legacy',
            'list'  => 'why_did_i_get_this_score',
            'description' => 'You received this score because you have no will.',
            'trigger_score' => 'have_will',
            'trigger_scope' => 'low'
        ]);

        DB::table('wealth_score_comments')->insert( [
            'wealth_score' => 'legacy',
            'list'  => 'why_did_i_get_this_score',
            'description' => 'You received this score because you have power of attorney.',
            'trigger_score' => 'have_power_of_attorney',
            'trigger_scope' => 'high'
        ]);

        DB::table('wealth_score_comments')->insert( [
            'wealth_score' => 'legacy',
            'list'  => 'why_did_i_get_this_score',
            'description' => 'You received this score because you have no power of attorney.',
            'trigger_score' => 'have_power_of_attorney',
            'trigger_scope' => 'low'
        ]);

        DB::table('wealth_score_comments')->insert( [
            'wealth_score' => 'legacy',
            'list'  => 'why_did_i_get_this_score',
            'description' => 'You received this score because you have a healthcare proxy.',
            'trigger_score' => 'have_healthcare_proxy',
            'trigger_scope' => 'high'
        ]);

        DB::table('wealth_score_comments')->insert( [
            'wealth_score' => 'legacy',
            'list'  => 'why_did_i_get_this_score',
            'description' => 'You received this score because you have no healthcare proxy.',
            'trigger_score' => 'have_healthcare_proxy',
            'trigger_scope' => 'low'
        ]);

        DB::table('wealth_score_comments')->insert( [
            'wealth_score' => 'legacy',
            'list'  => 'what_can_i_do_to_improve',
            'description' => 'You should look into setting up a trust.',
            'trigger_score' => 'have_trust',
            'trigger_scope' => 'low'
        ]);

        DB::table('wealth_score_comments')->insert( [
            'wealth_score' => 'legacy',
            'list'  => 'what_can_i_do_to_improve',
            'description' => 'You should look into getting power of attorney.',
            'trigger_score' => 'have_power_of_attorney',
            'trigger_scope' => 'low'
        ]);

        DB::table('wealth_score_comments')->insert( [
            'wealth_score' => 'legacy',
            'list'  => 'what_can_i_do_to_improve',
            'description' => 'You should look into getting a healthcare proxy.',
            'trigger_score' => 'have_healthcare_proxy',
            'trigger_scope' => 'low'
        ]);

        DB::table('wealth_score_comments')->insert( [
            'wealth_score' => 'legacy',
            'list'  => 'what_can_i_do_to_improve',
            'description' => 'You should look into getting a will.',
            'trigger_score' => 'have_will',
            'trigger_scope' => 'low'
        ]);

        /**==============================================
         *  Investment Comments
        ===============================================*/

        DB::table('wealth_score_comments')->insert( [
            'wealth_score' => 'investments',
            'list'  => 'why_did_i_get_this_score',
            'description' => 'You have received this score because your true risk formula is low. This means that your current investment allocation has a poor risk adjusted return.',
            'trigger_score' => 'true_risk_formula',
            'trigger_scope' => 'low'
        ]);
        DB::table('wealth_score_comments')->insert( [
            'wealth_score' => 'investments',
            'list'  => 'what_can_i_do_to_improve',
            'description' => 'In order to get a higher score,review your investment allocation and potentially shifting to a new allocation.',
            'trigger_score' => 'true_risk_formula',
            'trigger_scope' => 'low'
        ]);

        /**==============================================
         *  Insurance Comments
        ===============================================*/

        DB::table('wealth_score_comments')->insert( [
            'wealth_score' => 'insurance',
            'list'  => 'why_did_i_get_this_score',
            'description' => 'You received this score because you have health insurance.',
            'trigger_score' => 'have_health_insurance',
            'trigger_scope' => 'high'
        ]);

        DB::table('wealth_score_comments')->insert( [
            'wealth_score' => 'insurance',
            'list'  => 'why_did_i_get_this_score',
            'description' => "You received this score because you don't have health insurance.",
            'trigger_score' => 'have_health_insurance',
            'trigger_scope' => 'low'
        ]);

        DB::table('wealth_score_comments')->insert( [
            'wealth_score' => 'insurance',
            'list'  => 'why_did_i_get_this_score',
            'description' => "You received this score because you have homeowner's insurance.",
            'trigger_score' => 'have_homeowners_insurance',
            'trigger_scope' => 'high'
        ]);

        DB::table('wealth_score_comments')->insert( [
            'wealth_score' => 'insurance',
            'list'  => 'why_did_i_get_this_score',
            'description' => "You received this score because you don't have homeowner's insurance.",
            'trigger_score' => 'have_homeowners_insurance',
            'trigger_scope' => 'low'
        ]);

        DB::table('wealth_score_comments')->insert( [
            'wealth_score' => 'insurance',
            'list'  => 'why_did_i_get_this_score',
            'description' => "You received this score because you have disability insurance.",
            'trigger_score' => 'have_disability_insurance',
            'trigger_scope' => 'high'
        ]);

        DB::table('wealth_score_comments')->insert( [
            'wealth_score' => 'insurance',
            'list'  => 'why_did_i_get_this_score',
            'description' => "You received this score because you don't have disability insurance.",
            'trigger_score' => 'have_disability_insurance',
            'trigger_scope' => 'low'
        ]);

        DB::table('wealth_score_comments')->insert( [
            'wealth_score' => 'insurance',
            'list'  => 'what_can_i_do_to_improve',
            'description' => "You should look into getting disability insurance.",
            'trigger_score' => 'have_disability_insurance',
            'trigger_scope' => 'low'
        ]);

        DB::table('wealth_score_comments')->insert( [
            'wealth_score' => 'insurance',
            'list'  => 'what_can_i_do_to_improve',
            'description' => "You should look into getting health insurance.",
            'trigger_score' => 'have_health_insurance',
            'trigger_scope' => 'low'
        ]);

        DB::table('wealth_score_comments')->insert( [
            'wealth_score' => 'insurance',
            'list'  => 'what_can_i_do_to_improve',
            'description' => "You should look into getting homeowner's insurance.",
            'trigger_score' => 'have_homeowners_insurance',
            'trigger_scope' => 'low'
        ]);
    }
}
