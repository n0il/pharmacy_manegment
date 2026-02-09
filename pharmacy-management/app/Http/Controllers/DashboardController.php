<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\Sale;
use App\Models\Delivery;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalMedicines = Medicine::count();
        $lowStockMedicines = Medicine::where('quantity_in_stock', '<=', 'min_quantity')->count();
        $expiredMedicines = Medicine::where('expiry_date', '<', now())->count();
        
        $todaySales = Sale::whereDate('created_at', today())->sum('total_price');
        $monthSales = Sale::whereMonth('created_at', now()->month)
                         ->whereYear('created_at', now()->year)
                         ->sum('total_price');
        
        $todaySalesCount = Sale::whereDate('created_at', today())->count();
        $monthSalesCount = Sale::whereMonth('created_at', now()->month)
                              ->whereYear('created_at', now()->year)
                              ->count();
        
        $pendingDeliveries = Delivery::where('status', 'pending')->count();
        $overdueDeliveries = Delivery::where('status', 'pending')
                                    ->where('expected_delivery_date', '<', now())
                                    ->count();
        
        $recentSales = Sale::with(['medicine', 'user'])
                          ->latest()
                          ->take(5)
                          ->get();
        
        $lowStockItems = Medicine::where('quantity_in_stock', '<=', 'min_quantity')
                                ->orderBy('quantity_in_stock', 'asc')
                                ->take(5)
                                ->get();
        
        $upcomingDeliveries = Delivery::where('status', 'pending')
                                     ->orderBy('expected_delivery_date', 'asc')
                                     ->take(5)
                                     ->get();
        
        return view('dashboard', compact(
            'totalMedicines',
            'lowStockMedicines',
            'expiredMedicines',
            'todaySales',
            'monthSales',
            'todaySalesCount',
            'monthSalesCount',
            'pendingDeliveries',
            'overdueDeliveries',
            'recentSales',
            'lowStockItems',
            'upcomingDeliveries'
        ));
    }
}
