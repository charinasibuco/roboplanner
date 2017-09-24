<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 10/4/2016
 * Time: 11:41 AM
 */

namespace RoboPlanner\Repositories;
use RoboPlanner\Repositories\Repository;
use Illuminate\Support\Facades\Validator;
use App\CategoryPost;
use App\Category;

class PostRepository extends Repository
{
    const LIMIT = 20;

    protected $listener;
    private $rules          = ['title' => 'required', 'slug' => 'required'];
    private $messages       = ['required'      => 'The :attribute is required'];

    public function model(){
        return 'App\Post';
    }

    public function setListener($listener){
        $this->listener = $listener;
    }

    public function getPost($request = null, $frontDisplay = false){
        $model  = $this->model;
        $order  = 'created_at';
        $sort   = 'desc';
        if($request->input('order_by') && $request->input('sort')){
            $order  = $request->input('order_by');
            $sort   = $request->input('sort');
        }

        if($frontDisplay == true){
            $model  = $model->where('status', 'Publish');
        }

        if($request != null){
            if($request->has('search')){

                $model      = $model->where('title', 'LIKE', '%' . $request->input('search'). '%');
                $model      = $model->orWhere('slug', 'LIKE', '%' . $request->input('search') . '%');
                $model      = $model->orWhere('content', 'LIKE', '%' . $request->input('search') . '%');

                if($frontDisplay == false) {
                    $model  = $model->orWhere('status', 'LIKE', '%' . $request->input('search') . '%');
                }

                $model      = $model->select('*');
                $model      = $model->orderBy('title');
            }
        }



        $model      = $model->orderBy($order, $sort);

        if($request->input('category')){
            $model          = $model->whereHas('categories', function($query) use($request){
                $query->where('slug', $request->input('category'));
            });

        }

        if($request->input('archive')){
            $date   = explode(' ',trim(str_replace(["-", "–"], ' ', $request->input('archive'))));
            $month  = $date[0];
            $year   = $date[1];

            $model  = $model->whereYear('created_at', '=', $year);
            $model  = $model->whereMonth('created_at', '=', $month);
        }
        return $model->paginate(10);
    }

    public function getCategoryPost($category){
        $model          = $this->model;
        $model          = $model->where('status', 'Publish');
        $model          = $model->whereHas('categories', function($query) use($category){
            $query->where('slug', $category);
        });
        return $model->paginate(self::LIMIT);
    }

    public function getArchive($archive){
        $model  = $this->model;
        $date   = explode(' ',trim(str_replace(["-", "–"], ' ', $archive)));
        $month  = $date[0];
        $year   = $date[1];
        $model  = $model->where('status', 'Publish');
        $model  = $model->whereYear('created_at', '=', $year);
        $model  = $model->whereMonth('created_at', '=', $month);
        return $model->paginate(self::LIMIT);
    }

    public function getBlogPost($slug){
        return $this->model->where('slug', $slug)->first();
    }

    public function create(){
        $data['action']         = route('post_store');
        $cat                    = [];
        $data['title']          = old('title');
        $data['contents']       = old('contents');
        $data['slug']           = old('slug');
        $data['status']         = 'Publish';
        $data['meta_title']     = old('meta_title');
        $data['meta_keywords']  = old('meta_keywords');
        $data['meta_description']= old('meta_description');
        $data['postCategory']    =$cat;
        return $data;
    }

    public function edit($id){
        $post = $this->model->find($id);
        $cat                    = [];
        $data['action']         = route('post_update', $id);
        $data['title']          = $post->title;
        $data['contents']       = $post->contents;
        $data['slug']           = $post->slug;
        $data['status']         = $post->status;
        $data['meta_title']     = $post->meta_title;
        $data['meta_keywords']  = $post->meta_keywords;
        $data['meta_description']= $post->meta_description;
        foreach($post->CategoryPost as $category){
            $cat[]  = $category->category_id;
        }

        $data['postCategory']    =$cat;
        return $data;
    }

    public function save($request, $id = 0){
        $action         = ($id == 0) ? 'post_create' : 'post_edit';//functionality route

        $input              =  $request->except(['_token']);

        $validator          = Validator::make($input, $this->rules, $this->messages);
        if ($validator->fails()) {
            #$this->listener->failed($validator, $action);
            return ['status' => false, 'results' => $validator];
        }
//        dd($input);
        if($id == 0) {
            $post           = $this->model->create($input);

            if(isset($input['category'])){
                $post->attachCategory($input['category']);
            }

            $this->listener->setMessage('New Post is successfully created!');
        }
        else{
            $post                   = $this->model->with(['Categories'])->find($id);
            $post->title            = $input['title'];
            $post->contents         = $input['contents'];
            $post->meta_title       = $input['meta_title'];
            $post->meta_keywords    = $input['meta_keywords'];
            $post->meta_description = $input['meta_description'];
            $post->slug             = $input['slug'];
            $post->status           = (isset($input['status'])) ? $input['status'] : 'Hidden';

            if($post->save())
            {
                $category_post            = [];

                foreach($post->categories as $category){
                    $category_post[]  = $category->id;
                }

                $post->detachCategory($category_post);

                if(isset($input['category'])){
                    $post->attachCategory($input['category']);
                }
                $this->listener->setMessage('Post is successfully updated!');
            }
        }
        #dd($input['category']);
        #return $this->listener->passed($action, $id);
        return ['status' => true, 'results' => 'Success'];
    }

    public function destroy($id){
        $this->model->where('id',$id)->delete();
    }

    public function archive(){
        // $archive = $this->model->latest()->get()->groupBy(function($item)
        // {
        //  return $item->created_at->format('d-M-y');
        // })->toArray();
        return $this->model->where('status', 'Publish')->get()->groupBy(function($date){
            return \Carbon\Carbon::parse($date->created_at)->format('F Y');
        });
    }
}