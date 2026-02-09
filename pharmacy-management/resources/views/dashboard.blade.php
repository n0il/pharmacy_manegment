@extends('layouts.app')

@section('title', 'Табло за управление')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Medicines -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 bg-blue-100 rounded-full">
                <i class="fas fa-capsules text-blue-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-500">Общо лекарства</p>
                <p class="text-2xl font-semibold text-gray-800">{{ $totalMedicines }}</p>
            </div>
        </div>
    </div>
    
    <!-- Low Stock -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 bg-yellow-100 rounded-full">
                <i class="fas fa-exclamation-triangle text-yellow-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-500">Ниска наличност</p>
                <p class="text-2xl font-semibold text-gray-800">{{ $lowStockMedicines }}</p>
            </div>
        </div>
    </div>
    
    <!-- Expired Medicines -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 bg-red-100 rounded-full">
                <i class="fas fa-clock text-red-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-500">Изтекли лекарства</p>
                <p class="text-2xl font-semibold text-gray-800">{{ $expiredMedicines }}</p>
            </div>
        </div>
    </div>
    
    <!-- Pending Deliveries -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 bg-purple-100 rounded-full">
                <i class="fas fa-truck text-purple-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-500">Чакащи доставки</p>
                <p class="text-2xl font-semibold text-gray-800">{{ $pendingDeliveries }}</p>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Sales Statistics -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">
            <i class="fas fa-chart-line text-green-600 mr-2"></i>
            Продажби
        </h3>
        <div class="grid grid-cols-2 gap-4">
            <div class="text-center p-4 bg-green-50 rounded">
                <p class="text-sm text-gray-600">Днес</p>
                <p class="text-xl font-bold text-green-600">{{ number_format($todaySales, 2) }} лв.</p>
                <p class="text-xs text-gray-500">{{ $todaySalesCount }} продажби</p>
            </div>
            <div class="text-center p-4 bg-blue-50 rounded">
                <p class="text-sm text-gray-600">Този месец</p>
                <p class="text-xl font-bold text-blue-600">{{ number_format($monthSales, 2) }} лв.</p>
                <p class="text-xs text-gray-500">{{ $monthSalesCount }} продажби</p>
            </div>
        </div>
    </div>
    
    <!-- Delivery Status -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">
            <i class="fas fa-truck-loading text-purple-600 mr-2"></i>
            Статус на доставките
        </h3>
        <div class="grid grid-cols-2 gap-4">
            <div class="text-center p-4 bg-yellow-50 rounded">
                <p class="text-sm text-gray-600">Чакащи</p>
                <p class="text-xl font-bold text-yellow-600">{{ $pendingDeliveries }}</p>
            </div>
            <div class="text-center p-4 bg-red-50 rounded">
                <p class="text-sm text-gray-600">Закъснели</p>
                <p class="text-xl font-bold text-red-600">{{ $overdueDeliveries }}</p>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Recent Sales -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">
            <i class="fas fa-shopping-cart text-blue-600 mr-2"></i>
            Последни продажби
        </h3>
        <div class="space-y-3">
            @forelse($recentSales as $sale)
                <div class="flex justify-between items-center p-3 bg-gray-50 rounded">
                    <div>
                        <p class="font-medium text-gray-800">{{ $sale->medicine->name }}</p>
                        <p class="text-xs text-gray-500">{{ $sale->created_at->format('d.m.Y H:i') }}</p>
                    </div>
                    <div class="text-right">
                        <p class="font-semibold text-green-600">{{ number_format($sale->total_price, 2) }} лв.</p>
                        <p class="text-xs text-gray-500">{{ $sale->quantity }} бр.</p>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 text-center">Няма продажби</p>
            @endforelse
        </div>
    </div>
    
    <!-- Low Stock Items -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">
            <i class="fas fa-exclamation-triangle text-yellow-600 mr-2"></i>
            Лекарства с ниска наличност
        </h3>
        <div class="space-y-3">
            @forelse($lowStockItems as $medicine)
                <div class="flex justify-between items-center p-3 bg-yellow-50 rounded">
                    <div>
                        <p class="font-medium text-gray-800">{{ $medicine->name }}</p>
                        <p class="text-xs text-gray-500">Минимум: {{ $medicine->min_quantity }} бр.</p>
                    </div>
                    <div class="text-right">
                        <p class="font-semibold text-yellow-600">{{ $medicine->quantity_in_stock }} бр.</p>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 text-center">Всички лекарства са в наличност</p>
            @endforelse
        </div>
    </div>
    
    <!-- Upcoming Deliveries -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">
            <i class="fas fa-calendar text-purple-600 mr-2"></i>
            Предстоящи доставки
        </h3>
        <div class="space-y-3">
            @forelse($upcomingDeliveries as $delivery)
                <div class="p-3 bg-purple-50 rounded">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="font-medium text-gray-800">{{ $delivery->delivery_number }}</p>
                            <p class="text-xs text-gray-500">{{ $delivery->supplier_name }}</p>
                        </div>
                        <span class="px-2 py-1 text-xs rounded-full bg-purple-200 text-purple-800">
                            {{ $delivery->expected_delivery_date->format('d.m.Y') }}
                        </span>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 text-center">Няма предстоящи доставки</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
