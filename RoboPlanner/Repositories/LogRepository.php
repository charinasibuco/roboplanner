<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 6/14/2016
 * Time: 11:36 AM
 */

namespace RoboPlanner\Repositories;

use RoboPlanner\Repositories\Repository;

class LogRepository extends Repository
{

    const LIMIT = 50;

    protected $listener;

    public function model()
    {
        // TODO: Implement model() method.
        return 'App\Log';
    }

    public function setListener($listener){
        $this->listener = $listener;
    }

    public function getLog($id){
       return $this->model->find($id);
    }
    public function getLogs($request = null, $id = 0, $limit = 0){

        $query      = $this->model;
        $order_by   = 'updated_at';
        $sort       = 'desc';

        $limit      = ($limit == 0) ? $limit : self::LIMIT;
//        dd($request->input('search'));
        if($request != null) {
            $order_by   = ($request->input('order_by')) ? $request->input('order_by') : $order_by;
            $sort       = ($request->input('sort'))? $request->input('sort') : $sort;

            if ($request->has('search')) {
                $query = $query->where('log', 'LIKE', '%'.$request->input('search') . '%');
//                dd($query->toSql());
//                $query->where(function ($user) use ($request) {
//                    $user->where('log', 'LIKE', '%'.$request->input('search') . '%');
//                });
//                $query->appends($request->input('search'))->links();
            }
        }



        if($id == 0){

            return $query->orderBy($order_by, $sort)->paginate($limit);
        }

        return $query->where('user_id', $id)->orderBy($order_by, $sort)->paginate($limit);
    }

    public function create(){

    }

    public function edit($id)
    {
        // TODO: Implement edit() method.
    }


    public function destroy($id){
        $this->model->find($id)->delete();
    }
}