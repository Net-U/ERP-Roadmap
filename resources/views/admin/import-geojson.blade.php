@extends('layouts-admin.app')

@section('content')
<div class="container">
    <h2 class="mb-4">📂 Import Data Blok Kebun (GeoJSON)</h2>

    {{-- Alert Success/Error --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Form Upload --}}
    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.import-geojson.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="geojson_file" class="form-label">Pilih File GeoJSON</label>
                    <input type="file" class="form-control" id="geojson_file" name="geojson_file" required>
                    <div class="form-text">Hanya mendukung file .geojson atau .json</div>
                </div>
                <button type="submit" class="btn btn-primary">Upload & Import</button>
            </form>
        </div>
    </div>
</div>
@endsection
