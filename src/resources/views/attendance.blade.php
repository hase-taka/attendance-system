@extends('layouts.app-2')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance.css')}}">
@endsection

@section('content')
<div class="attendance-date">
    <a class="arrow-left" href="{{ route('attendance', ['date' => \Carbon\Carbon::parse($date)->subDay()->toDateString()]) }}"></a><p class="attendance-date__date">{{$date}}</p><a class="arrow-right" href="{{ route('attendance', ['date' => \Carbon\Carbon::parse($date)->addDay()->toDateString()]) }}"></a>
</div>
<div class="container">
    <div class="attendance__table">
        <table class="attendance__table-inner">
            <tr class="attendance__row">
                <th class="attendance__label">名 前</th>
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
                <td class="attendance__data">{{$time->totalBreakTime}}</td>
                <td class="attendance__data">{{$time->workTime}}</td>
            </tr>
            @endforeach
        </table>
    </div>
    <div class="pagination">
        {{ $times->links('pagination::default') }}
    </div>
</div>
@endsection