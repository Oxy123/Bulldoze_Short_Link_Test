<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function signin(Request $request){


        // Validate User Inputs
        $validator = Validator::make($request->all(),[
            "email" => "required|email",
            "password" => "required",
        ]);


        // If Validation Fail ! redirect user back with Errors to show them
        if($validator->fails()){
            return redirect()->back()->withErrors($validator);
        }

        // If Validation Success
        else {
            $validated = $validator->validated();


            try {
                // Try to Authenticate User and redirect him to home page
                if(Auth::attempt($validated)){

                    // if authentication success redirect user to home
                    return redirect("/")->with(["success" => "user connected successfully"]);
                }
                // if autentication fails => redirect the user back and show errors!
                else {
                    return redirect()
                        ->back()
                        ->with(["authError" => __("auth.failed")])
                        ->withInput();
                }
            } catch (\Exception $e){
                return redirect()
                    ->back()
                    ->with(["authError" => __("common.internalError")])
                    ->withInput();

            }
        }
    }


    public function signup(RegisterUserRequest $request){

        $validated = $request->validated();
        $userData = $request->safe()->except('password_confirmation');
        $userData["password"] = Hash::make($userData["password"]);

        try{
            $newUser = User::create($userData);
            auth()->login($newUser);
            return redirect('/');
        } catch (\Exception $e){
            return redirect()->back()->with(["create_user_fails" =>__("common.createUserFails")])->withInput();
        }
    }


    public function logout(){
        auth()->logout();
        return redirect("/");
    }
}
