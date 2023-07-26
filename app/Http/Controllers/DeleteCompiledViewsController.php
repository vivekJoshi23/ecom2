<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Request;
use Commands\ViewClearCommand;
        
class DeleteCompiledViewsController extends Controller
{

    public function index()
    {
        return view('admin.dashboard');
    }

    public function deleteCompiledViews(Request $request)
    {
        // Call the `view:clear` Artisan command to delete compiled views.
        Artisan::call('view:clear');

        // Return a response (you can customize the response based on your requirements).
        return response()->json(['message' => 'Compiled views deleted successfully.']);
    }
}
