<?php

namespace App\Http\Controllers;

use App\Models\Harvest;
use App\Models\Employee;
use App\Models\BlokKebun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HarvestController extends Controller
{
    public function create()
    {
        $employees = Employee::all();
        $blokKebun = BlokKebun::all();
        return view('harvest.create', compact('employees', 'blokKebun'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'blok_kebun_id' => 'required|exists:blok_kebun,id',
            'afd' => 'required|string|max:10',
            'kerja' => 'required|string|max:50',
            'ttl_janjang' => 'required|integer|min:1',
            'tonase' => 'required|numeric|min:0',
            'tanggal_panen' => 'required|date',
        ]);

        Harvest::create($request->all());
        return redirect()->route('admin.harvest.create')->with('success', 'Data hasil panen berhasil disimpan!');
    }
}
