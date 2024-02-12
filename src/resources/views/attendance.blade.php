@extends('layouts.app-2')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance.css')}}">
@endsection

@section('content')
<div class="attendance-date">
    <a href="/data?date={{ \Carbon\Carbon::parse($date)->subDay()->format('Y-m-d') }}">&lt;</a><p>{{$date}}</p><a href="/data?date={{ \Carbon\Carbon::parse($date)->addDay()->format('Y-m-d') }}">&gt;</a>
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
            @foreach($times as $time)
            <tr class="attendance__row">
                <td class="attendance__data">{{$time->user->name}}</td>
                <td class="attendance__data">
                <?php $punchIn = new DateTime($time->punchIn);
                echo $punchIn->format('H:i:s');?>
                </td>
                <td class="attendance__data">
                <?php $punchOut = new DateTime($time->punchOut);
                echo $punchOut->format('H:i:s');?>
                </td>
                <td class="attendance__data">{{$time->breakTime}}</td>
                <td class="attendance__data">{{$time->workTime}}</td>
            </tr>
            @endforeach
        </table>
    </div>
    <div class="page-nation">
        
    </div>
</div>
@endsection