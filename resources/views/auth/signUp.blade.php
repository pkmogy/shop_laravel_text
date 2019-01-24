<!--繼承母模板-->
@extends('layout.master')
<!--傳送資料到母模板,並指定變數title-->
@section('title',$title)
<!---傳送資料到母模板，並指定變數title-->
@section('content')
<h1>{{$title}}</h1>

@include('component.socialButtons')

Email:<input type="text" name="email" placeholder="Email">

密碼:<input type="password" name="password" placeholder="密碼">

暱稱:<input type="text" name="nickname" placeholder="暱稱">
@endsection