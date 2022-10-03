
@extends("layouts.main")

@section('title',"Login")

@section("main")
    <div class="login-box">
        <h2>{{__("titles.login")}}</h2>


        @if(session()->has("authError"))
            <div class="alert alert-danger" role="alert">
                {{session()->get('authError')}}
            </div>
        @endif
        <form action={{route("signIn")}} method="POST">
            @csrf
            <div class="form-floating mb-3">
                <input type="email" name="email" class="form-control" id="userEmail" required placeholder="example@example.com" value="{{old("email")}}">
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
            <button type="submit" class="btn btn-outline-light">{{__("buttons.login")}}</button>

        </form>
    </div>
@endsection
