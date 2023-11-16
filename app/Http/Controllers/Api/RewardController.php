<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reward;
use Illuminate\Http\Request;

class RewardController extends BaseController
{
    public function index(Request $request)
    {
        $data = Reward::query();
        if ($request->filled('cat_name')) {
            $data->whereRelation('category', 'name', '=', $request->cat_name);
        }
        if ($request->filled('cat_id')) {
            $data->where('category_reward_id', '=', $request->cat_id);
        }
        $result = $data->with('category')->get();
        return response()->json(['message' => '', 'data' => $result]);
    }
}
