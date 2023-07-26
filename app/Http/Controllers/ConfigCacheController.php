<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class ConfigCacheController extends Controller
{
    public function clearConfigCache(Request $request)
    {

        Artisan::call('config:clear');
        return response()->json(['message' => 'Config cache cleared successfully']);
    }
}
