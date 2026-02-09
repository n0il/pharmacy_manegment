@extends('layouts.app')

@section('title', 'Ново лекарство')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Ново лекарство</h1>
    <a href="{{ route('medicines.index') }}" class="text-blue-600 hover:text-blue-800">
        <i class="fas fa-arrow-left mr-2"></i>Обратно към лекарства
    </a>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <form action="{{ route('medicines.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Име на лекарство *</label>
                <input type="text" name="name" required 
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                       value="{{ old('name') }}">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Производител *</label>
                <input type="text" name="manufacturer" required 
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                       value="{{ old('manufacturer') }}">
                @error('manufacturer')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Баркод *</label>
                <input type="text" name="barcode" required 
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                       value="{{ old('barcode') }}">
                @error('barcode')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Цена (лв.) *</label>
                <input type="number" name="price" step="0.01" min="0" required 
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                       value="{{ old('price') }}">
                @error('price')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Количество в склад *</label>
                <input type="number" name="quantity_in_stock" min="0" required 
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                       value="{{ old('quantity_in_stock') }}">
                @error('quantity_in_stock')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Минимално количество *</label>
                <input type="number" name="min_quantity" min="0" required 
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                       value="{{ old('min_quantity', 10) }}">
                @error('min_quantity')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Категория *</label>
                <input type="text" name="category" required 
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                       value="{{ old('category') }}">
                @error('category')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Активно вещество *</label>
                <input type="text" name="active_substance" required 
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                       value="{{ old('active_substance') }}">
                @error('active_substance')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Дозировка *</label>
                <div class="flex gap-2">
                    <input type="number" name="dosage" step="0.01" min="0" required 
                           class="flex-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           value="{{ old('dosage') }}">
                    <input type="text" name="dosage_unit" required placeholder="мг, мл, etc."
                           class="w-20 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           value="{{ old('dosage_unit') }}">
                </div>
                @error('dosage')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                @error('dosage_unit')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Срок на годност *</label>
                <input type="date" name="expiry_date" required 
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                       value="{{ old('expiry_date') }}">
                @error('expiry_date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Описание</label>
                <textarea name="description" rows="3" 
                          class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Снимка</label>
                <input type="file" name="image" accept="image/*" 
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('image')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">Позволени формати: JPEG, PNG, GIF (макс. 2MB)</p>
            </div>

            <div>
                <label class="flex items-center">
                    <input type="checkbox" name="prescription_required" value="1" 
                           class="mr-2 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                           {{ old('prescription_required') ? 'checked' : '' }}>
                    <span class="text-sm font-medium text-gray-700">Изисква рецепта</span>
                </label>
            </div>
        </div>

        <div class="mt-6 flex justify-end gap-4">
            <a href="{{ route('medicines.index') }}" 
               class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                Отказ
            </a>
            <button type="submit" 
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                Запази
            </button>
        </div>
    </form>
</div>
@endsection
