<?php

namespace App\Http\Controllers\Admin;

use App\Models\Employee;
use App\Models\Grade;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\EmployeeImport; // ⬅️ Import class Excel
use App\Exports\DynamicExport;
use App\Http\Controllers\Controller;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\SimpleType\Jc;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use App\Models\Department; // ✅ Tambahkan ini
use App\Models\Position; 
use PhpOffice\PhpWord\TemplateProcessor;


class EmployeeController extends Controller
{
    /**
     * Menampilkan daftar semua karyawan dengan filter & grafik.
     */
    public function index(Request $request)
    {
        /* ---------- 1. Query dasar ---------- */
        $years = Employee::selectRaw('YEAR(join_date) as year')
                        ->distinct()
                        ->orderBy('year')
                        ->pluck('year');

        $query = Employee::with(['grade', 'position', 'department']);

        /* ---------- 2. Filter pencarian ---------- */
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('nrk', 'like', "%{$search}%")
                ->orWhere('nik_sap', 'like', "%{$search}%")
                ->orWhere('phone', 'like', "%{$search}%")
                ->orWhere('address', 'like', "%{$search}%");
            });
        }

        $employees = $query->latest()->paginate(15)->appends($request->query());

        /* ---------- 3. Data rekap ---------- */
        $totalEmployees  = Employee::count();
        $employeePerYear = Employee::selectRaw('YEAR(join_date) as year, COUNT(*) as total')
                                ->groupBy('year')
                                ->orderBy('year')
                                ->get();

        /* ---------- 4. Statistik Grade ---------- */
        $grades = Grade::withCount('employees')      // agar employees_count tersedia
                    ->orderBy('code')
                    ->get();

        // ––– a.  labels & counts untuk grafik donat
        $gradeLabels = $grades->pluck('code');
        $gradeCounts = $grades->pluck('employees_count');

        // ––– b.  datasets unik (1 baris = 1 grade) untuk grafik garis
        $gradeEmployeeData = $grades->map(function ($g) use ($years) {
            $perYear = $years->map(function ($y) use ($g) {
                return $g->employees()
                        ->whereYear('join_date', $y)
                        ->count();
            });

            return [
                'label'           => $g->code . ' - ' . $g->grade_name,
                'data'            => $perYear,
                'borderColor'     => '#'.substr(md5($g->id), 0, 6),
                'backgroundColor' => 'transparent',
                'tension'         => 0.4,
            ];
        });

        /* ---------- 5. Kirim ke view ---------- */
        return view('employees.index', compact(
            'employees',
            'years',
            'grades',
            'gradeLabels',       // 🆕
            'gradeCounts',       // 🆕
            'gradeEmployeeData', // 🆕
            'totalEmployees',
            'employeePerYear'
        ));
    }

    /**
     * Menampilkan detail lengkap dari satu karyawan.
     */
    public function show(Employee $employee)
    {
        $employee->load(['grade', 'position', 'department', 'jobHistories', 'penalties', 'trainings','latestSalary']);

        $totalEmployees = Employee::count();
        $employeePerYear = Employee::selectRaw('YEAR(join_date) as year, COUNT(*) as total')
                                   ->groupBy('year')
                                   ->orderBy('year')
                                   ->get();

        $grades = Grade::all();

        return view('employees.show', compact(
            'employee',
            'grades',
            'totalEmployees',
            'employeePerYear'
        ));
    }


            /**
         * Menampilkan halaman form import Excel.
         */
        public function showImportForm()
        {
            $totalEmployees = Employee::count();
            $grades = Grade::all();

            return view('employees.import', compact('totalEmployees', 'grades'));
        }

    /**
     * Mengimpor data karyawan dari file Excel.
     */
    public function import(Request $request)
    {
        // Validasi file harus excel
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        try {
            // Proses impor menggunakan Laravel Excel
            Excel::import(new EmployeeImport, $request->file('file'));

         // Lebih direkomendasikan pakai with() daripada Session::flash()
        return redirect()->route('employees.index')->with('success', '✅ Data karyawan berhasil diimpor!');

        } catch (\Exception $e) {
            // Pesan gagal
        return redirect()->route('employees.import')->with('error', '❌ Terjadi kesalahan saat impor: ' . $e->getMessage());
        }

        // Redirect kembali ke halaman employee
        return redirect()->route('employees.index');
    }

    public function exportFull()
    {
        $employees = Employee::with(['grade', 'position', 'department'])->get()->map(function ($e) {
            return [
                'name'            => $e->name,
                'nrk'             => $e->nrk,
                'nik_sap'         => $e->nik_sap,
                'identity_number' => $e->identity_number,
                'join_date'       => $e->join_date?->format('Y-m-d'),
                'date_of_birth'   => $e->date_of_birth?->format('Y-m-d'),
                'place_of_birth'  => $e->place_of_birth,
                'gender'          => $e->gender,
                'religion'        => $e->religion,
                'blood_type'      => $e->blood_type,
                'email'           => $e->email,
                'phone'           => $e->phone,
                'address'         => $e->address,
                'district'        => $e->district,
                'city'            => $e->city,
                'education'       => $e->education,
                'education_major' => $e->education_major,
                'bank_account'    => $e->bank_account,
                'bpjs_tk'         => $e->bpjs_tk,
                'bpjs_ks'         => $e->bpjs_ks,
                'npwp'            => $e->npwp,
                'subdivision'     => $e->subdivision,
                'spouse_job'      => $e->spouse_job,
                'marital_status'  => $e->marital_status,
                'spouse_name'     => $e->spouse_name,
                'children_count'  => $e->children_count,
                'vaccine_1'       => $e->vaccine_1,
                'vaccine_2'       => $e->vaccine_2,
                'vaccine_3'       => $e->vaccine_3,
                'user_id'         => $e->user_id,
                'department_id'   => $e->department_id,
                'position_id'     => $e->position_id,
                'grade_id'        => $e->grade_id,
            ];
        });

        $headings = [
            'name','nrk','nik_sap','identity_number','join_date','date_of_birth',
            'place_of_birth','gender','religion','blood_type','email','phone',
            'address','district','city','education','education_major','bank_account',
            'bpjs_tk','bpjs_ks','npwp','subdivision','spouse_job','marital_status','spouse_name',
            'children_count','vaccine_1','vaccine_2','vaccine_3','user_id',
            'department_id','position_id','grade_id'
        ];

        return Excel::download(new DynamicExport($employees, $headings), 'data_karyawan_lengkap.xlsx');
    }

    public function exportWord(Employee $employee)
    {
        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

        // ================== GAMBAR TENGAH HALAMAN ==================
        $imagePath = $employee->photo
            ? storage_path('app/public/' . $employee->photo)
            : public_path('img/profile.png');

        if (file_exists($imagePath)) {
            $imgRun = $section->addTextRun(['alignment' => Jc::CENTER]);
            $imgRun->addImage($imagePath, [
                'width'  => 150,
                'height' => 150,
            ]);
        } else {
            $section->addText("Foto tidak ditemukan", ['italic' => true], ['alignment' => Jc::CENTER]);
        }

        $section->addTextBreak(1); // Jarak antara gambar dan tabel

        // ================== TABEL DUA KOLOM ==================
        $table = $section->addTable([
            'width' => 100 * 50,
            'unit' => \PhpOffice\PhpWord\SimpleType\TblWidth::PERCENT,
            'alignment' => Jc::CENTER,
            'layout' => \PhpOffice\PhpWord\Style\Table::LAYOUT_FIXED,
        ]);

        $table->addRow();

        // ================== KOLOM KIRI ==================
        $leftCell = $table->addCell(50 * 50, ['valign' => 'top']);
        $leftCell->addText(strtoupper($employee->name), ['bold' => true, 'size' => 14]);
        $leftCell->addText("Bergabung pada: " . optional($employee->join_date)->format('d F Y'));

        $leftCell->addText("Departemen: " . ($employee->department->name ?? '-'));
        $leftCell->addText("Posisi: " . ($employee->position->name ?? '-'));
        $leftCell->addText("Grade: " . ($employee->grade->grade_name ?? '-'));
        $leftCell->addText("Gaji Terakhir: " . ($employee->last_salary ?? 'Belum ada data gaji'));

        $leftCell->addTextBreak(1);
        $leftCell->addText('Aktivitas', ['bold' => true, 'size' => 14]);
        $leftCell->addText("Jumlah Cuti:  {$employee->penalties()->count()}");
        $leftCell->addText("Jumlah Training: {$employee->trainings()->count()}");
        $leftCell->addText("Jumlah Gaji: {$employee->salaries()->count()}");

        $leftCell->addTextBreak();
        $leftCell->addText('Riwayat Jabatan:', ['bold' => true]);
        if ($employee->jobHistories->isEmpty()) {
            $leftCell->addText('- Tidak ada data jabatan -');
        } else {
            foreach ($employee->jobHistories as $history) {
                $periode = \Carbon\Carbon::parse($history->start_date)->format('M Y') . ' - ' .
                    ($history->end_date ? \Carbon\Carbon::parse($history->end_date)->format('M Y') : 'Sekarang');
                $leftCell->addText("• {$history->position} di {$history->department} ({$periode})", [], ['spaceAfter' => 0]);
            }
        }

        // ================== KOLOM KANAN ==================
        $rightCell = $table->addCell(50 * 50, ['valign' => 'top']);
        $rightCell->addText('Data Karyawan', ['bold' => true, 'size' => 14]);
        $rightCell->addText("NRK: {$employee->nrk}");
        $rightCell->addText("NIK SAP: {$employee->nik_sap}");
        $rightCell->addText("Email: {$employee->email}");
        $rightCell->addText("No. Telepon: {$employee->phone}");
        $rightCell->addText("Jenis Kelamin: {$employee->gender}");
        $rightCell->addText("Tempat, Tanggal Lahir: {$employee->birth_place}, " . date('d F Y', strtotime($employee->birth_date)));
        $rightCell->addText("Agama: {$employee->religion}");
        $rightCell->addText("Golongan Darah: {$employee->blood_type}");
        $rightCell->addText("Status Pernikahan: {$employee->marital_status}");
        $rightCell->addText("Pekerjaan Pasangan: {$employee->spouse_job}");
        $rightCell->addText("Jumlah Anak: {$employee->children_count}");
        $rightCell->addText("Alamat: {$employee->address}");
        $rightCell->addText("Kecamatan/Kota: {$employee->district} / {$employee->city}");
        $rightCell->addText("Pendidikan: {$employee->education}");
        $rightCell->addText("No. Identitas: {$employee->identity_number}");
        $rightCell->addText("BPJS TK: {$employee->bpjs_tk}");
        $rightCell->addText("BPJS KS: {$employee->bpjs_ks}");
        $rightCell->addText("NPWP: {$employee->npwp}");
        $rightCell->addText("Rekening Bank: {$employee->bank_account}");
        $rightCell->addText("Vaksin 1: " . ($employee->vaccine_1 ? 'Ya' : 'Tidak'));
        $rightCell->addText("Vaksin 2: " . ($employee->vaccine_2 ? 'Ya' : 'Tidak'));
        $rightCell->addText("Vaksin 3: " . ($employee->vaccine_3 ? 'Ya' : 'Tidak'));

        // Simpan file
        $fileName = 'employee_' . $employee->nrk . '.docx';
        $tempPath = base_path('app/templates/' . $fileName);
        if (!file_exists(base_path('app/templates/'))) {
            mkdir(base_path('app/templates/'), 0777, true);
        }

        IOFactory::createWriter($phpWord, 'Word2007')->save($tempPath);
        return response()->download($tempPath)->deleteFileAfterSend();
    }






    public function editCustom($id)
    {
        $employee    = Employee::findOrFail($id);
        $departments = Department::all();
        $positions   = Position::all();
        $grades      = Grade::all();
        $employeesList = Employee::all();

        return view('register.update', compact('employee', 'departments', 'positions', 'grades','employeesList'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'employee_id'   => 'required|exists:employees,id',
            'nrk'           => 'nullable|string|max:50',
            'nik_sap'       => 'nullable|string|max:50',
            'identity_number' => 'nullable|string|max:50',
            'email'         => 'nullable|email',
            'phone'         => 'nullable|string|max:20',
            'photo'         => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'department_id' => 'nullable|exists:departments,id',
            // Tambahkan validasi lain sesuai kebutuhan
        ]);

        $employee = Employee::findOrFail($id);

        // Handle upload foto baru jika ada
        if ($request->hasFile('photo')) {
            if ($employee->photo && file_exists(storage_path('app/public/' . $employee->photo))) {
                unlink(storage_path('app/public/' . $employee->photo));
            }

            $path = $request->file('photo')->store('employees', 'public');
            $employee->photo = $path;
        }

        // Update semua kolom kecuali photo (karena sudah diproses manual)
        $employee->update($request->except('photo', 'employee_id') + ['photo' => $employee->photo]);

        return redirect()->route('employees.index')->with('success', '✅ Data karyawan berhasil diperbarui.');
    }



}

    

