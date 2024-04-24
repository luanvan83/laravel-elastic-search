<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Log;

class ApiController extends Controller
{
    //
    public function logEntry($data = [])
    {
        Log::info(
            sprintf(
                'Entry %s::%s',
                static::class, debug_backtrace()[1]['function']
            ),
            $data
        );
    }

    public function logExit($data = [])
    {
        Log::info(
            sprintf(
                'Exit %s::%s',
                static::class, debug_backtrace()[1]['function']
            ),
            $data
        );
    }
}
