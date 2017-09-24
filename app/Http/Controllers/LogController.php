<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use RoboPlanner\Repositories\LogRepository;
use RoboPlanner\Repositories\UserRepository;

class LogController extends Controller
{
    //
    protected $log;
    protected $auth;
    protected $request;
    protected $user;
    private $message;



    public function __construct(LogRepository $log, UserRepository $user, Request $request)
    {
        $this->middleware('auth');
        $this->log      = $log;
        $this->user     = $user;
        $this->request  = $request;
        $this->log->setListener($this);
    }

    public function index(){
        $data['search']	= trim($this->request->input('search'));
        $data['sort']   = ($this->request->input('sort') == 'asc')? 'desc' : 'asc';
        $data['page_number']= $this->request->input('page');
        $data['logs']   = $this->log->getLogs($this->request);
//        dd($data['logs']);

        return view('roboplanner.logs.logs', $data);
    }

    public function getUserLog($id){
        $data['user']           = $this->user->find($id);
        $data['search']	        = trim($this->request->input('search'));
        $data['sort']           = ($this->request->input('sort') == 'asc')? 'desc' : 'asc';
        $data['page_number']    = $this->request->input('page');
        $data['logs']           = $this->log->getLogs($this->request, $id);
//        return view('roboplanner.errors.403');
        return view('roboplanner.logs.user', $data);
    }

    public function delete($id){
        $this->log->destroy($id);
        return redirect()->route('logs')->with('message','Log Successfully Deleted!');
    }

    public function deleteFromUser($id){
        $user_id = $this->log->getLog($id)->user_id;
        $this->log->destroy($id);
        return redirect()->route('user_logs',$user_id)->with('message','Log Successfully Deleted!');
    }

    public function deleteAll($id){

    }

    public function clearLog($id = 0){

    }
}
