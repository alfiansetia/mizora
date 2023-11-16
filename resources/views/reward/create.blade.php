@extends('layouts.main')
@section('title')
    Rewards
@endsection
@section('content')
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-headphones bg-green"></i>
                        <div class="d-inline">
                            <h5>Products</h5>
                            <span>View, delete and update products</span>
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
                                <a href="#">Products</a>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form class="forms-sample" method="POST" action="{{ route('rewards.store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="name">Name<span class="text-red">*</span></label>
                                        <input id="name" type="text" class="form-control" name="name"
                                            value="{{ old('name') }}" placeholder="Enter product name" required="">
                                        @error('name')
                                            <div class="help-block with-errors">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="point">Point<span class="text-red">*</span></label>
                                        <input id="point" type="number" class="form-control" name="point"
                                            value="{{ old('point') }}" placeholder="Enter product point" required="">
                                        @error('point')
                                            <div class="help-block with-errors">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="start_date_time">Start Date<span class="text-red">*</span></label>
                                        <input id="start_date_time" type="date" class="form-control"
                                            name="start_date_time" value="{{ old('start_date_time') }}"
                                            placeholder="Enter product price" required="">
                                        @error('start_date_time')
                                            <div class="help-block with-errors">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="end_date_time">End Date<span class="text-red">*</span></label>
                                        <input id="end_date_time" type="date" class="form-control" name="end_date_time"
                                            value="{{ old('end_date_time') }}" placeholder="Enter product price"
                                            required="">
                                        @error('end_date_time')
                                            <div class="help-block with-errors">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Images</label>
                                        <input type="file" name="image" class="form-control">
                                        @error('image')
                                            <div class="help-block with-errors">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea class="form-control html-editor h-205" rows="10" name="description">{{ old('description') }}</textarea>
                                        @error('description')
                                            <div class="help-block with-errors">{{ $message }}</div>
                                        @enderror
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
@endsection
