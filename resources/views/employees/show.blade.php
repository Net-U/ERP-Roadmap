@extends('layouts-admin.app')

@section('content')
<div class="content-wrapper" style="min-height: 100vh; background-color: #f8f9fa; padding: 20px;">

  
<!-- ... bagian head dan layout tetap -->

<div class="content-wrapper">
  <div class="container-fluid">
    <div class="row mt-3">
      <!-- Sidebar Profil -->
      <div class="col-lg-4">
        <div class="card profile-card-2">
          <div class="d-flex justify-content-end px-3 pt-3">
            <img src="{{ asset('img/profile.png') }}" class="logo-icon" alt="logo icon" width="200" height="20">
          </div>
          <div class="d-flex justify-content-center mt-4 mb-3">
            <img src="{{ $employee->photo ? asset('storage/' . $employee->photo) : asset('img/profile.png') }}"
                alt="Foto Profil"
                style="width: 200px; height: 200px; object-fit: cover; border-radius: 50%; border: 4px solid white; box-shadow: 0 0 12px rgba(0,0,0,0.3);">
          </div>
          <div class="card-body pt-5">
            <h5 class="card-title">{{ $employee->name }}</h5>
            <p class="card-text">
              Bergabung pada {{ \Carbon\Carbon::parse($employee->join_date)->translatedFormat('d F Y') }}
            </p>
          </div>
          <div class="card-body border-top border-light">
            <div class="media align-items-center mb-3">
              <div class="media-body text-left ml-3">
                <h6 class="mb-0">Departemen</h6>
                <p>{{ $employee->department->name ?? '-' }}</p>
              </div>
            </div>
            <div class="media align-items-center mb-3">
              <div class="media-body text-left ml-3">
                <h6 class="mb-0">Posisi</h6>
                <p>{{ $employee->position->name ?? '-' }}</p>
              </div>
            </div>
            <div class="media align-items-center mb-3">
              <div class="media-body text-left ml-3">
                <h6 class="mb-0">Grade</h6>
                <p>{{ $employee->grade->grade_name ?? '-' }}</p>
              </div>
            </div>

            <div class="media align-items-center mb-3">
              <div class="media-body text-left ml-3">
                <h6 class="mb-0">Gaji Terakhir</h6>
                <p>
                  @if($employee->latestSalary)
                    Rp {{ number_format($employee->latestSalary->basic_salary + $employee->latestSalary->tunjangan_keluarga + $employee->latestSalary->tunjangan_kematian + $employee->latestSalary->tunjangan_lainnya - $employee->latestSalary->deduction, 0, ',', '.') }}
                    <br><small class="text-muted">
                      Periode: {{ \Carbon\Carbon::createFromDate($employee->latestSalary->year, $employee->latestSalary->month)->translatedFormat('F Y') }}
                    </small>
                  @else
                    <span class="text-muted">Belum ada data gaji</span>
                  @endif
                </p>
              </div>
            </div>

          </div>
        </div>
      </div>

      <!-- Detail -->
      <div class="col-lg-8">
        <div class="card">
          <div class="card-body">
            <ul class="nav nav-tabs nav-tabs-primary top-icon nav-justified">
              <li class="nav-item">
                <a href="#profile" data-toggle="pill" class="nav-link active">
                  <i class="icon-user"></i> <span>Profil</span>
                </a>
              </li>
              <li class="nav-item">
                <a href="#activity" data-toggle="pill" class="nav-link">
                  <i class="icon-note"></i> <span>Aktivitas</span>
                </a>
              </li>
            </ul>

            <div class="tab-content p-3">
              <!-- Tab Profil -->
              <div class="tab-pane active" id="profile">
                <h5 class="mb-3">Data Karyawan</h5>
                <div class="row">
                  <div class="col-md-6">
                    <p><strong>NRK:</strong> {{ $employee->nrk }}</p>
                    <p><strong>NIK SAP:</strong> {{ $employee->nik_sap }}</p>
                    <p><strong>Email:</strong> {{ $employee->email }}</p>
                    <p><strong>No. Telepon:</strong> {{ $employee->phone ?? '-' }}</p>
                    <p><strong>Jenis Kelamin:</strong> {{ $employee->gender }}</p>
                    <p><strong>Tempat, Tanggal Lahir:</strong> {{ $employee->place_of_birth }}, {{ \Carbon\Carbon::parse($employee->date_of_birth)->translatedFormat('d F Y') }}</p>
                    <p><strong>Agama:</strong> {{ $employee->religion }}</p>
                    <p><strong>Golongan Darah:</strong> {{ $employee->blood_type }}</p>
                  </div>
                  <div class="col-md-6">
                    <p><strong>Alamat:</strong> {{ $employee->address }}</p>
                    <p><strong>Kecamatan/Kota:</strong> {{ $employee->district }} / {{ $employee->city }}</p>
                    <p><strong>Pendidikan:</strong> {{ $employee->education }} - {{ $employee->education_major }}</p>
                    <p><strong>No. Identitas:</strong> {{ $employee->identity_number }}</p>
                    <p><strong>BPJS TK:</strong> {{ $employee->bpjs_tk }}</p>
                    <p><strong>BPJS KS:</strong> {{ $employee->bpjs_ks }}</p>
                    <p><strong>NPWP:</strong> {{ $employee->npwp }}</p>
                    <p><strong>Rekening Bank:</strong> {{ $employee->bank_account }}</p>
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-md-6">
                    <p><strong>Status Pernikahan:</strong> {{ $employee->marital_status }}</p>
                    <p><strong>Nama Pasangan:</strong> {{ $employee->spouse_name }}</p>
                    <p><strong>Pekerjaan Pasangan:</strong> {{ $employee->spouse_job }}</p>
                    <p><strong>Jumlah Anak:</strong> {{ $employee->children_count }}</p>
                  </div>
                  <div class="col-md-6">
                    <p><strong>Vaksin 1:</strong> {{ $employee->vaccine_1 ? 'Ya' : 'Tidak' }}</p>
                    <p><strong>Vaksin 2:</strong> {{ $employee->vaccine_2 ? 'Ya' : 'Tidak' }}</p>
                    <p><strong>Vaksin 3:</strong> {{ $employee->vaccine_3 ? 'Ya' : 'Tidak' }}</p>
                  </div>
                </div>
              </div>

              <!-- Tab Aktivitas -->
              <div class="tab-pane" id="activity">
                <h5 class="mb-3">Aktivitas Terbaru</h5>
                <ul>
                  <li>Tanggal Masuk: {{ \Carbon\Carbon::parse($employee->join_date)->format('d M Y') }}</li>
                  <li>Data dibuat: {{ $employee->created_at->diffForHumans() }}</li>
                  <li>Terakhir diupdate: {{ $employee->updated_at->diffForHumans() }}</li>
                </ul>

                <hr>
                <h6>🧾 Riwayat Jabatan</h6>
                <ul>
                  @forelse ($employee->jobHistories as $history)
                    <li>{{ $history->position }} di {{ $history->department ?? '-' }} ({{ \Carbon\Carbon::parse($history->start_date)->format('M Y') }} - {{ $history->end_date ? \Carbon\Carbon::parse($history->end_date)->format('M Y') : 'Sekarang' }})</li>
                  @empty
                    <li>Tidak ada data jabatan.</li>
                  @endforelse
                </ul>

                <h6>🚫 SP / Penalty</h6>
                <ul>
                  @forelse ($employee->penalties as $penalty)
                    <li>{{ $penalty->type }} - {{ $penalty->reason }} ({{ \Carbon\Carbon::parse($penalty->date)->format('d M Y') }})</li>
                  @empty
                    <li>Tidak ada SP.</li>
                  @endforelse
                </ul>

                <h6>🎓 Pelatihan</h6>
                <ul>
                  @forelse ($employee->trainings as $training)
                    <li>Topik Pelatihan {{ $training->topic }} Lokasi {{ $training->location ?? 'N/A' }} ({{ \Carbon\Carbon::parse($training->date)->format('d M Y') }})</li>
                  @empty
                    <li>Belum mengikuti pelatihan.</li>
                  @endforelse
                </ul>
              </div>


            </div> <!-- tab-content -->
          </div>
        </div>
      </div> <!-- end col-lg-8 -->
    </div>
  </div>
</div>

<!-- ... bagian scripts tetap -->
  {{-- Scripts --}}
  <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/js/popper.min.js') }}"></script>
  <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/simplebar/js/simplebar.js') }}"></script>
  <script src="{{ asset('assets/js/sidebar-menu.js') }}"></script>
  <script src="{{ asset('assets/js/app-script.js') }}"></script>

  @if(isset($years) && isset($gradeEmployeeData))
  <script>
    const ctx = document.getElementById('chart1').getContext('2d');
    new Chart(ctx, {
      type: 'line',
      data: {
        labels: @json($years),
        datasets: @json($gradeEmployeeData)
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            position: 'top',
            labels: {
              color: '#fff',
              font: { size: 12 }
            }
          },
          title: {
            display: true,
            text: 'Jumlah Karyawan per Grade per Tahun',
            color: '#fff',
            font: { size: 20, weight: 'bold' }
          }
        },
        scales: {
          x: {
            ticks: { color: '#fff' },
            grid: { color: '#444' }
          },
          y: {
            beginAtZero: true,
            ticks: { color: '#fff' },
            grid: { color: '#444' }
          }
        }
      }
    });
  </script>
  @endif

  @if(isset($gradeLabels) && isset($gradeCounts))
  <script>
    const doughnutCtx = document.getElementById('chart2').getContext('2d');
    new Chart(doughnutCtx, {
      type: 'doughnut',
      data: {
        labels: @json($gradeLabels),
        datasets: [{
          data: @json($gradeCounts),
          backgroundColor: ['#4bc0c0', '#36a2eb', '#ff6384', '#9966ff', '#ffcd56'],
          borderWidth: 2
        }]
      },
      options: {
        plugins: {
          legend: { display: false },
          title: { display: false }
        },
        cutout: '70%',
        responsive: true,
        maintainAspectRatio: false
      }
    });
  </script>
  @endif

@endsection
