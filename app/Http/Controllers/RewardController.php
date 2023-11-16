<?php

namespace App\Http\Controllers;

use App\Models\CategoryReward;
use App\Models\Reward;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RewardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Reward::all();
        return view('reward.list', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category_reward = CategoryReward::all();
        return view('reward.create', compact('category_reward'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'point' => 'required|integer',
            'image' => 'image|mimes:png,jpg,jpeg',
            'description' => 'required|max:100',
            'terms' => 'required|max:100',
            'howto' => 'required|max:100',
            'store' => 'required|max:100',
            'start_date_time' => 'required',
            'end_date_time' => 'required',
        ]);
        $image = $request->file('image');
        $imageName = time() . '.' . $image->extension();
        $image->move(public_path('reward'), $imageName);

        $data = [
            'name' => $request->name,
            'point' => $request->point,
            'start_date_time' => $request->start_date_time,
            'end_date_time' => $request->end_date_time,
            'description' => $request->description,
            'terms' => $request->terms,
            'howto' => $request->howto,
            'store' => $request->store,
            'image' => $imageName
        ];
        Reward::create($data);
        return redirect()->route('rewards.index')->with('success', 'Success Create Data');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Reward $reward)
    {
        $start_date_time = Carbon::createFromFormat('Y-m-d H:i:s', $reward->start_date_time)->startOfDay();
        $end_date_time = Carbon::createFromFormat('Y-m-d H:i:s', $reward->end_date_time)->startOfDay();
        return view('reward.edit', compact('reward', 'start_date_time', 'end_date_time'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reward $reward)
    {
        $fileName = '';
        if ($request->hasFile('image')) {
            $fileName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('reward'), $fileName);
            if ($reward->image) {
                if (file_exists(public_path('reward/' . $reward->image))) {
                    unlink(public_path('reward/' . $reward->image));
                }
            }
        } else {
            $fileName = $reward->image;
        }
        $data = [
            'name' => $request->name,
            'point' => $request->point,
            'start_date_time' => $request->start_date_time,
            'end_date_time' => $request->end_date_time,
            'description' => $request->description,
            'image' => $fileName
        ];
        $reward->update($data);
        return redirect()->route('rewards.index')->with('success', 'Success Update Data');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reward $reward)
    {
        if ($reward->image) {
            if (file_exists(public_path('reward/' . $reward->image))) {
                unlink(public_path('reward/' . $reward->image));
            }
        }

        $reward->delete();
        return redirect()->route('rewards.index')->with('success', 'Success Delete Data');
    }
}
