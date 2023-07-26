<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;

class LogController extends Controller
{
    public function clearLog()
    {
        // Run the log cleaning command using Symfony Process
        $process = new Process([PHP_BINARY, base_path('artisan'), 'logcleaner:run']);
        $process->run();

        // Log the output for debugging purposes
        Log::info($process->getOutput());

        if ($process->isSuccessful()) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'message' => 'Failed to clear log file. Please check the server logs.']);
        }
    }
}
