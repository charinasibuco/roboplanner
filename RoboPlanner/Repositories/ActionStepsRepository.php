<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 6/14/2016
 * Time: 11:36 AM
 */

namespace RoboPlanner\Repositories;
use RoboPlanner\Repositories\UserScoresAndFlags as Flags;

class ActionStepsRepository extends Repository
{
    public function __construct(Flags $flags)
    {
        $this->flags = $flags;
    }

    protected $listener;
    public function model()
    {
        // TODO: Implement model() method.
        return 'App\Investment';
    }

    public function setListener($listener){
        $this->listener = $listener;
    }

    public function results($id = null){
        /**
         * Placeholders
         */
        $data = [];
        $data['flags'] = [];

        if($id != null){
            $this->flags->putUser($id);
        }

        if($this->flags->getRetirementFlags()){
            foreach($this->flags->getRetirementFlags() as $flag){
                $data['flags'][] = $flag;
            }
        }

        if($this->flags->getInvestmentFlags()){
            foreach($this->flags->getInvestmentFlags() as $flag){
                $data['flags'][] = $flag;
            }
        }

        if($this->flags->getLiquidityFlags()){
            foreach($this->flags->getLiquidityFlags() as $flag){
                $data['flags'][] = $flag;
            }
        }

        if($this->flags->getInsuranceFlags()){
            foreach($this->flags->getInsuranceFlags() as $flag){
                $data['flags'][] = $flag;
            }
        }

        if($this->flags->getLegacyFlags()){
            foreach($this->flags->getLegacyFlags() as $flag){
                $data['flags'][] = $flag;
            }
        }

        $data["colors"] = ["Red","Yellow"];
        $data["wealth_scores"] = ["Liquidity","Insurance","Legacy","Retirement","Investments","College"];
        return $data;
    }

    public function create(){

    }

    public function edit($id)
    {
        // TODO: Implement edit() method.
    }

    public function destroy($id){

    }
}