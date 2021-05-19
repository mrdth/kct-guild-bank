<?php

namespace App\Http\Controllers;

use App\Models\Character;
use Illuminate\Http\Request;

class BankController extends Controller
{
    public function __invoke(Request $request)
    {
        if (! $request->hasValidSignature()) {
            return view('expired');
        }

        $characters = Character::with('inventory')->get();

        return view('bank', compact('characters'));
    }
}
