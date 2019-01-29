@extends('layout.master')

@section('title',$title)

@section('content')

    <div class="container">
        <h1>{{$title}}</h1>
        @include('component.validationErrorMessage')
        <div><a href="/merchandise/create">新增商品</a></div>
        <table class="table">
            <tr>
                <th>編號</th>
                <th>名稱</th>
                <th>圖片</th>
                <th>狀態</th>
                <th>價格</th>
                <th>剩餘數量</th>
                <th>編輯</th>
            </tr>
            @foreach($MerchandisePaginate as $Merchandise)
                <tr>
                    <td>{{$Merchandise->id}}</td>
                    <td>{{$Merchandise->name}}</td>
                    <td><img src="@if($Merchandise->photo != ''){{$Merchandise->photo}} @else {{'/assets/images/default-merchandise.png'}} @endif"></td>
                    <td>
                        @if($Merchandise->status =='C')
                            建立中
                        @else
                            可販售
                        @endif
                    </td>
                    <td>{{$Merchandise->price}}</td>
                    <td>{{$Merchandise->remain_count}}</td>
                    <td>
                        <a href="/merchandise/{{$Merchandise->id}}/edit">編輯</a>
                    </td>
                </tr>
            @endforeach
        </table>
        {{--分頁頁數按鈕--}}
        {{$MerchandisePaginate->links()}}
    </div>


@endsection