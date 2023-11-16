<?php

namespace App\Http\Controllers;

use App\Models\CategoryMessage;
use App\Models\Membership;
use App\Models\Message;
use DateTime;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $counter = 1;
            $group = Message::with(['category'])->orderBy('id', 'desc')->get();

            return DataTables::of($group)
                ->addIndexColumn()
                ->addColumn('no', function () use (&$counter) {
                    return $counter++;
                })
                ->addColumn('category', function ($row) {
                    return $row->category->name;
                })
                ->addColumn('image', function ($row) {
                    return "<img src='" . asset($row->image) . "' width='100' height='100' /> ";
                })
                ->addColumn('description', function ($row) {
                    return '<div class="line-clamp-2 nowrap" style="width: 300px;">' . $row->description . '</div>';
                })
                ->addColumn('url', function ($row) {
                    return '<div class="line-clamp-2 nowrap" style="width: 300px;">' . $row->url_cta . '</div>';
                })
                ->addColumn('label', function ($row) {
                    return $row->label_cta;
                })
                ->addColumn('datetime', function ($row) {
                    return Carbon::parse($row->created_at)->format('Y-m-d H:i:s');
                })
                ->addColumn('action', function ($row) {
                    $btn = "
                    <a onclick='runFunction(event,`open_edit`,`$row->id`)' href='javascript:void(0)'><i class='ik ik-edit f-16 mr-15 text-green'></i></a>
                    <a onclick='runFunction(event,`open_delete`,`$row->id`)' href='javascript:void(0)'><i class='ik ik-trash-2 f-16 text-red'></i></a>
                    ";
                    return $btn;
                })
                ->rawColumns(['image', 'description', 'url', 'action'])
                ->make(true);
        }
        return view('pages.message');
    }

    public function getOption()
    {
        $thisCategory = CategoryMessage::get();

        foreach ($thisCategory as $category) {
            $array[] = $category->name;
        }

        return response()->json([
            'data' => true,
            'array' => $array
        ], 200);
    }

    public function create(Request $request)
    {
        // VALIDATE IMAGE
        // required|image|mimes:jpg,jpeg,png|max:5120
        //required|date|date_format:Y-m-d\TH:i

        $rules = [
            'category' => 'required|string',
            'title' => 'required|string',
            'description' => 'required|string',
            'url' => 'required|string',
            'label' => 'required|string',
            'datetime' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $category = $request->category;

        $dateTime = new DateTime($request->expiry);
        $cnvDateTime = $dateTime->format('Y-m-d H:i:s');

        $categoryID = CategoryMessage::where('name', $category)->first();
        $thisID = $categoryID->id;

        $files = $request->file('image');

        if ($files) {
            foreach ($files as $file) {
                if ($file && $file->isValid()) {
                    $mime = $file->getClientMimeType();

                    $allowedMimes = ['image/jpeg', 'image/jpg', 'image/png'];

                    if (in_array($mime, $allowedMimes)) {
                        $thisFilename = str_replace(" ", "_", $file->getClientOriginalName());
                        $fileName = time() . '_' . $thisFilename;

                        $publicDirectory = public_path('img/notifications/' . strtolower($category));

                        $file->move($publicDirectory, $fileName);

                        $filePath = 'img/notifications/' . strtolower($category) . '/' . $fileName;
                    } else {
                        $errorArray = [
                            "Invalid file format. Only JPG/JPEG and PNG images are allowed."
                        ];
                        $errorResponse = [
                            "image" => $errorArray
                        ];

                        return response()->json(['errors' => $errorResponse], 422);
                    }
                }
            }
        }

        Message::create([
            'category_message_id' => $thisID,
            'title' => $request->title,
            'image' => $filePath,
            'description' => $request->description,
            'url_cta' => $request->url,
            'label_cta' => $request->label,
            'datetime' => $cnvDateTime,
        ]);

        return response()->json([
            'data' => true,
            'notif' => '[CREATE] message success!'
        ], 200);
    }

    public function edit(Request $request)
    {

        $parameter = $request->parameter;
        if ($parameter == "get") {
            $thisData = Message::with(['category'])->where('id', $request->value)->first();

            $array['category'] = $thisData->category->name;
            $array['title'] = $thisData->title;
            $array['description'] = $thisData->description;
            $array['url'] = $thisData->url_cta;
            $array['label'] = $thisData->label_cta;
            $array['datetime'] = Carbon::parse($thisData->datetime)->format('Y-m-d H:i:s');

            return response()->json([
                'data' => true,
                'array' => $array
            ], 200);
        } else if ($parameter == "save") {
            $rules = [
                'category' => 'required|string',
                'title' => 'required|string',
                'description' => 'required|string',
                'url' => 'required|string',
                'label' => 'required|string',
                'datetime' => 'required',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $category = $request->category;

            $dateTime = new DateTime($request->expiry);
            $cnvDateTime = $dateTime->format('Y-m-d H:i:s');

            $categoryID = CategoryMessage::where('name', $category)->first();
            $thisID = $categoryID->id;

            $files = $request->file('image');

            if ($files) {
                foreach ($files as $file) {
                    if ($file && $file->isValid()) {
                        $mime = $file->getClientMimeType();

                        $allowedMimes = ['image/jpeg', 'image/jpg', 'image/png'];

                        if (in_array($mime, $allowedMimes)) {
                            $thisFilename = str_replace(" ", "_", $file->getClientOriginalName());
                            $fileName = time() . '_' . $thisFilename;

                            $publicDirectory = public_path('img/notifications/' . strtolower($category));

                            $checkImage = Message::where('id', $request->value)->first();
                            $imageDB = public_path($checkImage->image);

                            if ($imageDB) {
                                unlink($imageDB);
                            }

                            $file->move($publicDirectory, $fileName);

                            $filePath = 'img/notifications/' . strtolower($category) . '/' . $fileName;

                            Message::where('id', $request->value)->update([
                                'image' => $filePath
                            ]);
                        } else {
                            $errorArray = [
                                "Invalid file format. Only JPG/JPEG and PNG images are allowed."
                            ];
                            $errorResponse = [
                                "image" => $errorArray
                            ];

                            return response()->json(['errors' => $errorResponse], 422);
                        }
                    }
                }
            }

            $thisData = Message::where('id', $request->value)->update([
                'category_message_id' => $thisID,
                'title' => $request->title,
                'description' => $request->description,
                'url_cta' => $request->url,
                'label_cta' => $request->label,
                'datetime' => $cnvDateTime,
            ]);

            return response()->json([
                'data' => true,
                'notif' => '[EDIT] message success!'
            ], 200);
        }
    }

    public function delete(Request $request)
    {
        $parameter = $request->parameter;
        if ($parameter == "get") {
            $thisData = Message::with(['category'])->where('id', $request->value)->first();

            $array['category'] = $thisData->category->name;
            $array['title'] = $thisData->title;
            $array['description'] = $thisData->description;
            $array['url'] = $thisData->url_cta;
            $array['label'] = $thisData->label_cta;
            $array['datetime'] = Carbon::parse($thisData->datetime)->format('Y-m-d H:i:s');

            return response()->json([
                'data' => true,
                'array' => $array
            ], 200);
        } else if ($parameter == "confirm") {
            $checkImage = Message::where('id', $request->value)->first();
            $imageDB = public_path($checkImage->image);

            if ($imageDB) {
                unlink($imageDB);
                $checkImage->delete();
            }

            return response()->json([
                'data' => true,
                'notif' => '[DELETE] message success!'
            ], 200);
        }
    }
}
