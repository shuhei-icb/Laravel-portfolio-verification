<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use App\Services\Contracts\SampleServiceInterface;

class SampleController extends Controller
{
    function __construct(
        
    )
    {}

    public function sample(): Response
    {
        $message = "Hello World";
        return Inertia::render('SamplePage', [
            'message' => $message,
        ]);
    }
}
