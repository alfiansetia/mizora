@extends('layouts.main')

@section('content')
    <style>
        #table-data {
            width: 100%;
            min-width: 100%;
        }
    </style>
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i id="icon_title" class="ik ik-star bg-yellow"></i>
                        <div class="d-inline">
                            <h5>{{ __('Category Reward') }}</h5>
                            <span>{{ __('Lists of category reward') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item"><a href="#">{{ __('Reward') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Add Category Reward') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-block">
                        <div class="d-flex flex-row">
                            <div>
                                <h3 class="pt-2">Add Category Reward</h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="container">
                            <form action="{{ route('reward-category.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="" class="form-label">Nama</label>
                                            <input type="text" name="name"
                                                class="form-control @error('name') is-invalid @enderror"
                                                value="{{ old('name') }}">
                                            @error('name')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="" class="form-label">Image</label>
                                            <input type="file" name="image"
                                                class="form-control @error('name') is-invalid @enderror"
                                                onchange="document.getElementById('image').src = window.URL.createObjectURL(this.files[0])">
                                            @error('image')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                            <div class="mb-2"><img src="" id="image" alt=""
                                                    width="200">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="d-flex">
                                            <a href="{{ route('reward-category.index') }}"
                                                class="btn btn-warning btn-sm mr-2">Back</a>
                                            <button class="btn btn-primary btn-sm ms-auto" type="submit">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
