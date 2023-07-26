<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class RoutingCacheController extends Controller
{
    public function clearRoutingCache(Request $request)
    {
        if ($request->ajax()) {
            // Call the `route:clear` Artisan command to clear the routing cache.
            Artisan::call('route:clear');

            return response()->json(['message' => 'Routing cache cleared successfully.']);
        }

        // If it's a regular request (non-AJAX), redirect back with a success message.
        return back()->with('success', 'Routing cache cleared successfully.');
    }
}
