<?php
namespace RoboPlanner\Repositories;
use RoboPlanner\Repositories\Repository;
use Illuminate\Support\Facades\Validator;

class CategoryRepository extends Repository
{
    const LIMIT = 20;

    protected $listener;
    private $rules          = ['title' => 'required', 'slug' => 'required','sort' => 'required'];
    private $messages       = ['required'      => 'The :attribute is required'];

    public function model(){
        return 'App\Category';
    }

    public function setListener($listener){
        $this->listener = $listener;
    }
    public function getAllCategories(){
        return $this->model->all();
    }
    public function getCategories($request = null){
        $model      = $this->model;
        if($request != null) {
            if ($request->has('search')) {
                $model = $model->where('title', 'LIKE', '%' . $request->input('search') . '%')
                    ->orWhere('slug', 'LIKE', '%' . $request->input('search') . '%')
                    ->orWhere('sort', 'LIKE', '%' . $request->input('search') . '%')
                    ->orWhere('description', 'LIKE', '%' . $request->input('search') . '%')
                    ->select('id', 'title', 'slug', 'sort', 'description')
                    ->orderBy('title', $request->input('sort'));
//                ->paginate(self::LIMIT);
            }

            if($request->input('order_by') && $request->input('sort')){
                $model  = $model->orderBy($request->input('order_by'), $request->input('sort'));
//            return $this->model->orderBy($request->input('order_by'), $request->input('sort'))->paginate(self::LIMIT);
            }
        }


        return $model->paginate(self::LIMIT);
    }



    public function create(){

    }

    public function edit(){
    }

    public function save($request, $id = 0){
        $action         = ($id == 0) ? 'category_add' : 'category_edit';
        $input          = $request->all();
        $messages       = ['required'      => 'The :attribute is required'];

        $validator      = Validator::make($input, $this->rules, $messages);
        if ($validator->fails()) 
            {
               #return $this->listener->failed($validator, $action);
                return ['status' => false, 'results' => $validator];
            }

        if($id == 0){
            $this->model->create($input);
        }else{
            $this->model->find($id)->update($input);
        }

        #return $this->listener->passed($action, $id);
        return ['status' => true, 'results' => 'Success'];
    }

    public function destroy($id){
        $this->model->where('id',$id)->delete();
    }
}