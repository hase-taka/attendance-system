@extends('layouts.app-2')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css')}}">
@endsection
<script src="https://code.jquery.com/jquery.min.js"></script>
<script>
$(function() {
    $(".attendance-btn button").click(function() {
        $(this).toggleClass("click");
    });
});
</script>

@section('content')
<div class="my-page__alert">
    <div class="my-page__alert--login">
        <h2><?php $user = Auth::user(); ?>{{ $user->name }}さんお疲れさまです！</h2>
    </div>
</div>
<div class="attendance-btn">
    <div class="work-btn">
        <div class="punchin__form">
            <form class="timestamp" action="/punchin" method="post">
            @csrf
                <div class="punchin__btn">
                    <button class="punchin__btn-submit" type="submit" id="button1" onclick="disabled=true;submit()">勤務開始</button>
                </div>
            </form>
        </div>
        <div class="punchout__form">
            <form class="timestamp" action="/punchout" method="post">
            @csrf
                <div class="punchout__btn">
                    <button class="punchout__btn-submit" type="submit" onclick="getElementById('button1').disabled = false;">勤務終了</button>
                </div>
            </form>
        </div>
    </div>
    <div class="break-btn">
        <div class="breakin__form">
            <form class="timestamp" action="breakin" method="post">
            @csrf
                <div class="breakin__btn">
                    <button class="breakin__btn-submit" type="submit" id="button2" >休憩開始</button>
                </div>
            </form>
        </div>
        <div class="breakout__form">
            <form class="timestamp" action="breakout" method="post">
            @csrf
                <div class="breakout__btn">
                    <button class="breakout__btn-submit" type="submit" onclick="getElementById('button2').disabled = false;">休憩終了</button>
                </div>
            </form>
        </div>
    </div>
</div>
<p>{{session('error')}}</p>
<p>{{session('message')}}</p>
@endsection