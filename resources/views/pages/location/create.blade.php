@extends('layouts.main')

@section('content')
    @push('head')
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
            integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
        <link rel="stylesheet" href="https://unpkg.com/leaflet-geosearch@3.0.0/dist/geosearch.css" />
        <script src="https://unpkg.com/leaflet-geosearch@3.0.0/dist/geosearch.umd.js"></script>
    @endpush
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
                            <h5>{{ __('Location') }}</h5>
                            <span>{{ __('Lists of Location') }}</span>
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
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Add Location') }}</li>
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
                                <h3 class="pt-2">Add Location</h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-5">
                                    <div id="map" class="pt-5" style="height: 400px;"></div>
                                </div>
                                <div class="col-md-7">
                                    <form action="{{ route('location.store') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group mb-3">
                                                    <label for="" class="form-label">Name</label>
                                                    <input type="text" name="name"
                                                        class="form-control @error('name') is-invalid @enderror"
                                                        value="{{ old('name') }}">
                                                    @error('name')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group mb-3">
                                                    <label for="" class="form-label">Street 1</label>
                                                    <input type="text"
                                                        class="form-control @error('street1') is-invalid @enderror"
                                                        name="street1" value="{{ old('street1') }}">
                                                    @error('street1')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group mb-3">
                                                    <label for="" class="form-label">Street 2</label>
                                                    <input type="text"
                                                        class="form-control @error('street2') is-invalid @enderror"
                                                        name="street2" value="{{ old('street2') }}">
                                                    @error('street2')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group mb-3">
                                                    <label for="" class="form-label">Location</label>
                                                    <input type="text"
                                                        class="form-control @error('location') is-invalid @enderror"
                                                        name="location" value="{{ old('location') }}">
                                                    @error('location')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group mb-3">
                                                    <label for="" class="form-label">Latitude</label>
                                                    <input type="text"
                                                        class="form-control @error('lat') is-invalid @enderror"
                                                        id="lat" name="lat" value="{{ old('lat') }}">
                                                    @error('lat')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group mb-3">
                                                    <label for="" class="form-label">Longtitude</label>
                                                    <input type="text"
                                                        class="form-control @error('lng') is-invalid @enderror"
                                                        id="lng" name="lng" value="{{ old('lng') }}">
                                                    @error('lng')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group mb-3">
                                                    <label for="" class="form-label">Postal Code</label>
                                                    <input type="number"
                                                        class="form-control @error('postal_code') is-invalid @enderror"
                                                        name="postal_code" value="{{ old('postal_code') }}">
                                                    @error('postal_code')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group mb-3">
                                                    <label for="" class="form-label">Phone</label>
                                                    <input type="number"
                                                        class="form-control @error('phone') is-invalid @enderror"
                                                        name="phone" value="{{ old('phone') }}">
                                                    @error('phone')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group mb-3">
                                                    <label for="" class="form-label">WhatsApp</label>
                                                    <input type="number"
                                                        class="form-control @error('whatsapp') is-invalid @enderror"
                                                        name="whatsapp" value="{{ old('whatsapp') }}">
                                                    @error('whatsapp')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group mb-3">
                                                    <label for="" class="form-label">Day Of Week</label>
                                                    <input type="text"
                                                        class="form-control @error('daf_of_week') is-invalid @enderror"
                                                        name="day_of_week" value="{{ old('day_of_week') }}">
                                                    @error('day_of_week')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group mb-3">
                                                    <label for="" class="form-label">Start Time</label>
                                                    <input type="text"
                                                        class="form-control @error('start_time') is-invalid @enderror"
                                                        name="start_time" value="{{ old('start_time') }}">
                                                    @error('start_time')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group mb-3">
                                                    <label for="" class="form-label">End Time</label>
                                                    <input type="text"
                                                        class="form-control @error('end_time') is-invalid @enderror"
                                                        name="end_time" value="{{ old('end_time') }}">
                                                    @error('end_time')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group-mb-3">
                                                    <label for="" class="form-label">Description</label>
                                                    <textarea class="form-control @error('description') is-invalid @enderror html-editor h-205" rows="10"
                                                        name="description">{{ old('description') }}</textarea>
                                                    @error('description')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md">
                                                <div class="d-flex">
                                                    <a href="{{ route('location.index') }}"
                                                        class="btn btn-warning btn-sm mr-2">Back</a>
                                                    <button class="btn btn-primary btn-sm ms-auto"
                                                        type="submit">Save</button>
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
        </div>
    </div>
    <script>
        var map = L.map('map').setView([51.505, -0.09], 13);

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
        }).addTo(map);

        map.on('click', function(e) {
            var lat = e.latlng.lat;
            var lng = e.latlng.lng;
            $('#lat').val(lat)
            $('#lng').val(lng)
        });
    </script>
@endsection
