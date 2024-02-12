<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Time;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class TimestampController extends Controller
{
    public function create(){
        return view('index');
    }


    public function punchIn(Request $request){
        
        // $user = Auth::user();

        // /**
        //  * 打刻は1日一回までにしたい 
        //  * DB
        //  */
        // $oldTimestamp = Time::where('user_id', $user->id)->latest()->first();
        // if ($oldTimestamp) {
        //     $oldTimestampPunchIn = new Carbon($oldTimestamp->punchIn);
        //     $oldTimestampDay = $oldTimestampPunchIn->startOfDay();
        // } else {
        //     $timestamp = Time::create([
        //         'user_id' => $user->id,
        //         'punchIn' => Carbon::now(),
        //     ]);

        //     return redirect()->back()->with('my_status', '出勤打刻が完了しました');

        // }
        
        // $newTimestampDay = Carbon::today();

        // /**
        //  * 日付を比較する。同日付の出勤打刻で、かつ直前のTimestampの退勤打刻がされていない場合エラーを吐き出す。
        //  */
        // if (($oldTimestampDay == $newTimestampDay) && (empty($oldTimestamp->punchOut))){
        //     return redirect()->back()->with('error', 'すでに出勤打刻がされています');
        // }

        // $timestamp = Time::create([
        //     'user_id' => $user->id,
        //     'punchIn' => Carbon::now(),
        // ]);

        // return redirect()->back()->with('my_status', '出勤打刻が完了しました');

         // **必要なルール**
        // ・同じ日に2回出勤が押せない(もし打刻されていたらhomeに戻る設定)
// **必要なルール**
        // ・同じ日に2回出勤が押せない(もし打刻されていたらhomeに戻る設定)
        


        $user = Auth::user();
        $oldtimein = Time::where('user_id',$user->id)->latest()->first();//一番最新のレコードを取得
        
        $oldDay = '';

        //退勤前に出勤を2度押せない制御
        if($oldtimein) {
            $oldTimePunchIn = new Carbon($oldtimein->punchIn);
            $oldDay = $oldTimePunchIn->startOfDay();//最後に登録したpunchInの時刻を00:00:00で代入
        }
        $today = Carbon::today();//当日の日時を00:00:00で代入

        if(($oldDay == $today) && (empty($oldtimein->punchOut))) {
            return redirect()->back()->with('message','出勤打刻済みです');
        }

        // 退勤後に再度出勤を押せない制御
        if($oldtimein) {
            $oldTimePunchOut = new Carbon($oldtimein->punchOut);
            $oldDay = $oldTimePunchOut->startOfDay();//最後に登録したpunchInの時刻を00:00:00で代入
        }

        if(($oldDay == $today)) {
            return redirect()->back()->with('message','退勤打刻済みです');
        }

        $time = Time::create([
            'user_id' => $user->id,
            'punchIn' => Carbon::now(),
            // parse()->format('H:i:s'),
            'date' => Carbon::parse()->format('Y-m-d'),
        ]);
        return redirect()->back();
    }
    

    


    public function punchOut(){
        $user = Auth::user();
        $timestamp = Time::where('user_id', $user->id)->latest()->first();

        if( !empty($timestamp->punchOut)||empty($timestamp->punchIn)) {
            return redirect()->back()->with('error', '既に退勤の打刻がされているか、出勤打刻されていません');
        }

        // 各時間の取得
        $now = new Carbon();
        $punchIn = new Carbon($timestamp->punchIn);
        $breakIn = new Carbon($timestamp->breakIn);
        $breakOut = new Carbon($timestamp->breakOut);
        // 勤務時間の差分の計算
        $punchOuttime = strtotime($now);
        
        $punchIntime = strtotime($punchIn);
        $stayTime = $punchOuttime - $punchIntime;
        // 休憩時間の差分の計算
        $breakIntime = strtotime($breakIn);
        $breakOuttime = strtotime($breakOut);
        $breakTimeint = ($breakOuttime - $breakIntime);
        
        $workTimeint = ($stayTime - $breakTimeint);

        $breakTime = gmdate('H:i',$breakTimeint);
        $workTime = gmdate('H:i',$workTimeint);

        // 退勤が12時を過ぎた場合、出勤当日の11:59分の打刻
        $oldpunchIn = new Carbon($timestamp->punchIn);
        $punchInDay = $oldpunchIn->format('Y-m-d');
        $punchOut = Carbon::now();
        $punchOutDay = $punchOut->format('Y-m-d');

        $punchOutEndOfDay = $oldpunchIn->endOfDay();

        if($punchInDay == $punchOutDay){
        $timestamp->update([
            'punchOut' => Carbon::now(),
            // parse()->format('H:i:s'),
            'breakTime' => $breakTime,
            'workTime' => $workTime,
        ]);
    }

        if($punchInDay != $punchOutDay){
            $timestamp->update([
                'punchOut' => $punchOutEndOfDay,
                // parse()->format('H:i:s'),
                'breakTime' => $breakTime,
                'workTime' => $workTime,
            ]);
        }
        // dd($timestamp);
        

        return redirect()->back()->with('message', '退勤打刻が完了しました');
    
    }


    public function breakIn(){
        $user = Auth::user();
        $oldtimein = Time::where('user_id',$user->id)->latest()->first();

        if($oldtimein->punchIn && !$oldtimein->punchOut && !$oldtimein->breakIn){
            $oldtimein->update([
                'breakIn' => Carbon::parse()->format('H:i:s'),
            ]);
            return redirect()->back();
        }
        return redirect()->back();
    }


    public function breakOut(){
        $user = Auth::user();
        $oldtimein = Time::where('user_id',$user->id)->latest()->first();

        if($oldtimein->breakIn && !$oldtimein->breakOut) {
            $oldtimein->update([
                'breakOut' => Carbon::now(),
            ]);
            return redirect()->back();
        }
        else{return redirect()->back()->with('error','失敗です');
    }}
// ->format('H:i:s')
    public function admin(){
        $items = [];
        return view('attendance',['items'=>$items]);
    }

    public function result(Request $request){
        $items = [];
        return view('attendance',['items'=>$items]);
    }
}
