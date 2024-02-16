<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BreakTime extends Model
{
    protected $fillable = [
        'time_id','breakIn','breakOut','breakTime'
    ];

    public function time()
    {
        return $this->belongsTo(Time::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
