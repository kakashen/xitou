<?php

namespace App\Http\Controllers;

use App\Area;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AreaController extends Controller
{
    public function store(Request $request, Area $area)
    {
        $ret = $area->insert($request->toArray());
        Log::info(json_encode($ret));
        return response()->json(['data' => 'ok']);
    }
}
