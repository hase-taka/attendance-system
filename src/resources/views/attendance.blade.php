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
            <!-- @foreach($ as $)
            <tr class="attendance__row">
                <td class="attendance__data">{{$->name}}</td>
                <td class="attendance__data">{{$->timein}}</td>
                <td class="attendance__data">{{$->timeout}}</td>
                <td class="attendance__data">{{$->breakTime}}</td>
                <td class="attendance__data">{{$->workTime}}</td>
            </tr>
            @endforeach -->
        </table>
    </div>
    <div class="page-nation">
        <!-- {{ $->links('')}} -->
    </div>
</div>
@endsection