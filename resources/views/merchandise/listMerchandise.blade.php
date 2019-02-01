@extends("layout.master")

@section("title",$title)

@section("content")
    <div class="container">
        <h1>{{$title}}</h1>
        <div><a href="/transaction">交易紀錄</a></div>
        @include('component.validationErrorMessage')

        <table>
            <th>名稱</th>
            <th>照片</th>
            <th>價格</th>
            <th>剩餘數量</th>
            @foreach($MerchandisePaginate as $Merchandise)
                <tr>
                    <td><a href="/merchandise/{{$Merchandise->id}}">{{$Merchandise->name}}</a></td>
                    <td><a href="/merchandise/{{$Merchandise->id}}"><img src="@if($Merchandise->photo != ''){{$Merchandise->photo}} @else {{'/assets/images/default-merchandise.png'}} @endif"></a></td>
                    <td>
                        @if($Merchandise->status =='C')
                            建立中
                        @else
                            可販售
                        @endif
                    </td>
                    <td>{{$Merchandise->price}}</td>
                    <td>{{$Merchandise->remain_count}}</td>
                </tr>
            @endforeach
        </table>
        {{--分頁頁數按鈕--}}
        {{$MerchandisePaginate->links()}}
    </div>


@endsection