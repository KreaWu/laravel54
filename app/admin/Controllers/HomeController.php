<?php
namespace App\admin\Controllers;

class HomeController extends Controller
{
    public function index(){
        return view('admin/home/index');
    }

}