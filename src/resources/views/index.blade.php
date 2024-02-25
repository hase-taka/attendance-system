@extends('layouts.app-2')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css')}}">
@endsection

@section('content')
<div class="my-page__alert">
    <div class="my-page__alert--login">
        <h2><?php $user = Auth::user(); ?>{{ $user->name }}さんお疲れさまです！</h2>
    </div>
</div>
<div class="attendance-btn">
    <div class="work-btn">
        <div class="punchin__form">
            <form class="timestamp" action="{{ route('punchIn') }}" method="post">
            @csrf
                <div class="punchin__btn">
                    <button class="punchin__btn-submit" type="submit" {{ $workStartButtonState ? 'disabled' : '' }}>勤務開始</button>
                </div>
            </form>
        </div>
        <div class="punchout__form">
            <form class="timestamp" action="{{ route('punchOut') }}" method="post">
            @csrf
                <div class="punchout__btn">
                    <button class="punchout__btn-submit" type="submit"   {{ $workEndButtonState ? 'disabled' : '' }}>勤務終了</button>
                </div>
            </form>
        </div>
    </div>
    <div class="break-btn">
        <div class="breakin__form">
            <form class="timestamp" action="breakin" method="post">
            @csrf
                <div class="breakin__btn">
                    <button class="breakin__btn-submit" type="submit"   {{ $breakStartButtonState ? 'disabled' : '' }}>休憩開始</button>
                </div>
            </form>
        </div>
        <div class="breakout__form">
            <form class="timestamp" action="breakout" method="post">
            @csrf
                <div class="breakout__btn">
                    <button class="breakout__btn-submit" type="submit" {{ $breakEndButtonState ? 'disabled' : '' }}>休憩終了</button>
                </div>
            </form>
        </div>
    </div>
    <p class="error_alert">{{session('error')}}</p>
    <p class="message_alert">{{session('message')}}</p>
</div>

@endsection