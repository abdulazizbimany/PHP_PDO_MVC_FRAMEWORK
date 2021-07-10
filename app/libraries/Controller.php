<?php

//load the model and view
class Controller
{
    public function model($model)
    {
        //require model file
        require_once '../app/models/' . $model . '.php';
        //instantiate model
        return new $model();
    }

    public function view($view, $data = array())
    {
        //check for the view file
        if (file_exists('../app/views/' . $view . '.php')) {
            require_once '../app/views/' . $view . '.php';
        } else {
            die("View does not exist");
        }
    }
}