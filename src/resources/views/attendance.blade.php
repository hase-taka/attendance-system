@extends('layouts.app-2')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance.css')}}">
@endsection

@section('content')
<div class="attendance-date__form">
    <form class="attendance-date__form-inner" action="">
    @csrf
        <input type="date">
    </form>
</div>
<div class="container">
    <div class="attendance">
        <table class="attendance__table">
            <tr class="attendance__row">
                <th class="attendance__label">名前</th>
                <th class="attendance__label">勤務開始</th>
                <th class="attendance__label">勤務終了</th>
                <th class="attendance__label">休憩時間</th>
                <th class="attendance__label">勤務時間</th>
            </tr>
            @foreach($items as $item)
            <tr class="attendance__row">
                <td class="attendance__data">{{$item->name}}</td>
                <td class="attendance__data">{{$item->punchIn}}</td>
                <td class="attendance__data">{{$item->punchOut}}</td>
                <td class="attendance__data">{{$item->breakTime}}</td>
                <td class="attendance__data">{{$item->workTime}}</td>
            </tr>
            @endforeach
        </table>
    </div>
    <div class="page-nation">
        
    </div>
</div>
@endsection