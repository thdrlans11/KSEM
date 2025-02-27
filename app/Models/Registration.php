<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Registration extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $primaryKey = 'sid';

    protected $guarded = [
        'sid'
    ];

    protected $dates = [
        'complete_at',
        'payComplete_at'
    ];      

    protected $casts = [
        'complete_at' => 'datetime',
        'payComplete_at' => 'datetime',
    ];

    public function registrationAvg($type)
    {
        $optionAvg = Registration::selectRaw("
        count(*) as totalCount,
        sum( case when status='Y' then 1 else 0 end ) as statusY,
        sum( case when status='N' then 1 else 0 end ) as statusN,

        sum( case when payStatus in ('Y') and status='Y' then 1 else 0 end ) as payStatusY,
        sum( case when payStatus in ('N') and status='Y' then 1 else 0 end ) as payStatusN,
        sum( case when payStatus in ('F') and status='Y' then 1 else 0 end ) as payStatusF,

        sum( case when payMethod in ('C') and status='Y' then 1 else 0 end ) as payMethodC,
        sum( case when payMethod in ('B') and status='Y' then 1 else 0 end ) as payMethodB,
        sum( case when payMethod in ('F') and status='Y' then 1 else 0 end ) as payMethodF,
        sum( case when payMethod in ('S') and status='Y' then 1 else 0 end ) as payMethodS,

        sum( case when category in ('A') and status='Y' then 1 else 0 end ) as categoryA,
        sum( case when category in ('B') and status='Y' then 1 else 0 end ) as categoryB,
        sum( case when category in ('C') and status='Y' then 1 else 0 end ) as categoryC,
        sum( case when category in ('D') and status='Y' then 1 else 0 end ) as categoryD,
        sum( case when category in ('E') and status='Y' then 1 else 0 end ) as categoryE,
        sum( case when category in ('F') and status='Y' then 1 else 0 end ) as categoryF,
        sum( case when category in ('G') and status='Y' then 1 else 0 end ) as categoryG,
        sum( case when category in ('H') and status='Y' then 1 else 0 end ) as categoryH,
        sum( case when category in ('I') and status='Y' then 1 else 0 end ) as categoryI,
        sum( case when category in ('Z') and status='Y' then 1 else 0 end ) as categoryZ,

        sum( case when attendType in ('A') and status='Y' then 1 else 0 end ) as attendTypeA,
        sum( case when attendType in ('B') and status='Y' then 1 else 0 end ) as attendTypeB,
        sum( case when attendType in ('C') and status='Y' then 1 else 0 end ) as attendTypeC")->where('type', $type)->first();

        $data['optionAvg'] = $optionAvg;

        return $data;
    }
}
