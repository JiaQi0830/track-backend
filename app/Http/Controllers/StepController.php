<?php

namespace App\Http\Controllers;

use App\Models\Step;
use Laravel\Lumen\Routing\Controller as BaseController;

class StepController extends BaseController
{
    public function getStep()
    {
        $step = Step::all();

        return response(['data' => $step, 'message' => 'Retrieve successfully!', 'status' => true]);
    }

}
