<?php

namespace App\Http\Controllers;

use App\Area;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AreaController extends Controller
{
    private $area;
    public function __construct(Area $area)
    {
        $this->area = $area;
    }
    public function store(Request $request)
    {
        $ret = $this->area->insert($request->toArray());
        Log::info(json_encode($ret));
        return response()->json(['data' => 'ok']);
    }

    public function list()
    {
        $data = $this->area->get();
        return response()->json(['data' => $data]);
    }
}
