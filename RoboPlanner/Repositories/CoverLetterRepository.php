<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 6/14/2016
 * Time: 11:36 AM
 */

namespace RoboPlanner\Repositories;

class CoverLetterRepository extends Repository
{
    //const LIMIT = 50;

    protected $listener;

    public function model()
    {
        // TODO: Implement model() method.
        return 'App\Log';
    }

    public function setListener($listener){
        $this->listener = $listener;
    }

    public function results($request){
        $data = [];
        $scores = [];

        $score_names = ["Liquidity", "Insurance","Legacy","Retirement","Investments","College"];

        foreach($score_names as $row){
            $score = new \stdClass();
            $score->name = $row;
            $score->why_did_i_get_this_score = ["Lorem Ipsum is simply dummy text of the printing and typesetting industry.","Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book."];
            $score->what_can_i_do_to_improve = ["It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.","t was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum."];
            $score->result = 50;

            $flag =  new \stdClass();
            $flag->color = "red";
            $flag->description = "Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old.";
            $score->flags[] = $flag;

            $flag =  new \stdClass();
            $flag->color = "yellow";
            $flag->description = "There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable.";
            $score->flags[] = $flag;

            $scores[] = $score;
        }

        $data["scores"] = $scores;

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