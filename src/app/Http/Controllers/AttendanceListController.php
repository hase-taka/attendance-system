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
    $times = Time::whereDate('date', $date)
                 ->paginate(5);
        // $date = now()->toDateString();
        // // $request->input('date',now()->format('Y-m-d'));
        // $times = Time::whereDate('date',$date)->paginate(5);
        // // $times = Time::with('user')->get();
        return view('attendance',compact('times','date'));
    }
    
}
