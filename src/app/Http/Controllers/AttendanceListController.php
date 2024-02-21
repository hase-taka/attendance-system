<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Time;
use App\Models\User;

class AttendanceListController extends Controller
{
    public function index(Request $request){
        $date = $request->date ?? now()->toDateString(); // リクエストから日付を取得

    // 指定された日付のデータを取得
    $times = Time::whereDate('date', $date)->paginate(5);
        return view('attendance',compact('times','date'));
    }

    public function users_list(Request $request){
        // ユーザを全件取得　5人ずつ表示
        $users = User::paginate(5);
        return view('users_list',compact('users'));
    }

    public function user_attendance_list(User $user){
        // 利用者一覧のaタグで$userをパラメータで送ってもらう
        $times = Time::where(['user_id'=>$user->id])->paginate(10);
        return view('user_attendance_list',compact('times','user'));
    }
}
