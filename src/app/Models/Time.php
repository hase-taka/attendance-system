<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Time extends Model
{
    protected $fillable = ['user_id', 'date','punchIn', 'punchOut','breakIn','breakOut','workTime','totalBreakTime'];

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


}
