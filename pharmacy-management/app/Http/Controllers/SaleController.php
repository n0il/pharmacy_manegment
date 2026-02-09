<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with(['medicine', 'user'])
                    ->latest()
                    ->paginate(15);
        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        $medicines = Medicine::where('quantity_in_stock', '>', 0)
                            ->orderBy('name')
                            ->get();
        return view('sales.create', compact('medicines'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'medicine_id' => 'required|exists:medicines,id',
            'quantity' => 'required|integer|min:1',
            'customer_name' => 'nullable|string|max:255',
            'customer_egn' => 'nullable|string|digits:10',
            'prescription_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'notes' => 'nullable|string',
        ]);

        $medicine = Medicine::findOrFail($validated['medicine_id']);

        if ($medicine->quantity_in_stock < $validated['quantity']) {
            return back()->with('error', 'Недостатъчна наличност за тази продажба.');
        }

        if ($request->hasFile('prescription_file')) {
            $filePath = $request->file('prescription_file')->store('prescriptions', 'public');
            $validated['prescription_file'] = $filePath;
        }

        $validated['user_id'] = auth()->id();
        $validated['unit_price'] = $medicine->price;
        $validated['total_price'] = $medicine->price * $validated['quantity'];

        DB::beginTransaction();
        try {
            $sale = Sale::create($validated);
            
            $medicine->decrement('quantity_in_stock', $validated['quantity']);
            
            DB::commit();
            
            return redirect()->route('sales.index')
                ->with('success', 'Продажбата е записана успешно.');
        } catch (\Exception $e) {
            DB::rollback();
            
            if (isset($validated['prescription_file'])) {
                Storage::disk('public')->delete($validated['prescription_file']);
            }
            
            return back()->with('error', 'Възникна грешка при запис на продажбата.');
        }
    }

    public function show(Sale $sale)
    {
        $sale->load(['medicine', 'user']);
        return view('sales.show', compact('sale'));
    }

    public function edit(Sale $sale)
    {
        return back()->with('error', 'Продажбите не могат да се редактират.');
    }

    public function update(Request $request, Sale $sale)
    {
        return back()->with('error', 'Продажбите не могат да се редактират.');
    }

    public function destroy(Sale $sale)
    {
        DB::beginTransaction();
        try {
            $medicine = $sale->medicine;
            $medicine->increment('quantity_in_stock', $sale->quantity);
            
            if ($sale->prescription_file) {
                Storage::disk('public')->delete($sale->prescription_file);
            }
            
            $sale->delete();
            
            DB::commit();
            
            return redirect()->route('sales.index')
                ->with('success', 'Продажбата е изтрита успешно.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Възникна грешка при изтриване на продажбата.');
        }
    }

    public function reports()
    {
        $todaySales = Sale::whereDate('created_at', today())
                         ->with(['medicine', 'user'])
                         ->get();
        
        $monthSales = Sale::whereMonth('created_at', now()->month)
                         ->whereYear('created_at', now()->year)
                         ->with(['medicine', 'user'])
                         ->get();
        
        $topMedicines = Sale::select('medicine_id', 
                                   DB::raw('COUNT(*) as sales_count'),
                                   DB::raw('SUM(quantity) as total_quantity'),
                                   DB::raw('SUM(total_price) as total_revenue'))
                           ->with('medicine')
                           ->groupBy('medicine_id')
                           ->orderBy('total_revenue', 'desc')
                           ->limit(10)
                           ->get();
        
        $dailyStats = Sale::select(DB::raw('DATE(created_at) as date'),
                                 DB::raw('COUNT(*) as sales_count'),
                                 DB::raw('SUM(total_price) as total_revenue'))
                         ->whereDate('created_at', '>=', now()->subDays(30))
                         ->groupBy(DB::raw('DATE(created_at)'))
                         ->orderBy('date', 'desc')
                         ->get();
        
        return view('sales.reports', compact(
            'todaySales', 
            'monthSales', 
            'topMedicines', 
            'dailyStats'
        ));
    }
}
