<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use RoboPlanner\Repositories\PageRepository;
use App\Http\Requests;
use Gate;
use App\Page;
class PageController extends Controller
{
	public function __construct(PageRepository $page){
		$this->middleware('auth');
   		$this->page = $page;
   	}
   public function index(Request $request)
   {
   	if(Gate::denies('view_pages'))
   	{
   		return view('roboplanner.errors.403');
   	}
   	else
   	{
//		return $request->url();
//		return URL::to('/');
   		$data['pages'] = $this->page->getPage($request);
	   	$data['search']= $request->input('search');
	   	return view('roboplanner.page.index', $data);
	}
   }
   public function create(Request $request)
   {
   	if(Gate::denies('add_page'))
   	{
        return view('roboplanner.errors.403');
    }
    else
    {
    	$data = $this->page->create();
    	$data['pages'] = $this->page->getPage($request);
	   	$data['action'] = route('page_store');
	   	return view('roboplanner.page.form',$data);
	}
   }
   public function save(Request $request)
	{
		#dd($request->all());
		$results = $this->page->save($request);
		if($results['status'] == false)
		{
			return redirect()->route('page_create')->withErrors($results['results'])->withInput();
		}
		return redirect()->route('page')->with('message', 'Successfully Added Page');
	}
	public function edit(Request $request, $id)
	{
		if(Gate::denies('edit_page'))
		{
            return view('roboplanner.errors.403');
        }
        else
        {
        	$data = $this->page->edit($id);
        	$data['pages'] = $this->page->getPage($request);
			$data['action'] = route('page_update', $id);
			return view('roboplanner.page.form', $data);
        }
	}
	public function update(Request $request, $id)
	{
		#dd($request->all());
		$results = $this->page->save($request, $id);
		if($results['status'] == false)
		{
			return redirect()->route('page_edit', $id)->withErrors($results['results'])->withInput();
		}
		 return redirect()->route('page', $id)->with('message', 'Successfully Update Page');
		#dd($results);
	}
	public function destroy(Request $request, $id)
	{
		if(Gate::denies('delete_page')){
            return view('roboplanner.errors.403');
        }
        else{
        	$this->page->delete($id);
        	Page::select('id')->where('parent_id', $id)->delete($id);
			return redirect()->route('page')->with('message', 'Successfully Deleted');
        }
	}
}
