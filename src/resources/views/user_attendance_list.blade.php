@extends('layouts.app-2')

@section('css')
<link rel="stylesheet" href="{{ asset('css/user_attendance_list.css')}}">
@endsection

@section('content')
<div class="user_list__title">
    <p class="user_list__title-inner1">{{$user->name}}さん</p>
    <p class="user_list__title-inner2">勤怠表</p>
</div>
<div class="container">
    <div class="user-time__table">
        <table class="user-time__table-inner">
            <tr class="time__table-row">
                <th class="time__label">日  付</th>
                <th class="time__label">勤務開始</th>
                <th class="time__label">勤務終了</th>
                <th class="time__label">休憩時間</th>
                <th class="time__label">勤務時間</th>
            </tr>
            @foreach($times as $time)
            <tr class="user-time__table-row">
                <td class="time__data">{{$time->date}}</td>
                <td class="time__data">
                <?php $punchIn = new DateTime($time->punchIn);
                echo $punchIn->format('H:i:s');?>
                </td>
                <td class="time__data">
                <?php $punchOut = new DateTime($time->punchOut);
                echo $punchOut->format('H:i:s');?>
                </td>
                <td class="time__data">{{$time->totalBreakTime}}</td>
                <td class="time__data">{{$time->workTime}}</td>
            </tr>
            @endforeach
        </table>
    </div>
    <div class="pagination">
        {{ $times->links('pagination::default') }}
    </div>
</div>
@endsection