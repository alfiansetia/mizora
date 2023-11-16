@extends('inventory.layout')
@section('title', 'Add Product')
@section('content')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-headphones bg-blue"></i>
                        <div class="d-inline">
                            <h5>Add Product</h5>
                            <span>Add new product in inventory</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/dashboard"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">Add Product</a>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-body">
                        <form class="forms-sample" method="POST" action="{{ route('demo.eventory.add') }}"
                            enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row">
                                <div class="col-sm-6">

                                    <div class="form-group">
                                        <label for="title">Title<span class="text-red">*</span></label>
                                        <input id="title" type="text" class="form-control" name="title"
                                            value="{{ old('title') }}" placeholder="Enter product title" required="">
                                        @error('title')
                                            <div class="help-block with-errors">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="category_product_id">Category<span class="text-red">*</span></label>
                                        <select class="form-control" name="category_product_id">
                                            <option disabled selected>--Select Category--</option>
                                            @foreach ($category_products as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('category_product_id')
                                            <div class="help-block with-errors">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="price">Price<span class="text-red">*</span></label>
                                        <input id="price" type="number" class="form-control" name="price"
                                            value="{{ old('price') }}" placeholder="Enter product price" required="">
                                        @error('Price')
                                            <div class="help-block with-errors">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="purchase_price">Point<span class="text-red">*</span></label>
                                        <input id="purchase_price" type="number" class="form-control" name="point"
                                            value="{{ old('point') }}" placeholder="Enter product price" required="">
                                        @error('point')
                                            <div class="help-block with-errors">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="offer_price">Url</label>
                                        <input id="offer_price" type="text" class="form-control" name="url"
                                            value="{{ old('url') }}" placeholder="Enter offer price" required="">
                                        @error('url')
                                            <div class="help-block with-errors">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Product Images</label>
                                        <div class="input-images" data-input-name="img"
                                            data-label="Drag & Drop product images here or click to browse"></div>
                                        @if ($errors->has('img'))
                                            @foreach ($errors->get('img') as $error)
                                                <div class="help-block with-errors">{{ $error }}</div>
                                            @endforeach
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea class="form-control html-editor h-205" rows="10" name="dec">{{ old('dec') }}</textarea>
                                    </div>

                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>T & C</label>
                                        <textarea class="form-control html-editor h-205" rows="10" name="terms">{{ old('terms') }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>How To</label>
                                        <textarea class="form-control html-editor h-205" rows="10" name="howto">{{ old('howto') }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Store</label>
                                        <textarea class="form-control html-editor h-205" rows="10" name="store">{{ old('store') }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-group text-right">
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if (session('success'))
        <script>
            Swal.fire(
                'Success!',
                '{{ session('success') }}',
                'success'
            )
        </script>
    @endif
@endsection
