<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gate;
use RoboPlanner\Helper\ControllerHelper;
use App\Http\Requests;
use RoboPlanner\Repositories\PostRepository;
use RoboPlanner\Repositories\CategoryRepository;
use App\Post;

class PostController extends Controller
{
	use ControllerHelper;

    private $message;

    public function __construct(PostRepository $post, CategoryRepository $categories){
		$this->middleware('auth');
   		$this->post = $post;
   		$this->categories = $categories;
   		$this->post->setListener($this);
   	}

   	public function setMessage($message){
        $this->message = $message;
    }

    public function index(Request $request){
    	if(Gate::denies('view_blogs'))
	   	{
	   		return view('roboplanner.errors.403');
	    }
	    $data['posts'] 		= $this->post->getPost($request);
	    return view('roboplanner.post.index', $data);
    }

    public function create(Request $request)
   {
	   	if(Gate::denies('add_blog'))
	   	{
	   		return view('roboplanner.errors.403');
	   		
	    }
	    $data = $this->post->create();
	    $data['posts'] = $this->post->getPost($request);
	    $data['categories'] = $this->categories->getAllCategories();
    	return view('roboplanner.post.form', $data);
   }
   public function store(Request $request)
	{
		#dd($request->all());
		#return $this->post->save($request);
		$results = $this->post->save($request);
        if($results['status'] == false)
        {
            return redirect()->route('post_create')->withErrors($results['results'])->withInput();  
        }
        return redirect()->route('post')->with('message', 'Successfully Added');
	}
	public function edit(Request $request, $id)
	{
		if(Gate::denies('update_blog'))
		{
            return view('roboplanner.errors.403');
        }
        else
        {
        	$data = $this->post->edit($id);
//        	$data['posts'] = $this->post->getPost($request);
        	$data['categories'] = $this->categories->getAllCategories();
			return view('roboplanner.post.form', $data);
        }
	}
	public function update(Request $request, $id)
	{
		#return $this->post->save($request, $id);
		$results =  $this->post->save($request,$id);
        if($results['status'] == false)
        {
            return redirect()->route('post_create',$id)->withErrors($results['results'])->withInput();  
        }
        return redirect()->route('post')->with('message', 'Successfully Updated');
	}
	public function destroy(Request $request, $id)
	{
		if(Gate::denies('delete_blog'))
		{
            return view('roboplanner.errors.403');
        }
        else{
        	$this->post->destroy($id);
		return redirect()->route('post');
		}
	}
}
