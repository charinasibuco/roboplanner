<?php

namespace App\Http\Controllers;

use RoboPlanner\Repositories\FlagRepository;
use Illuminate\Http\Request;

use App\Http\Requests;

class FlagController extends Controller
{
   	public function __construct(FlagRepository $flag){
		$this->middleware('auth');
   		$this->flag = $flag;
   	}
   	public function index(Request $request)
	{
		$data['page_number'] = $request->page;
		$data['search'] = $request->search;
		$data['sort'] = ($request->sort == 'asc')? 'desc' : 'asc';
		$data['flags'] = $this->flag->getFlag($request);
		#dd($data['search']);
		return view('roboplanner.flag.index',$data);
	}
   	public function create()
	{
		$data = $this->flag->create();
		return view('roboplanner.flag.form', $data);
	}
	public function store(Request $request)
	{
		$results = $this->flag->save($request);
		if($results['status'] == false)
		{
			return redirect()->route('flags_create')->withErrors($results['results'])->withInput();
		}
		return redirect()->route('flags_create')->with('message', 'Successfully Added Flag');
	}
	public function edit($id)
	{
		$data = $this->flag->edit($id);
		return view('roboplanner.flag.form', $data);
	}
	public function update($request, $id)
	{
		$this->flag->update($request, $id);
	}
	public function destroy(Request $request, $id)
	{
		$this->flag->delete($id);
		return redirect()->route('flags')->with('message', 'Successfully Deleted');
	}
}
