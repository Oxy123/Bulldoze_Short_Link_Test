<?php

namespace App\Http\Controllers;

use App\Models\Short;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ShortifyController extends Controller
{



    public function redirectToUrl($short_key){

        $short = Short::where('short_link',"=",$short_key)->first();

        if(isset($short)){
            return redirect($short->original_link);
        } else {
            return view("shortLinkNotFound");
        }
    }
    public function shortify(Request $request){

        // get the authenticated user
        $user = auth()->user();

        // validate the user Inputs
        $validator = Validator::make($request->all(),[
            "url" => "required|url"
        ]);


        //redirect back withErrors if the user input doesn't meet the validation rules
        if($validator->fails()){
            return redirect()->back()->withErrors($validator);
        } else {


            //check if the user can create More short links ( 5 as mentioned in the test )
            if($user->cannot('createMore',$user)){
                return redirect()->back()->with(["cannotCreateMore" => __('common.cantCreateMore')]);
            }
            // Generate a random short_key & check if is already in use
            do {
                $short_key = Str::random(6);
                // check if generated short_key is already in use
                $check = Short::where("short_link","=",$short_key)->first();
            } while( $check != null);




            // new record to save
            $data = [
                "user_id" => $user->id,
                "original_link" => $request->url,
                "short_link" => $short_key,
            ];

            $allShortLinks = Short::all()->count();


            // delete short links if there is more than 20 in database
            if ($allShortLinks > 19){
                $ancientShort = Short::orderBy("created_at","ASC")->limit($allShortLinks - 19);
                $ancientShort->delete();
            }

            try{
                $newShort = Short::create($data);
                return redirect()->back()->with(["shortifySuccess" => __("common.shortifySuccess")]);
            } catch (\Exception $e){
                return redirect()->back()->with(["authError" => __("common.internalError")]);
            }


        }
    }


    public function delete($id){

        try {
            Short::destroy($id);
            return redirect()->back();
        } catch (\Exception $e){
            return redirect()->back()->with(["internalError" => __("common.internalError")]);
        }
    }
}
