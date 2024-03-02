@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css')}}">
@endsection

@section('content')
<div class="login-form">
    <h2 class="login-form__head-title">ログイン</h2>
    <div class="login-form__inner">
        <form class="login-form__form" action="/login" method="post">
        @csrf
            <div class="login-form__group">
                <input class="login-form__input" type="mail" name="email" id="email" placeholder="メールアドレス" >
                <div class="login-form__error-message">
                    <!-- @error('email')
                    {{ $message }}
                    @enderror -->
                    @if ($errors->has('email'))
                  <span class="invalid-feedback" role="alert">
                    {{ $errors->first('email') }}
                  </span>
                @endif
                </div>
            </div>
            <div class="login-form__group">
                <input class="login-form__input" type="password" name="password" id="password" placeholder="パスワード">
                <div class="login-form__error-message">
                    <!-- @error('password')
                    {{ $message }}
                    @enderror -->
                    @if ($errors->has('error'))
                  <span class="invalid-feedback" role="alert">
                    {{ $errors->first('error') }}
                  </span>
                @endif
                </div>
            </div>
            <input class="login-form__btn" type="submit" value="ログイン">
        </form>
        <div class="register-transition__form">
            <p class="register-nav">アカウントをお持ちでない方はこちらから</p>
            <a class="register-transition__btn" href="/register">会員登録</a>
        </div>
    </div>
</div>
@endsection