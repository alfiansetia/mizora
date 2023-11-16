<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas = Page::all();
        return view('pages.page.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.page.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'image' => 'required|image|mimes:png,jpg,jpeg',
        ], [
            'title.required' => 'Nama Kategori Wajib Diisi!',
            'description.required' => 'Description Wajib Diisi!',
            'image.required' => 'Gambar Kategori Wajib Diupload!'
        ]);

        $data = $request->all();
        $data = request()->except(['_method', '_token']);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();

            // Move the uploaded file to a specified directory
            $image->move(public_path('pages'), $imageName);

            $data['image'] = $imageName;
        }

        // dd($data);

        Page::create($data);
        return redirect()->route('page.index')->with('success', 'Data berhasil disimpan');
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
    public function edit($id)
    {
        $page = Page::find($id);
        return view('pages.page.edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $page = Page::find($id);
        $imageName = '';
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('pages'), $imageName);
            $data['image'] = $imageName;
            if ($page->image) {
                if (file_exists(public_path('pages/' . $page->image))) {
                    unlink(public_path('pages/' . $page->image));
                }
            }
        } else {
            $imageName = $page->image;
        }
        $page->update($data);
        return redirect()->route('page.index')->with('success', 'Data berhasil di update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $page = Page::find($id);
        if ($page->image) {
            if (file_exists(public_path('pages/' . $page->image))) {
                unlink(public_path('pages/' . $page->image));
            }
        }

        $page->delete();

        return redirect()->route('page.index')->with('success', 'Data berhasil dihapus');
    }
}
