<?php
namespace RoboPlanner\Repositories;
use RoboPlanner\Repositories\Repository;
use Illuminate\Support\Facades\Validator;

class FlagRepository extends Repository{
	const LIMIT = 20;

	public function model(){
		return 'App\Flag';
	}

	public function getFlag($request = null)
	{
		if($request != null){
			if($request->has('search')){
				return $this->model->where('color', 'LIKE', '%' . $request->input('search'). '%')
					->orWhere('description', 'LIKE', '%' . $request->input('search') . '%')
					->orWhere('range', 'LIKE', '%' . $request->input('search') . '%')
					->orWhere('wealth_score', 'LIKE', '%' . $request->input('search') . '%')
					->select('*')
					->orderBy('color')
					->paginate(self::LIMIT);
			}
		}
		if($request->input('order_by') && $request->input('sort')){
			return $this->model->orderBy($request->input('order_by'), $request->input('sort'))
				->paginate(self::LIMIT);
		}
		return $this->model->paginate(self::LIMIT);
	}

	public function create()
	{
		$data['flag_type'] 		= old('flag_type');
		$data['color'] 			= old('color');
		$data['description'] 	= old('description');
		$data['range'] 			= old('range');

		return $data;
	}
	public function save($request)
	{
		$input = $request->all();
		$messages   = [
            'required' => 'The :attribute is required',
        ];
		$validator = Validator::make($input, [
										'color' 	=> 'required',
										'description'	=> 'required',
										'range' 		=> 'required',
										'wealth_score'	=> 'required'
										],$messages);
		if($validator->fails()){
			 return ['status' => false, 'results' => $validator];
		}
		$result = $this->model->create($input);
		return ['status' => true, 'results' => $result];
	}
	public function edit($id)
	{
		$flag 					= $this->model->find($id);
		$data['flag_type']		= $flag->flag_type;
		$data['color'] 		= $flag->color;
		$data['description'] 	= $flag->description;
		$data['range'] 			= $flag->range;
		$data['wealth_score'] = $flag->wealth_score;

		return $data;
	}
	public function update(array $request, $id)
	{
		$input = $request->all();
		$this->model->update($input);
	}
	public function delete($id)
	{
		$this->model->where('id', $id)->delete();
		$this->listener->setMessage('Log Successfully Deleted!');
	}
}