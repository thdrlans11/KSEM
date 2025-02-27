<?php

namespace App\Http\Controllers\Scene;

use App\Http\Controllers\Controller;
use App\Services\Registration\RegistrationService;
use Illuminate\Http\Request;

class SceneController extends Controller
{
    private $RegistrationService;

    public function __construct()
    {
        $this->RegistrationService = new RegistrationService();

        view()->share([
            'mainNum' => '8'
        ]);
    }

    public function registration()
    {
        return $this->RegistrationService->sceneRegistration();
    }

    public function upsert(Request $request)
    {
        return $this->RegistrationService->fluidUpsert($request);
    }
}
