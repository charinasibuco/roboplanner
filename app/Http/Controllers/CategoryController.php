<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use RoboPlanner\Helper\ControllerHelper;
use RoboPlanner\Repositories\CategoryRepository;

use Gate;
use Auth;


class CategoryController extends Controller
{
    use ControllerHelper;
    private $message;
    /**
     * RoleController constructor.
     * @param RoleInterface $role
     * @param PermissionInterface $permissions
     */
    public function __construct(CategoryRepository $category){
        $this->middleware('auth');
        $this->category         = $category;
        $this->category->setListener($this);
}

    public function index(Request $request){
        $data = [];

        if(Gate::denies('view_categories'))
        {
            return view('roboplanner.errors.403');
        }
        else
        {
            $data['search']     = trim($request->input('search'));
            $data['sort']       = ($request->input('sort') == 'asc')? 'desc' : 'asc';
            $data['page_number']= $request->input('page');
            $data['categories'] = $this->category->getCategories($request);
            return view('roboplanner.categories.index',$data);
        }
    }

    public function create(){

        if(Gate::denies('add_category')){
            abort(403);
        }
        $data['action']         = route('category_store');
        $data['header']         = 'Add Category';
        $data['category']       = $this->category->create();
        $data['categories']     = $this->category->getAllCategories();
        return view('roboplanner.categories.form',$data);
    }

    public function edit($id){

        if(Gate::denies('update_category')){
            abort(403);
        }
        $data['action']             = route('category_update',$id);
        $data['header']             = 'Edit Category';
        $category                    = $this->category->find($id);
        $data['category']               = $category;
        $data['categories']     = $this->category->getAllCategories();
        return view('roboplanner.categories.form',$data);
    }

    public function store(Request $request){

        $results = $this->category->save($request);
        if($results['status'] == false)
        {
            return redirect()->route('category_add')->withErrors($results['results'])->withInput();  
        }
        return redirect()->route('category_list')->with('message', 'Successfully Added');
    }

    public function destroy($id)
    {
        if(Gate::denies('delete_category')){
            abort(403);
        }

        $result     = $this->category->delete($id);
        if($result){
            return redirect()->route('category_list')->with('message', 'Successfully Deleted');
        }
    }

    public function update(Request $request, $id){

        $results =  $this->category->save($request,$id);
        if($results['status'] == false)
        {
            return redirect()->route('category_edit',$id)->withErrors($results['results'])->withInput();  
        }
        return redirect()->route('category_list')->with('message', 'Successfully Updated');

    }

    public function getCategories($input = null){
      //  return $this->category->getCategories($input);
    }
}
