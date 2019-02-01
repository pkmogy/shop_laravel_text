<!--繼承母模板-->
@extends('layout.master')
<!--傳送資料到母模板,並指定變數title-->
@section('title',$title)
<!---傳送資料到母模板，並指定變數content-->
@section('content')
    <div class="container">
        <h1>{{$title}}</h1>

        @include('component.socialButtons')
        @include('component.validationErrorMessage')
        <form action="/user/auth/sign-in" method="post">
            {!! csrf_field() !!}
            <label>
                Email:<input type="text" name="email" placeholder="Email" value="{{old('email')}}">
            </label>
            <label>
                密碼:<input type="password" name="password" placeholder="密碼" value="{{old('password')}}">
            </label>
            <button type="submit">登入</button>
        </form>
        <a href="/user/auth/facebook-sign-in"><button type="button">FB登入</button></a>
    </div>
@endsection