@extends("layout.master")

@section("title",$title)

@section("content")
    <div class="container">
        <h1>{{$title}}</h1>

        @include("component.validationErrorMessage")
        <table>
            <tr>
                <th>名稱</th>
                <td>{{ $Merchandise->name}}</td>
            </tr>
            <tr>
                <th>照片</th>
                <td><img src="@if($Merchandise->photo != ''){{$Merchandise->photo}} @else {{'/assets/images/default-merchandise.png'}} @endif"></td>
            </tr>
            <tr>
                <th>價格</th>
                <td>{{$Merchandise->price}}</td>
            </tr>
            <tr>
                <th>剩餘數量</th>
                <td>{{$Merchandise->remain_count}}</td>
            </tr>
            <tr>
                <th>介紹</th>
                <td>{{$Merchandise->introduction}}</td>
            </tr>
            <tr>
                <td colspan="2">
                    <form action="/merchandise/{{$Merchandise->id}}/buy" method="post">
                        <select name="buy_count">
                            @for($count =0; $count<=$Merchandise->remain_count;$count++)
                                <option value="{{$count}}">{{$count}}</option>
                            @endfor
                        </select>
                        <button type="submit">
                            購買
                        </button>
                        {{csrf_field()}}
                    </form>
                </td>
            </tr>
        </table>
    </div>
@endsection