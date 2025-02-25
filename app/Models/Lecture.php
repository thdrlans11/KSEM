<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lecture extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $primaryKey = 'sid';

    protected $guarded = [
        'sid'
    ];

    protected $dates = [
        'complete_at',
    ];      

    protected $casts = [
        'complete_at' => 'datetime',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function lectureAvg()
    {
        $optionAvg = Lecture::selectRaw("
        count(*) as totalCount,
        sum( case when lang='KOR' then 1 else 0 end ) as countryK,
        sum( case when lang='ENG' then 1 else 0 end ) as countryE,

        sum( case when payStatus in ('Y') then 1 else 0 end ) as payStatusY,
        sum( case when payStatus in ('N') then 1 else 0 end ) as payStatusN,
        sum( case when payStatus in ('F') then 1 else 0 end ) as payStatusF,

        sum( case when payMethod in ('C') then 1 else 0 end ) as payMethodC,
        sum( case when payMethod in ('B') then 1 else 0 end ) as payMethodB,
        sum( case when payMethod in ('F') then 1 else 0 end ) as payMethodF,

        sum( case when category in ('A') then 1 else 0 end ) as categoryA,
        sum( case when category in ('B') then 1 else 0 end ) as categoryB,

        sum( case when attendType in ('F') then 1 else 0 end ) as attendTypeF,
        sum( case when attendType in ('O') then 1 else 0 end ) as attendTypeO")->where('year', config('site.common.default.year'))->first();

        $data['optionAvg'] = $optionAvg;

        return $data;
    }
}
