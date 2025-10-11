<?php

namespace App\Http\Controllers;

use App\Models\Training;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrainingController extends Controller
{
    /**
     * Tampilkan daftar pelatihan
     */
    public function index()
    {
        $trainings = Training::with('employee')
            ->orderBy('start_date', 'desc')
            ->paginate(10);

        return view('training.training', compact('trainings'));
    }

    /**
     * Tampilkan form tambah pelatihan baru
     */
    public function create()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user(); // pakai facade Auth agar IDE lebih paham

        if ($user && $user->role === 'admin') {
            $employees = Employee::all();
            return view('training.create', compact('employees'));
        }

        return view('training.create');
    }

    /**
     * Simpan data pelatihan baru ke database
     */
    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'topic' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'laporan_pasca_pelatihan' => 'nullable|mimes:pdf|max:2048',
            'evaluasi_pasca_pelatihan' => 'nullable|mimes:pdf|max:2048',
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::id(); // gunakan Auth untuk konsistensi

        // Upload file laporan
        if ($request->hasFile('laporan_pasca_pelatihan')) {
            $data['laporan_pasca_pelatihan'] = $request
                ->file('laporan_pasca_pelatihan')
                ->store('laporan_pelatihan', 'public');
        }

        // Upload file evaluasi
        if ($request->hasFile('evaluasi_pasca_pelatihan')) {
            $data['evaluasi_pasca_pelatihan'] = $request
                ->file('evaluasi_pasca_pelatihan')
                ->store('evaluasi_pelatihan', 'public');
        }

        Training::create($data);

        return redirect()
            ->route('training.create')
            ->with('success', 'Pelatihan berhasil ditambahkan!');
    }
}
