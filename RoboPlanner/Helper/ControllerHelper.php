<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 5/23/2016
 * Time: 10:17 AM
 */

namespace RoboPlanner\Helper;


Trait ControllerHelper
{
    public function passed($action, $id = 0){
        if($id == 0){
            return redirect()->route($action)->with('message', $this->message);
        }else{
            return redirect()->route($action,$id)->with('message', $this->message);
        }

    }

    public function failed($validator, $action = '', $id = 0){
        if($id == 0) {
            return redirect()->route($action)->withErrors($validator)->withInput();
        } else {
            return redirect()->route($action,$id)->withErrors($validator)->withInput();
        }

    }

}