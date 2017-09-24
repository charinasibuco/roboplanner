<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use RoboPlanner\Helper\ControllerHelper;
use RoboPlanner\Repositories\TaxRepository;
use Gate;
use Auth;


class TaxController extends Controller
{
    //
    use ControllerHelper;
    protected $tax;
    protected $auth;
    private $message;

    /**
     * TaxController constructor.
     * @param TaxRepository $tax
     */
    public function __construct(TaxRepository $tax)
    {
        $this->middleware('auth');

        $this->tax = $tax;
        $this->auth = Auth::user();
        $this->tax->setListener($this);
    }

    /**
     * Set Return message
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

        if(Gate::denies('view_taxes')){
            return view('roboplanner.errors.403');
        }

        $data['search']	        = trim($request->input('search'));
        $data['sort']           = ($request->input('sort') == 'asc')? 'desc' : 'asc';
        $data['page_number']    = $request->input('page');
        $data['taxes']          = $this->tax->getTaxes($request);
        return view('roboplanner.taxes.index',$data);
    }

    /**
     * Method to create Tax
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(){
        if(Gate::denies('create_tax')){
            return view('roboplanner.errors.403');
        }

        $data = $this->tax->create();
        $data['action'] = route('tax_store');
        $data['header'] = 'Add Tax';
        return view('roboplanner.taxes.form', $data);
    }

    /**
     * Method to save new tax
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request){
        return $this->tax->save($request);
    }

    /**
     * Method to edit tax
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id){
        if(Gate::denies('edit_tax')){
            return view('roboplanner.errors.403');
        }

        $data           = $this->tax->edit($id);
        $data['action'] = route('tax_update',$id);
        $data['header'] = 'Edit Tax';

        return view('roboplanner.taxes.form',$data);
    }

    public function update(Request $request, $id){
        return $this->tax->save($request,$id);
    }

    public function destroy($id)
    {
        if(Gate::denies('delete_tax')){
            return view('roboplanner.errors.403');
        }

        $result     = $this->tax->destroy($id);
//        if($result){
            return redirect()->route('taxes')->with('message', 'Successfully Deleted');
//        }
    }
}
