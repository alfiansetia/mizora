<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends BaseController
{
    public function index()
    {
        $data = Location::where('status', 1)->get();
        return response()->json(['message' => '', 'data' => $data]);
    }
}
