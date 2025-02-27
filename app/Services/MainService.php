<?php

namespace App\Services;

use App\Models\Board;
use App\Models\LecturePeriod;
use App\Models\RegistrationPeriod;
use Illuminate\Http\Request;

/**
 * Class MainService
 * @package App\Services
 */
class MainService
{
    public function data()
    {
        $data['registrationPeriod'] = RegistrationPeriod::find('1');
        $data['lecturePeriod'] = LecturePeriod::find('1');

        return $data;
    }
}
