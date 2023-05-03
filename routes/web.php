<?php

use App\Http\Controllers\applicationcontroller;
use App\Http\Controllers\admin\usercontroller;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
});
// Route::get('admin/dashboard',function (){
//     return view('dashboard');
// });
route::get('{view}',applicationcontroller::class)->where('view','(.*)');

// Route::get('/users',[usercontroller::class,'index']);