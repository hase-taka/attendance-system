<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Time;
use App\Models\User;

class AttendanceListController extends Controller
{
    public function index(Request $request){
        $date = $request->input('date',now()->format('Y-m-d'));
        $times = Time::whereDate('date',$date)->get();
        // $times = Time::with('user')->get();
        return view('attendance',compact('times','date'));
    }
    
}
