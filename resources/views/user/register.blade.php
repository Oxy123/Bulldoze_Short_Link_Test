
@extends("layouts.main")

@section('title',"Login")

@section("main")
    <div class="login-box">
        <h2>{{__("titles.register")}}</h2>

        @if(session()->has("create_user_fails"))
            <div class="alert alert-danger" role="alert">
                {{session()->get('create_user_fails')}}
            </div>

        @endif

        <form action={{route("signUp")}} method="POST">
            @csrf
            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="name" id="username" placeholder="{{__("common.name")}}" value="{{old("name")}}">
                <label for="username">{{__("common.name")}}</label>
                @if($errors->has("name"))
                    <div>
                        {{$errors->first('name')}}
                    </div>
                @endif
            </div>
            <div class="form-floating mb-3">
                <input type="email" name="email" class="form-control" id="userEmail" placeholder="example@example.com" value="{{old("email")}}">
                <label for="userEmail">{{__("common.email")}}</label>
                @if($errors->has("email"))
                    <div>
                        {{$errors->first('email')}}
                    </div>
                @endif
            </div>

            <div class="form-floating mb-3">
                <input type="password" name="password" class="form-control" id="Password" placeholder="{{__("common.password")}}">
                <label for="Password">{{__("common.password")}}</label>
                @if($errors->has("password"))
                    <div>
                        {{$errors->first('password')}}
                    </div>
                @endif
            </div>
            <div class="form-floating mb-5">
                <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="{{__("common.confirmpassword")}}">
                <label for="password_confirmation">{{__("common.confirmpassword")}}</label>
                @if($errors->has("password_confirmation"))
                    <div>
                        {{$errors->first('password_confirmation')}}
                    </div>
                @endif
            </div>
            <button type="submit" class="btn btn-outline-light">{{__("buttons.login")}}</button>

        </form>
    </div>
@endsection
