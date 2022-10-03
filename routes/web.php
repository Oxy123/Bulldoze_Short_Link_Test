<?php

use App\Http\Controllers\ShortifyController;
use App\Http\Controllers\UserController;
use App\Models\Short;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


//Route::get("/test",function (){
//    $expired = Short::where('created_at', '<', now()->subHours(24))->get();
//    dd($expired);
//});
Route::get('/', function () {

    $user = auth()->user();
    $shorts = $user->shorts;
    return view('home',["shorts" => $shorts]);
})->middleware("auth")->name("home");


Route::get('/{short_key}',[ShortifyController::class,"RedirectToUrl"])->name("redirectToUrl");

Route::get('/change_language/{lang}',function ($lang){
    \Illuminate\Support\Facades\App::setLocale("fr");
    Session::put('locale', $lang);
    return redirect()->back();
})->name("changeLanguage");




Route::prefix("user")->group(function (){
    Route::view('/login','user.login')->name('login')->middleware('guest');
    Route::view('/register','user.register')->name('register')->middleware('guest');
    Route::get('/logout',[UserController::class,"logout"])->name("logout")->middleware("auth");
    Route::post('/signin',[UserController::class, "signin"])->name("signIn");
    Route::post('/signup',[UserController::class,"signup"])->name("signUp");
});

Route::middleware("auth")->prefix("shortify")->group(function(){
    Route::post("/create",[ShortifyController::class,"shortify"])->name("shortify");
    Route::delete("/delete/{id}",[ShortifyController::class,"delete"])->name("delete");
});
