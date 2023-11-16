<?php

namespace App\Http\Controllers;

use App\Models\Membership;

use DateTime;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class LevelMembershipController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $counter = 1;
            $group = Membership::orderBy('id', 'desc')->get();
            return DataTables::of($group)
                ->addIndexColumn()
                ->addColumn('no', function () use (&$counter) {
                    return $counter++;
                })
                ->addColumn('action', function ($row) {
                    $btn = "
                    <a onclick='runFunction(event,`open_edit`,`$row->id`)' href='javascript:void(0)'><i class='ik ik-edit f-16 mr-15 text-green'></i></a>
                    <a onclick='runFunction(event,`open_delete`,`$row->id`)' href='javascript:void(0)'><i class='ik ik-trash-2 f-16 text-red'></i></a>
                    ";
                    return $btn;
                })
                ->addColumn('created_at', function ($row) {
                    return Carbon::parse($row->created_at)->format('Y-m-d H:i:s');
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('pages.membership');
    }

    public function create(Request $request)
    {
        // dd($request->all());
        $rules = [
            'level' => 'required|string',
            'point' => 'required|integer',
            'expiry' => 'required|date|date_format:Y-m-d\TH:i',
            'description' => 'required|string',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $dateTime = new DateTime($request->expiry);
        $cnvDateTime = $dateTime->format('Y-m-d H:i:s');

        Membership::create([
            'level' => $request->level,
            'point' => $request->point,
            'expiry' => $cnvDateTime,
            'description' => $request->description,
        ]);

        return response()->json([
            'data' => true,
            'notif' => '[CREATE] level membership success!'
        ], 200);
    }

    public function edit(Request $request)
    {
        $parameter = $request->parameter;
        if ($parameter == "get") {
            $thisData = Membership::where('id', $request->value)->first();

            $array['level'] = $thisData->level;
            $array['point'] = $thisData->point;
            $array['expiry'] = $thisData->expiry;
            $array['description'] = $thisData->description;

            return response()->json([
                'data' => true,
                'array' => $array
            ], 200);
        } else if ($parameter == "save") {
            $rules = [
                'level' => 'required|string',
                'point' => 'required|integer',
                'expiry' => 'required|date|date_format:Y-m-d\TH:i',
                'description' => 'required|string',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $dateTime = new DateTime($request->expiry);
            $cnvDateTime = $dateTime->format('Y-m-d H:i:s');

            $thisData = Membership::where('id', $request->value)->update([
                'level' => $request->level,
                'point' => $request->point,
                'expiry' => $cnvDateTime,
                'description' => $request->description,
            ]);

            return response()->json([
                'data' => true,
                'notif' => '[EDIT] level membership success!'
            ], 200);
        }
    }

    public function delete(Request $request)
    {
        $parameter = $request->parameter;
        if ($parameter == "get") {
            $thisData = Membership::where('id', $request->value)->first();

            $array['level'] = $thisData->level;
            $array['point'] = $thisData->point;
            $array['expiry'] = $thisData->expiry;
            $array['description'] = $thisData->description;

            return response()->json([
                'data' => true,
                'array' => $array
            ], 200);
        } else if ($parameter == "confirm") {
            Membership::where('id', $request->value)->delete();

            return response()->json([
                'data' => true,
                'notif' => '[DELETE] level membership success!'
            ], 200);
        }
    }
}
