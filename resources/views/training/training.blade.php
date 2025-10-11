@extends('layouts-admin.app')

@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row mt-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title text-white">
                                <i class="zmdi zmdi-collection-text"></i> Rekap Data Pelatihan Karyawan
                            </div>
                            <hr>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover text-white">
                                    <thead class="thead-light bg-light text-dark">
                                        <tr>
                                            <th>#</th>
                                            <th>Karyawan</th>
                                            <th>Topik</th>
                                            <th>Deskripsi</th>
                                            <th>Lokasi</th>
                                            <th>Tanggal</th>
                                            <th>Laporan</th>
                                            <th>Evaluasi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($trainings as $index => $t)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $t->employee->name }}</td>
                                                <td>{{ $t->topic }}</td>
                                                <td>{{ $t->description }}</td>
                                                <td>{{ $t->location ?? '-' }}</td>
                                                <td>
                                                    {{ \Carbon\Carbon::parse($t->start_date)->format('d M Y') }} <br>
                                                    s/d <br>
                                                    {{ \Carbon\Carbon::parse($t->end_date)->format('d M Y') }}
                                                </td>
                                                <td>
                                                    @if($t->laporan_pasca_pelatihan)
                                                        <a href="{{ asset('storage/' . $t->laporan_pasca_pelatihan) }}" target="_blank" class="btn btn-sm btn-info">Lihat</a>
                                                    @else
                                                        <span class="badge badge-secondary">Tidak ada</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($t->evaluasi_pasca_pelatihan)
                                                        <a href="{{ asset('storage/' . $t->evaluasi_pasca_pelatihan) }}" target="_blank" class="btn btn-sm btn-warning">Lihat</a>
                                                    @else
                                                        <span class="badge badge-secondary">Tidak ada</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach

                                        @if($trainings->count() == 0)
                                            <tr>
                                                <td colspan="8" class="text-center text-white">Belum ada data pelatihan.</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            {{-- Optional: Pagination --}}
                            {{-- {{ $trainings->links() }} --}}
                            <div class="d-flex justify-content-end mt-3">
                                {{ $trainings->links('pagination::bootstrap-5') }}
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection