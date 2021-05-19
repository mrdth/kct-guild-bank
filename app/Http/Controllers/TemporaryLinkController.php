<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class TemporaryLinkController extends Controller
{
    public function __invoke(Request $request)
    {
        if ($request->bearerToken() !== config('app.api_token')) {
            abort(403);
        }

        return response()->json(['url' => URL::temporarySignedRoute('bank', now()->addMinutes(30))]);
    }
}
