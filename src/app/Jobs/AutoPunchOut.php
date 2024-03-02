<?php

namespace App\Jobs;

use App\Models\Time;
use App\Models\BreakTime;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AutoPunchOut implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // $now = Carbon::now();
        // $yesterday = Carbon::now()->subDay()->format('Y-m-d');
        $today = Carbon::now()->format('Y-m-d');

        $times = Time::where('date', $today)->get();
        // ↑$yesterday <-> $today
        foreach($times as $time){
        if ($time->punchIn && !$time->punchOut) {

            $timeId = $time->id;
            $toDayPunchIn = $time->punchIn;
            $breakTimes = BreakTime::where(['time_id'=>$timeId])->get();

            $totalBreakTimeInt = 0;
        foreach($breakTimes as $breakTime){
            $breakTimeIn = $breakTime->breakIn;
            $breakTimeOut = $breakTime->breakOut;
            $breakInStr = strtotime($breakTimeIn);
            $breakOutStr = strtotime($breakTimeOut);
            $breakTimeInt = ($breakOutStr - $breakInStr);
            $totalBreakTimeInt += $breakTimeInt;
        }

            $lastPunchOut = $now->endOfDay();
            $punchIn = new Carbon($toDayPunchIn);

            $punchOuttime = strtotime($lastPunchOut);
            $punchIntime = strtotime($punchIn);
            $stayTimeInt = $punchOuttime - $punchIntime;

            $workTimeInt = ($stayTimeInt - $totalBreakTimeInt);
            $workTime = gmdate('H:i:s',$workTimeInt);
            $totalBreakTime = gmdate('H:i',$totalBreakTimeInt);

            $time->update([
                'punchOut' => Carbon::now()->subDay()->endOfDay(),
                'totalBreakTime' => $totalBreakTime,
                'workTime' => $workTime,
                'workStartButtonState' => false,
                'workEndButtonState' => true,
                'breakStartButtonState' => true,
                'breakEndButtonState' => true
            ]); // 勤務終了打刻

            // 勤務開始日の翌日の勤務開始打刻
            $nextDayPunchIn = Carbon::now()->addDay()->startOfDay();
            // Carbon::now()->addDay()->startOFDay()
            $newPunchIn = Time::create([
                'user_id' => $time->user_id,
                'punchIn' => $nextDayPunchIn,
                'date' => $nextDayPunchIn->format('Y-m-d'),
                'workStartButtonState' => true,
                'workEndButtonState' => false,
                'breakStartButtonState' => false,
            ]);
        }}
    }

}
// 'timeId' => $time->id