<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mentee extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'industry',
        'profession',
        'experience',
        'available',
        'time_available',
        'mentor',
    ];
}
