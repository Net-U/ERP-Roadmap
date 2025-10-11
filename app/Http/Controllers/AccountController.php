<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function create()
    {
        // Ambil karyawan yang belum punya akun (user_id kosong)
        $employees = Employee::whereNull('user_id')->get();
        return view('makeakun.akun', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        // Ambil data karyawan yang dipilih
        $employee = Employee::findOrFail($request->employee_id);

        // pastikan identity_number tidak null
        $username = $employee->identity_number ?? explode('@', $request->email)[0];

        // Simpan ke tabel users
        $user = User::create([
            'name' => $employee->name,
            'username' => $username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        // Update kolom user_id di tabel employees
        $employee->user_id = $user->id;
        $employee->save();

        return redirect()->back()->with('success', '✅ Akun berhasil dibuat untuk karyawan.');
    }
}
