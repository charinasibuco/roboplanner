<?php
/**
 * Created by PhpStorm.
 * User: Jaime Handayan
 * Date: 9/26/2016
 * Time: 11:52 AM
 */

namespace RoboPlanner\Repositories;
use Illuminate\Support\Facades\Validator;


class TaxRepository extends Repository
{
    const LIMIT                 = 20;
    const INPUT_DATE_FORMAT     = 'Y-m-d';
    const OUTPUT_DATE_FORMAT    = 'F d,Y';

    protected $listener;


    public function model(){
        return 'App\Tax';
    }

    public function setListener($listener){
        $this->listener = $listener;
    }

    public function getTaxes($request){

        $query = $this->model;
        if($request != null) {
            if ($request->has('search')) {
                $search = trim($request->input('search'));
                $query = $query->where(function ($query) use ($search) {
                    $query->where('tax_rate', 'LIKE', '%' . $search . '%')
                        ->orWhere('single_filters_from', 'LIKE', '%' . $search . '%')
                        ->orWhere('single_filters_to', 'LIKE', '%' . $search . '%')
                        ->orWhere('married_filling_jointly_from', 'LIKE', '%' . $search . '%')
                        ->orWhere('married_filling_jointly_to', 'LIKE', '%' . $search . '%')
                        ->orWhere('married_filling_separately_from', 'LIKE', '%' . $search . '%')
                        ->orWhere('married_filling_separately_to', 'LIKE', '%' . $search . '%')
                        ->orWhere('head_of_household_from', 'LIKE', '%' . $search . '%')
                        ->orWhere('head_of_household_to', 'LIKE', '%' . $search . '%');
                });
            }

            $order_by = ($request->input('order_by')) ? $request->input('order_by') : 'tax_rate';
            $sort = ($request->input('sort')) ? $request->input('sort') : 'asc';

            return $query->orderBy($order_by, $sort)->paginate(self::LIMIT);
        }else{
            return $this->model->orderBy('tax_rate', 'asc')->paginate(self::LIMIT);
        }
    }

    public function create(){

        $data['tax_rate']                       = old('tax_rate');
        $data['single_filters_from']            = old('single_filters_from');
        $data['single_filters_to']              = old('single_filters_to');
        $data['married_filling_jointly_from']   = old('married_filling_jointly_from');
        $data['married_filling_jointly_to']     = old('married_filling_jointly_to');
        $data['married_filling_separately_from']= old('married_filling_separately_from');
        $data['married_filling_separately_to']  = old('married_filling_separately_to');
        $data['head_of_household_from']         = old('head_of_household_from');
        $data['head_of_household_to']           = old('head_of_household_to');
        $data['due_date']                       = old('due_date');
        return $data;
    }

    public function edit($id){
        $result                                 = $this->model->find($id);
        $data['tax_rate']                       = $result->tax_rate;
        $data['single_filters_from']            = $result->single_filters_from;
        $data['single_filters_to']              = $result->single_filters_to;
        $data['married_filling_jointly_from']   = $result->married_filling_jointly_from;
        $data['married_filling_jointly_to']     = $result->married_filling_jointly_to;
        $data['married_filling_separately_from']= $result->married_filling_separately_from;
        $data['married_filling_separately_to']  = $result->married_filling_separately_to;
        $data['head_of_household_from']         = $result->head_of_household_from;
        $data['head_of_household_to']           = $result->head_of_household_to;
        $data['due_date']                       = $result->due_date->format('m/d/Y');
        return $data;
    }

    public function save($request, $id = 0){
        $action     = ($id == 0) ? 'tax_create' : 'tax_edit';

        $input      = $request->except(['_token', 'single_filters_or_more', 'married_filling_jointly_or_more', 'married_filling_separately_to_or_more', 'head_of_household_to_or_more']);

        $messages   = [
            'required' => 'The :attribute is required',
        ];



        if(isset($request->single_filters_or_more)){
            $input['single_filters_to'] = 'or more';
        }

        if(isset($request->married_filling_jointly_or_more)){
            $input['married_filling_jointly_to'] = 'or more';
        }

        if(isset($request->married_filling_separately_to_or_more)){
            $input['married_filling_separately_to'] = 'or more';
        }

        if(isset($request->head_of_household_to_or_more)){
            $input['head_of_household_to'] = 'or more';
        }

        $rules      = [
            'tax_rate'                      => 'required',
            'due_date'                      => 'required',
            'single_filters_to'             => 'required',
            'married_filling_jointly_to'    => 'required',
            'married_filling_separately_to' => 'required',
            'head_of_household_to'          => 'required',
        ];

        $validator      = Validator::make($input, $rules, $messages);
        $tmp            = [];
        foreach($input as $item => $va){
            if($va != 'or more'){
                $tmp[$item] = str_replace(['$', '%', ',', ' '], '', $va);
            }else{
                $tmp[$item] = $va;
            }

        }

        $input          = $tmp;
//return $input;
        $validator->after(function($validator) use($input) {
            $ctr_validation_error = 0;
            if( $input['single_filters_to'] != 'or more'){
                if((float) $input['single_filters_from'] > (float) $input['single_filters_to']){
                    $validator->errors()->add('single_filters_from_error', 'Single filers from should be lesser than Single filers to field!');
                    $ctr_validation_error++;
                }
            }

            if($input['married_filling_jointly_to'] != 'or more'){
                if((float) $input['married_filling_jointly_from'] > (float) $input['married_filling_jointly_to']){
                    $validator->errors()->add('married_filling_jointly_from_error', 'Married filing jointly from should be lesser than Married filing jointly to field!');
                    $ctr_validation_error++;
                }
            }

            if($input['married_filling_separately_to'] != 'or more') {
                if ((float)$input['married_filling_separately_from'] > (float)$input['married_filling_separately_to'] ) {
                    $validator->errors()->add('married_filling_separately_from_error', 'Married filing separately from should be lesser than Married filing separately to field!');
                    $ctr_validation_error++;
                }
            }

            if($input['head_of_household_to'] != 'or more'){
                if ((float)$input['head_of_household_from'] > (float)$input['head_of_household_to'] ) {
                    $validator->errors()->add('head_of_household_from_error', 'Head of household from should be lesser than Head of household to field!');
                    $ctr_validation_error++;
                }

//                $validator->errors()->add('valid_with_error', $ctr_validation_error);
            }
        });


        if($validator->fails()){
            return $this->listener->failed($validator, $action, $id);
        }







        if($id == 0){
            $this->model->create($input);
            $this->listener->setMessage('New tax is successfully created!');
            return $this->listener->passed($action);
        }else{
            $input['tax_rate']  = str_replace(['%', ' '], '', $input['tax_rate']) / 100;
            $input['due_date']  = date('Y-m-d', strtotime($input['due_date']));
            $this->model->where('id',$id)->update($input);
            $this->listener->setMessage('Tax is successfully updated!');
            return $this->listener->passed($action, $id);
        }
    }

    public function destroy($id){
        $this->model->where('id',$id)->delete();
    }
}