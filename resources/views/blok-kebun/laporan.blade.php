@extends('layouts-admin.app')

@section('title', 'Laporan Blok Siap Panen')

@section('content')
<div class="container-fluid mt-4 mb-5">
  <div class="row">
    <div class="col-lg-10 mx-auto">

      <div class="card shadow-sm border-0 rounded-3">
        
        <!-- Header -->
        <div class="card-header text-white py-3" style="background-color:#155b46;">
          <h5 class="mb-0 fw-semibold text-center text-uppercase">Daftar Blok Siap Panen (> 6 Hari)</h5>
        </div>

        <!-- Isi Tabel -->
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-striped mb-0 align-middle text-center">
              <thead class="bg-light fw-semibold text-dark">
                <tr>
                  <th>KODE BLOK</th>
                  <th>LUAS (Ha)</th>
                  <th>TGL PANEN TERAKHIR</th>
                  <th>HARI SEJAK PANEN</th>
                  <th>ROTASI PANEN</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($blokKebun as $blok)
                  <tr>
                    <td>{{ $blok['kode_blok'] }}</td>
                    <td>{{ number_format($blok['luas_ha'], 2, ',', '.') }}</td>
                    <td>{{ $blok['tgl_panen_terakhir'] }}</td>
                    <td>
                      <span class="badge bg-danger">{{ $blok['hari_sejak_panen'] }} hari</span>
                    </td>
                    <td>{{ $blok['rotasi_panen'] }}</td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="5" class="text-muted py-3">Tidak ada blok yang lewat dari 6 hari.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
@endsection
