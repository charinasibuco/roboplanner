<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use RoboPlanner\Repositories\UserRepository;
use RoboPlanner\Repositories\SettingRepository;
use Auth;
use Gate;

class ClientController extends Controller
{
    protected $user;
    protected $auth;
    //
    public function __construct(UserRepository $user, SettingRepository $setting)
    {
        $this->middleware('auth');
        $this->auth = Auth::user();
        $this->user = $user;
        $this->setting = $setting;
    }

    public function index(Request $request){
        if(Gate::denies('view_clients')){
            return view('roboplanner.errors.403');
        }

        $data['search']	        = trim($request->input('search'));
        $data['sort']           = ($request->input('sort') == 'asc')? 'desc' : 'asc';
        $data['page_number']    = $request->input('page');
        $data['users']          = $this->user->getClients($request);
        return view('roboplanner.clients.index',$data);
    }

    public function profile($id){

        if(Gate::denies('view_client_profile')){
            return view('roboplanner.errors.403');
        }

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
                return view('roboplanner.user.client-profile',$data);
            }
            return view('roboplanner.user.show',$data);
        }
    }

    public function edit($id){
        if(Gate::denies('edit_client')){
            return view('roboplanner.errors.403');
        }
    }

    public function update(Request $request){

    }

    public function destroy($id){
        if(Gate::denies('delete_client')){
            return view('roboplanner.errors.403');
        }

        $this->user->destroy($id);

        return redirect()->route('clients')->with('message','Client successfully deleted!');
    }

    public function checkSymbols(Request $request){
        $symbol = $request->symbols;
        if($this->setting->findSymbol($symbol)){
            echo "true";
        }else{
            echo "false";
        }
    }
}
