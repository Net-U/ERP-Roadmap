<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Grade;
use App\Models\Department;
use App\Models\Position;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    // Untuk register dari auth bawaan (user biasa)
    public function index()
    {
        return view('register.index', [
            'title' => 'register',
            'active' => 'register'
        ]);
    }

    // Untuk form registrasi karyawan (dari dashboard)
    public function create()
    {
        return view('register.index', [
            'title'       => 'Register Karyawan',
            'active'      => 'register',
            'departments' => Department::all(),
            'positions'   => Position::all(),
            'grades'      => Grade::all(),
        ]);
    }    

    // Menyimpan data karyawan dari dashboard
    public function store(Request $request)
    {
        $rules = [
            // --- Data pribadi ---
            'name'            => 'required|max:255',
            'nrk'             => 'nullable|max:20|unique:employees,nrk',
            'nik_sap'         => 'nullable|max:20',
            'identity_number' => 'required|max:50|unique:employees,identity_number',
            'place_of_birth'  => 'nullable|max:100',
            'date_of_birth'   => 'nullable|date',
            'gender'          => 'nullable|in:Laki-laki,Perempuan',
            'religion'        => 'nullable|max:20',
            'blood_type'      => 'nullable|in:A,B,AB,O',

            // --- Kontak & alamat ---
            'email'           => 'required|email|unique:employees,email',
            'phone'           => 'nullable|max:20',
            'address'         => 'nullable|max:255',
            'district'        => 'nullable|max:100',
            'city'            => 'nullable|max:100',

            // --- Pekerjaan ---
            'join_date'       => 'required|date',
            'department_id'   => 'nullable|exists:departments,id',
            'position_id'     => 'nullable|exists:positions,id',
            'grade_id'        => 'nullable|exists:grades,id',
            'subdivision'     => 'nullable|max:100',

            // --- Pendidikan ---
            'education'       => 'nullable|max:100',
            'education_major' => 'nullable|max:100',

            // --- Status keluarga ---
            'marital_status'  => 'required|in:Lajang,Menikah',
            'spouse_name'     => 'nullable|max:255|required_if:marital_status,Menikah',
            'spouse_job'      => 'nullable|max:255|required_if:marital_status,Menikah',
            'children_count'  => 'nullable|integer|min:0|required_if:marital_status,Menikah',

            // --- Lain‑lain ---
            'bank_account'    => 'nullable|max:50',
            'bpjs_tk'         => 'nullable|max:50',
            'bpjs_ks'         => 'nullable|max:50',
            'npwp'            => 'nullable|max:50',

            // --- Vaksin (select 1/0) ---
            'vaccine_1'       => 'nullable|boolean',
            'vaccine_2'       => 'nullable|boolean',
            'vaccine_3'       => 'nullable|boolean',
        
            // --- Data Ahli Waris ---
            'heir_name'        => 'required|max:255',
            'heir_relationship'=> 'required|max:100',
            'heir_phone'       => 'nullable|max:20',
            'heir_address'     => 'nullable|max:255',

            // --- Foto ---
            'photo'           => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        // ✅ Validasi
        $data = $request->validate($rules);

        // ✅ Konversi select “1”/“0” → boolean (opsional; cast di model juga bisa)
        $data['vaccine_1'] = (bool) ($request->input('vaccine_1'));
        $data['vaccine_2'] = (bool) ($request->input('vaccine_2'));
        $data['vaccine_3'] = (bool) ($request->input('vaccine_3'));

        // ✅ Upload foto
        if ($request->file('photo')) {
            $data['photo'] = $request->file('photo')->store('photos', 'public');
        }

        // Jika login:
        // $data['user_id'] = auth()->id();

        Employee::create($data);

        return back()->with('success', 'Data karyawan berhasil ditambahkan!');
    }
    
    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        $positions = Position::all();

        return view('register.form', compact('employee', 'positions'));
    }
    
    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);

        $rules = [
            // --- Data pribadi ---
            'name'            => 'required|max:255',
            'nrk'             => 'nullable|max:20|unique:employees,nrk',
            'nik_sap'         => 'nullable|max:20',
            'identity_number' => 'required|max:50|unique:employees,identity_number',
            'place_of_birth'  => 'nullable|max:100',
            'date_of_birth'   => 'nullable|date',
            'gender'          => 'nullable|in:Laki-laki,Perempuan',
            'religion'        => 'nullable|max:20',
            'blood_type'      => 'nullable|in:A,B,AB,O',

            // --- Kontak & alamat ---
            'email'           => 'required|email|unique:employees,email',
            'phone'           => 'nullable|max:20',
            'address'         => 'nullable|max:255',
            'district'        => 'nullable|max:100',
            'city'            => 'nullable|max:100',

            // --- Pekerjaan ---
            'join_date'       => 'required|date',
            'department_id'   => 'nullable|exists:departments,id',
            'position_id'     => 'nullable|exists:positions,id',
            'grade_id'        => 'nullable|exists:grades,id',
            'subdivision'     => 'nullable|max:100',

            // --- Pendidikan ---
            'education'       => 'nullable|max:100',
            'education_major' => 'nullable|max:100',

            // --- Status keluarga ---
            'marital_status'  => 'required|in:Lajang,Menikah',
            'spouse_name'     => 'nullable|max:255|required_if:marital_status,Menikah',
            'spouse_job'      => 'nullable|max:255|required_if:marital_status,Menikah',
            'children_count'  => 'nullable|integer|min:0|required_if:marital_status,Menikah',

            // --- Lain‑lain ---
            'bank_account'    => 'nullable|max:50',
            'bpjs_tk'         => 'nullable|max:50',
            'bpjs_ks'         => 'nullable|max:50',
            'npwp'            => 'nullable|max:50',

            // --- Vaksin (select 1/0) ---
            'vaccine_1'       => 'nullable|boolean',
            'vaccine_2'       => 'nullable|boolean',
            'vaccine_3'       => 'nullable|boolean',
        
            // --- Data Ahli Waris ---
            'heir_name'        => 'required|max:255',
            'heir_relationship'=> 'required|max:100',
            'heir_phone'       => 'nullable|max:20',
            'heir_address'     => 'nullable|max:255',

            // --- Foto ---
            'photo'           => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        // ✅ Validasi
        $data = $request->validate($rules);

        // ✅ Konversi select “1”/“0” → boolean (opsional; cast di model juga bisa)
        $data['vaccine_1'] = (bool) ($request->input('vaccine_1'));
        $data['vaccine_2'] = (bool) ($request->input('vaccine_2'));
        $data['vaccine_3'] = (bool) ($request->input('vaccine_3'));

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
            $validated['photo'] = $photoPath;
        }

        $employee->update($validated);

        return redirect()->route('employees.index')->with('success', 'Data karyawan berhasil diperbarui.');
    }
}
