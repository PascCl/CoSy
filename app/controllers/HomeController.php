<?php

class HomeController extends Controller
{
    public function index($name = '')
    {
        $user = $this->model('Home');
        $user->name = $name;
        
        $this->view('home/index', ['name' => $user->name]);
    }
    
    public function test()
    {
        echo "this is a test";
    }
}