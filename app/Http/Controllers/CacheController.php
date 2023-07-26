<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;


class CacheController extends Controller
{
    public function clearCache(Request $request)
    {
        if ($request->ajax()) {
            // Call the `cache:clear` Artisan command to clear the cache.
            Artisan::call('cache:clear');

            return response()->json(['message' => 'Cache cleared successfully.']);
        }

        // If it's a regular request (non-AJAX), redirect back with a success message.
        return back()->with('success', 'Cache cleared successfully.');
    }
}
