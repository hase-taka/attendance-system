@extends('layouts.app-2')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css')}}">
@endsection

@section('content')
<div class="my-page__alert">
    @if(session('message'))
    <div class="my-page__alert--login">
        {{ session('message') }}
        <!-- return redirect('/')->with('message', 'さんお疲れさまです！') -->
    </div>
    @endif
</div>
<div class="punchin__form">
    <form class="timestamp" action="" method="post">
    @csrf
        <div class="punchin__btn">
            <button class="punchin__btn-submit" type="submit">勤務開始</button>
        </div>
    </form>
</div>
<div class="punchout__form">
    <form class="timestamp" action="" method="post">
    @csrf
        <div class="punchout__btn">
            <button class="punchout__btn-submit" type="submit">勤務終了</button>
        </div>
    </form>
</div>
<div class="breakin__form">
    <form class="timestamp" action="" method="post">
    @csrf
        <div class="breakin__btn">
            <button class="breakin__btn-submit" type="submit">休憩開始</button>
        </div>
    </form>
</div>
<div class="breakout__form">
    <form class="timestamp" action="" method="post">
    @csrf
        <div class="breakout__btn">
            <button class="breakout__btn-submit" type="submit">休憩終了</button>
        </div>
    </form>
</div>
@endsection