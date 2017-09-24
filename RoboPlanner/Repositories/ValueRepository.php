<?php
namespace RoboPlanner\Repositories;
use App\Value;

class ValueRepository extends Repository{
    const LIMIT = 10;

    protected $listener;

    public function model(){
        return 'App\Value';
    }

    public function setListener($listener){
        $this->listener = $listener;
    }




    public function allValues(){
        return $this->model->all()->toArray();
    }

    public function searchValue($value){
        return $this->model->where('slug',"=",$value)->first();
    }

    public function getValue($request){
        if($request->has('search')){
            return  $query = $this->model->where('name', 'LIKE', '%' . $request->input('search'). '%')
                                ->orWhere('label', 'LIKE', '%' . $request->input('search') . '%')
                                ->select('id','name','label')
                                ->orderBy('name', $request->input('sort'))
                                ->paginate(self::LIMIT);
        }
        if($request->input('order_by') && $request->input('sort')){
            return Value::orderBy($request->input('order_by'), $request->input('sort'))->paginate(self::LIMIT);
        }
        return Value::paginate(self::LIMIT);
    }

    public function getFillable(){
        return $this->model->getFillable();
    }
    public function create(){
        $data = [];
        foreach($this->getFillable() as $value){
            $data[$value] = old($value); 
        }
        return $data;   
    }


    public function store(Array $input){
        $input['slug'] = $this->slugify($input['name']);
        $item = $this->model->create($input);
        return $item;
    }


   
    public function edit($id){
        $data = [];
        $value = $this->model->find($id);
        foreach($this->getFillable() as $field){
            $data[$field] = is_null(old($field))?$value[$field]:old($value);
        }
        
        return $data;
    }


    public function update(Array $input,$id){
        $input['slug'] = $this->slugify($input['name']);
        $this->model->where('id',$id)->update($input);
        return $this->model->find($id);
    }

    public function destroy($id){
        $item = $this->model->find($id)->name;
        $this->model->find($id)->delete();
        return $item;
    }

    public function checkName($input){
        $count = $this->model->where('name','=',$input['name'])->count();
        if($count > 0){
            $item = $this->model->find($input['id']);
            if(($input['header'] == "Edit") && ($item->name == $input['name'])){
                return "true";
            }
            return 'false';
        }
        return 'true';

    }
}