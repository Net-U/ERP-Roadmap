@extends('layouts-admin.app')

@section('content')
<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row mt-3">
            <div class="col-lg-8 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title text-white">
                            <i class="zmdi zmdi-library"></i> Tambah Data Pelatihan Karyawan
                        </div>
                        <hr>

                        <form action="{{ route('training.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            @if(auth()->user()->role === 'admin')
                                <div class="form-group">
                                    <label class="text-white">Pilih Karyawan</label>
                                    <select name="employee_id" class="form-control" required>
                                        <option value="">-- Pilih Karyawan --</option>
                                        @foreach($employees as $emp)
                                            <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @else
                                <input type="hidden" name="employee_id" value="{{ auth()->user()->employee->id }}">
                                <div class="form-group">
                                    <label class="text-white">Nama Karyawan</label>
                                    <input type="text" class="form-control" value="{{ auth()->user()->employee->name }}" readonly>
                                </div>
                            @endif

                            <div class="form-group">
                                <label class="text-white">Topik Pelatihan</label>
                                <input type="text" name="topic" class="form-control" placeholder="Contoh: Pelatihan K3" required>
                            </div>

                            <div class="form-group">
                                <label class="text-white">Deskripsi</label>
                                <textarea name="description" class="form-control" rows="3" placeholder="Deskripsi pelatihan..." required></textarea>
                            </div>

                            <div class="form-group">
                                <label class="text-white">Lokasi</label>
                                <input type="text" name="location" class="form-control" placeholder="Masukkan lokasi pelatihan (opsional)">
                            </div>

                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="text-white">Tanggal Mulai</label>
                                    <input type="date" name="start_date" class="form-control" required>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="text-white">Tanggal Selesai</label>
                                    <input type="date" name="end_date" class="form-control" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="text-white">Laporan Pasca Pelatihan <small class="text-warning">(PDF maks 2MB)</small></label>
                                <input type="file" name="laporan_pasca_pelatihan" class="form-control-file" accept=".pdf">
                            </div>

                            <div class="form-group">
                                <label class="text-white">Evaluasi Pasca Pelatihan <small class="text-warning">(PDF maks 2MB)</small></label>
                                <input type="file" name="evaluasi_pasca_pelatihan" class="form-control-file" accept=".pdf">
                            </div>

                            <div class="form-group mt-4 d-flex justify-content-between align-items-center">
                                <button type="submit" class="btn btn-light px-4">
                                    <i class="zmdi zmdi-check"></i> Simpan Pelatihan
                                </button>

                                @if(auth()->user()->role === 'admin')
                                    <a href="{{ route('training.training') }}" class="btn btn-warning">
                                        <i class="zmdi zmdi-collection-text"></i> Lihat Rekap Pelatihan
                                    </a>
                                @endif
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>

@endsection