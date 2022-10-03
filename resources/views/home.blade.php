@extends("layouts.main")

@section('title',"Bulldozer Shortify")


@section('main')
    <div class="login-box" style="width: 70%">
        <h2>{{__("titles.pasteUrl")}}</h2>
        @if(session()->has("cannotCreateMore"))
            <div class="alert alert-danger" role="alert">
                {{session()->get('cannotCreateMore')}}
            </div>
        @endif
        @if(session()->has("internalError"))
            <div class="alert alert-danger" role="alert">
                {{session()->get('internalError')}}
            </div>
        @endif
        @if(session()->has("shortifySuccess"))
            <div class="alert alert-success" role="alert">
                {{session()->get('shortifySuccess')}}
            </div>
        @endif
        <form method="POST" action="{{ route("shortify") }}">
            @csrf
            <div class="mb-3 url-box">
                <div class="url-input pr-3">
                    <input type="text" class="form-control form-control-lg" name="url" placeholder="example.com">
                    @if($errors->has("url"))
                        <div>
                            {{$errors->first('url')}}
                        </div>
                    @endif
                </div>
                <button type="submit" class="btn btn-danger btn-lg">{{__("buttons.shortify")}}</button>
            </div>
        </form>

        <h2>{{__("titles.yourShorts")}}</h2>

        <div>
            <table class="table table-dark table-striped-columns">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">{{__("titles.OriginalLink")}}</th>
                        <th scope="col">{{__("titles.ShortLink")}}</th>
                        <th scope="col">{{__("titles.ExpireDate")}}</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if($shorts)
                        @foreach($shorts as $index => $short)
                            <tr>
                                <th scope="row">{{$index + 1}}</th>
                                <td>{{$short->original_link}}</td>
                                <td>{{url()->full() . "/" . $short->short_link}}</td>
                                <td>{{\Carbon\Carbon::make($short->created_at)->addDay()->format("d-m-Y h:i:s A")}}</td>
                                <td>
                                    <form action="{{ route("delete",['id' => $short->id]) }}" method="POST">
                                        @csrf
                                        @method("DELETE")
                                        <button type="submit" class="btn btn-danger btn-sm">{{__("buttons.delete")}}</button>
                                    </form>
                                </td>
                            </tr>

                        @endforeach

                        @else
                        <p>Nothing to show</p>
                    @endif
                </tbody>

            </table>
        </div>

    </div>
@endsection
