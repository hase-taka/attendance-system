<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Time;
use Carbon\Carbon;

class AutoPunchOut extends Command
{

    protected $signature = 'auto:punch-out';
    protected $description = 'Auto punch out for users with ongoing shift';

    public function handle()
    {
        $now = Carbon::now();

        $times = Time::whereNull('punchOut')
            ->whereDate('punchIn', '<', $now->toDateString())
            ->get();

        foreach ($times as $time) {
            $time->update(['punchOut' => $time->punchIn->endOfDay()]);

            // 勤務開始日の翌日分の勤務開始打刻を実施
            Time::create([
                'user_id' => $time->user_id,
                'punchIn' => $time->punchIn->addDay(),
            ]);
        }

        $this->info('Auto Punch Out executed successfully.');
    
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */


    /**
     * The console command description.
     *
     * @var string
     */


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */

}
