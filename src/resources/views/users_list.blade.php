@extends('layouts.app-2')

@section('css')
<link rel="stylesheet" href="{{ asset('css/users_list.css')}}">
@endsection

@section('content')
<div class="user_list__title">
    <p class="user_list__title-inner">利用者一覧</p>
</div>
<div class="container">
    <div class="user__table">
        <table class="user__table-inner">
            <tr class="user__table-row">
                <th class="user__label">名前</th>
                <th class="user__label">メールアドレス</th>
                <th class="user__label"></th>
            </tr>
            @foreach($users as $user)
            <tr class="user__table-row">
                <td class="user__data-name">{{$user->name}}</td>
                <td class="user__data-email">{{$user->email}}</td>
                <td class="user__data">
                    <a href="{{ route('user_attendance_list', ['user' => $user->id]) }}">利用者勤怠表</a>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
    <div class="pagination">
        {{ $users->links('pagination::default') }}
    </div>
</div>
@endsection