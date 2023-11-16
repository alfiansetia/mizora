<?php

namespace App\Http\Controllers\Demo;

use App\Http\Controllers\Controller;
use App\Models\CategoryProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Inventory extends Controller
{
    public function index()
    {
        $data = [
            'products' => DB::table('product')->get(),
        ];

        return view('inventory.product.list', $data);
    }


    public function add(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_product_id' => 'required',
            'terms' => 'required',
            'howto' => 'required',
            'store' => 'required',
            'description' => 'required',
            'img.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Sesuaikan ukuran file maksimal sesuai kebutuhan
            'price' => 'integer|min:1', // Sesuaikan aturan validasi sesuai kebutuhan
            'point' => 'integer|min:1',
            'url' => 'url',
        ]);

        $img = [];
        if (count($request->img) != 0) {
            foreach ($request->img as $file) {
                $fileName = time() . '_' . $file->getClientOriginalName();

                $file->move(public_path('uploads'), $fileName);
                array_push($img, $fileName);
            }
        }
        $data = [
            'name' => $request->title,
            'category_product_id' => $request->category_product_id,
            'price' => $request->price,
            'point' => $request->point,
            'url' => $request->url,
            'description' => $request->dec,
            'terms' => $request->terms,
            'howto' => $request->howto,
            'store' => $request->store,
            'img' => json_encode($img),
            'created_at' => now(),
            'updated_at' => now(),
        ];

        DB::table('product')->insert($data);
        session()->flash('success', 'Data berhasil disimpan.');

        return back();
    }
    public function edit(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'integer|min:1', // Sesuaikan aturan validasi sesuai kebutuhan
            'point' => 'integer|min:1',
            'url' => 'url',
        ]);
        // dd($request->all());
        $img = [];
        if ($request->img &&  count($request->img) != 0) {
            foreach ($request->img as $file) {
                $fileName = time() . '_' . $file->getClientOriginalName();

                $file->move(public_path('uploads'), $fileName);
                array_push($img, $fileName);
            }
        }
        $data = [
            'name' => $request->title,
            'price' => $request->price,
            'point' => $request->point,
            'url' => $request->url,
            'description' => $request->dec,
            'terms' => $request->terms,
            'howto' => $request->howto,
            'store' => $request->store,
            'img' =>   json_encode($img),
            'updated_at' => now(),
        ];

        if ($request->img &&  count($request->img) != 0) {
            $data['img'] = json_encode($img);
        }

        DB::table('product')->where('id', $request->id)->update($data);
        session()->flash('success', 'Data berhasil disimpan.');

        return back();
    }

    public function get(Request $request)
    {
        $id = $request->id;
        $res = DB::table('product')->where('id', $id)->first();
        return response()->json($res);
    }
    public function getEdit($id)
    {

        $id = decrypt($id);
        $data = DB::table('product')->where('id', $id)->first();
        $category_products = CategoryProduct::all();
        return view('inventory.product.edit', compact('data', 'category_products'));
    }
    public function deleted($id)
    {
        $id = decrypt($id);
        DB::table('product')->where('id', $id)->delete();
        session()->flash('success', 'Data berhasil disimpan.');
        return back();
    }
}
