<?php

namespace RoboPlanner\Repositories;
use App\Log;
use Carbon\Carbon;
use RoboPlanner\Helper\AesTrait;
use App\PersonalInfo;
use App\RoleUser;
use App\Role;
use App\UserMeta;
use Illuminate\Support\Facades\Validator;
use RoboPlanner\Helper\StateHelper;

class UserRepository extends Repository{

    const LIMIT                 = 20;
    const INPUT_DATE_FORMAT     = 'Y-m-d';
    const OUTPUT_DATE_FORMAT    = 'F d,Y';


    use AesTrait, StateHelper;

    protected $listener;

    private $inflationRate      = 0.03;
    private $growthRate         = 0.06;
    private $inputAttributes    = [];
    protected $metas;

    public function model(){
        return 'App\User';
    }

    public function setListener($listener){
        $this->listener = $listener;
    }

    public function setDate($date){
        return date('Y-m-d', strtotime($date));
    }

    public function getUsers($request = null)
    {
        if($request != null) {
            $query = $this->model->leftJoin('personal_infos', 'personal_infos.user_id', '=', 'users.id');
            if ($request->has('search')) {
                $search = trim($request->input('search'));
                $query = $query->where(function ($query) use ($search) {
                    $query->where('first_name', 'LIKE', '%' . $search . '%')
                        ->orWhere('last_name', 'LIKE', '%' . $search . '%')
                        ->orWhere('email', 'LIKE', '%' . $search . '%');
                });
            }

            $order_by = ($request->input('order_by')) ? $request->input('order_by') : 'id';
            $sort = ($request->input('sort')) ? $request->input('sort') : 'desc';

            return $query->select('users.*')
                ->orderBy('users.' . $order_by, $sort)->paginate(self::LIMIT);

        }else{
            return $this->model->orderBy('created_at', 'desc')->paginate(self::LIMIT);
        }
    }

    public function getClients($request){
        $query          = Role::find(2)->users();
        if($request->has('search')){
            $search     = trim($request->input('search'));
            $query->where(function($query) use ($search){
                $query->where('first_name','LIKE','%'.$search.'%')
                    ->orWhere('last_name','LIKE','%'.$search.'%')
                    ->orWhere('email','LIKE','%'.$search.'%');
            });
        }

        $order_by   = ($request->input('order_by')) ? $request->input('order_by') : 'id';
        $sort       = ($request->input('sort'))? $request->input('sort') : 'desc';

        return $query->orderBy($order_by, $sort)->get();
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
            $this->model->where('id', $id)->first()->assignedRole($request);
        }

    }

    public function save($request, $id = 0){
        $action     = ($id == 0) ? 'user_create' : 'user_edit';

        $input      = $request->except(['_token','confirm']);

        $messages   = [
            'required' => 'The :attribute is required',
        ];
        $validator  = Validator::make($input, [
            'first_name'    => 'required',
            'last_name'     => 'required',
        ], $messages);

        if($validator->fails()){
            return $this->listener->failed($validator, $action, $id);
        }

        if($input['password'] != ''){
            $input['password']  = bcrypt($input['password']);
        }else{
            unset($input['password']);
        }

        if($id == 0){
            $this->model->create($input);
//            $this->model->orderBy('created_at', 'desc')->first()->assignRole(2);
            $this->listener->setMessage('User is successfully created!');
        }else{

            $this->model->where('id',$id)->update($input);
            $this->listener->setMessage('User is successfully updated!');
        }

        return $this->listener->passed($action, $id);
    }

    public function edit($id){
        $data['action']         = route('user_update', $id);
        $data['action_name']    = 'Edit';

        $user                   = $this->model->find($id);
        $p_info                 = PersonalInfo::where('user_id', $id)->first();
        $data['email']          = (is_null(old('email'))?$user->email:old('email'));
        $data['first_name']     = (is_null(old('first_name'))?$user->first_name:old('first_name'));
        $data['last_name']      = (is_null(old('last_name'))?$user->last_name:old('last_name'));
        $data['password']       = (is_null(old('password'))?$user->password:old('password'));
        $data['status']         = (is_null(old('status'))?$user->status:old('status'));
        $data['image']         = (is_null(old('image'))?$user->image:old('image'));

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

    /*public function update(array $request, $id){
        $this->model->find($id)->update($request);
    }*/

    public function show($id){
        $user           = $this->model->find($id);
        $object         = null;
        if(count($user->usermeta) > 0) {
            $object = new \stdClass();
            $arr        = ['children', 'pension', 'investments', 'assets', 'liabilities','expenses', 'life_insurance'];
            $notNumber  = ['you_would_be_uncomfortable', 'age', 'what_age_would_you_like_us_to_assume', 'what_age_would_you_like_us_to_assume2', 'spouse_age', 'what_age_do_you_plan_on_retiring_age', 'duration_in_months', 'symbol'];
            foreach ($user->usermeta as $meta) {
                if (!in_array($meta['option'], $arr)) {
                    //$object->{$meta['option']} = (is_numeric($meta['value']) && !in_array($meta['option'], $notNumber)) ? '$' . number_format($meta['value'], 2) : $meta['value'];
                    $object->{$meta['option']} = (is_numeric($meta['value']) && !in_array($meta['option'], $notNumber)) ?  $meta['value'] : $meta['value'];
                } else {
                    $regex = '/s:([0-9]+):"(.*?)"/';
                    $fixed_data = preg_replace_callback(
                        $regex, function ($match) {
                        return "s:" . mb_strlen($match[2]) . ":\"" . $match[2] . "\"";
                    },
                        $meta['value']
                    );
                    /******************************
                     * Just an error catcher
                     **************************/
                    $data = $fixed_data != 'Array'?unserialize($fixed_data):[];
//                    $data = is_array($meta) ? unserialize($meta):[];
                    $data2 = [];
                    if ($meta['value'] != '') {
                        $ctr = 0;
                        if ($meta['option'] == 'children') {
//                            dd($data);
                            if(isset($data['name'])){
                                for($i = 0; $i <= (count($data['name']) - 1); $i++) {
                                    $object2 = new \stdClass();
                                    $object2->name = $data['name'][$i];
                                    $object2->age = $data['age'][$i];
                                    $object2->child_college_plan = $data['child_college_plan'][$i];
                                    $ctr++;

                                    $data2[] = $object2;
                                }
                            }else {
//
                                foreach ($data as $key => $v) {
                                    $object2 = new \stdClass();
                                    $object2->name = isset($v['name'])?$v['name']:"";
                                    $object2->age = isset($v['age'])?$v['age']:"";
                                    $object2->child_college_plan = isset($v['child_college_plan'])?$v['child_college_plan']:"";
                                    $ctr++;
                                    $data2[] = $object2;
                                }
                            }

                            $object->{$meta['option']} = $data2;
                        } elseif ($meta['option'] == 'pension' ) {

                            foreach ($data as $k => $v) {
                                $object2 = new \stdClass();
                                foreach ($v as $k2 => $v2) {
                                    $object2->{$k2} = (is_numeric($v2) && !in_array($v2, $notNumber)) ? '$' . number_format($v2, 2) : $v2;
                                }

                                $data2[] = $object2;
                            }
                            $object->{$meta['option']} = $data2;
                        }
                        elseif($meta['option'] == 'assets' || $meta['option'] == 'liabilities' || $meta['option'] == 'expenses' || $meta['option'] == 'life_insurance'){
//                            if($meta['option'] == 'life_insurance'){
//                                dd($data);
//                            }
                            foreach ($data as $k => $v) {
                                $object2 = new \stdClass();
                                foreach ($v as $k2 => $v2) {
                                    if (!is_array($v2)){
                                        $object2->{$k2} = (is_numeric($v2) && !in_array($k2, $notNumber)) ? number_format($v2, 0) : $v2;
                                    }else{
                                        $list = [];
//                                        dd($v2);
                                        foreach($v2 as $k3 => $v3){
                                            $object3 = new \stdClass();
                                            $cur = ['dollar_value'];
                                            foreach($v3 as $k4 => $v4){
//                                                $object3->{$k4} = (in_array($k4, $cur) ? '$ ': '') .$v4;
                                                $object3->{$k4} = $v4;
                                            }

                                            $list[$k3] = $object3;
                                        }

                                        $object2->{$k2} = $list;
                                    }
                                }

                                $data2[$k] = $object2;
                            }
                            $object->{$meta['option']} = $data2;
                        }elseif($meta['option'] == 'investments'){

                            foreach ($data as $k => $v) {
                                $object2        = new \stdClass();
                                $object2->name  = $v;
                                $data2[]        = $object2;
                            }

                            $object->{$meta['option']}  = $data2;
                        }


//                    $object->{$meta['option']} = $data2;
//                    $object->{$meta['option']} = $data;
                    }

                }

            }
        }
        $this->metas    = $object;
        return $user;
    }

    public function getMeta(){
        return $this->metas;
    }


    public function destroy($id){
        $this->model->where('id',$id)->delete();
        PersonalInfo::where('user_id',$id)->delete();
        Log::where('user_id', $id)->delete();
    }


    
    public function signupSave($input){
        $this->inputAttributes      = $input;
        $user                       = [];

        if(isset($input['pension'])){

            $myfinalarray = array();
            foreach ($input['pension'] as $key => $value) {
                foreach ($value as $k => $v) {
                    $myfinalarray[$k][$key] = $v;
                }
            }

        }

        $user['first_name']     = $input['first_name'];
        $user['last_name']      = $input['last_name'];
        $user['email']          = $input['email'];
//        $user['password']       = bcrypt($this->cryptoJsAesDecrypt($input['phrase'], $input['password']));
        $user['password']       = bcrypt($input['password']);

        $user                   = $this->model->create($user);

        $unset_keys             = ['first_name','last_name','email','password','phrase','confirm','step', '_token'];

        foreach($unset_keys as $key)
        {
            unset($input[$key]);
        };

        if($user){
            $this->assign_role(2, $user->id);
            $meta               = $this->model->find($user->id);

            foreach($input as $key => $value){
                if(!is_array($value)){
//                    $user_meta[]      = ['option' => $key, 'value' => $value];
                    $meta->usermeta()->create(['option' => $key, 'value' => str_replace(['$', ','], '', $value)]);
                }

        }
            if(isset($input['expense'])){
                $meta->usermeta()->create(['option' => 'expense', 'value' => serialize($input['expense'])]);
            }
            if(isset($input['pension'])){
                $meta->usermeta()->create(['option' => 'pension', 'value' => serialize($input['pension'])]);
            }
            if(isset($input['child'])){
                $meta->usermeta()->create(['option' => 'children', 'value' => serialize($input['child'])]);
            }
            if(isset($input['investments'])){
                $meta->usermeta()->create(['option' => 'investments', 'value' => serialize($input['investments'])]);
            }
            if(isset($input['asset'])){
                $meta->usermeta()->create(['option' => 'assets', 'value' => serialize($input['asset'])]);
            }
            if(isset($input['liability'])){
                $meta->usermeta()->create(['option' => 'liabilities', 'value' => serialize($input['liability'])]);
            }

            if(isset($input['life_insurance'])){
                $meta->usermeta()->create(['option' => 'life_insurance', 'value' => serialize($input['life_insurance'])]);
            }


        }

        return $user;
//        return ;
    }

    public function getIncomeGoal($age, $spouseAge = 0){
        $incomeGoalArray            = [];
        $incomeGoal                 = 100000;
        $maxAge                     = 100;
        if($age > 31 || $spouseAge > 29){
            $incomeGoalArray[]        = 0;

            for($j = 31; $j <= $age; $j++){
                $incomeGoal             += $incomeGoal * ( 1+ $this->inflationRate);
            }
        }

        for($x = $age; $x <= $maxAge; $x++){
            $incomeGoal             += $incomeGoal * ( 1+ $this->inflationRate);
            $incomeGoalArray[]      = [
                'age' => $x, 'income_goal' => $incomeGoal
            ];
        }

        return $incomeGoalArray;
    }

    public function checkEmail($email){
        $result = $this->model->where('email', '=', $email)->first();

        if($result){
            return ['status' => 1, 'message' => 'Email is already exists!'];
        }

        return ['status' => 0];
    }

}



