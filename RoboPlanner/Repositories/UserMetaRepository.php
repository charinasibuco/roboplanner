<?php

namespace RoboPlanner\Repositories;
use Carbon\Carbon;
use RoboPlanner\Repositories\Repository;
use App\PersonalInfo;
use App\RoleUser;
use App\Role;
use App\UserMeta;
use Illuminate\Support\Facades\Validator;

class UserMetaRepository extends Repository{

    /*const LIMIT                 = 20;
    const INPUT_DATE_FORMAT     = 'Y-m-d';
    const OUTPUT_DATE_FORMAT    = 'F d,Y';*/

    protected $listener;

    public function model(){
        return 'App\UserMeta';
    }

    public function setListener($listener){
        $this->listener = $listener;
    }

    public function setDate($date){
        return date('Y-m-d', strtotime($date));
    }

    public function getUsers($request){
        $query          = $this->model->leftJoin('personal_infos','personal_infos.user_id','=','users.id');
        if($request->has('search')){
            $search     = trim($request->input('search'));
            $query      = $query->where(function($query) use ($search){
                            $query->where('first_name','LIKE','%'.$search.'%')
                                ->orWhere('last_name','LIKE','%'.$search.'%')
                                ->orWhere('nickname','LIKE','%'.$search.'%')
                                ->orWhere('gender','LIKE','%'.$search.'%')
                                ->orWhere('position','LIKE','%'.$search.'%');
            });
        }

        $data           = $query->select('users.*')->get();

        return $data;
    }

    public function create(){

        $data['action']         = route('user_store');
        $data['action_name']    = 'Add';

        $data['email']          = old('email');
        $data['first_name']     = old('first_name');
        $data['last_name']      = old('last_name');
        $data['nickname']       = old('nickname');
        $data['status']         = old('status');
        $data['birthdate']      = old('birthdate');
        $data['gender']         = old('gender');
        $data['position']       = old('position');
        $data['date_hired']     = old('date_hired');

        return $data;
    }

    public function assign_role($request, $id){
        if(RoleUser::where('user_id',$id)->first()){
            RoleUser::where('user_id',$id)->update(['role_id' => $request]);
        }else{
            $this->model->where('id', $id)->first()->assignRole($request);
        }

    }

    public function save($request, $id = 0){

        $action     = ($id == 0) ? 'user_create' : 'user_edit';

        $input      = $request->all();
        $messages   = [
            'required' => 'The :attribute is required',
        ];
        $validator  = Validator::make($input, [
            'first_name'    => 'required',
            'last_name'     => 'required',
            'nickname'      => 'required',
            'email'         => 'required',
            'birthdate'     => 'required',
            'gender'        => 'required',
            'position'      => 'required',
            'date_hired'    => 'required'
        ], $messages);

        if($validator->fails()){
            return $this->listener->failed($validator, $action);
        }

        if($id == 0){
            $this->model->create($input);
            $this->model->orderBy('created_at', 'desc')->first()->assignRole(2);
            $this->listener->setMessage('User is successfully created!');
        }else{
            $this->model->where('id',$id)->update($input);
            $this->listener->setMessage('User is successfully updated!');
        }

        return $this->listener->passed($action);
    }

    public function signupSave($id, $input)
    {
        $user_meta = [];
        $user_meta['user_id'] = $id;
        $unset_keys = ['first_name','last_name','email','password','phrase','confirm','state'];
        foreach($unset_keys as $key)
        {
            unset($input[$key]);
        };
        $user_meta['option']    = 'account_details';
        $user_meta['value']     = serialize($input);
        return $this->model->create($user_meta);
    }

    public function edit($id){
        $data['action']         = route('user_edit', $id);
        $data['action_name']    = 'Edit';

        $user                   = $this->model->find($id);
        $p_info                 = PersonalInfo::where('user_id', $id)->first();

        $data['email']          = (is_null(old('email'))?$user->email:old('email'));
        $data['first_name']     = (is_null(old('first_name'))?$user->first_name:old('first_name'));
        $data['last_name']      = (is_null(old('last_name'))?$user->last_name:old('last_name'));
        $data['nickname']       = (is_null(old('nickname'))?$user->nickname:old('nickname'));
        $data['status']         = (is_null(old('status'))?$user->status:old('status'));
        $data['password']       = (is_null(old('password'))?$user->password:old('password'));

        if(is_object($p_info)){
            $data['gender']     = (is_null(old('gender'))?$p_info->gender:old('gender'));
            $data['birthdate']  = $this->getDate((is_null(old('birthdate'))?$p_info->birthdate:old('birthdate')));
            $data['position']   = (is_null(old('position'))?$p_info->birthdate:old('position'));
            $datehired          = (is_null(old('date_hired'))?$p_info->date_hired:old('date_hired'));

            $data['date_hired'] = Carbon::createFromFormat(self::OUTPUT_DATE_FORMAT, $datehired);
        }else{
            $data['gender']     = old('gender');
            $data['birthdate']  = old('birthdate');
            $data['position']   = old('position');
            $data['date_hired'] = old('date_hired');
        }

        return $data;
    }

    public function update(array $input, $id){
        if(!isset($input['investments'])){
            $input['investments']=[];
        }

        $hasInsurance = false;

        foreach($input as $option => $value){
            $user_meta = $this->model->where('user_id', $id)->where('option',$option)->first();
            if($option == 'children'){
                unset($value['default']);
                $children = [];
                foreach($value as $child_key => $child_value){
                    $children[$child_key]['name'] = $child_value['name'];
                    $children[$child_key]['age'] = $child_value['age'];
                    $children[$child_key]['child_college_plan'] = isset($child_value['child_college_plan'])?$child_value['child_college_plan']:"";
                }
                $value = $children;
                $input['number_children'] = count($children);
                $input['specified_number_children'] = count($children);
            }
            if($option == 'expenses'){
                unset($value['default']);
                $expenses = [];
                foreach($value as $expense_key => $expense_value){
                    $expenses[$expense_key]['expense_type'] = $expense_value['expense_type'];
                    $expenses[$expense_key]['expense_amount'] = str_replace(['%','$', ','], '', $expense_value['expense_amount']);
                    $expenses[$expense_key]['timeframe_start'] = $expense_value['timeframe_start'];
                    $expenses[$expense_key]['timeframe_end'] = $expense_value['timeframe_end'];
                    $expenses[$expense_key]['others'] = isset($expense_value['others'])?$expense_value['others']:"";
                }
                $value = $expenses;
            }
            if($option == 'pension'){
                unset($value['default']);
                $pension = [];
                foreach($value as $pension_key => $pension_value){
                    $pension[$pension_key]['type'] = isset($pension_value['type'])?$pension_value['type']:null;
                    $pension[$pension_key]['does_it_have_a_cost_of_living_adjustment'] = isset($pension_value['does_it_have_a_cost_of_living_adjustment'])?$pension_value['does_it_have_a_cost_of_living_adjustment']:"No";
                    $pension[$pension_key]['projected_monthly_pension_benefit'] = str_replace(['%','$', ','], '', $pension_value['projected_monthly_pension_benefit']);
                     $pension[$pension_key]['own'] = $pension_value['own'];
                    $pension[$pension_key]['survivor_benefit'] = $pension_value['survivor_benefit'];
                    $pension[$pension_key]['what_percent_gets_passed_on'] = str_replace(['%','$', ','], '', $pension_value['what_percent_gets_passed_on']);
                }
                $value = $pension;
            }
            if($option == 'assets'){
                unset($value['default']);
                $assets     = [];
                $strreplace = ['$', '$', ',', ' '];
                $num    = ['balance', 'additions', 'withdrawals', 'annual_income', 'value','interest_rate'];
                foreach($value as $asset_key => $asset_value){
                     if(!isset($asset_value['asset_type'])){
                        unset($value[$asset_key]);
                    }
                    foreach($asset_value as $key => $v){
                        if(!is_array($v)){
                            if(in_array($key, $num)) {
                                $assets[$asset_key][$key] = str_replace($strreplace,'', $v);
                            }else{
                                $assets[$asset_key][$key] = $v;
                            }
                        }else{
                            foreach($v as $k2 => $v2){
                                foreach($v2 as $k3 => $v3) {
                                    if(in_array($k3, $num)) {
                                        $assets[$asset_key][$key][$k2][$k3] = str_replace($strreplace, '', $v3);
                                    }else{
                                        $assets[$asset_key][$key][$k2][$k3] = $v3;
                                    }
                                }
                            }
                        }

                    }
                }
                $value = $assets;
            }
            if($option == 'liabilities'){
                unset($value['default']);
                $liabilities = [];
                foreach($value as $liability_key => $liability_value){
                    $liabilities[$liability_key]['liability_type'] = $liability_value['liability_type'];
                    $liabilities[$liability_key]['owner_debtor'] = $liability_value['owner_debtor'];
                    $liabilities[$liability_key]['bank'] = $liability_value['bank'];
                    $liabilities[$liability_key]['balance'] = str_replace(['%','$', ','], '', $liability_value['balance']);
                    $liabilities[$liability_key]['monthly_payment'] = str_replace(['%','$', ','], '', $liability_value['monthly_payment']);
                    $liabilities[$liability_key]['interest_rate'] = str_replace(['%','$', ','], '', $liability_value['interest_rate']);
                    $liabilities[$liability_key]['loan_term_start'] = $liability_value['loan_term_start'];
                    $liabilities[$liability_key]['loan_term_end'] = $liability_value['loan_term_end'];
                    $liabilities[$liability_key]['loan_date'] = isset($liability_value['loan_date'])?$liability_value['loan_date']:"";
                    $liabilities[$liability_key]['others'] = isset($liability_value['others'])?$liability_value['others']:"";
                }
                $value = $liabilities;
            }

            if($option == 'do_you_have_life_insurance'){
                if($value == 'Yes'){
                    $hasInsurance = true;
                }
            }

            if($option == 'life_insurance'){
                unset($value['default']);
                $insurance      = [];
                if($hasInsurance == true) {
                    foreach ($value as $key => $value) {
                        $insurance[$key]['benefit_type'] = $value['benefit_type'];
                        $insurance[$key]['loans'] = isset($value['loans'])?$value['loans']:null;
                        $insurance[$key]['cash_value'] = str_replace(['$', '%', ',', ' '],'', $value['cash_value']);
                        $insurance[$key]['duration_in_months'] = $value['duration_in_months'];
                        $insurance[$key]['death_benefit'] = str_replace(['$', '%', ',', ' '], '', $value['death_benefit']);
                        $insurance[$key]['yearly_premium'] = str_replace(['$', '%', ',', ' '], '', $value['yearly_premium']);
                        $insurance[$key]['beneficiary'] = $value['beneficiary'];
                    }
                }

                $value = $insurance;
            }



            if(isset($user_meta)){
                $user_meta->value = is_array($value)?serialize($value):str_replace(['%','$', ','], '', $value);
                $user_meta->save();
            }else{
                if(is_array($value)){
                    $value = serialize($value);
                }
                $this->model->create(['user_id'=>$id,'option'=>$option,'value'=>$value]);
            }
        }

        return 'true';
    }

    public function show($id){
        $data = $this->model->find($id);

        return $data;
    }


    public function destroy($id){
        $this->model->where('id',$id)->delete();
        PersonalInfo::where('user_id',$id)->delete();
    }

    
    public function getModel(){
        return $this->model;
    }

}



