<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use RoboPlanner\Helper\SpreadSheet;
use RoboPlanner\Libraries\Csv;
use RoboPlanner\Repositories\LogRepository;
use RoboPlanner\Repositories\CoverLetterRepository as CoverLetter;
use RoboPlanner\Repositories\RetirementPlanRepository as RetirementPlan;
use RoboPlanner\Repositories\ActionStepsRepository as ActionSteps;
use Auth;
use Carbon\Carbon;
use App\User;
use RoboPlanner\Repositories\UserRepository;
use RoboPlanner\Repositories\UserScoresAndFlags;

class DashboardController extends Controller
{
    public function __construct(CoverLetter $cover_letter, RetirementPlan $retirement_plan, ActionSteps $action_steps, UserRepository $users, LogRepository $logs, UserScoresAndFlags $ret_scores)
    {
        $this->middleware('auth');
        $this->users            = $users;
        $this->cover_letter     = $cover_letter;
        $this->retirement_plan  = $retirement_plan;
        $this->action_steps     = $action_steps;
        $this->logs             = $logs;
        $this->ret_scores = $ret_scores;
    }



    public function index(Request $request, UserScoresAndFlags $scores){
        if(Auth::user()->hasRole('client')){
            $action_steps               = $this->action_steps->results();
            $data                       = array_merge_recursive($scores->results(), $action_steps);
            $meta                       = Auth::user()->usermeta->where('option', 'married')->first();
            $spouse                     = Auth::user()->usermeta->where('option', 'spouse_name')->first();
            $retirementAge              = Auth::user()->usermeta->where('option', 'what_age_do_you_plan_on_retiring_age')->first();
            $data['married']               = $meta->value;
            $data['spouse_name']           = $spouse->value;
            $data['owner']                 = Auth::user()->first_name;

            $illustrative_plan              = $scores->getRetirementPlan();
            $retirement_table   = $scores->retirementTable();
            $data['retirement_columns'] = $retirement_table['columns'];
            $data['retirement_table'] = $retirement_table['plan'];
            $data['life_expectancy']        = $scores->lifeExpectancy;
            $data['life_expectancy_spouse'] = $scores->lifeExpectancySpouse;


            $data['illustrative_plan']      = $illustrative_plan;
            $data['retirement_age']         = $retirementAge->value;
            $plan                           = json_decode(json_encode($illustrative_plan['graph']));
            $data['retirement_plan']        = $this->retirement_plan->results($plan);
            return view('roboplanner.client-dashboard',$data);
        }

        $data               = [];
        $data['users']      = $this->users->getUsers();
        $data['logs']       = $this->logs->getLogs();
        $data['clients']    = User::orderBy('users.created_at','DESC')
                                ->leftJoin('role_user','users.id','=','role_user.user_id')
                                ->leftJoin('roles','roles.id','=','role_user.role_id')
                                ->where('roles.name','client')
                                ->get();

        return view('roboplanner.dashboard',$data);
    }


    public function dashboard_show($id, UserScoresAndFlags $scores){
        $user                       = $scores->find($id);
        $score_results = $scores->results($id);
        $action_steps               = $this->action_steps->results();

        $data                       = array_merge_recursive($score_results, $action_steps);
        $meta                       = User::find($id)->usermeta->where('option', 'married')->first();
        $spouse                     = User::find($id)->usermeta->where('option', 'spouse_name')->first();
        $data['user']               =  User::find($id);
        $data['married']               = ($meta) ? $meta->value : '';
        $data['spouse_name']           = ($spouse) ? $spouse->value : '';
        $illustrative_plan          = $scores->getRetirementPlan($id);
        
        $retirement_table   = $scores->retirementTable();
        $data['retirement_columns'] = $retirement_table['columns'];
        $data['retirement_table'] = $retirement_table['plan'];
        $data['life_expectancy']        = $scores->lifeExpectancy;
        $data['life_expectancy_spouse'] = $scores->lifeExpectancySpouse;

        $data['illustrative_plan']  = $illustrative_plan;
        $plan                       = json_decode(json_encode($illustrative_plan['graph']));
        $retirementAge              = User::find($id)->usermeta->where('option', 'what_age_do_you_plan_on_retiring_age')->first();
        $data['retirement_age']        = (isset($retirementAge)) ? $retirementAge->value : '';
        
        $data['owner']              = $user->first_name;
        $data['retirement_plan']       = (count($illustrative_plan['graph']) != 0 ) ? $this->retirement_plan->results($plan) :[];
        $data['id'] = $id;
        return view('roboplanner.client-dashboard',$data);

    }




}
