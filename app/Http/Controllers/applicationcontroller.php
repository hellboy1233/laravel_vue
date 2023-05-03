<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class applicationcontroller extends Controller
{
    public function __invoke(){
        return view('admin.layouts.app');
    }
}
