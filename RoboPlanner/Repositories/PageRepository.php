<?php
namespace RoboPlanner\Repositories;
use App\Http\Requests\Request;
use Illuminate\Support\Facades\URL;
use RoboPlanner\Repositories\Repository;
use Illuminate\Support\Facades\Validator;

class PageRepository extends Repository{

	protected $listener;

	const LIMIT = 20;

	public function model(){
		return 'App\Page';
	}

	public function setListener($listener){
        $this->listener = $listener;
    }

	public function getPage($request = null)
	{
		$model		= $this->model;
		$order		= 'created_at';
		$sort		= 'desc';

		if($request->input('order_by') && $request->input('sort')){
			$order		= $request->input('order_by');
			$sort		= $request->input('sort');
		}

		if($request != null){
			if($request->has('search')){
				$model = $model->where('title', 'LIKE', '%' . $request->input('search'). '%')
					->orWhere('slug', 'LIKE', '%' . $request->input('search') . '%')
					->orWhere('content', 'LIKE', '%' . $request->input('search') . '%')
					->orWhere('status', 'LIKE', '%' . $request->input('search') . '%')
					->select('*')
					->orderBy('title');
			}
		}
		if($request->input('order_by') && $request->input('sort')){
			$model	= $model->orderBy($order, $sort);
		}

		return $model->paginate(self::LIMIT);
	}

	public function create()
	{
		$data['parent_id']  = old('parent_id');
		$data['title'] 		= old('title');
		$data['content'] 	= old('content');
		$data['slug'] 		= old('slug');
		$data['template'] 	= old('template');
		$data['status'] 	= old('status');
		$data['order']		= old('order');
		$data['meta_title']	= old('meta_title');
		$data['keywords']		= old('keywords');
		$data['description']	= old('description');
		return $data;
	}
	public function edit($id)
	{
		$page 				= $this->model->find($id);
		$data['parent_id']	= $page->parent_id;
		$data['title']		= $page->title;
		$data['content'] 	= $page->content;
		$data['slug'] 		= $page->slug;
		$data['template'] 	= $page->template;
		$data['status'] 	= $page->status;
		$data['order'] 	    = $page->order;
		$data['meta_title']	= $page->meta_title;
		$data['keywords']   = $page->keywords;
		$data['description']= $page->description;
		return $data;
	}
	// public function update(array $request, $id)
	// {
	// 	$input = $request->all();
	// 	$this->model->update($input);
	// }

	public function save($request, $id = 0){
        $action         = ($id == 0) ? 'page_create' : 'page_update';
        $input          = $request->all();
        $display_slug 	= $input['display_slug'];
        $messages       = ['required'      => 'The :attribute is required'];
//			dd($input);
        $validator      = Validator::make($input, [ 'title' => 'required','slug' => 'required|unique:pages,slug' . ($id ? ",$id" : ''), 'status' => 'required'], $messages);
        
        if($validator->fails()){
			 return ['status' => false, 'results' => $validator];
		}

        if($id == 0){
        	
            $pages       = $this->model->create(['parent_id'=>$input['parent_id'], 'title' => $input['title'], 'content' => $input['content'], 'slug' =>$input['slug'],'status' => 'hidden', 'order'=>$input['order'],
            									'meta_title' => $input['meta_title'], 'keywords' => $input['keywords'], 'description' => $input['description']]);
            return ['status' => true, 'results' => 'Success'];
        }else{
            $pages 				 = $this->model->find($id);
            $pages->parent_id    = $input['parent_id'];
            $pages->title        = $input['title'];
            $pages->content      = $input['content'];
            $pages->slug         = $display_slug.$input['slug'];
            
            $pages->order        = $input['order'];
            $pages->meta_title   = $input['meta_title'];
            $pages->keywords     = $input['keywords'];
            $pages->description  = $input['description'];

            $status = $this->model->where('id',$pages->parent_id)->first();

            if($status){
				if($status->status == 'hidden'){
					$pages->status       = 'hidden';
				}else{
					$pages->status       = $input['status'];
				}
            }
            else{
            	$pages->status       = $input['status'];
            }
            $pages->save();    
        }
        return ['status' => true, 'results' => 'Success'];
    }

	public function getMenu($request, $id = 0 ){
		$url			= URL::to('/') != $request->url() ? str_replace(URL::to('/') . '/', '', $request->url()) : URL::to('/');
//		$url			= URL::to('/');

		$pages 			= $this->model->where('parent_id', $id)->where('status', 'published')->orderBy('order', 'asc');
		$results		= [];
		foreach($pages->get() as $page){
			$p 					= new \stdClass();
			$p->title			= $page->title;
			$p->slug			= $page->slug;
			$p->active			= ($url == $page->slug) ? true : false;
//			$p->url				= $url;
			$p->url				= URL::to('/') . '/'. $page->slug;
			$p->children		= $this->getMenu($request, $page->id);
			$results[]	= $p;
		}

		return $results;
	}

	public function delete($id)
	{
		return $this->model->find($id)->delete();
	}
}