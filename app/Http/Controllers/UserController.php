<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use RoboPlanner\Helper\ControllerHelper;
use RoboPlanner\Repositories\UserRepository;
use RoboPlanner\Repositories\UserMetaRepository;
use RoboPlanner\Repositories\SettingRepository;
use Illuminate\Http\Request;

use App\Http\Requests;

use Auth;

use Gate;

//use App\Http\Controllers\Controller;

/**
 * Class UserController
 * @package App\Http\Controllers
 */
class UserController extends Controller
{
	use ControllerHelper;
	protected $user;
	protected $auth;
	private $message;

	/**
	 * UserController constructor.
	 * @param UserInterface $user
	 */
	public function __construct(UserRepository $user, UserMetaRepository $user_meta, SettingRepository $setting){
		$this->middleware('auth');
		$this->user = $user;
		$this->auth = Auth::user();
		$this->user->setListener($this);
		$this->user_meta = $user_meta;
		$this->setting = $setting;
	}

	/**
	 * @param $message
	 */
	public function setMessage($message){
		$this->message = $message;
	}

	/**
	 * @param Request $request
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index(Request $request){

		if($this->auth->hasRole('client')){
			return redirect(route('user_show', $this->auth->id));
		}

		if(Gate::denies('add_user')){
			return view('roboplanner.errors.403');
		}

		$data['search']	= trim($request->input('search'));
		$data['sort']   = ($request->input('sort') == 'asc')? 'desc' : 'asc';
		$data['page_number']= $request->input('page');
		$data['users'] 	= $this->user->getUsers($request);
//		dd($data['users']);
		return view('roboplanner.user.index',$data);
	}


	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function create(){
		if(Gate::denies('add_user')){
			return view('roboplanner.errors.403');
		}

		$data = $this->user->create();

		return view('roboplanner.user.form', $data);
	}


	/**
	 * @param Request $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function save(Request $request, $id = 0){
		$this->user->save($request, $id);
		if($id == 0){
			return redirect()->route('users')->with('message','User Successfully Created!');
		}
		return redirect()->route('user_edit',$id)->with('message','User Successfully Updated!');
//		return redirect()->route('user_show');
	}


	/**
	 * @param $id
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function edit($id){
		if(Gate::allows('update_user') || Auth::user()->id == $id){
			$data = $this->user->edit($id);
			return view('roboplanner.user.form', $data);
		}else{
			return view('roboplanner.errors.403');
		}

	}


	/**
	 * @param Request $request
	 * @param $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update(Request $request, $id){
		$input = $request->except(['__token']);
		return $this->user->update($input, $id);
	}
	/**

	 * @param $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function destroy($id){
		if(Gate::denies('delete_user')){
			return view('roboplanner.errors.403');
		}

		$this->user->destroy($id);

		return redirect()->route('users')->with('message','User successfully deleted!');
	}

	/**
	 * @param Request $request
	 * @param $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function assign_role(Request $request, $id){
		$this->user->assign_role($request->role, $id);

		return redirect()->route('users')->with('message','User successfully assigned a role!');
	}

	public function show($id = 0){

		if($id == 0){
			$id 	= $this->auth->id;
		}

		$user			= $this->user->find($id);

		$data['user'] 	= $this->user->show($id);
		$metas			= $this->user->getMeta();
		$data['symbols'] = $this->setting->getSymbols();
		if($user->hasRole('client')){
			if($metas != null){
				$data['meta'] = $metas;
				$data['id'] = $user->id;
				return view('roboplanner.user.client-profile',$data);
			}

			return redirect()->route('user_edit',$id);
		}

		return redirect()->route('user_edit',$id);
	}

	public function client_template(Request $request){
		$data = $request->except("_token");
		return response(view("roboplanner.user.client-template.".$data['type'],$data)->render());
	}

	public function meta_update(Request $request, $id){
		$input = $request->except(['_token']);

		$data = $this->user_meta->update($input, $id);
		$keys	= [];
		$result	= [];
		if($data){
			foreach($input as $k => $v){
				$keys[] = $k;

				if(!is_array($v)){
					$result[]	= [
						'key' 	=> $k,
						'value'	=> $v
					];
				}else{
					$vaArr		= [];
					foreach($v as $j => $jv){
						$vaArr[$j]	= $jv;
					}
					$result[$k]	= $vaArr;
				}

			}

			//return redirect()->route('user_show', $id)->with('success','User Information Successfully Updated!');
		}


		return redirect()->route('user_show', $id)->with('message','User Information Successfully Updated!');
	}


}
