<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use RoboPlanner\Repositories\ValueRepository as Value;

class ValueController extends Controller
{
    public function __construct(Value $value){
    	$this->value = $value;
    }

    public function index(){
    	$data = [];
    	$data['values'] = $this->value->allValues();
    	$data['header'] = "Set";
		$data['action'] = route('value_set');
    	return view('roboplanner.values.index',$data);
    }
    public function create(){
    	$data = $this->value->create();
    	$data['header'] = "Create";
		$data['action'] = route("value_store");
    	//$data['action_name'] = "Create";
    	return view("roboplanner.values.form",$data);
    }


	public function edit($id){
		$data = $this->value->edit($id);
		$data['header'] = "Edit";
		$data['action'] = route("value_update",$id);
		$data['id'] = $id;
		//$data['action_name'] = "Create";
		return view("roboplanner.values.form",$data);
	}

	public function store(Request $request){
		$input = $request->except('_token');
		$item = $this->value->store($input);
		return redirect()->route('value_list')->with('message',$item->name.' Successfully Added.');
	}

	public function update(Request $request, $id){
		$input = $request->except('_token');
		$item = $this->value->update($input,$id);
		return redirect()->route('value_list')->with('message',$item->name.' Successfully Updated.');
	}

	public function checkUniqueName(Request $request){
		$input = $request->except('_token');
		$check = $this->value->checkName($input);
		echo $check;
	}


    public function set(Request $request){
    	$input = $request->except("_token");
		foreach($input as $key => $value){
			$item = $this->value->searchValue($key);
			$item->value = $value;
			$item->save();
		}
    	return redirect()->route("value_list")->with("message","Values Successfully Set.");
    }

    public function all_values(){
    	return serialize($this->value->allValues());
    }

	public function destroy($id){
		$item = $this->value->destroy($id);
		return redirect()->route('value_list')->with('message', $item." Successfully Deleted.");
	}

}
