<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

// new inventory routes
Route::get('/inventory', function () {
    return view('inventory.dashboard');
});
Route::get('/pos', function () {
    return view('inventory.pos');
});

Route::prefix('products')->group(function () {

    Route::get('/create', function () {
        $category_products = DB::table('category_products')->get();
        return view('inventory.product.create', compact('category_products'));
    });
    Route::post('add', [App\Http\Controllers\Demo\Inventory::class, 'add'])->name('demo.eventory.add');
    Route::post('edit', [App\Http\Controllers\Demo\Inventory::class, 'edit'])->name('demo.eventory.edit');
    Route::get('/', [App\Http\Controllers\Demo\Inventory::class, 'index'])->name('demo.eventory');
    Route::get('get', [App\Http\Controllers\Demo\Inventory::class, 'get'])->name('demo.eventory.get');
    Route::get('get/edit/{id}', [App\Http\Controllers\Demo\Inventory::class, 'getEdit'])->name('demo.eventory.get.edit');
    Route::get('delete/{id}', [App\Http\Controllers\Demo\Inventory::class, 'deleted'])->name('demo.eventory.delete');
});
// Route::get('/products', function () {
//     return view('inventory.product.list');
// });
// Route::get('/products/create', function () {
//     return view('inventory.product.create');
// });


Route::get('/categories', function () {
    return view('inventory.category.index');
});
Route::get('/sales', function () {
    return view('inventory.sale.list');
});
Route::get('/sales/create', function () {
    return view('inventory.sale.create');
});
Route::get('/purchases', function () {
    return view('inventory.purchase.list');
});
Route::get('/purchases/create', function () {
    return view('inventory.purchase.create');
});
Route::get('/customers', function () {
    return view('inventory.people.customers');
});
Route::get('/suppliers', function () {
    return view('inventory.people.suppliers');
});
