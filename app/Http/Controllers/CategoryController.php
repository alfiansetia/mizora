<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\CategoryProduct;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //
    public function index(Request $request)
    {
        $sort = $request->input('sort', 'asc'); // Default to ascending order if not specified
        $categories = CategoryProduct::orderBy('name', $sort)->get();

        return view('inventory.category.index', compact('categories'));
    }



    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Example validation for image upload
        ]);

        $data['image'] = $request->file('image')->store(
            'categoryproduct',
            'public'
        );
        $categories = CategoryProduct::create($data);

        $categories->save();

        return redirect()->route('inventory.category.index', compact('data', 'categories'));
    }
    // public function edit(CategoryProduct $category) {
    //     return view('inventory.category.edit', compact('category'));
    // }

    public function update(Request $request, CategoryProduct $category)
    {
        // Validate the request data
        $data = $request->validate([
            'name' => 'required|string',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Delete the old image file (if exists)
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }

            // Upload and store the new image
            $data['image'] = $request->file('image')->store('categoryproduct', 'public');
        } else {
            // If no new image is provided, keep the existing image
            $data['image'] = $category->image;
        }

        // Update the category title and image
        $category->name = $data['name'];
        $category->image = $data['image'];
        $category->save();

        // Redirect to the category index page with a success message
        return redirect()->route('inventory.category.index', compact('data', 'category'));
    }
    public function destroy(CategoryProduct $category)
    {
        // Delete the category
        $category->delete();

        // Redirect to the index view or any other desired action
        return redirect()->route('inventory.category.index')->with('success', 'Category deleted successfully.');
    }
}
