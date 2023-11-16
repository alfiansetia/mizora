<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index(Request $request)
    {
        $data = Setting::first();
        if (!$data) {
            $data = Setting::create([
                'email'     => 'mizora@mizora.id',
                'phone'     => '082333444555',
                'whatsapp'  => '082333444555',
                'address'   => 'Jl Mizora No.28 Bandung',
                'ig'        => 'mizora',
                'youtube'   => 'mizora',
            ]);
        }
        return response()->json(['message' => '', 'data' => $data]);
    }
}
