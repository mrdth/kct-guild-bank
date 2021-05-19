<?php

namespace App\Http\Controllers;

use App\InventoryImporter;
use Illuminate\Http\Request;

class InventoryImportController extends Controller
{
    // TODO

    public function store(Request $request)
    {
        if ($request->bearerToken() !== config('app.api_token')) {
            abort(403);
        }

        $inventory = json_decode(base64_decode($request->input('EncodedImportString')));
        InventoryImporter::import($inventory);

        return response()->noContent();
    }
}
