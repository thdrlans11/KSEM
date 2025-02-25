<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LecturePeriod extends Model
{
    use HasFactory;

    protected $primaryKey = 'sid';

    protected $guarded = [
        'sid'
    ];

    protected $casts = [
        'sdate' => 'datetime',
        'edate' => 'datetime',
    ];
}
