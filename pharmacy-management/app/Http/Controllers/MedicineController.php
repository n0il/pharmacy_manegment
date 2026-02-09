<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class MedicineController extends Controller
{
    public function index()
    {
        $medicines = Medicine::orderBy('name')->paginate(15);
        return view('medicines.index', compact('medicines'));
    }

    public function create()
    {
        return view('medicines.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'manufacturer' => 'required|string|max:255',
            'barcode' => 'required|string|unique:medicines,barcode',
            'price' => 'required|numeric|min:0',
            'quantity_in_stock' => 'required|integer|min:0',
            'min_quantity' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'prescription_required' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'expiry_date' => 'required|date|after:today',
            'category' => 'required|string|max:255',
            'active_substance' => 'required|string|max:255',
            'dosage' => 'required|numeric|min:0',
            'dosage_unit' => 'required|string|max:50',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('medicines', 'public');
            $validated['image_path'] = $imagePath;
        }

        $validated['prescription_required'] = $request->has('prescription_required');

        Medicine::create($validated);

        return redirect()->route('medicines.index')
            ->with('success', 'Лекарството е добавено успешно.');
    }

    public function show(Medicine $medicine)
    {
        return view('medicines.show', compact('medicine'));
    }

    public function edit(Medicine $medicine)
    {
        return view('medicines.edit', compact('medicine'));
    }

    public function update(Request $request, Medicine $medicine)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'manufacturer' => 'required|string|max:255',
            'barcode' => ['required', 'string', Rule::unique('medicines')->ignore($medicine->id)],
            'price' => 'required|numeric|min:0',
            'quantity_in_stock' => 'required|integer|min:0',
            'min_quantity' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'prescription_required' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'expiry_date' => 'required|date|after:today',
            'category' => 'required|string|max:255',
            'active_substance' => 'required|string|max:255',
            'dosage' => 'required|numeric|min:0',
            'dosage_unit' => 'required|string|max:50',
        ]);

        if ($request->hasFile('image')) {
            if ($medicine->image_path) {
                Storage::disk('public')->delete($medicine->image_path);
            }
            $imagePath = $request->file('image')->store('medicines', 'public');
            $validated['image_path'] = $imagePath;
        }

        $validated['prescription_required'] = $request->has('prescription_required');

        $medicine->update($validated);

        return redirect()->route('medicines.index')
            ->with('success', 'Лекарството е обновено успешно.');
    }

    public function destroy(Medicine $medicine)
    {
        if ($medicine->image_path) {
            Storage::disk('public')->delete($medicine->image_path);
        }
        
        $medicine->delete();

        return redirect()->route('medicines.index')
            ->with('success', 'Лекарството е изтрито успешно.');
    }
}
