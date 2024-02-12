<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Time extends Model
{
    protected $fillable = ['user_id', 'date','punchIn', 'punchOut','breakIn','breakOut','stayTime','breakTime','workTime'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
