<?php
namespace RoboPlanner\Repositories;
use RoboPlanner\Repositories\Repository;

class SettingRepository extends Repository{

    const LIMIT = 50;

    protected $listener;

    public function model()
    {
        // TODO: Implement model() method.
        return 'App\Setting';
    }
    public function findSymbol($value){
        return $this->model->where('name','=',$value)->first();
    }
    public function getSymbols()
    {
        $symbols = [];
        foreach($this->model->all() as $row){
            $symbols[] = $row->name;
        }
        return $symbols;
    }

    public function store(array $input)
    {
        $this->model()->create($input);
        return true;
    }
}