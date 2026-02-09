<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Models\DeliveryItem;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeliveryController extends Controller
{
    public function index()
    {
        $deliveries = Delivery::with('deliveryItems.medicine')
                            ->latest()
                            ->paginate(15);
        return view('deliveries.index', compact('deliveries'));
    }

    public function create()
    {
        $medicines = Medicine::orderBy('name')->get();
        return view('deliveries.create', compact('medicines'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplier_name' => 'required|string|max:255',
            'expected_delivery_date' => 'required|date|after:today',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.medicine_id' => 'required|exists:medicines,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.expiry_date' => 'required|date|after:today',
            'items.*.batch_number' => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            $totalAmount = 0;
            foreach ($validated['items'] as $item) {
                $totalAmount += $item['quantity'] * $item['unit_price'];
            }

            $delivery = Delivery::create([
                'delivery_number' => 'DEL-' . date('Y') . '-' . str_pad(Delivery::count() + 1, 4, '0', STR_PAD_LEFT),
                'supplier_name' => $validated['supplier_name'],
                'expected_delivery_date' => $validated['expected_delivery_date'],
                'status' => 'pending',
                'total_amount' => $totalAmount,
                'notes' => $validated['notes'],
            ]);

            foreach ($validated['items'] as $item) {
                DeliveryItem::create([
                    'delivery_id' => $delivery->id,
                    'medicine_id' => $item['medicine_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'total_price' => $item['quantity'] * $item['unit_price'],
                    'expiry_date' => $item['expiry_date'],
                    'batch_number' => $item['batch_number'],
                ]);
            }

            DB::commit();

            return redirect()->route('deliveries.index')
                ->with('success', 'Доставката е създадена успешно.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Възникна грешка при създаване на доставката.');
        }
    }

    public function show(Delivery $delivery)
    {
        $delivery->load('deliveryItems.medicine');
        return view('deliveries.show', compact('delivery'));
    }

    public function edit(Delivery $delivery)
    {
        if ($delivery->status === 'delivered') {
            return back()->with('error', 'Приетите доставки не могат да се редактират.');
        }

        $delivery->load('deliveryItems.medicine');
        $medicines = Medicine::orderBy('name')->get();
        return view('deliveries.edit', compact('delivery', 'medicines'));
    }

    public function update(Request $request, Delivery $delivery)
    {
        if ($delivery->status === 'delivered') {
            return back()->with('error', 'Приетите доставки не могат да се редактират.');
        }

        $validated = $request->validate([
            'supplier_name' => 'required|string|max:255',
            'expected_delivery_date' => 'required|date|after:today',
            'notes' => 'nullable|string',
            'status' => 'required|in:pending,delivered,cancelled',
        ]);

        $delivery->update($validated);

        if ($delivery->status === 'delivered' && !$delivery->actual_delivery_date) {
            $delivery->update(['actual_delivery_date' => now()]);
            
            foreach ($delivery->deliveryItems as $item) {
                $medicine = $item->medicine;
                $medicine->increment('quantity_in_stock', $item->quantity);
            }
        }

        return redirect()->route('deliveries.index')
            ->with('success', 'Доставката е обновена успешно.');
    }

    public function destroy(Delivery $delivery)
    {
        if ($delivery->status === 'delivered') {
            return back()->with('error', 'Приетите доставки не могат да се изтриват.');
        }

        $delivery->delete();

        return redirect()->route('deliveries.index')
            ->with('success', 'Доставката е изтрита успешно.');
    }

    public function receive(Delivery $delivery)
    {
        if ($delivery->status !== 'pending') {
            return back()->with('error', 'Само чакащи доставки могат да бъдат приети.');
        }

        DB::beginTransaction();
        try {
            $delivery->update([
                'status' => 'delivered',
                'actual_delivery_date' => now(),
            ]);

            foreach ($delivery->deliveryItems as $item) {
                $medicine = $item->medicine;
                $medicine->increment('quantity_in_stock', $item->quantity);
            }

            DB::commit();

            return redirect()->route('deliveries.index')
                ->with('success', 'Доставката е приета успешно.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Възникна грешка при приемане на доставката.');
        }
    }
}
