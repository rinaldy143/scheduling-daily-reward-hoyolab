<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cookies extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'cookie', 'status'];

    // Relasi ke model User jika diperlukan
    public function user()
    {
        return $this->belongsTo(User::class);
    }}
