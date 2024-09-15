<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    use HasFactory;

    protected $fillable = ['status', 'code', 'reward', 'info', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
