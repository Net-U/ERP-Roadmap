@extends('layouts-admin.app')

@section('title', 'Update Laporan Blok Kebun')

@section('content')
<div class="content-wrapper">
  <div class="container-fluid">
    <div class="row mt-4 mb-5">
      <div class="col-lg-8 mx-auto">
        <div class="card shadow-sm border-0 rounded-3">
          
          {{-- Header --}}
          <div class="card-header text-white text-center py-3" style="background-color: #155b46;">
            <h4 class="mb-0 fw-semibold">Update Laporan Panen (Sore Hari)</h4>
          </div>

          {{-- Body --}}
          <div class="card-body px-4 py-4">

            <form action="{{ route('admin.blok-kebun.update-laporan') }}" method="POST">
              @csrf

              {{-- Pilih Blok Kebun --}}
              <div class="form-group mb-3">
                <label for="blok_kebun_id" class="form-label fw-semibold text-dark">Pilih Blok Kebun</label>
                <select name="blok_kebun_id" id="blok_kebun_id" class="form-control" required>
                  <option value="">-- Pilih Blok --</option>
                  @foreach ($blokKebun as $blok)
                    <option value="{{ $blok->id }}">{{ $blok->kode_blok }} ({{ $blok->luas_ha }} ha)</option>
                  @endforeach
                </select>
              </div>

              {{-- Tanggal Panen Terakhir --}}
              <div class="form-group mb-3">
                <label for="tgl_panen_terakhir" class="form-label fw-semibold text-dark">Tanggal Panen Terakhir</label>
                <input type="date" name="tgl_panen_terakhir" id="tgl_panen_terakhir" class="form-control" required>
                <small id="info_hari" class="text-muted fw-semibold d-block mt-1"></small>
              </div>

              {{-- Rotasi Panen --}}
              <div class="form-group mb-4">
                <label for="rotasi_panen" class="form-label fw-semibold text-dark">Rotasi Panen (hari)</label>
                <input type="number" name="rotasi_panen" id="rotasi_panen" class="form-control" placeholder="Misal: 10" required>
              </div>

              {{-- Tombol Aksi --}}
              <div class="d-flex justify-content-between align-items-center">
                <button 
                  type="submit" 
                  class="btn btn-success px-5 py-2 fw-semibold custom-submit-btn">
                  <i class="bi bi-check-lg me-1"></i> Simpan Laporan
                </button>

                {{-- Tombol lihat blok siap panen --}}
                <a 
                  href="{{ route('admin.blok-kebun.laporan') }}" 
                  class="btn btn-outline-success px-4 py-2 fw-semibold custom-outline-btn">
                  <i class="bi bi-eye-fill me-1"></i> Lihat Blok Siap Panen
                </a>
              </div>

            </form>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Script AJAX --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
  const blokSelect = document.getElementById('blok_kebun_id');
  const tglPanenInput = document.getElementById('tgl_panen_terakhir');
  const rotasiInput = document.getElementById('rotasi_panen');
  const infoHari = document.getElementById('info_hari');

  blokSelect.addEventListener('change', async function() {
    const blokId = this.value;
    if (!blokId) {
      tglPanenInput.value = '';
      rotasiInput.value = '';
      infoHari.textContent = '';
      return;
    }

    try {
      const response = await fetch(`{{ url('admin/blok-kebun') }}/${blokId}/detail`);
      if (!response.ok) throw new Error('Gagal ambil data');
      const data = await response.json();

      // isi otomatis
      tglPanenInput.value = data.tgl_panen_terakhir;
      rotasiInput.value = data.rotasi_panen;
      infoHari.textContent = `Sudah ${Math.floor(data.hari_sejak_panen)} hari sejak panen terakhir.`;
    } catch (error) {
      console.error(error);
      infoHari.textContent = 'Gagal memuat data blok kebun.';
    }
  });
});
</script>

{{-- Style --}}
<style>
  .custom-submit-btn {
    background-color: #155b46 !important;
    border: none !important;
    transition: all 0.3s ease;
  }

  .custom-submit-btn:hover {
    background-color: #1e7b60 !important;
    transform: translateY(-1px);
    box-shadow: 0 3px 8px rgba(0,0,0,0.15);
  }

  .custom-submit-btn:active {
    background-color: #134d3c !important;
    transform: scale(0.98);
  }

  .custom-outline-btn {
    color: #155b46 !important;
    border-color: #155b46 !important;
    transition: all 0.3s ease;
  }

  .custom-outline-btn:hover {
    background-color: #1e7b60 !important;
    color: #fff !important;
    transform: translateY(-1px);
    box-shadow: 0 3px 8px rgba(0,0,0,0.15);
  }
</style>
@endsection
