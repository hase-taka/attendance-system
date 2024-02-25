<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Time;
use App\Models\User;
use App\Models\BreakTime;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;


class TimestampController extends Controller
{
    public function create(){
       
        return view('index');
    }


    public function punchIn(Request $request){

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
            return redirect()->back()->with('error','出勤打刻済みです');
        }

        // 退勤後に再度出勤を押せない制御
        if($oldtimein) {
            $oldTimePunchOut = new Carbon($oldtimein->punchOut);
            $oldDay = $oldTimePunchOut->startOfDay();//最後に登録したpunchInの時刻を00:00:00で代入
        }

        // if(($oldDay == $today)) {
        //     return redirect()->back()->with('error','退勤打刻済みです');
        // }

        $time = Time::create([
            'user_id' => $user->id,
            'punchIn' => Carbon::now(),
            'date' => Carbon::parse()->format('Y-m-d'),
        ]);
        session(['workStarted' => true]);
        return redirect()->back()->withInput(['timeId' => $time->id])->with('message','出勤打刻が完了しました');
    }


    public function punchOut(Request $request){

        $user = auth()->user();
        $timeId = $user->times()->latest()->first()->id;
        $timestamp = Time::where('user_id', $user->id)->latest()->first();
        $breakTimes = BreakTime::where(['time_id'=>$timeId])->get();

        // BreakTimetableから休憩時間合計を取得
        $totalBreakTimeInt = 0;
        foreach($breakTimes as $breakTime){
            $breakTimeIn = $breakTime->breakIn;
            $breakTimeOut = $breakTime->breakOut;
            $breakInStr = strtotime($breakTimeIn);
            $breakOutStr = strtotime($breakTimeOut);
            $breakTimeInt = ($breakOutStr - $breakInStr);
            $totalBreakTimeInt += $breakTimeInt;
        }

        // 勤務時間取得のため各時間の取得
        $now = new Carbon();
        $punchIn = new Carbon($timestamp->punchIn);
        // $breakIn = new Carbon($timestamp->breakIn);
        // $breakOut = new Carbon($timestamp->breakOut);
        // 勤務時間の差分の計算
        $punchOuttime = strtotime($now);
        $punchIntime = strtotime($punchIn);
        $stayTimeInt = $punchOuttime - $punchIntime;

        $workTimeInt = ($stayTimeInt - $totalBreakTimeInt);
        $workTime = gmdate('H:i:s',$workTimeInt);
        $totalBreakTime = gmdate('H:i',$totalBreakTimeInt);

        // 既に退勤済み、出勤していない時のerror
        if( !empty($timestamp->punchOut)||empty($timestamp->punchIn)) {
            return redirect()->back()->with('error', '既に退勤の打刻がされているか、出勤打刻されていません');
        }
        // 退勤が12時を過ぎた場合、出勤当日の11:59分の打刻
        $oldpunchIn = new Carbon($timestamp->punchIn);
        $punchInDay = $oldpunchIn->format('Y-m-d');
        $punchOut = Carbon::now();
        $punchOutDay = $punchOut->format('Y-m-d');

        // $punchOutEndOfDay = $oldpunchIn->endOfDay();

        if($punchInDay == $punchOutDay){
        $timestamp->update([
            'punchOut' => Carbon::now(),
            'totalBreakTime' => $totalBreakTime,
            'workTime' => $workTime,
        ]);
        session(['workStarted' => false]);
        return redirect()->back()->with('message', '退勤打刻が完了しました');
        }

        // if($punchInDay != $punchOutDay){
        //     $timestamp->update([
        //         'punchOut' => $punchOutEndOfDay,
        //         'totalBreakTime' => $totalBreakTime,
        //         'workTime' => $workTime,
        //     ]);
        //     session(['workStarted' => false]);
        // return redirect()->back()->with('message', '日付を跨いだため出勤日最終時刻で退勤打刻しました');
        // }
    }


    public function breakIn(Request $request){
        
        $user = Auth::user();
        $oldTime = Time::where('user_id',$user->id)->latest()->first();
        $timeId = $user->times()->latest()->first()->id;
        
        $oldBreakTime = BreakTime::where('time_id',$timeId)->latest()->first();

        $time = Time::findOrFail($timeId);

        if (!$oldTime->punchIn || !$timeId) {
            return redirect()->back()->with('error','出勤の打刻がされていません');}
        if ($oldTime->punchIn && $oldTime->punchOut) {
            return redirect()->back()->with('error','出勤の打刻がされていないか退勤済みです');}
        if (($oldBreakTime->breakIn ??"")&& !$oldBreakTime->breakOut) {
            return redirect()->back()->with('error','前の休憩終了打刻がされていません');}

        if($oldTime->punchIn && !$oldTime->punchOut && (!isset($oldBreakTime->breakIn) || (isset($oldBreakTime->breakIn) && isset($oldBreakTime->breakOut)))){
        $breakTime = new BreakTime([
            'breakIn' => Carbon::parse()->format('H:i:s'),
        ]);

        $time->breakTimes()->save($breakTime);
        session(['breakEnd' => true]);
        return redirect()->back()->with('message','休憩開始打刻が完了しました');}
    }

    public function breakOut(Request $request){

        $userId = auth()->user()->id;

        // 認証済みユーザーの最新のTimeレコードのIDを取得
        $timeId = Time::where('user_id', $userId)->latest()->value('id');

        // 認証済みユーザーの最新のTimeレコードを取得
        $time = Time::where('user_id', $userId)->latest()->first();
        $breakTime = BreakTime::where('time_id',$timeId)->latest()->first();

        // 休憩開始打刻せずに、休憩終了打刻操作時のerror
        if ($breakTime->breakIn && $breakTime->breakOut) {
            return redirect()->back()->with('error','休憩開始が打刻されていません');
        }

        // 新しいBreakTimeレコードを作成
        if($time->punchIn && !$time->punchOut && $breakTime->breakIn){

        $breakIn = new Carbon($breakTime->breakIn);
        $breakOut = Carbon::parse()->format('H:i:s');
        $breakIntime = strtotime($breakIn);
        $breakOuttime = strtotime($breakOut);
        $breakTimeint = ($breakOuttime - $breakIntime);
        $breakTimeTotal = gmdate('H:i',$breakTimeint);

        $breakTime -> update([
            'breakOut' => $breakOut, // 休憩終了時刻を現在の時刻として保存
        ]);

        // Timeモデルとのリレーションを利用してBreakTimeを関連付ける
        $time->breakTimes()->save($breakTime);
        session(['breakEnd' => false]);
        return redirect()->back()->with('message','休憩終了打刻が完了しました');}
    }


}
