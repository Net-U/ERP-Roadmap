<?php

namespace App\Http\Controllers;

use App\Models\Harvest;
use App\Models\Employee;
use App\Models\BlokKebun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HarvestController extends Controller
{
    /**
     * Tampilkan form input panen
     */
    public function create()
    {
        $employees = Employee::all();
        $blokKebun = BlokKebun::all();
        return view('harvest.create', compact('employees', 'blokKebun'));
    }

    /**
     * Simpan data hasil panen ke database
     */
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

        Harvest::create($request->only([
            'employee_id',
            'blok_kebun_id',
            'afd',
            'kerja',
            'ttl_janjang',
            'tonase',
            'tanggal_panen'
        ]));

        return redirect()
            ->route('harvest.create')
            ->with('success', 'Data hasil panen berhasil disimpan!');
    }

    /**
     * Menampilkan daftar hasil panen (dengan filter tanggal opsional)
     */
    public function index(Request $request)
    {
        $query = Harvest::with(['employee', 'blokKebun'])
            ->orderByDesc('tanggal_panen');

        // Filter tanggal jika ada input
        if ($request->filled('tanggal_panen')) {
            $query->whereDate('tanggal_panen', $request->tanggal_panen);
        }

        $harvests = $query->paginate(10);

        return view('harvest.index', compact('harvests'));
    }

    /**
     * API statistik hasil panen (untuk dashboard bottom bar)
     */

public function getStats()
{
    $today = Carbon::today();

    // === Data hari ini ===
    $todayHarvest = Harvest::whereDate('tanggal_panen', $today)
        ->selectRaw('COALESCE(SUM(ttl_janjang),0) as total_janjang, COALESCE(SUM(tonase),0) as total_tonase')
        ->first();

    // === 3 hari terakhir (termasuk hari ini) ===
    $startDate = Carbon::today()->subDays(2); // H-2 + H-1 + Hari ini = total 3 hari
    $endDate = Carbon::today()->endOfDay();

    $recentDays = Harvest::whereBetween('tanggal_panen', [$startDate, $endDate])
        ->select(
            DB::raw('DATE(tanggal_panen) as date'),
            DB::raw('SUM(ttl_janjang) as total_janjang'),
            DB::raw('SUM(tonase) as total_tonase')
        )
        ->groupBy(DB::raw('DATE(tanggal_panen)'))
        ->orderBy('date', 'asc')
        ->get();

    // === Rekap bulanan ===
    $monthly = Harvest::select(
            DB::raw('MONTH(tanggal_panen) as month'),
            DB::raw('SUM(tonase) as total_tonase')
        )
        ->groupBy(DB::raw('MONTH(tanggal_panen)'))
        ->orderBy('month', 'asc')
        ->get();

    return response()->json([
        'today' => $todayHarvest ?? ['total_janjang' => 0, 'total_tonase' => 0],
        'recent' => $recentDays ?? [],
        'monthly' => $monthly ?? [],
    ]);
}


}
