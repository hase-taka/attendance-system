<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Time extends Model
{
    protected $fillable = ['user_id', 'date','punchIn', 'punchOut','breakIn','breakOut','workTime','totalBreakTime','workStartButtonState','workEndButtonState','breakStartButtonState','breakEndButtonState'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function breakTimes()
    {
        return $this->hasMany(BreakTime::class);
    }

    public function totalBreakTime()
    {
        return $this->breakTimes()->sum('breakOut - breakIn');
    }

    public function workTime()
    {
        $totalBreakTime = $this->totalBreakTime();
        $punchIn = strtotime($this->punchIn);
        $punchOut = strtotime($this->punchOut);

        return max(0, $punchOut - $punchIn - $totalBreakTime);
    }

    // 勤務終了打刻メソッド
    public function punchOut()
    {
        // $this->update(['punchOut' => now()]);

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
        $breakIn = new Carbon($timestamp->breakIn);
        $breakOut = new Carbon($timestamp->breakOut);
        // 勤務時間の差分の計算
        $punchOuttime = strtotime($now);
        $punchIntime = strtotime($punchIn);
        $stayTimeInt = $punchOuttime - $punchIntime;

        $workTimeInt = ($stayTimeInt - $totalBreakTimeInt);
        $workTime = gmdate('H:i:s',$workTimeInt);
        $totalBreakTime = gmdate('H:i',$totalBreakTimeInt);

        $this->update([
            'punchOut' => Carbon::now(),
            'totalBreakTime' => $totalBreakTime,
            'workTime' => $workTime,
        ]);
        session(['workStarted' => false]);
    }

}
