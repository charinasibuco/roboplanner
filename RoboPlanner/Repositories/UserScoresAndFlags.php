<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 7/21/2016
 * Time: 3:29 PM
 */

namespace RoboPlanner\Repositories;


use RoboPlanner\Helper\StateHelper;
use RoboPlanner\Libraries\Csv;
use App\WealthScoreComment;
use App\Flag;
use App\Setting;
use App\Value;
use App\Tax;
use App\LifeExpectancy;
use Carbon\Carbon;
use Auth;

class UserScoresAndFlags extends Repository
{
    use StateHelper;
    const MAX_AGE                   = 100;
//    const MAX_AGE                   = 91;

    /**=====================================
     * For Social Security @var
     =====================================**/
    const YEAR = 12;
    const SS_INCREASE = 1.08;
    const SS_INCREASE_2 = 1.025;
    //const DELAY_IN_RETIREMENT = 3;
    const SS_AVAILABLE = 0.8;

    const HIGH_NET_WORTH = 2000000;

    protected $lifeInsuranceIncome;
    protected $totalLifeInsuranceNeed;
    protected $listener;
    public $attributes;



    private $scores                 = [];
    private $income                 = 0;
    private $insuranceScore         = 0;
    private $investmentScore        = 0;
    private $legacyScore            = 0;
    private $liquidityScore         = 0;
    private $gemWorthSemiPrivateStay;
    private $gemWorthAverageStay;
    /* test */ public $inflationRate;
    /* test */ public $lifeExpectancy;
    /* test */ public $lifeExpectancySpouse;
    private $lifeExpectancyAddon;
    private $timeHorizon;
    private $assumedInterestRate;
    private $growthRate             = 0.06;
    private $mar                    = 0;

    private $husbandPassedAwayAge  = 88;
    private $spousePassAwayAge      = 82;

    private $annuityIncome;
    private $pensionIncome;
    //private $freeTax;
    private $sumOfDeptPaymentPerMonth;
    private $riderBenefit;
    private $panicPoint;
    private $brokerageDiscountCoverage;
    private $incomeTarget;
    /* test */ public $retirementAdjustment;
    private $retirement_income_need = 0;
    private $true_risk_formula = 0;
    private $typeOneAsset           = ['401k', '403b', 'IRA', 'Brokerage', '529Plan', 'Simple', 'SEP', 'Roth'];
    private $notRetirementPlan      = ['CDs', 'Home', 'UTMA', 'UGMA', 'Coverdall', 'Savings', 'Checkings', 'Business'];
    private $filialState = ['Alaska', 'Arkansas', 'California', 'Connecticut', 'Delaware', 'Georga', 'Idaho', 'Indiana', 'Iowa', 'Kentucky',
        'Louisiana', 'Maryland', 'Massachusetts', 'Mississippi', 'Montana', 'Nevada', 'New Hampshire', 'New Jersey', 'North Carolina', 'North Dakota',
        'Ohio', 'Oregon', 'Pennsylvania', 'Rhode Island', 'South Dakota', 'Tennessee', 'Utah', 'Vermont', 'Virginia', 'West Virginia'];
    private $inFilialState;
    private $tableHeader            = [];
    private $tableHeader2           = [];

    public $user;
    public $assets                  = [];
    public $calculatedAssets        = [];
    public $retirementPlan          = [];
    public $graphData               = [];
    public $husband401k             = null;
    public $wife401k                = null;
    public $husband403b             = null;
    public $wife403b                = null;
    public $husbandIRA              = null;
    public $wifeIRA                 = null;
    public $rental                  = null;
    public $husbandRoth             = null;
    public $wifeRoth                = null;
    public $husbandBrokerage        = null;
    public $wifeBrokerage           = null;
    public $husbandAnnuity          = null;
    public $wifeAnnuity             = null;
    public $husbandSimple           = null;
    public $wifeSimple              = null;
    public $husband529Plan          = null;
    public $wife529Plan             = null;
    public $husbandSep              = null;
    public $wifeSep                 = null;
    public $husbandHome             = null;
    public $wifeHome                = null;
    public $husbandSavings          = null;
    public $wifeSavings             = null;
    public $husbandChecking         = null;
    public $wifeChecking            = null;
    public $husbandBusiness         = null;
    public $husbandCDs              = null;
    public $wifeCDs                 = null;
    public $husbandUTMA             = null;
    public $wifeUTMA                = null;
    public $husbandUGMA             = null;
    public $wifeUGMA                = null;


    /* test */ public $annualFullRetirementBenefit;
    /* test */ public $annualFullRetirementBenefitSpouse;
    /* test */ public $fullRetirementAge;
    /* test */ public $birthYear;
    /* test */ public $yearDifference;
    /* test */ public $fullRetirementAgeSpouse;
    /* test */ public $yearDifferenceSpouse;
    /* test */ public $retirementAdjustmentSpouse;
    /* test */ public $SSBenefitAdjustment;
    /* test */ public $SSBenefitAdjustmentSpouse;
    private $fullRetirementAgeBenefits;




    /******
     * @return string
     */
//    public function altValue($object){
//        return isset($object)?$object->value:0;
//    }
    public function loadValues(){
        /************************
         * values
         *********************/
        $this->inflationRate = (Value::where('slug',"inflation_rate")->first()->value);
        $this->brokerageDiscountCoverage = Value::where('slug','brokerage_discount_coverage')->first()->value;
        $this->assumedInterestRate =  Value::where('slug','assumed_interest_rate')->first()->value;
        $this->gemWorthSemiPrivateStay = Value::where('slug','genworth_semi_private_stay')->first()->value;
        $this->gemWorthAverageStay = Value::where('slug','genworth_average_stay')->first()->value;
        $this->lifeExpectancyAddon = Value::where('slug','life_expectancy_addon')->first()->value;
        $this->SSBenefitAdjustment = Value::where('slug','ss_benefit_adjustment')->first()->value;
        $this->SSBenefitAdjustmentSpouse = Value::where('slug','ss_benefit_adjustment_spouse')->first()->value;
        /************************
         * in Filial state
         *********************/
        $state = isset($this->attributes['state'])?$this->attributes['state']:"";
        $this->inFilialState =  in_array($state,$this->filialState);
        /************************
         * time Horizon
         *********************/
        $this->timeHorizon = isset($this->attributes['when_do_you_plan_to_make_major_withdrawal'])?$this->attributes['when_do_you_plan_to_make_major_withdrawal']:"";
        /**************************
         * life expectancy
         ************************/
        $age = $this->attributes['age'];
        $age_spouse = isset($this->attributes['spouse_age'])?$this->attributes['spouse_age']:null;
        $sex = isset($this->attributes['sex'])?$this->attributes['sex']:"Male";
        $sex_spouse = isset($this->attributes['spouse_sex'])?$this->attributes['spouse_sex']:null;
        //$assumed = isset($this->attributes['what_age_would_you_like_us_to_assume'])?$this->attributes['what_age_would_you_like_us_to_assume']:null;
        $this->lifeExpectancy = $this->getLifeExpectancy($age,$sex);
        $this->lifeExpectancySpouse = $this->getLifeExpectancy($age_spouse,$sex_spouse);
        /*******************
         * Panic Point
         ******************/
        $point = isset($this->attributes['you_would_fire_me_panic_go_to_cash'])?$this->attributes['you_would_fire_me_panic_go_to_cash']:0;
        $point = -1 * (str_replace(['$',',', ' ','%'],'',$point));
        $this->panicPoint = $point;

        /*****************
         * Retirement Benefit
         ****************/
        $this->annualFullRetirementBenefit = 12*(isset($this->attributes['social_security_retirement_benefit_yours'])?$this->attributes['social_security_retirement_benefit_yours']:0);
        $this->fullRetirementAge = $this->getFullRetirementAge($this->getBirthYear($age));
        $this->birthYear = $this->getBirthYear($age);
        $this->yearDifference = $this->getYearDifference($age,$this->attributes['what_age_do_you_plan_on_retiring_age']);
        $this->fullRetirementAgeBenefits = $this->getFullRetirementAgeBenefits($age,$this->attributes['what_age_do_you_plan_on_retiring_age'],$this->attributes['social_security_retirement_benefit_yours']);
        $this->retirementAdjustment =  $this->getRetirementAdjustment($this->yearDifference,$this->birthYear);
        /******************************
         * Retirement Benefit Spouse
         ***************************/
        $this->annualFullRetirementBenefitSpouse = 12*(isset($this->attributes['social_security_retirement_benefit_spouse'])?$this->attributes['social_security_retirement_benefit_spouse']:0);
        $this->fullRetirementAgeSpouse = $this->getFullRetirementAge($this->getBirthYear($age_spouse));
        $this->birthYearSpouse = $this->getBirthYear($age_spouse);
        $this->yearDifferenceSpouse = $this->getYearDifference($age_spouse,$this->attributes['what_age_do_you_plan_on_retiring_age']);
        $this->fullRetirementAgeBenefitsSpouse = $this->getFullRetirementAgeBenefits($this->attributes['age'],$this->attributes['what_age_do_you_plan_on_retiring_age'],$this->attributes['social_security_retirement_benefit_yours']);
        $this->retirementAdjustmentSpouse =  $this->getRetirementAdjustment($this->yearDifferenceSpouse,$this->birthYearSpouse);
    }
    public function getLifeExpectancy($age,$sex){
        $assumed = isset($this->attributes['what_age_would_you_like_us_to_assume'])?$this->attributes['what_age_would_you_like_us_to_assume']:null;
        $row = LifeExpectancy::where('sex',"=",$sex)->where("exact_age","=",$age)->first();
        $life_expectancy = round(isset($row)?($row->exact_age+$row->life_expectancy):0);
        $life_expectancy = (isset($assumed) && $assumed < $life_expectancy)?$assumed:$life_expectancy;
        $life_expectancy += $this->lifeExpectancyAddon;
        return $life_expectancy;
    }

    public function model()
    {
        // TODO: Implement model() method.
        return 'App\User';
    }
    public function boot(){
        if(Auth::user()->hasRole('client')) {
            $this->user = Auth::user();

            foreach ($this->user->usermeta as $meta) {
                $this->attributes[$meta['option']] = $meta['value'];
            }
            $this->loadValues();
            $this->setSumOfDeptPaymentPerMonth();
            $this->getLiquidityScore();
            $this->getRetirementScore();
            $this->CalculateLiquidityScore();
            $this->CalculateInsuranceScore();
            $this->CalculateLegacyScore();
            $this->CalculateInvestmentScore();
            $this->CalculateRetirementScore();
            //$this->CalculateCollege();
            //$this->CalculateCashFlow();
        }
    }

    /** ==========================================
     *  This function is for admins to view wealth scores of users
     * ========================================== */
    public function execute(){
        $this->loadValues();
        $this->setSumOfDeptPaymentPerMonth();
        $this->getLiquidityScore();
        $this->getRetirementScore();
        $this->CalculateLiquidityScore();
        $this->CalculateInsuranceScore();
        $this->CalculateLegacyScore();
        $this->CalculateInvestmentScore();
        $this->CalculateRetirementScore();
        //$this->CalculateCollege();
        //$this->CalculateCashFlow();
    }


    //setters methods

    public function setIncome($income){
        $this->income                   = $income;
    }

    public function setAnnuityIncome($annuityIncome){
        $this->annuityIncome            = $annuityIncome;
    }

    public function setPensionIncome($pensionIncome){
        $this->pensionIncome            = $pensionIncome;
    }

    public function getPlanDuration(){
        $start_year = Carbon::parse($this->user->created_at)->format('Y');
        $current_year = Carbon::now()->year;
        return $current_year - $start_year;
    }


    // getters methods
    public function setSumOfDeptPaymentPerMonth(){
        //$results        = 0;
        $balance = 0;
        if(isset($this->attributes['liabilities'])){
            $liabilities = unserialize($this->attributes['liabilities']);
            foreach($liabilities as $liability){
                $balance += $liability['monthly_payment'];
            }
        }
        $this->sumOfDeptPaymentPerMonth = $balance;
    }

    public function getIncomePerMonth(){
        //$incomePerMonth                 = 0;
//        if(@$this->attributes['pre_tax_income'] != '' && @$this->attributes['pre_tax_income'] != '0.00'){
//            $incomePerMonth             = @$this->attributes['pre_tax_income'] / 12;
//        }

        //$incomePerMonth = ($this->getNetWorth() / 12) + $this->getLiabilitySum("annual");
        $incomePerMonth = ($this->getNetWorth() / 12);
        return $incomePerMonth;
    }

    public function getNumberOfMonthsAvailable(){
        $numberOfMonthsAvailableIncome      = 0;
        if($numberOfMonthsAvailableIncome > 0 ){
            $numberOfMonthsAvailableIncome      = $this->attributes['what_is_the_total_value_of_your_emergency_fund'] / $this->getIncomePerMonth();
            $numberOfMonthsAvailableIncome      = ceil($numberOfMonthsAvailableIncome);
        }

        return $numberOfMonthsAvailableIncome;
    }

    public function getIncome(){
        $this->attributes['do_you_know_your_social_security_benefit_at_retirement'] = isset($this->attributes['do_you_know_your_social_security_benefit_at_retirement'])?$this->attributes['do_you_know_your_social_security_benefit_at_retirement']:"No";
        if(isset($this->attributes['estimate_after_tax_monthly_income'])){ $this->income += $this->attributes['estimate_after_tax_monthly_income'];}

        if(isset($this->attributes['estimated_income'])) { $this->income += $this->attributes['estimated_income']; }
        if($this->attributes['do_you_know_your_social_security_benefit_at_retirement'] == 'Yes'){
            if(isset($this->attributes['pension'])) {
                foreach (unserialize($this->attributes['pension']) as $pension) {
                    $this->income += str_replace(['$', ',', ' '], '', $pension['projected_monthly_pension_benefit']);
                }
            }
        }
        return $this->income;
    }

    public function getRetirementIncome(){
        $income = 0;
        $this->attributes['do_you_know_your_social_security_benefit_at_retirement'] = isset($this->attributes['do_you_know_your_social_security_benefit_at_retirement'])?$this->attributes['do_you_know_your_social_security_benefit_at_retirement']:"No";
        if(isset($this->attributes['estimate_after_tax_monthly_income'])){
            $income += $this->attributes['estimate_after_tax_monthly_income'];
        }
        if(isset($this->attributes['estimated_income'])) { $income += $this->attributes['estimated_income']; }

        if(isset($this->attributes['pension'])) {
            foreach (unserialize($this->attributes['pension']) as $pension) {
                $income += $pension['projected_monthly_pension_benefit'];
            }
        }
        $income += $this->getSavings();
        return $income;
    }
    public function hasCOLA(){
        $pensions = isset($this->attributes['pension'])?unserialize($this->attributes['pension']):[];
        foreach($pensions as $pension){
            if(isset($pension['does_it_have_a_cost_of_living_adjustment']) && $pension['does_it_have_a_cost_of_living_adjustment'] == "Yes"){
                return true;
            }
        }
       return false;
    }

    public function getDiscountRate(){
        return $this->hasCOLA()?($this->getMAR()*$this->inflationRate):$this->getMAR();
    }
    public function getMAR(){
        $panic_range = [];
        $time_range = [];
        $mar_range = [0,0.02,0.04,0.06];
        $panic_range[] = ($this->panicPoint <= 0 && $this->panicPoint >= -10);
        $panic_range[] = ($this->panicPoint <= -11 && $this->panicPoint >= -19);
        $panic_range[] = ($this->panicPoint <= -20 && $this->panicPoint >= -29);
        $panic_range[] = ($this->panicPoint <= -30);

        $time_range[] = false;
        $time_range[] = ($this->timeHorizon == "<5 Years");
        $time_range[] = ($this->timeHorizon == "5-10 Years");
        $time_range[] = ($this->timeHorizon == "10-20 Years" || $this->timeHorizon == "20+ Years");

        $range[] = ($this->panicPoint >= -10 && $this->panicPoint <= 0);

        foreach($panic_range as $key => $range){
            $sit1 = ($key >= 0 || $key < 2) && ($range || $time_range[$key]);
            $sit2 = ($key >= 2) && ($range && $time_range[$key]);
            if($sit1 || $sit2){
                return $mar_range[$key];
            }
        }

        return 0;
    }



    public function getLTCLiability(){
        return $this->gemWorthSemiPrivateStay * ($this->gemWorthAverageStay * 1.5);
    }

    public function getRiderBenefits(){
        $amount = $this->attributes['how_mush_is_the_annual_amount_on_the_rider']?$this->attributes['how_mush_is_the_annual_amount_on_the_rider']:0;
        return $amount*(pow(1+$this->inflationRate,$this->getPlanDuration()));
    }

    public function getLTCNeed(){
        return $this->getLTCLiability() - $this->getPassiveIncome() - $this->riderBenefit;
    }

    // public function getInitialEquation(){
    //     return $this->getIncomeNeedToday() + $this->attributes['social_security_retirement_benefit_yours'] + ($this->attributes['free_Tax'] * $this->attributes['assume_interest_rate']) + ($this->attributes['tax_deferred'] * (1 - $this->attributes['effective_tax_rate']));
    // }

    public function getLTCScore(){
        if($this->getLTCLiability() != 0 && $this->getLTCNeed() != 0){
            return $this->getLTCLiability() / $this->getLTCNeed();
        }

        return 0;
    }

    // public function getLifeInsuranceIncome(){
    //     return $this->incomeTarget - $this->getInitialEquation();
    // }

    // public function getTotalLifeInsuranceNeed(){
    //     return $this->getLifeInsuranceIncome() / $this->attributes['assume_interest_rate'];
    // }

    public function getDebtScore(){
        if($this->sumOfDeptPaymentPerMonth != 0 && $this->getIncomePerMonth() != 0){
            return round(( $this->sumOfDeptPaymentPerMonth / $this->getIncomePerMonth() ) * (-150),2);
        }
        return 0;
    }

    public function getComments($wealth_score,$trigger,$score){
        $scope = "";
        $data = [];
        if($score > 0 || $score == "Yes"){
            $scope = "high";
        }
        if($score < 0 || $score == "No"){
            $scope = "low";
        }
        $comments_score = WealthScoreComment::where('list','why_did_i_get_this_score')
            ->where('wealth_score',$wealth_score)
            ->where('trigger_score',$trigger)
            ->where('trigger_scope',$scope)
            ->get();
        $comments_improve = WealthScoreComment::where('list','what_can_i_do_to_improve')
            ->where('wealth_score',$wealth_score)
            ->where('trigger_score',$trigger)
            ->where('trigger_scope',$scope)
            ->get();

        $data['score'] = [];
        $data['improve'] = [];

        foreach($comments_score as $row){
            $data['score'][] = $row->description;
        }

        foreach($comments_improve as $row){
            $data['improve'][] = $row->description;
        }

        return $data;
    }

    public function mergeMultipleArrays($arrays,$list = null){
        $data = [];
        foreach($arrays as $array){
            if(isset($list)){
                $array = $array[$list];
            }
            foreach($array as $row) {
                $data[] = $row;
            }
        }

        return $data;
    }

  


    public function CalculateLiquidityScore(){
        $emergency_fund_value = isset($this->attributes['what_is_the_total_value_of_your_emergency_fund'])?$this->attributes['what_is_the_total_value_of_your_emergency_fund']:0;
        $emergency_fund = $this->getComments('liquidity','emergency_fund_score',($emergency_fund_value >= $this->getIncome()*6)?"Yes":"No");
        $emergency_fund_2000 = $this->getComments('liquidity','emergency_fund_2000_score',($emergency_fund_value >= 2000)?"Yes":"No");
        $debt = $this->getComments('liquidity','debt_score',($this->getDebtScore() > 0)?"Yes":"No");

        $score                              = new \stdClass();
        $score->name                        = 'Liquidity';
        $score->result                      = round($this->getLiquidityScore());
        $score->why_did_i_get_this_score    = array_merge($emergency_fund['score'],$emergency_fund_2000['score'],$debt['score']);
        $score->what_can_i_do_to_improve    = array_merge($emergency_fund['improve'],$emergency_fund_2000['improve'],$debt['improve']);
        $score->flags                       = $this->getLiquidityFlags();
        $this->scores[]                     = $score;
    }

    public function getEmergencyFundScore(){
        $emergency_fund = isset($this->attributes['what_is_the_total_value_of_your_emergency_fund'])?$this->attributes['what_is_the_total_value_of_your_emergency_fund']:0;
        $emergency_fund_score = 60;
        $income = $this->getIncomePerMonth();
        if($income == 0){
            return 0;
        }
        if($emergency_fund < $income*6){
            $emergency_fund_score = (($income*6 - $emergency_fund)/$income)*-10;
            return $emergency_fund_score;
        }
        $emergency_fund_score += (($emergency_fund - $income*6)/$income)*5;
        return round($emergency_fund_score,2);
    }

    public function getLiquidityFlags($id = null){
        if(isset($id)){
            $this->putUser($id);
        }
        $flags = [];
        $income_per_month = $this->getIncomePerMonth();
        /***
         *  lacking You have high interest debt (Double mortgage rate)
         */
        $this->attributes['what_is_the_total_value_of_your_emergency_fund'] = isset($this->attributes['what_is_the_total_value_of_your_emergency_fund'])?$this->attributes['what_is_the_total_value_of_your_emergency_fund']:"";
        if($this->attributes['what_is_the_total_value_of_your_emergency_fund'] < 2000){
            $flags[] = Flag::where('description','Less than $2,000 in an emergency fund')->first();
        }
        if($this->sumOfDeptPaymentPerMonth > ($this->getIncome()/3)){
            $flags[] = Flag::where('description','Debt payments are a greater than 1/3 of income')->first();
        }
        if($this->attributes['what_is_the_total_value_of_your_emergency_fund'] < ($this->getIncome()*6)){
            $flags[] = Flag::where('description','Less than 6 months of income in emergency fund')->first();
        }
        if($this->sumOfDeptPaymentPerMonth > ($this->getIncome()*0.2)){
            $flags[] = Flag::where('description','Debt payments are greater than 20% of income')->first();
        }

        return $flags;
    }

    public function getLiquidityScore(){
        $results = 100 - (( 100 - $this->getEmergencyFundScore()) - $this->getDebtScore());
        if($results < 0){
            return 0;
        }

        if($results > 100){
            return 100;
        }
        return $results;
        //return round($results,2);
    }

    // public function getInsuranceScore(){
    //     if(in_array($this->attributes['state'], $this->getStates())){ $this->insuranceScore += 40; }
    //     if($this->attributes['do_you_have_life_insurance'] == 'Yes'){ $this->insuranceScore += 40; }
    //     if($this->attributes['do_you_have_disability_insurance'] == 'Yes'){ $this->insuranceScore += 5; }
    //     if($this->attributes['do_you_have_health_insurance'] == 'Yes'){ $this->insuranceScore += 5; }
    //     if($this->attributes['do_you_have_home_owners_insurance'] == 'Yes'){ $this->insuranceScore += 5; }

    //     return $this->insuranceScore;


    // }

    public function CalculateInsuranceScore(){
        $this->attributes['do_you_have_life_insurance'] = isset($this->attributes['do_you_have_life_insurance'])?$this->attributes['do_you_have_life_insurance']:"No";
        $this->attributes['do_you_have_disability_insurance'] = isset($this->attributes['do_you_have_disability_insurance'])?$this->attributes['do_you_have_disability_insurance']:"No";
        $this->attributes['do_you_have_health_insurance'] = isset($this->attributes['do_you_have_health_insurance'])?$this->attributes['do_you_have_health_insurance']:"No";
        $this->attributes['do_you_have_home_owners_insurance'] = isset($this->attributes['do_you_have_home_owners_insurance'])?$this->attributes['do_you_have_home_owners_insurance']:"No";
//        $this->attributes['state'] = isset($this->attributes['state'])?$this->attributes['state']:"";
//
//
//        if(in_array($this->attributes['state'], $this->getStates())){ $this->insuranceScore += 40; }
//        if($this->attributes['do_you_have_life_insurance'] == 'Yes'){ $this->insuranceScore += 40; }

        $this->insuranceScore += $this->getLTCScore() * 40;
        $this->insuranceScore += $this->getLifeInsurance() * 40;

        if($this->attributes['do_you_have_disability_insurance'] == 'Yes'){ $this->insuranceScore += 5; }
        if($this->attributes['do_you_have_health_insurance'] == 'Yes'){ $this->insuranceScore += 5; }
        if($this->attributes['do_you_have_home_owners_insurance'] == 'Yes'){ $this->insuranceScore += 5; }

        $have_life_insurance = $this->getComments('insurance','have_life_insurance', $this->attributes['do_you_have_life_insurance']);
        $have_disability_insurance = $this->getComments('insurance','have_disability_insurance', $this->attributes['do_you_have_disability_insurance']);
        $have_health_insurance = $this->getComments('insurance','have_health_insurance', $this->attributes['do_you_have_health_insurance']);
        $have_home_owners_insurance = $this->getComments('insurance','have_homeowners_insurance', $this->attributes['do_you_have_home_owners_insurance']);

        $score                              = new \stdClass();
        $score->name                        = 'Insurance';
        $score->why_did_i_get_this_score    = $this->mergeMultipleArrays([$have_life_insurance,$have_disability_insurance,$have_health_insurance,$have_home_owners_insurance],'score');
        $score->what_can_i_do_to_improve    = $this->mergeMultipleArrays([$have_life_insurance,$have_disability_insurance,$have_health_insurance,$have_home_owners_insurance],'improve');
        $score->result                      = $this->insuranceScore;
        $score->flags                       = $this->getInsuranceFlags();

        $this->scores[]                     = $score;
    }

    public function getInsuranceFlags($id = null){
        if(isset($id)){
            $this->putUser($id);
        }
        $flags = [];
        $this->attributes['do_you_have_life_insurance'] = isset($this->attributes['do_you_have_life_insurance'])?$this->attributes['do_you_have_life_insurance']:"No";
        $this->attributes['do_you_have_disability_insurance'] = isset($this->attributes['do_you_have_disability_insurance'])?$this->attributes['do_you_have_disability_insurance']:"No";
        $this->attributes['do_you_have_health_insurance'] = isset($this->attributes['do_you_have_health_insurance'])?$this->attributes['do_you_have_health_insurance']:"No";
        $this->attributes['do_you_have_home_owners_insurance'] = isset($this->attributes['do_you_have_home_owners_insurance'])?$this->attributes['do_you_have_home_owners_insurance']:"No";
        if($this->attributes['do_you_have_life_insurance'] == 'No'){
            $flags[] = Flag::where('description','Missing Homeowners Insurance')->first();
        }

        if($this->attributes['do_you_have_disability_insurance'] == 'No'){
            $flags[] = Flag::where('description','Missing Disability Insurance')->first();
        }

        if($this->attributes['do_you_have_health_insurance'] == 'No'){
            $flags[] = Flag::where('description','Missing Auto Insurance')->first();
        }

        if($this->attributes['do_you_have_home_owners_insurance'] == 'No'){
            $flags[] = Flag::where('description','Missing Health Insurance')->first();
        }

        return $flags;
    }


    public function getLiabilitySum($frequency = "monthly"){
        $liabilities = isset($this->attributes['liabilities'])?unserialize($this->attributes['liabilities']):[];
        $total_liability_value = 0;
        $frequency = ($frequency == "annual")?12:1;
        foreach($liabilities as $liability){
            if(isset($liability['monthly_payment'])){
                $total_liability_value += ($liability['monthly_payment']*$frequency);
            }
        };

        return $total_liability_value;
    }
    public function getNetWorth(){
        $pre_tax_income = isset($this->attributes['pre_tax_income'])?(float)$this->attributes['pre_tax_income']:0;
        $pre_tax_income_spouse = isset($this->attributes['pre_tax_income_spouse'])?(float)$this->attributes['pre_tax_income_spouse']:0;
        $assets = isset($this->attributes['assets'])?unserialize($this->attributes['assets']):[];

        $total_asset_value = 0;
        $total_liability_value = 0;

        $retirement_assets = ['401k','403b','Simple','SEP','IRA','ROTH'];
        $bank_assets = ['Savings','Checkings','Brokerage'];
        
        foreach($assets as $key => $asset){
            $value = isset($asset['value'])?$asset['value']:0;
            $annual_income = isset($asset['annual_income'])?$asset['annual_income']:0;
            $additions = isset($asset['additions'])?$asset['additions']:0;
            $withdrawals = isset($asset['withdrawals'])?$asset['withdrawals']:0;
            $balance = isset($asset['balance'])?$asset['balance']:0;
           
            if($asset['asset_type'] == "Rental Properties" || $asset['asset_type'] == "Business"){
                $total_asset_value += ($value + $annual_income);
            }
            if($asset['asset_type'] == "Home"){
                $total_asset_value += $annual_income;
            }

            if(in_array($asset['asset_type'], $bank_assets)){
                $final_additions = ($additions - $withdrawals);
                $total_additions = $final_additions;
                if($asset['asset_type'] == "Brokerage"){
                    $discount = $withdrawals * ($this->brokerageDiscountCoverage * .01);
                    $total_additions += $discount;
                }
                $total_asset_value += $total_additions;
            }



            if($this->attributes['age'] >= $this->attributes['what_age_do_you_plan_on_retiring_age']){
                if(in_array($asset['asset_type'], $retirement_assets)){
                    $total_asset_value += $balance;
                }
            }
        };




        $total_liability_value = $this->getLiabilitySum("annual");
        $net_worth = $pre_tax_income + $pre_tax_income_spouse + ($total_asset_value - $total_liability_value);
        return $net_worth;

        //NetWorth = Pre-Tax Annual Income + Spouse Pre-Tax Annual Income + SumOfSpecifiedAssets – SumOfLiabilities

    }

    public function CalculateLegacyScore(){
        $net_worth = $this->getNetWorth();
        //$net_worth = isset($this->attributes['net_worth'])?$this->attributes['net_worth']:0;
        $do_you_have_a_will = isset($this->attributes['do_you_have_a_will'])?$this->attributes['do_you_have_a_will']:"No";
        $do_you_have_healthcare_proxy = isset($this->attributes['do_you_have_healthcare_proxy'])?$this->attributes['do_you_have_healthcare_proxy']:"No";
        $do_you_have_power_of_attorney = isset($this->attributes['do_you_have_power_of_attorney'])?$this->attributes['do_you_have_power_of_attorney']:"No";
        $have_special_needs_trust = isset($this->attributes['have_special_needs_trust'])?$this->attributes['have_special_needs_trust']:"No";

        $have_will = $this->getComments('legacy','have_will',$do_you_have_a_will);
        $have_healthcare_proxy = $this->getComments('legacy','have_healthcare_proxy',$do_you_have_healthcare_proxy);
        $have_power_of_attorney = $this->getComments('legacy','have_power_of_attorney',$do_you_have_power_of_attorney);
        $have_special_needs_child = $this->getComments('legacy','have_special_needs_child',$have_special_needs_trust);
        $high_net_worth = $this->getComments('legacy','high_net_worth',($net_worth > self::HIGH_NET_WORTH?1:0));


        if($do_you_have_a_will == "Yes"){
            $this->legacyScore += ($net_worth > self::HIGH_NET_WORTH)?30:50;
        }

        if($do_you_have_healthcare_proxy == "Yes"){
            $this->legacyScore += ($net_worth > self::HIGH_NET_WORTH)?20:25;
        }

        if($do_you_have_power_of_attorney == "Yes"){
            $this->legacyScore += ($net_worth > self::HIGH_NET_WORTH)?20:25;
        }

        if(isset($this->attributes['have_child_special_needs']) && $this->attributes['have_child_special_needs'] == "Yes"){
            $this->legacyScore = 0;
        }

        if($have_special_needs_trust == "Yes"){
            $this->legacyScore += 100;
        }

        $this->legacyScore = ($this->legacyScore > 100)?100:$this->legacyScore;

        if($this->inFilialState){
            if($this->getLTCScore() < 100){
                $this->legacyScore = $this->legacyScore - (100 - $this->getLTCScore());
            }
        }

        $this->legacyScore = ($this->legacyScore < 0)?0:$this->legacyScore;
        $this->legacyScore = ($this->legacyScore > 100)?100:$this->legacyScore;

        $score                              = new \stdClass();
        $score->name                        = 'Legacy';
        $score->why_did_i_get_this_score    = $this->mergeMultipleArrays([$have_will,$have_healthcare_proxy,$have_power_of_attorney,$have_special_needs_child,$high_net_worth],"score");
        $score->what_can_i_do_to_improve    =  $this->mergeMultipleArrays([$have_will,$have_healthcare_proxy,$have_power_of_attorney,$have_special_needs_child,$high_net_worth],"improve");
        $score->result                      = $this->legacyScore;

        $score->flags                       = $this->getLegacyFlags();
        $this->scores[]                     = $score;

        return $this->legacyScore;


    }

    public function getLegacyFlags($id = null){
//        if(isset($id)){
//            $this->putUser($id);
//        }
        $this->attributes['married'] = isset($this->attributes['married'])?$this->attributes['married']:"No";
        $flags = [];
        $net_worth = isset($this->attributes['net_worth'])?$this->attributes['net_worth']:0;
        $do_you_have_a_will = isset($this->attributes['do_you_have_a_will'])?$this->attributes['do_you_have_a_will']:"No";
        $have_special_needs_trust = isset($this->attributes['have_special_needs_trust'])?$this->attributes['have_special_needs_trust']:"No";
        $have_special_needs = isset($this->attributes['have_special_needs'])?$this->attributes['have_special_needs']:"No";
        $this->attributes['number_children'] = isset($this->attributes['number_children'])?$this->attributes['number_children']:"";
        $number_children = isset($this->attributes['children'])?count(unserialize($this->attributes['children'])):0;
        if($this->attributes['married'] == 'Yes' && $do_you_have_a_will == "No"){
            $flags[] = Flag::where('description','Married and no will')->first();
        }

        /*if($this->attributes['number_children'] > 0 && $do_you_have_a_will == "No"){
            $flags[] = Flag::where('description','Married and no will')->first();
        }*/

        if($number_children > 0 && $do_you_have_a_will == "No"){
            $flags[] = Flag::where('description','Kids and no will')->first();
        }

        if($have_special_needs == "Yes" && $have_special_needs_trust == "No"){
            $flags[] = Flag::where('description','Special needs child: Your child must have a special needs trust or they risk losing government assistance.')->first();
        }

        if($net_worth > self::HIGH_NET_WORTH && $have_special_needs_trust == "No"){
            $flags[] = Flag::where('description','High Net Worth and no trust')->first();
        }

       /* if($this->attributes['married'] == 'No' && $do_you_have_a_will == "No"){
            $flags[] = Flag::where('description','Married and kids with no will')->first();
        }*/
        return $flags;
    }


    public function calculateCDRateOfReturn($cd){
        $interest_rate = str_replace('%','',$cd['interest_rate']) * 0.01;
        return $cd['value']*(pow((1+$interest_rate),($cd['months_remaining']/12)));
    }

    public function calculateCDScore($cd){
        $ror = $this->calculateCDRateOfReturn($cd);
        if($ror < $this->inflationRate){
            return -1;
        }else if($ror == $this->inflationRate){
            return 0;
        }
        return 1;
    }

    public function getAssetsWithSymbolValue(){
        $assets = (isset($this->attributes['assets']))?unserialize($this->attributes['assets']):[];
        //$symbol_sums = [];
        foreach($assets as $asset_key => $asset_value){
            $asset = $asset_value;
            if(isset($asset['symbols']) && count($asset['symbols']) > 0){
                $symbol_sum = 0;
                foreach($asset['symbols'] as $key => $value){
                    if(isset($value['share_price']) && isset($value['number_of_shares'])){
                        $asset['symbols'][$key]['value'] = str_replace(['$',',',' '],'',$value['share_price'])*$value['number_of_shares'];
                    }else{
                        $asset['symbols'][$key]['value'] = 0;
                    }


                    $symbol_sum += $asset['symbols'][$key]['value'];

                }
                foreach($asset['symbols'] as $key => $value){
                    if($symbol_sum != 0) {
                        $asset['symbols'][$key]['percent_of_account'] = $value['value'] / $symbol_sum;
                    }else{
                        $asset['symbols'][$key]['percent_of_account'] = 0;
                    }


                }
            }
            $assets[$asset_key] = $asset;
        }

        return $assets;
    }
    public function getSymbols(){
        $investments = [];
        if(isset($this->attributes['assets']) && $this->attributes['assets'] != '') {
            foreach (unserialize($this->attributes['assets']) as $row) {
                if (isset($row['symbols'])) {
                    foreach ($row['symbols'] as $symbol) {
                        $investments[] = $symbol['symbol'];
                    }
                }
            }
        }
        return $investments;
    }

    public function getCDs(){
        $cds = [];
        if(isset($this->attributes['assets']) && $this->attributes['assets'] != '') {
            foreach (unserialize($this->attributes['assets']) as $row) {
                if($row['asset_type'] == 'CDs' || $row['asset_type'] == 'cds'){
                    $cds[] = $row;
                }
            }

        }
        return $cds;
    }
    public function calculateSymbolSum($symbol){
        $assets = $this->getAssetsWithSymbolValue();
        $total_value = 0;
        foreach($assets as $asset){
            if(isset($asset['symbols']) && $asset['symbols'] > 0){
                foreach($asset['symbols'] as $asset_symbol){
                    if($symbol == $asset_symbol['symbol']){
                        $total_value += $asset_symbol['value'];
                    }
                }
            }
        }
        return $total_value;
    }
    public function calculateDiversification(){
        $symbols = $this->getSymbols();
        $symbols_diverse = [];
        $assets = isset($this->attributes['assets'])?unserialize($this->attributes['assets']):[];
        $total_sum = 0;
        foreach($symbols as $symbol){
            $symbols_diverse[] = [
                "ticker" => str_replace(['#',' '],'',$symbol),
                "sum" => $this->calculateSymbolSum($symbol)
            ];
            $total_sum += $this->calculateSymbolSum($symbol);
        }


        foreach($symbols_diverse as $key => $value){
            if($total_sum != 0) {
                $symbols_diverse[$key]['pwa'] = $value['sum'] / $total_sum;
            }else{
                $symbols_diverse[$key]['pwa'] = 0;
            }
        }
        return $symbols_diverse;
    }
    public function CalculateInvestmentScore(){
        $calculations = new Csv();
        $result    = 0;
        $investments = $this->getSymbols();
        $cds = $this->getCDs();
        if(isset($this->attributes['assets'])){
            $mar_basis = $this->attributes['you_would_fire_me_panic_go_to_cash'];
            $true_risk_formulas = [];
            $mar = 0;
            if($mar_basis >= 0 && $mar_basis <= 10){
                $mar = 0;
            }elseif($mar_basis >= 11 && $mar_basis <= 19){
                $mar = .02;
            }elseif($mar_basis >= 20 && $mar_basis <= 29){
                $mar = .04;
            }elseif($mar_basis >= 30) {
                $mar = .06;
            }
            //dd($investments);
            foreach($investments as $investment){
                $symbol = Setting::where('name',$investment)->first();
                if(isset($symbol)){
                    $true_risk_formulas[] = $calculations->getTrueRiskFormula($mar,$symbol->geometric_return,$symbol->absolute_value);
                }

            }


            $this->true_risk_formula = 0;
            if(count($true_risk_formulas) > 0){
                $this->true_risk_formula = array_sum($true_risk_formulas)/count($true_risk_formulas);
            }
            if($this->true_risk_formula == 0 && (!isset($this->attributes['assets']) || count($investments) == 0)){
                $result += 0;
            }elseif($this->true_risk_formula < -2){
                $result += 25;
            }elseif($this->true_risk_formula >= -2 && $this->true_risk_formula < -1){
                $result += 35;
            }elseif($this->true_risk_formula >= -1 && $this->true_risk_formula < -0.5){
                $result += 53;
            }elseif($this->true_risk_formula >= -0.5 && $this->true_risk_formula < 0){
                $result += 68;
            }elseif($this->true_risk_formula == 0){
                $result += 75;
            }elseif($this->true_risk_formula > 0 && $this->true_risk_formula < 0.5){
                $result += 78;
            }elseif($this->true_risk_formula >= 0.5 && $this->true_risk_formula < 1){
                $result += 88;
            }elseif($this->true_risk_formula >= 1 && $this->true_risk_formula < 2){
                $result += 93;
            }elseif($this->true_risk_formula >= 2 && $this->true_risk_formula < 3){
                $result += 98;
            }elseif($this->true_risk_formula >= 3){
                $result += 100;
            }
        }



        /**========================================================
        Included CD Score
        ========================================================**/
        $total_cd_score = 0;
        foreach($cds as $row){
            $score = $this->calculateCDScore($row);
            $total_cd_score += $score;
        }

        $result += $total_cd_score;



        if($result > 100){
            $result = 100;
        }

        if($result < 0){
            $result = 0;
        }

        $true_risk_formula = $this->getComments('investments','true_risk_formula',(($this->true_risk_formula >= 3)?"Yes":"No"));

        $score                              = new \stdClass();
        $score->name                        = 'Investments';
        $score->why_did_i_get_this_score    = $true_risk_formula['score'];
        $score->what_can_i_do_to_improve    = $true_risk_formula['improve'];
        $score->result                      = $result;
        $score->flags                     = $this->getInvestmentFlags();

        $this->scores[]                     = $score;

        $this->investmentScore = $score;

        return $this->investmentScore;
    }

    public function getInvestmentFlags($id = null){
//        if(isset($id)){
//            $this->putUser($id);
//        }
        $symbols_diverse = $this->calculateDiversification();
        $flags = [];
        foreach($symbols_diverse as $row){
            if(strlen($row['ticker']) < 5 && $row['pwa'] > 0.05){
                $flag = Flag::where('description','Stock '.$row['ticker'].' is not diversified')->first();
                if($flag){
                    $flags[] = $flag;
                }
            }
            elseif(strlen($row['ticker']) >= 5 && $row['pwa'] > 0.15){
                $flag = Flag::where('description','Mutual Fund '.$row['ticker'].' is not diversified')->first();
                if($flag){
                    $flags[] = $flag;
                }
            }
        }
        if($this->true_risk_formula < 0){
            $flags[] = Flag::where('description','There is a cheaper alternative to invest in unless True Risk Formula is higher with current allocation')->first();
        }

        if($this->true_risk_formula < 3){
            $flags[] = Flag::where('description','Possible investment upgrade')->first();
        }

        return $flags;
    }

    public function getIncomeNeedToday(){
        if(isset($this->attributes['in_todays_dollars_do_you_know_the_exact_after_tax_income_you_will_need_in_retirement']) && $this->attributes['in_todays_dollars_do_you_know_the_exact_after_tax_income_you_will_need_in_retirement'] != '' && $this->attributes['in_todays_dollars_do_you_know_the_exact_after_tax_income_you_will_need_in_retirement'] != 0) {
            return $this->attributes['in_todays_dollars_do_you_know_the_exact_after_tax_income_you_will_need_in_retirement'] * 12;
        }

        return 2000;
    }

    public function getRetirementScore(){
        $ret_values = $this->getRetirementValues();
        $percentage = ($ret_values["cover"] > 0)?$ret_values["gap"]/$ret_values["cover"]:0;
        $score = 110 - round($percentage * 100);
//        dd($this->attributes['age']);
//        $this->attributes['what_age_would_you_like_us_to_assume'] = isset($this->attributes['what_age_would_you_like_us_to_assume'])?$this->attributes['what_age_would_you_like_us_to_assume']:65;
 //       $result                             = 0;
    //    $pow                                = @$this->attributes['what_age_would_you_like_us_to_assume'] - @$this->attributes['age'];

//        if($this->attributes['income_need_today'] != ''){
    //    if($this->getIncomeNeedToday() != '' || $this->getIncomeNeedToday() != 0){
//            $this->retirement_income_need         += $this->attributes['income_need_today'] * pow(( 1 + $this->inflationRate()), $pow);
    //        $this->retirement_income_need         += $this->getIncomeNeedToday() * pow(( 1 + $this->inflationRate), $pow);
    //        $result                         = 100*(($this->getRetirementIncome()) / (1.1 * $this->retirement_income_need));
    //        $result                         = ( $result <= 100 ) ? $result : 100 ;
    //    }

        return ($score > 100)?100:$score;
//        $result = $this->getIncomeNeedToday();
    }


    public function CalculateRetirementScore(){
        $result = $this->getRetirementScore();
        $income_need_score = "";
        $income_need_scope = "Yes";
        if($result >= 100 ){
            $income_need_score = '100_percent_lifetime_retirement_income_need';
        }
        if($result < 100 && $result >= 90){
            $income_need_score = '90_percent_lifetime_retirement_income_need';
        }
        if($result < 90 && $result >= 75){
            $income_need_score = '75_percent_lifetime_retirement_income_need';
        }
        if($result < 75 && $result >= 50){
            $income_need_score = '50_percent_lifetime_retirement_income_need';
        }
        if($result < 50){
            $income_need_score = '50_percent_lifetime_retirement_income_need';
            $income_need_scope = "No";
        }
        $retirement_income_need = $this->getComments('retirement',$income_need_score,$income_need_scope);
        $score                              = new \stdClass();
        $score->name                        = 'Retirement';
        $score->why_did_i_get_this_score    = $retirement_income_need['score'];
        $score->what_can_i_do_to_improve    = $retirement_income_need['improve'];
        $score->result                      = $result;
        $score->flags                       = $this->getRetirementFlags();

        $this->scores[]                     = $score;
    }

    public function getSavings(){
        $savings = 0;
        if(isset($this->attributes['assets'])){
            if($this->attributes['assets'] != '') {
                $assets = unserialize($this->attributes['assets']);
                foreach ($assets as $asset) {
                    if ($asset['asset_type'] == "Savings" || $asset['asset_type'] == "savings") {
                        $savings += $asset['balance'];
                    }
                }
            }
        }
        return $savings;
    }
    public function getRetirementFlags($id = null){
//        if($id != null){
//            $this->putUser($id);
         $x     = @$this->attributes['what_age_do_you_plan_on_retiring_age'];
        $age    = @$this->attributes['age'];
//            dd($x);

//        }

        $flags = [];
        $result = $this->getRetirementScore();
        if($x < 65){
            $flags[] = Flag::where('description', 'Your income will not last to life expectancy because your retirement is too early')->first();
        }


        $savings = $this->getSavings();
        /** Figures came from investopedia.com
         * */
        if($result < 100){
            if($age >= 20 && $age <= 29 && $savings < 45000){
                $flags[] = Flag::where('description', 'Your income will not last to life expectancy because you don’t save enough')->first();
            }
            if($age >= 30 && $age <= 39 && $savings < 16000){
                $flags[] = Flag::where('description', 'Your income will not last to life expectancy because you don’t save enough')->first();
            }
            if($age >= 40 && $age <= 49 && $savings < 165000){
                $flags[] = Flag::where('description', 'Your income will not last to life expectancy because you don’t save enough')->first();
            }
            if($age >= 50 && $age <= 59 && $savings < 240000){
                $flags[] = Flag::where('description', 'Your income will not last to life expectancy because you don’t save enough')->first();
            }
            if($age >= 60  && $savings < 360000){
                $flags[] = Flag::where('description', 'Your income will not last to life expectancy because you don’t save enough')->first();
            }

        /**
         *  don't move, this flag is based on the presence of the above three red flags.
         */

            if($age > 62){
                $flags[] = Flag::where('description', 'There may be a more advanced way to plan social security')->first();
            }

            if($age < 70.5){
                $flags[] = Flag::where('description', 'You may benefit from taking RMD ’s earlier than age 70 1/2 please consult a CPA.')->first();
            }

            if(count($flags) > 3){
                $flags[] = Flag::where('description', 'At your current rate of savings, you will never be able to reach your retirement goal.')->first();
            }
        }


        //if($this->retirement_income_need)

        return $flags;
    }

    public function CalculateCollege(){
        $result                             = 0;
        $score                              = new \stdClass();
        $score->name                        = 'College';
        $score->why_did_i_get_this_score    = ["Lorem Ipsum is simply dummy text of the printing and typesetting industry.","Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book."];
        $score->what_can_i_do_to_improve    = ["It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.","t was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum."];
        $score->result                      = $result;

        $flag                               =  new \stdClass();
        $flag->color                        = "red";
        $flag->description                  = "Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old.";
        $score->flags[]                     = $flag;

        $flag                               =  new \stdClass();
        $flag->color                        = "yellow";
        $flag->description                  = "There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable.";
        $score->flags[]                     = $flag;

        $this->scores[]                     = $score;
    }

    public function CalculateCashFlow(){
        $result                             = 0;
        $score                              = new \stdClass();
        $score->name                        = 'Cashflow';
        $score->why_did_i_get_this_score    = ["Lorem Ipsum is simply dummy text of the printing and typesetting industry.","Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book."];
        $score->what_can_i_do_to_improve    = ["It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.","t was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum."];
        $score->result                      = $result;

        $flag                               =  new \stdClass();
        $flag->color                        = "red";
        $flag->description                  = "Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old.";
        $score->flags[]                     = $flag;

        $flag                               =  new \stdClass();
        $flag->color                        = "yellow";
        $flag->description                  = "There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable.";
        $score->flags[]                     = $flag;

        $this->scores[]                     = $score;
    }

    public function results($id = null){
        if(isset($id)){
            $this->user = $this->model->find($id);
            $this->attributes = [];
            foreach ($this->user->usermeta as $meta) {
                $this->attributes[$meta['option']] = $meta['value'];
            }
            $this->execute();
        }
        $data["scores"] = $this->scores;
        return $data;
    }

    public function test($id = null){
        if(isset($id)){
            $this->user = $this->model->find($id);
            $this->attributes = [];
            foreach ($this->user->usermeta as $meta) {
                $this->attributes[$meta['option']] = $meta['value'];
            }
            $this->execute();
        }
        return $this;
    }

    public function putUser($id = null){
        if(isset($id)){
            $this->user = $this->model->find($id);
            $this->attributes = [];
            foreach ($this->user->usermeta as $meta) {
                $this->attributes[$meta['option']] = $meta['value'];
            }
//            $this->execute();
        }
    }

    public function getExpectedSocialSecurityBenefit(){

        $return = $this->annualFullRetirementBenefit;
        $return *= ($this->yearDifference > -1)?pow(1+($this->retirementAdjustment),$this->yearDifference):(1-$this->retirementAdjustment);
        $return *= pow(1+($this->inflationRate),$this->yearDifference);
        $return *= $this->SSBenefitAdjustment;

        return round($return,2);
    }





    /***************************************
     * For Social Security Beneft, Rental Properties, and Savings
     * Add 'Annuity to specify'
     * @param $value e.g. ss beneft
     * @param $rate  1=growth+inflation  2=discount+inflation 3=growth
     * @return mixed$this->getMAR()
     */

    public function getIncrementYearValue($value,$rate = null){
        $total_rate = 0;
        $inflation_rate = $this->inflationRate;
        if($rate == 1 || $rate == 3){
            $total_rate = $this->getMAR();
        }
        if($rate == 2){
            $total_rate = $this->getDiscountRate();
        }

        if($rate == 3){
            $inflation_rate = 0;
        }
       
        return $value * (1 + $total_rate + $inflation_rate);
    }

    /**
     * @param $initial_value
     * @param bool $discount_rate = SET IF DISCOUNT RATES need to be applied
     * @param null $span
     * @return mixed
     */
    public function getCurrentYearValue($initial_value,$discount_rate = false,$span = null){
        if(!is_bool($discount_rate)){
            $span = $discount_rate;
            $discount_rate = false;
        }
        $span = isset($span)?$span:$this->getPlanDuration();
        $rate = $discount_rate?$this->getDiscountRate()+$this->inflationRate:$this->inflationRate;
        return $initial_value * pow((1 + $rate), $span);
    }






    public function getRevisedSSBenefitSpouse(){
        $return = $this->annualFullRetirementBenefitSpouse;
        $return = ($return < $this->annualFullRetirementBenefit/2)?$this->annualFullRetirementBenefit/2:$return;
        return round($return,2);
    }

    public function getRetirementAdjustmentSpouse(){
        return round(abs($this->yearDifferenceSpouse) * 12 * (25/36 * 0.01),4);
    }
    public function getAdjustedSSBenefitSpouse(){
        $return = $this->getRevisedSSBenefitSpouse();
        if($this->yearDifferenceSpouse < -1){
            $return *= (1 - $this->getRetirementAdjustmentSpouse());
        }
        $return *= $this->SSBenefitAdjustmentSpouse;
        return round($return,2);
    }



    public function getFullRetirementAge($year)
    {
        if ($year <= 1939) {
            return 65;
        }
        if ($year > 1939 && $year <= 1956) {
            return 66;
        }
        if ($year > 1956) {
            return 67;
        }
        return false;
    }
    public function getYearlyRateOfIncrease($year)
    {

        if ($year <= 1934) {
            return .055;
        }
        if ($year > 1934 && $year <= 1936) {
            return .06;
        }
        if ($year > 1936 && $year <= 1938) {
            return .065;
        }
        if ($year > 1938 && $year <= 1940) {
            return .07;
        }
        if ($year > 1940 && $year <= 1942) {
            return .075;
        }
        if ($year > 1942) {
            return .08;
        }
        return false;
    }
    public function getBirthYear($age){
        return date('Y') - $age;
    }

    public function getYearDifference($age,$retirement_age){
        return ($retirement_age - $this->getFullRetirementAge($this->getBirthYear($age)));

    }

    public function getRetirementAdjustment($year_difference,$birth_year){
        if($year_difference > -1){
            return  $this->getYearlyRateOfIncrease($birth_year);
        }
       return round(12*abs($year_difference)*((5/9)*0.01),4);
    }



    public function getFullRetirementAgeBenefits($age,$retirement_age,$amount = null){
        $birth_year = $this->getBirthYear($age);
        $year_difference = $this->getYearDifference($age,$retirement_age);
        $total_rate = 0;
        /*$amount = 1000;
        $year_difference  = -3;*/
        for($x = 1;$x <= abs($year_difference); $x++){
            if($year_difference > 0) {
                $total_rate *= 1+$this->getYearlyRateOfIncrease($birth_year);
                if($x == 1){
                    $total_rate = 1+$this->getYearlyRateOfIncrease($birth_year);
                }
                $array[] = $total_rate;
            }else{
                if($x <= 3){
                    $total_rate -= 0.0667;
                    if($x == 1){
                        $total_rate = -0.0667;
                    }
                }else{
                    $total_rate -= 0.05;
                }
            }
        }
        if(is_null($amount)){
            return $total_rate;
        }
        //dd($amount*$total_rate,$amount+($amount*$total_rate));
        if($year_difference > 0){
            //dd($amount*$total_rate);
            return $amount*$total_rate;
        }else{
            //dd($amount+($amount*$total_rate));
            return $amount+($amount*$total_rate);
        }
    }

    /************
     * Getting the Sum of Assets
     *
     * @param $asset_type
     * @param null $total_field
     * @return array|number
     */
    public function getAsset($asset_type,$owner = null, $total_field = null){
        $assets = isset($this->attributes['assets'])?unserialize($this->attributes['assets']):[];
        $return_assets = [];
        foreach($assets as $asset){
            $asset["own"] = isset($asset["own"])?$asset["own"]:"mine";
            if($asset["asset_type"] == $asset_type && (is_null($owner) || $asset["own"] == $owner)){
                $return_assets[] = isset($total_field)?(isset($asset[$total_field])?$asset[$total_field]:0):$asset;

            }
            
        }
       
        return ($total_field)?array_sum($return_assets):$return_assets;

    }

     public function getTotalCDValue($owner){
        $cds = $this->getAsset("CDs",$owner);
        $total = 0;
        foreach($cds as $cd){
            $total += $cd["value"]*pow(1+$this->discountRate,$cd["months_remaining"]/12);
        }
        return $total;
    }


    // public function getCurrentBrokerageValue($owner){
    //     $brokerage = $this->getAsset("Brokerage",$owner,"balance");
    //     return $this->getAsset("Brokerage",$owner,"balance") + $this->getCurrentBrokerageIncome($owner);
    // }

    // public function getCurrentBrokerageIncome($owner){
    //     $additions = $this->getAsset("Brokerage",$owner,"additions_per_year");
    //     $withdrawals = $this->getAsset("Brokerage",$owner,"withdrawals_per_year");
    //     return (-1 * ($this->getLifeInsurance() + $this->getTotalCDValue($owner) + ($additions - $withdrawals)));
    // }

    // public function getIncrementBrokerageValue($value,$owner){
    //     return ($value - $this->getCurrentBrokerageIncome($owner) * (1 + $this->getMAR()));
    // }
    //Current Year Brokerage Value = (Previous Year Balance - Current Brokerage Income) * (1 + MAR   ROBO-108 DONE  

    public function getPension($owner = null){
        $pensions = isset($this->attributes['pension'])?unserialize($this->attributes['pension']):[];
       return $this->getPensionIncome($pensions,$owner);
    }

    public function getIncomeToday($asset_type, $total_field){
        $assets = isset($this->attributes['assets'])?unserialize($this->attributes['assets']):[];
        //$pension = isset($this->attributes['pension'])?unserialize($this->attributes['pension']):[];
        //$assets = ($asset_type == "Pension")?$pension:$assets;
        $duration = $this->getPlanDuration();
        $discount_rate = $this->getDiscountRate();
        $total_value = 0;

        foreach($assets as $asset){
            //if(($asset_type == "Pension") || ($asset_type != "Pension" && ($asset["asset_type"] == $asset_type))){
                $total_value += str_replace(['%', '$', ',', ' '], '',$asset[$total_field]);
            //}
        }

        //$total_value *= ($asset_type=="Pension")?12:1;
        //return $total_value*pow((1+$discount_rate),$duration);
        return $total_value;

    }

 
    /***
     * TODO: ask to site death of spouse
     */

    public function getTotalSurvivorBenefit($owner = null){
        $pension = isset($this->attributes['pension'])?unserialize($this->attributes['pension']):[];
        $total = 0;
        foreach($pension as $item){
            // TODO: implement pension ownership
            if($owner == null || (isset($item['own']) && $item['own'] == $owner)){
                $survivor_benefit = isset($item['what_percent_gets_passed_on'])?str_replace(['%', '$', ',', ' '], '', $item['what_percent_gets_passed_on'])*0.01:0;
            $total += $survivor_benefit * $item['projected_monthly_pension_benefit'];
            }
            
        }

        return $total*12;
    }

    public function getIncrementPensionValue($value,$age = 0,$owner=null){
        $life_expectancy = $owner==null?$this->lifeExpectancySpouse:$this->lifeExpectancy;
        $other = $owner=="mine"?"spouse":"mine";
        $outlives_other = $age > $life_expectancy;
        if($this->getTotalSurvivorBenefit($other) > 0 && $outlives_other){
            return ($value*(1 + $this->getDiscountRate())) + ($this->getTotalSurvivorBenefit($other));
        }
        return ($value*(1 + $this->getDiscountRate()));
    }

    public function getCurrentPensionValue($age,$owner,$span){
        $pensions = isset($this->attributes['pension'])?unserialize($this->attributes['pension']):[];

        $total_income = 0;
        foreach($pensions as $pension) {
            if($owner==null || (isset($pension['own']) && $pension['own'] == $owner)){
                $value = str_replace(['%', '$', ',',' '],'', $pension['projected_monthly_pension_benefit']);
                if($pension['does_it_have_a_cost_of_living_adjustment'] == "Yes"){
                    $value *= pow(1+$this->inflationRate,$span);    
                }
                $total_income += $value;
            }
        }

        $total_income *= 12;
        // Adding Survivor Benefit
        $life_expectancy_other = $owner=="own"?$this->lifeExpectancySpouse:$this->lifeExpectancy;
        $other = $owner=="mine"?"spouse":"mine";

        if($age >= $life_expectancy_other && ($this->getTotalSurvivorBenefit($other))){
            $total_income += $this->getTotalSurvivorBenefit($other);
        }
        return $total_income;
       // return ($value*(1 + $this->getDiscountRate()));
    }

    // public function getCurrentLifeInsurance(){
    //     $insurances = isset($this->attributes['insurance'])?unserialize($this->attributes['insurance']):[];
    //     $total_death_benefit = 0;
    //     foreach($insurances as $insurance){
    //         if($insurance['death_benefit'] && $insurance['cash_value']){
    //             $total_death_benefit += ($insurance['cash_value'] * ($insurance['death_benefit'] * 0.01));
    //         }
    //     }

    //     return $total_death_benefit;
    // }
    public function getTotalDeathBenefit(){
        $insurances = isset($this->attributes['life_insurance'])?unserialize($this->attributes['life_insurance']):[];
        $total_death_benefit = 0;
        foreach($insurances as $insurance){
            if($insurance['death_benefit'] && $insurance['cash_value']){
                $total_death_benefit += ($insurance['cash_value'] * (($insurance['death_benefit'] * 0.01)));
            }
        }
        return $total_death_benefit;
    }



    public function getLifeInsurance(){
        if($this->getTotalLifeInsuranceIncomeNeed() == 0){
            return 0;
        }
        return $this->getCurrentLifeInsurance()/$this->getTotalLifeInsuranceIncomeNeed();
    }
    public function getEffectiveTaxRate(){
        $pre_tax_income = isset($this->attributes['pre_tax_income'])?$this->attributes['pre_tax_income']:0;
        $pre_tax_income_spouse = isset($this->attributes['pre_tax_income_spouse'])?$this->attributes['pre_tax_income_spouse']:0;
        $total_pre_tax_income = $pre_tax_income + $pre_tax_income_spouse;
        $status = "single_filters";

        if($this->attributes['married'] == 'Yes'){
            $status = "married_filling_jointly";
        }
        $tax_bracket = Tax::where($status."_from","<=",$total_pre_tax_income)->where($status."_to",">=",$total_pre_tax_income)->first();

        $effective_tax_rate = ($tax_bracket->tax_rate * $total_pre_tax_income) / $total_pre_tax_income;

        return $effective_tax_rate;
    }

    public function getPassiveIncome(){
        $annuity_income = $this->getIncomeToday("Annuity","value");
        $pension = $this->getIncomeToday("Pension","projected_monthly_pension_benefit");
        $ss_yours = isset($this->attributes['social_security_retirement_benefit_yours'])?$this->attributes['social_security_retirement_benefit_yours']:0;
        $ss_spouse =  isset($this->attributes['social_security_retirement_benefit_spouse'])?$this->attributes['social_security_retirement_benefit_spouse']:0;
        $social_security_income = $ss_yours + $ss_spouse;

        //$total_death_benefit = $this->getTotalDeathBenefit();

        $tax_free = isset($this->attributes['tax_free'])?$this->attributes['tax_free']:0;
        $tax_deferred = isset($this->attributes['tax_deferred'])?$this->attributes['tax_deferred']:0;

        $passive_income = $annuity_income+$pension+$social_security_income+($tax_free * $this->assumedInterestRate)+($tax_deferred * $this->assumedInterestRate * (1 - $this->getEffectiveTaxRate()));

        return $passive_income;

    }

    public function getLifeInsuranceIncomeNeed(){
        return ($this->getRetirementIncome() * 12) - $this->getPassiveIncome();

    }

    public function getTotalLifeInsuranceIncomeNeed(){
        if($this->assumedInterestRate == 0){
            return 0;
        }
        return ($this->getLifeInsuranceIncomeNeed()/$this->assumedInterestRate);

    }

    public function getPensionIncome($pension_array,$owner = null){
        $pensions = is_string($pension_array)?unserialize($pension_array):$pension_array;
        $total_income = 0;
        foreach($pensions as $pension) {
            if($owner==null || (isset($pension['own']) && $pension['own'] == $owner)){
                $total_income += str_replace(['%', '$', ',',' '],'', $pension['projected_monthly_pension_benefit']);
            }
        }
        return $total_income * 12;
    }


    /**
     * Assets Setters Methods
     * @param array $data
     */

    public function setAssets($data = []){

        $obj                    = new \stdClass();
        $objAsset               = new \stdClass();
        $num                    = ['$', '%', ',', ' '];
        $obj->type              = $data['asset_type'];
        $objAsset->type         = $data['asset_type'];
        $objAsset->own          = isset($data['own']) ? $data['own'] : 'mine';
        $spouse_name            = explode(' ', $this->attributes['spouse_name']);
        $spouse_name            = $spouse_name[0];
        $strip                  = ['$', '%', ',', ' '];
        if(in_array($data['asset_type'], $this->typeOneAsset)){
            $symbols_arr            = [];
            $data['balance']        = str_replace($strip, '', $data['balance']);
            $data['additions']      = str_replace($strip, '', $data['additions']);
            $data['withdrawals']    = str_replace($strip, '', $data['withdrawals']);
            $interest               = str_replace($strip, '', $data['interest_rate']) / 100;
            $obj->company           = $data['company'];
            $obj->balance           = $data['balance'];
            $obj->additions         = $data['additions'];
            $obj->withdrawals       = $data['withdrawals'];
            $obj->interest_rate     = $data['interest_rate'];
            $obj->beneficiary       = $data['beneficiary'];


            $growthRate             = ($interest != '' && $interest != 0) ? $interest : 0;
            $objAsset->interest_rate= $growthRate;
            $income                 = $data['additions'] - $data['withdrawals'];
            if($data['asset_type'] != 'Roth') {
//                if($data['asset_type'] == '401k'){
//                    $objAsset->income = ($income > 0) ? ($income * -0.12) : 0;
//                }else{
//                    $objAsset->income = $income;
//                }

                $objAsset->income   = -$income;
            }else{
                $objAsset->income   = -$data['additions'];
            }
            $objAsset->balance      =  $data['balance'];

            if(isset($data['symbols'])){

                foreach($data['symbols'] as $item){
                    $obj2                       = new \stdClass();
                    $obj2->symbol               = $item['symbol'];
                    $obj2->share_price          = isset($item['share_price']) ? $item['share_price'] : 0;
                    $obj2->number_of_shares     = $item['number_of_shares'];
                    $symbols_arr[]              = $obj2;
                }
            }

            $obj->symbols           = $symbols_arr;
            $data['own']            = isset($data['own']) ? $data['own'] : 'mine';
            $name                           = ($data['own'] == 'mine') ? $this->user->first_name : $spouse_name;
            array_push($this->tableHeader, $name . ' ' . $data['asset_type']);
            array_push($this->tableHeader2, 'Income');
            array_push($this->tableHeader2, 'Balance');
        }elseif($data['asset_type'] == 'Rental'){
            if(isset($data['value'])) {
                $obj->value = $data['value'];
                $obj->annual_income = $data['annual_income'];
//            $objAsset->rental       = $obj->annual_income * pow(1.02, 15);
                $objAsset->rental = str_replace($strip, '', $obj->annual_income);
//            $rental_v           = $Rental * pow(1.02, 15 );
                array_push($this->tableHeader, 'Rental Inc.');
                array_push($this->tableHeader2, '');
            }
        }elseif($data['asset_type'] == 'Annuity'){

            $obj->company           = $data['company'];
            $obj->additions         = $data['additions'];
            $obj->value             = $data['value'];
            $obj->annual_premium    = $data['annual_premiums'];
            $data['own'] = isset($data['own'])?$data['own']:"mine";
            $name                   = ($data['own'] == 'mine') ? $this->user->first_name : $this->attributes['spouse'];
//            $objAsset->own          = $data['own'];
//            $objAsset->value        = $data['value'];
//            $objAsset->annual_premium=  $data['balance'];

            array_push($this->tableHeader, $name .' Annuity');
            array_push($this->tableHeader2, 'Income');
            array_push($this->tableHeader2, 'Annual Premium');
        }elseif($data['asset_type'] == 'Savings' || $data['asset_type'] == 'Checking'){
            $interest               = str_replace($strip, '', $data['interest_rate']) / 100;
            $obj->company           = $data['company'];
            $obj->balance           = $data['balance'];
            $obj->additions         = $data['additions'];
            $obj->withdrawals       = $data['withdrawals'];
            $obj->interest_rate     = $data['interest_rate'];
        }elseif($data['asset_type'] == 'CDs'){
            $obj->months_remaining  = $data['months_remaining'];
            $obj->dollar_value      = $data['value'];
            $obj->interest_rate     = $data['interest_rate'];
        }


        $this->assets[]             = $obj;
        $this->calculatedAssets[]   = $objAsset;
    }

    public function getRetirementPlan($id = null){
        $user                       = isset($id)?$this->model->find($id):Auth::user();

        if(!isset($this->attributes['assets'])){
            return  ['header' => [], 'header2' => [], 'h_passedAway' => 0, 'graph' => [], 'data' => []];
        }

        $assets = (isset($this->attributes['assets']) && $this->attributes['assets'] != '' )?$this->attributes['assets']:[];
        $assets = is_array($assets)?$assets:unserialize($assets);
//        return $assets;
        $this->attributes['age']        = isset($this->attributes['age'])?$this->attributes['age']:"";
        $this->attributes['spouse_age'] = isset($this->attributes['spouse_age'])?$this->attributes['spouse_age']:"";
        $year                           = isset($user->created_at)?$user->created_at->format('Y'):"";
        $age                            = $this->attributes['age'];
        $spouseAge                      = $this->attributes['spouse_age'];
        $incomeGoal                     = 100000;
        $maxAge                         = self::MAX_AGE;
        $spouse_name                    = '';
        if(isset($this->attributes['spouse_name'])) {
            $spouse_name = explode(' ', $this->attributes['spouse_name']);
            $spouse_name = $spouse_name[0];
        }

        if($age > 31 || $spouseAge > 29){
            for($j = 31; $j <= $age; $j++){
                $incomeGoal             = $incomeGoal * ( 1+ $this->inflationRate);
            }
        }

        $this->tableHeader         = ['Year', $user->first_name . ' Age'];
        $this->tableHeader2        = ['', ''];


        if($this->attributes['married'] == 'Yes'){

            array_push($this->tableHeader, $spouse_name .' Age');
            array_push($this->tableHeader2, '');
        }

        $husband_age_retirement     = (integer) $this->attributes['what_age_do_you_plan_on_retiring_age'];
        //need clarification from these variable values below
        $EmployeeContrib401K            = 0.06;
        $EmployerContrib401K            = 0.06;
        $SalaryIncrease                 = 0.03;
        $Investment                     = 0.06;
        $InvestmentAddOn                = 0.03;

        $HusbandPreTaxIncome            = (float) $this->attributes['pre_tax_income'];
        $after_tax_income               = isset($this->attributes['in_todays_dollars_do_you_know_the_exact_after_tax_income_you_will_need_in_retirement'])?$this->attributes['in_todays_dollars_do_you_know_the_exact_after_tax_income_you_will_need_in_retirement']:0;
        $preTaxTarget                   = ((float) str_replace(['$', ',', ' '], '', $after_tax_income) ) * 12;

        $totalIncome                    = 0;
        $Rental                         = null;
        $ss_husband                     = null;
        $ss_wife                        = null;

        $pension_income                 = null;
        $tempS3                         = 0;
        $ctr                            = 0;




        $ss_h       = 0;
        $ss_w       = 0;
        $rental_v   = 0;

        $ss_husband_calculated = $this->fullRetirementAgeBenefits;
        $ss_wife_calculated = $this->getFullRetirementAgeBenefits($this->attributes['spouse_age'],$this->attributes['what_age_do_you_plan_on_retiring_age'],$this->attributes['social_security_retirement_benefit_spouse']);

        $year_difference_husband = $this->yearDifference;
        $year_difference_wife = $this->getYearDifference($this->attributes['spouse_age'],$this->attributes['what_age_do_you_plan_on_retiring_age']);

        $husband_ss_benefit = .8;
        $wife_ss_benefit = .8;
        $pension_income = 0;
        if(isset($this->attributes['pension']) && $this->getPensionIncome($this->attributes['pension']) != 0 ){
            $pension_income = $this->getPensionIncome($this->attributes['pension']);
            array_push($this->tableHeader, 'Pension');
            array_push($this->tableHeader2, '');
        }

        /**============================================
         * If Age is more than retirement age
        ===========================================**/
        $deficit_age = $this->attributes['age'] - $this->attributes['what_age_do_you_plan_on_retiring_age'];
        if($deficit_age > 0){
            for($x = 0; $x <= $deficit_age; $x++){
                if($x == 0){;
                    $ss_husband     = self::YEAR * $ss_husband_calculated * pow(self::SS_INCREASE, $year_difference_husband) * pow(self::SS_INCREASE_2, $year_difference_husband) * $husband_ss_benefit;
                    $ss_wife        = self::YEAR * $ss_wife_calculated * pow(self::SS_INCREASE, $year_difference_wife) * pow(self::SS_INCREASE_2, $year_difference_wife) * $wife_ss_benefit;
                }else{
                    $ss_husband = $ss_husband * self::SS_INCREASE_2;
                    $ss_wife = $ss_wife * self::SS_INCREASE_2;
                }
            }
        }

        if(isset($this->attributes['social_security_retirement_benefit_yours']) && $this->attributes['social_security_retirement_benefit_yours'] != '' && $this->attributes['social_security_retirement_benefit_yours'] != 0) {
            array_push($this->tableHeader, $user->first_name . ' SS');
            array_push($this->tableHeader2, '');
        }

        if($this->attributes['married'] == 'Yes'){
            if(isset($this->attributes['social_security_retirement_benefit_spouse']) && $this->attributes['social_security_retirement_benefit_spouse'] != '' && $this->attributes['social_security_retirement_benefit_spouse'] != 0) {
                array_push($this->tableHeader, $spouse_name . ' SS');
                array_push($this->tableHeader2, '');
            }
        }

        if($assets) {
            foreach ($assets as $asset) {
                $this->setAssets($asset);
            }
        }


        array_push($this->tableHeader, 'PRE-Tax Target');
        array_push($this->tableHeader, 'Income');
        array_push($this->tableHeader, 'Gap');
        array_push($this->tableHeader2, '');
        array_push($this->tableHeader2, '');
        array_push($this->tableHeader2, '');

        //Temp variable for calculated ss
        $calc_h_ss              = 0;
        $calc_w_ss              = 0;

        $retirement401kBalance  = 0;
        $retirement403bBalance  = 0;
        $balance                = 0;
        $income                 = 0;
        $tempGap                = 0;
        $finalTotalIncome       = 0;
        $tempIncome             = 0;
        $calc_w_ira_balance     = 0;

        for($x = $age; $x <= $maxAge; $x++){

            $ctr++;

            $year                   = ($ctr > 1) ? $year + 1 : $year;
            $calc_ira_balance_loop  = 0;
            $calc_ira_balance       = 0;

            $calc_ira_income        = 0;
            $calc_w_ira_income        = 0;
            $tmp_ira_balance        = 0;
            $tempIncome             = 0;
            $tempBalance            = 0;
            $totalIncome            = 0;
            $grapRow                = [];
            /**
             * Increment Client Age and year of retirement Plan
             */
            $row                    = ['year' => $year, 'husband_age' => $x];
            $grapRow                = ['year' => $year, 'husband_age' => $x];

            if($this->attributes['married'] == 'Yes'){
                $grapRow['wife_age'] = $spouseAge;
                $row['wife_age']            = $spouseAge;

            }

            if($x >= $this->attributes['what_age_do_you_plan_on_retiring_age']) {
                $totalIncome        += $pension_income;
                if($x == $this->attributes['what_age_do_you_plan_on_retiring_age']){
                    if(isset($this->attributes['social_security_retirement_benefit_yours']) && $this->attributes['social_security_retirement_benefit_yours'] != '' && $this->attributes['social_security_retirement_benefit_yours'] != 0) {
                        if($x <= $this->husbandPassedAwayAge) {
                            $ss_h = str_replace(['$', ',', ' '], '', $this->attributes['social_security_retirement_benefit_yours']);
                            $ss_h = $ss_h * 12 * pow(1.08, 3) * pow(1.025, 3) * 0.8;
                            $tempIncome += $ss_h;
                            $totalIncome += $ss_h;
                            $row['h_ss'] = number_format($ss_h, 0);
                        }else{
                            $row['h_ss'] = 0;
                        }
                    }

                    if(isset($this->attributes['social_security_retirement_benefit_spouse']) && $this->attributes['social_security_retirement_benefit_spouse'] != '' && $this->attributes['social_security_retirement_benefit_spouse'] != 0) {
                        $ss_w               = str_replace(['$', ',', ' '], '', $this->attributes['social_security_retirement_benefit_spouse']);
                        $ss_w               = $ss_w * 12 * 0.75;
                        $tempIncome        += $ss_w;
                        $totalIncome        += $ss_w;
                        $row['w_ss']        = number_format($ss_w, 0);
                    }

                }elseif($x > $this->attributes['what_age_do_you_plan_on_retiring_age']){
                    if(isset($this->attributes['social_security_retirement_benefit_yours']) && $this->attributes['social_security_retirement_benefit_yours'] != '' && $this->attributes['social_security_retirement_benefit_yours'] != 0) {
                        if($x <= $this->husbandPassedAwayAge) {
                            $ss_h                = $ss_h * 1.025;
                            $tempIncome         += $ss_h;
                            $totalIncome        += $ss_h;
                            $row['h_ss']        = number_format($ss_h, 0);
                        }else{
                            $row['h_ss']        = 0;

                            if($ss_h != 0) {
                                $ss_w           = $ss_h;
                            }
                            $ss_h               = 0;
                        }
                    }

                    if(isset($this->attributes['social_security_retirement_benefit_spouse']) && $this->attributes['social_security_retirement_benefit_spouse'] != '' && $this->attributes['social_security_retirement_benefit_spouse'] != 0) {
                        $ss_w                           = $ss_w * 1.025;
                        $tempIncome                     += $ss_w;
                        $totalIncome                    += $ss_w;
                        $row['w_ss']                    = number_format($ss_w, 0);
                    }
                }

            }else{
                if(isset($this->attributes['social_security_retirement_benefit_yours']) && $this->attributes['social_security_retirement_benefit_yours'] != '' && $this->attributes['social_security_retirement_benefit_yours'] != 0) {
                    $row['h_ss']        = '';
                }

                if(isset($this->attributes['social_security_retirement_benefit_spouse']) && $this->attributes['social_security_retirement_benefit_spouse'] != '' && $this->attributes['social_security_retirement_benefit_spouse'] != 0) {
                    $row['w_ss']        = '';
                }
            }

            if(isset($this->attributes['pension']) && $this->getPensionIncome($this->attributes['pension']) != 0){
                if($x >= $this->attributes['what_age_do_you_plan_on_retiring_age']) {
                    $row['pension']         = $pension_income;
                    $tempIncome             += $pension_income;
                }else{
                    $row['pension']         = '';
                }
            }

            if($ctr > 1) {
                if($x < ($this->husbandPassedAwayAge + 1)) {
                    $preTaxTarget       = ($preTaxTarget * $this->inflationRate) + $preTaxTarget;
                }else{
                    if($x == ($this->husbandPassedAwayAge + 1)) {
                        $preTaxTarget   = ($preTaxTarget * 0.75);
                    }elseif($x > $this->husbandPassedAwayAge){
                        $preTaxTarget   = ($preTaxTarget * $this->inflationRate) + $preTaxTarget;
                    }
                }
                $incomeGoal = $incomeGoal * (1 + $this->inflationRate);

                /**
                 * Iteration of assets and calculation per growth
                 */
                foreach ($this->calculatedAssets as $asset) {
                    if ($asset->type == 'Rental') {
                        $Rental = true;
                        if ($x >= 72) {
                            if ($x == 72) {
                                if(isset($asset->rental)) {
                                    $rental_v = $asset->rental;
                                }
                            } else {
                                if($rental_v != 0) {
                                    $rental_v = $rental_v * 1.02;
                                }
                            }

                            $asset->rental = $rental_v;

                            $tempIncome             += $rental_v;
                            $totalIncome            += $rental_v;
                            $row['rental']          = $this->getDisplayNumberFormat($rental_v);
                        } else {
                            $row['rental']          = '';
                            $Rental = true;
                        }
                    } else {

                        if($asset->type != 'Roth') {
                            if ($x < $this->attributes['what_age_do_you_plan_on_retiring_age']) {// if age less than age of retirement
                                $income = $this->getCalculateAssetIncome($asset->income);
                            } else {
                                if ($x == $this->attributes['what_age_do_you_plan_on_retiring_age']) {// if age is equal to age of retirement
                                    if ($asset->type == '401k') {
                                        $income = $asset->balance;
                                        $totalIncome = $totalIncome + $income;
                                    }elseif($asset->type == '403b') {
                                        $income = $asset->balance;
                                        $totalIncome = $totalIncome + $income;
                                    }elseif($asset->type == 'IRA' && $asset->own == 'mine') {
                                        $income             = -$retirement401kBalance;
                                        $calc_ira_income    = -$retirement401kBalance;
                                        $calc_ira_balance   = $asset->balance;
                                        $totalIncome        = $totalIncome + $income;
                                    }elseif($asset->type == 'IRA' && $asset->own == 'spouse'){
                                        $calc_w_ira_income    = -$retirement403bBalance;
                                        $calc_w_ira_balance = $asset->balance;
                                        $income             = -$retirement403bBalance;
                                        $totalIncome = $totalIncome + $income;
                                    }else{
                                        $income = 0;
                                        $totalIncome = $totalIncome + $income;
                                    }
                                } elseif ($x > $this->attributes['what_age_do_you_plan_on_retiring_age']) {//if age is greater than age of retirement
                                    $income = 0;

                                    if($asset->type == 'IRA' && $asset->own == 'mine') {
                                        $calc_ira_balance   = $asset->balance;
                                    }

                                    if($asset->type == 'IRA' && $asset->own == 'spouse'){
                                        $calc_w_ira_balance = $asset->balance;
                                    }
                                    $totalIncome = $totalIncome + $income;
                                }
                            }

                        }else{
                            if ($x < $this->attributes['what_age_do_you_plan_on_retiring_age']) {// if age less than age of retirement
                                $income = $asset->income;
                            }else{

                                $income = 0;
                            }
                        }

                        if($x < $this->attributes['what_age_do_you_plan_on_retiring_age']) {// if age less than age of retirement
                            $asset->interest_rate = isset($asset->interest_rate)?$asset->interest_rate:0;
                            $balance        = $this->getCalculateBalance($asset->balance, $income, $asset->interest_rate);
                        }else{
                            if($asset->type == '401k' || $asset->type == '403b') {
                                $balance = 0;
                            }else{
                                if($asset->type == 'IRA'){
                                    if($x > $this->attributes['what_age_do_you_plan_on_retiring_age']) {// if age greater than age of retirement
                                        if($asset->own == 'mine'){
                                            $balance        = $asset->balance;
                                        }else{
                                            $balance        = $this->getCalculateBalance($asset->balance, $income, $asset->interest_rate);
                                        }
                                    }
                                }else{
                                    if(!property_exists($asset,'interest_rate')){
                                        $asset->interest_rate = 0;
                                    }
                                    $balance        = $this->getCalculateBalance($asset->balance, $income, $asset->interest_rate);
                                }
                            }
                        }

                        if($asset->type == '401k'){
                            $retirement401kBalance  = $asset->balance;
                        }

                        if($asset->type == '403b'){
                            $retirement403bBalance  = $asset->balance;
                        }

                        $totalIncome        = $totalIncome + $income;
                        $asset->income      = $income;
                        $asset->balance     = $balance;

                        if($asset->own == 'mine'){
                            $name           = $user->first_name;
                        }else{
                            $name           = $spouse_name;
                        }

                        $grapRow[$name . '_' . $asset->type]    = ['income' => $this->getDisplayNumberFormat($income, false)];
                        $row[$name . '_' . $asset->type]        = ['income' => $this->getDisplayNumberFormat($income), 'balance' => $this->getDisplayNumberFormat($balance)];
                    }
                }

                if ($x >= $this->attributes['what_age_do_you_plan_on_retiring_age']) {//if age is greater than age of retirement
                    $tempGap            = $preTaxTarget - $totalIncome;
                        if ($x == $this->attributes['what_age_do_you_plan_on_retiring_age']) {//if age is greater than age of retirement
                            $ira_income = $calc_ira_income + $tempGap;
                            foreach($this->calculatedAssets as $asset){
                                if($asset->type == 'IRA' && $asset->own == 'mine'){
                                    $asset->income                                      = $ira_income;
                                    $tempBalance                                        = $this->getCalculateBalance($calc_ira_balance, $ira_income, $asset->interest_rate);
                                    $asset->balance                                     = $tempBalance;

                                    $grapRow[$user->first_name . '_IRA']['income']      = $this->getDisplayNumberFormat($ira_income, false);
                                    $row[$user->first_name . '_IRA']['income']          = $this->getDisplayNumberFormat($ira_income);
                                    $row[$user->first_name . '_IRA']['balance']         = $this->getDisplayNumberFormat($tempBalance);
                                }

                                if($asset->type == 'IRA' && $asset->own == 'spouse'){
                                    $w_ira_balance                          = $this->getCalculateBalance($calc_w_ira_balance, -$retirement403bBalance, $asset->interest_rate);
                                    $calc_w_ira_balance                     = $w_ira_balance;
                                    $asset->balance                         = $w_ira_balance;

                                    $row[$spouse_name . '_IRA']['balance']  = $this->getDisplayNumberFormat($w_ira_balance);
                                }
                            }
                        }else{
//                            $ira_income         = $calc_ira_income + $tempGap;
                            $ira_income         = $tempGap;
                            $ira_balance        = 0;
                            foreach($this->calculatedAssets as $asset){

                                if($asset->type == 'IRA' && $asset->own == 'mine'){
                                    if($asset->balance > $ira_income){
                                        $asset->income          = $ira_income;
                                        $ira_balance            = $this->getCalculateBalance($asset->balance, $ira_income, $asset->interest_rate);
                                        $asset->balance         = $ira_balance;
                                    }else{
                                        $ira_income             = $asset->balance;
                                        if($asset->balance != 0) {
                                            $asset->income = $ira_income;
                                        }else{
                                            $asset->income  =0;
                                        }
                                        $ira_balance            = 0;
                                        $asset->balance         = 0;
                                        $calc_ira_balance       = 0;
                                    }

                                    $grapRow[$user->first_name . '_IRA']['income']  = $this->getDisplayNumberFormat($ira_income, false);

                                    $row[$user->first_name . '_IRA']['income'] = $this->getDisplayNumberFormat($ira_income);
                                    $row[$user->first_name . '_IRA']['balance'] = $this->getDisplayNumberFormat($ira_balance);
                                }

                            }
                        }
                }

            } else {
                foreach ($this->calculatedAssets as $asset) {
                    if ($asset->type == 'Rental') {
                        $row['rental']  = '';
                        $Rental = true;
                    } else {
                        if($asset->own == 'mine'){
                            $name           = $user->first_name;
                        }else{
                            $name           = $spouse_name;
                        }
                        if(!property_exists($asset,'income')){
                            $asset->income = 0;
                        }
                        if(!property_exists($asset,'balance')){
                            $asset->balance = 0;
                        }
                        $grapRow[$name . '_' . $asset->type]    = ['income' => $this->getDisplayNumberFormat($asset->income, false)];
                        $row[$name . '_' . $asset->type]        = ['income' => $this->getDisplayNumberFormat($asset->income), 'balance' => $this->getDisplayNumberFormat($asset->balance)];
                    }

                }

            }

            foreach($this->calculatedAssets as $asset){
                if($asset->type != 'Rental') {
                    $tempIncome += $asset->income;
                }
            }

            $finalTotalIncome               = $tempIncome;
            $gap                            = $preTaxTarget - $tempIncome;
            if ($x > $this->attributes['what_age_do_you_plan_on_retiring_age']) {//if age is greater than age of retirement
                if ($calc_ira_balance == 0) {
                    foreach ($this->calculatedAssets as $asset) {
                        if ($asset->type == 'IRA' && $asset->own == 'spouse') {
                            $s_ira_income       = $gap;
                            if($calc_w_ira_balance > $s_ira_income) {
                                $s_ira_balance          = $this->getCalculateBalance($calc_w_ira_balance, $s_ira_income, $asset->interest_rate);
                                $asset->income          = $s_ira_income;
                                $asset->balance         = $s_ira_balance;
                                $calc_w_ira_balance     = $s_ira_balance;
                            }else{
                                $s_ira_income           = $calc_w_ira_balance;
                                $asset->income          = $s_ira_income;
                                $asset->balance         = 0;
                                $calc_w_ira_balance     = 0;
                                $s_ira_balance          = 0;
                            }

                            $grapRow[$spouse_name . '_IRA']['income'] = $this->getDisplayNumberFormat($s_ira_income, false);

                            $row[$spouse_name . '_IRA']['income']   = $this->getDisplayNumberFormat($s_ira_income);
                            $row[$spouse_name . '_IRA']['balance']  = $this->getDisplayNumberFormat($s_ira_balance);

                        }
                    }
                    $tempIncome2            = $ss_h + $ss_w + $pension_income;
                    foreach ($this->calculatedAssets as $asset) {
                        if($asset->type == 'Rental'){
                            if(isset($asset->rental)) {
                                $tempIncome2 += $asset->rental;
                            }
                        }else {
                            $tempIncome2 += $asset->income;
                        }
                    }
                    $finalTotalIncome           = $tempIncome2;
                    $gap                        = $preTaxTarget - $tempIncome2;
                }
            }

            $row['pre-tax-target']              = $this->getDisplayNumberFormat($preTaxTarget);

            if ($x >= $this->attributes['what_age_do_you_plan_on_retiring_age']) {//if age is greater than age of retirement
                $grapRow['gap']                 = $this->getDisplayNumberFormat($gap, false);
                $grapRow['income']              = $this->getDisplayNumberFormat($finalTotalIncome, false);
                $row['income']                  = $this->getDisplayNumberFormat($finalTotalIncome);
                $row['gap']                     = $this->getDisplayNumberFormat($gap);

            }else{
                $row['income']                  = '';
                $row['gap']                     = '';
            }

            $grapRow['pre_tax_target']          = $this->getDisplayNumberFormat($preTaxTarget, false);



            if ($Rental != null) {
                $grapRow['rental'] = $this->getDisplayNumberFormat($rental_v, false);
            }

            /**
             * condition statement if client has pension declared then add data to graph
             */
            if (isset($this->attributes['pension']) && $this->getPensionIncome($this->attributes['pension']) != 0) {
                $grapRow['pension'] = $this->getDisplayNumberFormat($pension_income, false);
            }



            /**
             * condition statement if client has Social Security declared then add data to graph
             */
            if (isset($this->attributes['social_security_retirement_benefit_yours']) && $this->attributes['social_security_retirement_benefit_yours'] != '' && $this->attributes['social_security_retirement_benefit_yours'] != 0) {
                $grapRow[$user->first_name . '_ss'] = $this->getDisplayNumberFormat($ss_h, false);
            }
            /**
             * condition statement if client has Social Security for spouse declared then add data to graph
             */
            if (isset($this->attributes['social_security_retirement_benefit_spouse']) && $this->attributes['social_security_retirement_benefit_spouse'] != '' && $this->attributes['social_security_retirement_benefit_spouse'] != 0) {
                $grapRow[$spouse_name . '_ss'] = $this->getDisplayNumberFormat($ss_w, false);
            }



            if($x >= (integer) $this->attributes['what_age_do_you_plan_on_retiring_age']) {
                $this->graphData[] = $grapRow;
            }

            $spouseAge++;

            $this->retirementPlan[]                 = $row;
        }

        return  ['header' => $this->tableHeader, 'header2' => $this->tableHeader2, 'h_passedAway' => $this->husbandPassedAwayAge, 'graph' => $this->graphData, 'data' => $this->retirementPlan];
    }

    public function getCalculateBalance($balance, $income, $interest_rate = 0){
        if($interest_rate == 0){
            return $balance * (1+$this->growthRate) - ($income * (1 + $this->inflationRate));
        }

        $interest_rate = $interest_rate / 100;

        return $balance * ( 1 + $interest_rate) - ($income * (1 + $this->inflationRate));
    }

    public function getCalculateAssetIncome($income, $interest_rate = 0){
//        if($interest_rate == 0){
            return $income * (1 + $this->inflationRate);
//        }
//        return;
    }

    public function getDisplayNumberFormat($value, $converNegativeValue = true){
        if($converNegativeValue == true) {
            if ($value < 0) {
                return '(' . str_replace('-', '', number_format($value, 0)) . ')';
            } elseif ($value == 0) {
                return '';
            } else {
                return number_format($value, 0);
            }
        }

//        dd($value);
        return (isset($value) && $value != '' ) ? number_format($value, 0) : '';
    }


    public function getHusbandIRA($age){
        $husband_ira_income     = 2400;
        /*if($age >= 31 && $age <= 60){
            $husband_ira_income     = $husband_ira_income;
        }else*/
        if($age >= 61 && $age <= 70){
            $husband_ira_income = 0;
        }elseif($age == 71){
            $husband_ira_income = -22348.30;
        }elseif($age >= 72 && $age <= 80){
            $husband_ira_income = -99234.19;
        }elseif($age == 81){
            $husband_ira_income = -170690.02;
        }elseif($age == 82){
            $husband_ira_income = -175738.72;
        }elseif($age == 83){
            $husband_ira_income = -180938.88;
        }elseif($age == 84){
            $husband_ira_income = -186295.05;
        }elseif($age == 85){
            $husband_ira_income = -191811.90;
        }elseif($age == 86){
            $husband_ira_income = -54921.63;
        }

        return $husband_ira_income;
    }

    public function getHusbandIncome65AgeAbove($age){
        switch ($age) {
            case '65':
                $husband_401_income = -231803.57;
                break;
            case '66':
                $husband_401_income = -238757.67;
                break;
            case '67':
                $husband_401_income = -248320.40;
                break;
            case '68':
                $husband_401_income = -255698.02;
                break;
            case '69':
                $husband_401_income = -263296.96;
                break;
            case '70':
                $husband_401_income = -271123.86;
                break;
            case '71':
                $husband_401_income = -15653.14;
                break;
            default:
                $husband_401_income = 0;
                break;
        }

        return $husband_401_income;
    }

    private function parseToObject(array $arr, $parent = null) {
        if ($parent === null) {
            $parent = $this;
        }

        foreach ($arr as $key => $val) {
            if (is_array($val)) {
                $parent->$key = $this->parseToObject($val, new \stdClass);
            } else {
                $parent->$key = $val;
            }
        }

        return $parent;
    }


    /**
     *
     * @param $value
     * @param $array
     * @return float
     */
    public function getStandardDeviation($value,$array){
        $deviations = [];
        foreach($array as $row){
            $deviations[] = pow($row-$value,2);
        }
        return sqrt(array_sum($deviations)/count($deviations));
    }

    /** Rate of return
     * @param $array
     * @return array
     */
    public function getRateOfReturn($array){
        $rate_of_returns = [];
        foreach($array as $key => $row){
            $rate_of_returns[] = (isset($array[$key-1]))?(($row-$array[$key-1])/$array[$key-1]):0;
        }
        return $rate_of_returns;
    }

    /**
     * @param $value
     * @param $array
     * @return float
     */
    public function getGeometricReturn($array){
        $return = 1;
        foreach($array as $row){
            $return = $return*(1+$row);
        }
        return pow($return,1/3)-1;
    }


    public function getTotalIncome($row){
        $row['Total Income'] = $row['Brokerage']['Income'];
        $row['Total Income'] += $row['401(k)']['Income'];
        $row['Total Income'] += $row['Life Insurance'];
        $row['Total Income'] += $row['Part-time Work'];
        $row['Total Income'] += $row['Rental Properties'];
        if(isset($row['Client'])){
            $row['Total Income'] += $row['Client']['Social Security'];
            $row['Total Income'] += $row['Client']['CDs'];
            $row['Total Income'] += $row['Client']['Pension'];
            $row['Total Income'] += $row['Client']['Annuity'];
            $row['Total Income'] += $row['Client']['IRA']['Income'];
            $row['Total Income'] += $row['Client']['Simple']['Income'];
            $row['Total Income'] += $row['Client']['Savings'];
        }
        

        if(isset($row['Spouse'])){
            $row['Total Income'] += $row['403(b)']['Income'];
            $row['Total Income'] += $row['Spouse']['Social Security'];
            $row['Total Income'] += $row['Spouse']['Pension'];
            $row['Total Income'] += $row['Spouse']['Annuity'];
            $row['Total Income'] += $row['Spouse']['CDs'];
            $row['Total Income'] += $row['Spouse']['IRA']['Income'];
            $row['Total Income'] += $row['Spouse']['SEP']['Income'];
            $row['Total Income'] += $row['Spouse']['Savings'];
        }
        return $row;
    }

    public function initializeNullValues($spouse = false){
        $row = [];
        $row['Year'] = null;
        $row['Brokerage']['Income'] = null;
        $row['Brokerage']['Balance'] = null;
        $row['Life Insurance'] = null;
        $row['Part-time Work'] = null;
        $row['401(k)']['Income'] = null;
        $row['401(k)']['Balance'] = null;
        $row['Pre-tax Target'] = null;
        $row['Total Income'] = null;
        $row['Gap'] = null;
        $row['Adjusted Gap'] = null;
        $row['Rental Properties'] = null;
        $row['Client']['Age'] = null;
        $row['Client']['IRA']['Income'] = null;
        $row['Client']['IRA']['Balance'] = null;

        $row['Client']['Simple']['Income'] = null;
        $row['Client']['Simple']['Balance'] = null;

        $row['Client']['CDs'] = null;

        $row['Client']['Social Security'] = null;
        $row['Client']['Pension'] = null;
        $row['Client']['Annuity'] = null;
        $row['Client']['Savings'] = null;
        $row['Spouse']['Age'] = null;
        $row['Spouse']['CDs'] = null;
        $row['Spouse']['Social Security'] = null;
        $row['Spouse']['Pension'] = null;
        $row['Spouse']['IRA']['Income'] = null;
        $row['Spouse']['IRA']['Balance'] = null;
        $row['Spouse']['SEP']['Income'] = null;
        $row['Spouse']['SEP']['Balance'] = null;
        $row['Spouse']['Annuity'] = null;
        $row['Spouse']['Savings'] = null;
        $row['403(b)']['Income'] = null;
        $row['403(b)']['Balance'] = null;


        
        return $row;
        
    }

    public function getAdjustments(){
        $adjustment = [];
        $adjustment[] = ['owner' => 'Client','name' => 'IRA','field' => 'Balance'];
        $adjustment[] = ['owner' => 'Spouse','name' => 'IRA','field' => 'Balance'];
        $adjustment[] = ['owner' => 'Client','name' => 'Simple','field' => 'Balance'];
        $adjustment[] = ['owner' => 'Spouse','name' => 'SEP','field' => 'Balance'];
        $adjustment[] = ['owner' => null,'name' => 'Brokerage','field' => 'Balance'];

        return $adjustment;
    }

    public function getColumns($spouse){
        $columns = [
            ['owner' => null,'name' => 'Year','field' => null], //Year
            ['owner' => 'Client', 'name' => 'Age','field' => null], //Ages
            ['owner' => 'Spouse', 'name' => 'Age','field' => null],
            ['owner' => 'Client', 'name' => 'Social Security','field' => null], // Social Securities
            ['owner' => 'Spouse', 'name' => 'Social Security','field' => null],
            ['owner' => 'Client', 'name' => 'Pension','field' => null],//Pensions
            ['owner' => 'Spouse', 'name' => 'Pension','field' => null],
            ['owner' => 'Client', 'name' => 'Annuity','field' => null], //Annuity
            ['owner' => null,'name' => 'Part-time Work', 'field' => null],
            ['owner' => 'Client', 'name' => 'Savings','field' => null],
            ['owner' => 'Spouse', 'name' => 'Savings','field' => null],
            ['owner' => null,'name' => 'Rental Properties','field' => null],
            ['owner' => null,'name' => 'Life Insurance','field' => null],
            ['owner' => 'Client','name' => 'CDs', 'field' => null],
            ['owner' => 'Spouse','name' => 'CDs', 'field' => null],
            ['owner' => null,'name' => '401(k)', 'field' => 'Income'],
            ['owner' => null,'name' => '401(k)', 'field' => 'Balance'],
            ['owner' => null,'name' => '403(b)', 'field' => 'Income'],
            ['owner' => null,'name' => '403(b)', 'field' => 'Balance'],
            ['owner' => 'Client','name' => 'IRA','field' => 'Income'],
            ['owner' => 'Client','name' => 'IRA','field' => 'Balance'],
            ['owner' => 'Spouse','name' => 'IRA','field' => 'Income'],
            ['owner' => 'Spouse','name' => 'IRA','field' => 'Balance'],
            ['owner' => 'Client','name' => 'Simple','field' => 'Income'],
            ['owner' => 'Client','name' => 'Simple','field' => 'Balance'],
            ['owner' => 'Spouse','name' => 'SEP','field' => 'Income'],
            ['owner' => 'Spouse','name' => 'SEP','field' => 'Balance'],
            ['owner' => null,'name' => 'Brokerage','field' => 'Income'],
            ['owner' => null,'name' => 'Brokerage','field' => 'Balance'],
            ['owner' => null,'name' => 'Total Income','field' => null],
            ['owner' => null,'name' => 'Pre-tax Target','field' => null],
            //['owner' => null,'name' => 'Gap','field' => null],
            ['owner' => null,'name' => 'Adjusted Gap','field' => null]
        ];


        if(!$spouse){
            foreach($columns as $key => $row){
                if($row["owner"] == "Spouse" || $row["name"] == "403(b)" || $row["name"] == "SEP"){
                    unset($columns[$key]);
                }
            }
        }

        return $columns;
    }

    public function retirementTable(){
        $starting_year = Carbon::now()->year;
        $spouse = $this->attributes['married'] == "Yes";
        $data['columns'] = $this->getColumns($spouse);
        $plan = [];
        $row = $this->initializeNullValues($spouse);
       
        $last_ss = ['mine' => 0, 'spouse' => 0];
        $min_age = $this->attributes['age'];
        $max_age = $this->lifeExpectancy;

        $retirement_income_need = isset($this->attributes['retirement_income_funded'])?$this->attributes['retirement_income_funded']*12:0;
        $part_time_income = isset($this->attributes['estimated_income'])?$this->attributes['estimated_income']*12:0;
        $cds = ['Client' => $this->getAsset('CDs','mine'), 'Spouse' => $this->getAsset('CDs','spouse')];
        if($spouse && $this->lifeExpectancySpouse > $max_age){
            $max_age = $this->lifeExpectancySpouse;
        }

        $retirement_age = $this->attributes['what_age_do_you_plan_on_retiring_age'];

        $row['Year'] = $starting_year;
        $row['Client']['Age'] = $min_age;

       
        if($spouse){
            $row['Spouse']['Age'] = $this->attributes['spouse_age'];
            $row['Spouse']['Savings'] = $this->getAsset('Savings','spouse','balance');
            
            
            $row['Spouse']['IRA']['Income'] = -1 * ($this->getAsset('IRA','spouse','additions') - $this->getAsset('IRA','spouse','withdrawals'));
            $row['Spouse']['IRA']['Balance'] = $this->getAsset('IRA','spouse','balance');
            
            $row['Spouse']['SEP']['Income'] = -1 * ($this->getAsset('SEP','spouse','additions') - $this->getAsset('SEP','spouse','withdrawals'));
            $row['Spouse']['SEP']['Balance'] = $this->getAsset('SEP','spouse','balance');
        }

        $row['Client']['Annuity'] = $this->getAsset('Annuity','mine','value');
        $row['Client']['Savings'] = $this->getAsset('Savings','mine','balance');
        $row['Rental Properties'] = $this->getAsset('Rental','mine','annual_income');

        
        $row['401(k)']['Income'] = -1 * ($this->getAsset('401k','mine','additions') - $this->getAsset('401k','mine','withdrawals'));
        $row['403(b)']['Income'] = -1 * ($this->getAsset('403b','spouse','additions') - $this->getAsset('403b','spouse','withdrawals'));

        $row['Client']['IRA']['Income'] = -1 * ($this->getAsset('IRA','mine','additions') - $this->getAsset('IRA','mine','withdrawals'));
        $row['Client']['IRA']['Balance'] = $this->getAsset('IRA','mine','balance');

        $row['Client']['Simple']['Income'] = -1 * ($this->getAsset('Simple','mine','additions') - $this->getAsset('Simple','mine','withdrawals'));
        $row['Client']['Simple']['Balance'] = $this->getAsset('Simple','mine','balance');

        $row['Brokerage']['Income'] = -1 * ($row['Client']['CDs'] + $row['Life Insurance'] + $this->getAsset('Brokerage','mine','additions') - $this->getAsset('Brokerage','mine','wthdrawals'));
        $row['Brokerage']['Balance'] =  $this->getAsset('Brokerage','mine','balance');


        $row['401(k)']['Balance'] = $this->getAsset('401k','mine','balance');
        $row['403(b)']['Balance'] = $this->getAsset('403b','spouse','balance');

        $plan[] = $row;
        $increment = 0;
        $retirement_span = ['mine' => 0, 'spouse' => 0];
        $year = $starting_year;
        for($age = $min_age+1;$age <= $max_age;$age++){
            $increment++;
            $year++;
            $row = $this->initializeNullValues($spouse);
            $row['Year'] = $year;

            $row['Client']['Age'] = $plan[$increment-1]['Client']['Age']+1;

            if($spouse){
                $row['Spouse']['Age'] = $plan[$increment-1]['Spouse']['Age']+1;
                $row['Spouse']['Savings'] = round($this->getIncrementYearValue($plan[$increment-1]['Spouse']['Savings']));
            }


              //CDs
            foreach($cds['Client'] as $cd_client){
                if(round($cd_client['months_remaining']/12) == $increment+1){
                    $row['Client']['CDs'] = $cd_client['value']*pow(1+$this->inflationRate,round($cd_client['months_remaining']/12));
                }
            }
            foreach($cds['Spouse'] as $cd_spouse){
                if(round($cd_client['months_remaining']/12) == $increment+1){
                    $row['Spouse']['CDs'] = $cd_spouse['value']*pow(1+$this->inflationRate,round($cd_spouse['months_remaining']/12));
                }
            }



                // Before Retirement
            //Age before retirement
           
            if($age < $retirement_age){
                $row['401(k)']['Income'] = $this->getIncrementYearValue($plan[$increment-1]['401(k)']['Income']);
                $row['401(k)']['Balance'] = $this->getIncrementYearValue($plan[$increment-1]['401(k)']['Balance'],3) - $row['401(k)']['Income'];
                $row['403(b)']['Income'] = $this->getIncrementYearValue($plan[$increment-1]['403(b)']['Income']);
                $row['403(b)']['Balance'] = $this->getIncrementYearValue($plan[$increment-1]['403(b)']['Balance'],3) - $row['403(b)']['Income'];
                $row['Brokerage']['Income'] = -1 * ($row['Client']['CDs'] + $row['Life Insurance'] + $this->getAsset('Brokerage','mine','additions') - $this->getAsset('Brokerage','mine','wthdrawals'));
                
                // Pre - Asset income
                $row['Client']['IRA']['Income'] = $this->getIncrementYearValue($plan[$increment-1]['Client']['IRA']['Income'],3);
                $row['Client']['Simple']['Income'] = $this->getIncrementYearValue($plan[$increment-1]['Client']['Simple']['Income'],3);
                if($spouse){
                    $row['Spouse']['IRA']['Income'] = $this->getIncrementYearValue($plan[$increment-1]['Spouse']['IRA']['Income'],3);
                    $row['Spouse']['SEP']['Income'] = $this->getIncrementYearValue($plan[$increment-1]['Spouse']['SEP']['Income'],3);
                }

                

            }

             if($age == $retirement_age-1){
                $row['Client']['IRA']['Income'] += -1 * $row['401(k)']['Balance'];
                if($spouse){
                    $row['Spouse']['IRA']['Income'] += -1 * $row['403(b)']['Balance'];
                }
            }

            $row['Client']['Annuity'] = $this->getIncrementYearValue($plan[$increment-1]['Client']['Annuity'],1);
            $row['Client']['Savings'] = $this->getIncrementYearValue($plan[$increment-1]['Client']['Savings']);
            $row['Rental Properties'] = $this->getIncrementYearValue($plan[$increment-1]['Rental Properties']);
            $row['Brokerage']['Balance'] = $this->getIncrementYearValue($plan[$increment-1]['Brokerage']['Balance'] - $row['Brokerage']['Income'],3);
            $row['Client']['IRA']['Balance'] = $this->getIncrementYearValue($plan[$increment-1]['Client']['IRA']['Balance'] - $row['Client']['IRA']['Income'],3);
            $row['Client']['Simple']['Balance'] = $this->getIncrementYearValue($plan[$increment-1]['Client']['Simple']['Balance'] - $row['Client']['Simple']['Income'],3);
            
            $row['Spouse']['IRA']['Balance'] = $this->getIncrementYearValue($plan[$increment-1]['Spouse']['IRA']['Balance'] - $row['Spouse']['IRA']['Income'],3);
            $row['Spouse']['SEP']['Balance'] = $this->getIncrementYearValue($plan[$increment-1]['Spouse']['SEP']['Balance'] - $row['Spouse']['SEP']['Income'],3);
            //}
            //if($spouse && isset($plan[$increment-1]['Spouse'])){
            

            //apply CDS
           
        
             //Retirement Age
            if($age >= $retirement_age){
                $row['Client']['Social Security'] = ($age == $retirement_age)?$this->getExpectedSocialSecurityBenefit():$this->getIncrementYearValue($plan[$increment-1]['Client']['Social Security']);
                $row['Client']['Pension'] = $this->getCurrentPensionValue($row['Client']['Age'],'mine',$retirement_span['mine']);
                $retirement_span['mine']++;
    
               if($spouse){
                    $row['Spouse']['Social Security'] = ($age == $retirement_age)?$this->getAdjustedSSBenefitSpouse():$this->getIncrementYearValue($plan[$increment-1]['Spouse']['Social Security']);
                    $row['Spouse']['Pension'] = $this->getCurrentPensionValue($row['Spouse']['Age'],'spouse',$retirement_span['spouse']);
                    $retirement_span['spouse']++;
                }
                $row['Pre-tax Target'] = ($age == $retirement_age)?$retirement_income_need*pow(1+$this->inflationRate,15):$this->getIncrementYearValue($plan[$increment-1]['Pre-tax Target']);
                  $row['Part-time Work'] = ($age == $retirement_age)?$part_time_income*pow(1+$this->inflationRate,15):$this->getIncrementYearValue($plan[$increment-1]['Part-time Work']);
                $row = $this->getTotalIncome($row);
                $row['Adjusted Gap'] = $row['Gap'] =  $row['Pre-tax Target'] - $row['Total Income'];
                $adj_count = 0;
                $adjustments = $this->getAdjustments();
                $prev_gap = 0;
                $balance = 0;
                if($row['Gap'] > 0){
                    while($row['Adjusted Gap'] > 0){
                        if($adj_count == 5){
                            break;
                        }
                        $adj_owner = $adjustments[$adj_count]['owner'];
                        $adj_asset = $adjustments[$adj_count]['name'];
                        $adj_field = $adjustments[$adj_count]['field'];
                      
                        $prev_asset = 0;
                        if(isset($plan[$increment-1][$adj_owner]) || isset($plan[$increment-1][$adj_asset])){
                            $prev_asset = isset($adj_owner)?$plan[$increment-1][$adj_owner][$adj_asset][$adj_field]:$plan[$increment-1][$adj_asset][$adj_field];
                        }
                        $balance =  $prev_asset - $row['Adjusted Gap'];
                        $row['Adjusted Gap'] = ($balance > 0)?0: $row['Adjusted Gap'] - $prev_asset;
                        $account_value = ($balance > 0)?$this->getIncrementYearValue($balance,3):0;
                        if(isset($adj_owner)){
                            $row[$adj_owner][$adj_asset][$adj_field] = $account_value;
                        }else{
                            $row[$adj_asset][$adj_field] = $account_value;
                        }
                        //$row['Adjusted Gap'] = ($balance > 0)?0: $row['Adjusted Gap'] - $prev_asset;
                        $adj_count++;
                    }
                }
                $row = $this->getTotalIncome($row);
            }
            //during life expectancy
            if($age == $this->lifeExpectancy && isset($row['Client'])){
                $row['Life Insurance'] = $this->getTotalDeathBenefit();
                if($spouse){
                    $last_ss['Client'] = $row['Client']['Social Security'];
                }
            }
            if($age == $this->lifeExpectancySpouse && isset($row['Spouse'])){
                $last_ss['Spouse'] = $row['Spouse']['Social Security'];
            }

            //after life expectancy
            if($age > $this->lifeExpectancy && isset($row['Spouse'])){
                //unset($row['Client']);
                if($age == $this->lifeExpectancy+1){
                    $row['Spouse']['Social Security'] = $last_ss['Client'];
                }
            }
            if($age > $this->lifeExpectancySpouse && isset($row['Spouse'])){
                //unset($row['Spouse']);
                if($age == $this->lifeExpectancySpouse+1){
                    $row['Client']['Social Security'] = $last_ss['Spouse'];
                }
            }

            $plan[] = $row;
        }

        $data['plan'] = $this->stylize($plan,$spouse);
        return $data;

    }

    public function mask($value){
        $value = round($value);
        if($value < 0){
            $value = "(".(-1 * $value).")";
        }elseif($value == 0){
            $value = null;
        }
        return $value;

    }
    public function stylize($plan,$spouse){
        $columns = $this->getColumns($spouse);
        foreach($plan as $key => $row){
            foreach($columns as $column){
                if(isset($column["owner"]) && isset($row[$column["owner"]])){
                    if(isset($column["field"])){
                        $plan[$key][$column["owner"]][$column["name"]][$column["field"]] = $this->mask($plan[$key][$column["owner"]][$column["name"]][$column["field"]]);
                    }else{
                        $plan[$key][$column["owner"]][$column["name"]] = $this->mask($plan[$key][$column["owner"]][$column["name"]]);
                    }
                    
                }elseif(isset($row[$column["name"]])){
                    if(isset($column["field"])){
                        $plan[$key][$column["name"]][$column["field"]] = $this->mask($plan[$key][$column["name"]][$column["field"]]);
                    }else{
                        $plan[$key][$column["name"]] = $this->mask($plan[$key][$column["name"]]);
                    }
                }
            }
        }

        return $plan;
    }


    public function getRetirementValues(){
        $table = $this->retirementTable();
        $data["cover"] = 0;
        $data["gap"] = 0;
        foreach($table["plan"] as $row){
            if($row["Client"]["Age"] >= $this->attributes['what_age_do_you_plan_on_retiring_age']){
                $data["cover"]++;
            }
            if(isset($row["Gap"]) && $row["Gap"] > 0){
                $data["gap"]++;
            }
        }

        return $data;
    }
    

}