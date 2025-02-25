<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistrationPeriod extends Model
{
    use HasFactory;

    protected $primaryKey = 'sid';

    protected $guarded = [
        'sid'
    ];

    protected $casts = [
        'Esdate' => 'datetime',
        'Eedate' => 'datetime',
        'Ssdate' => 'datetime',
        'Sedate' => 'datetime'
    ];
}
