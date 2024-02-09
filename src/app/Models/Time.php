<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Time extends Model
{
    protected $fillable = ['user_id', 'punchIn', 'punchOut','breakIn','breakOut','stayTime','breakTime','workTime'];

    public function user()
    {
        $this->belongsTo(User::class);
    }
}
