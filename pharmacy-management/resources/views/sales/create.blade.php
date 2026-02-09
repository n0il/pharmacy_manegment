@extends('layouts.app')

@section('title', 'Нова продажба')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Нова продажба</h1>
    <a href="{{ route('sales.index') }}" class="text-blue-600 hover:text-blue-800">
        <i class="fas fa-arrow-left mr-2"></i>Обратно към продажби
    </a>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <form action="{{ route('sales.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Лекарство *</label>
                <select name="medicine_id" required id="medicineSelect"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Изберете лекарство</option>
                    @foreach($medicines as $medicine)
                        <option value="{{ $medicine->id }}" 
                                data-price="{{ $medicine->price }}"
                                data-stock="{{ $medicine->quantity_in_stock }}"
                                data-prescription="{{ $medicine->prescription_required ? 'true' : 'false' }}">
                            {{ $medicine->name }} - {{ $medicine->quantity_in_stock }} бр. - {{ number_format($medicine->price, 2) }} лв.
                        </option>
                    @endforeach
                </select>
                @error('medicine_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Количество *</label>
                <input type="number" name="quantity" min="1" required id="quantityInput"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('quantity')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500" id="stockInfo"></p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Единична цена</label>
                <input type="text" id="unitPrice" readonly
                       class="w-full px-4 py-2 border rounded-lg bg-gray-50">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Обща цена</label>
                <input type="text" id="totalPrice" readonly
                       class="w-full px-4 py-2 border rounded-lg bg-gray-50 font-semibold">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Име на клиент</label>
                <input type="text" name="customer_name" 
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                       value="{{ old('customer_name') }}">
                @error('customer_name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">ЕГН на клиент</label>
                <input type="text" name="customer_egn" maxlength="10" pattern="[0-9]{10}"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                       value="{{ old('customer_egn') }}">
                @error('customer_egn')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Рецепта (PDF или изображение)</label>
                <input type="file" name="prescription_file" accept="application/pdf,image/*" 
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                       id="prescriptionFile">
                @error('prescription_file')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">Позволени формати: PDF, JPEG, PNG (макс. 2MB)</p>
                <p class="mt-1 text-sm text-yellow-600" id="prescriptionWarning" style="display: none;">
                    <i class="fas fa-exclamation-triangle mr-1"></i>
                    Това лекарство изисква рецепта. Моля качете рецепта.
                </p>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Бележки</label>
                <textarea name="notes" rows="3" 
                          class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('notes') }}</textarea>
                @error('notes')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mt-6 flex justify-end gap-4">
            <a href="{{ route('sales.index') }}" 
               class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                Отказ
            </a>
            <button type="submit" id="submitBtn"
                    class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                Запази продажба
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const medicineSelect = document.getElementById('medicineSelect');
    const quantityInput = document.getElementById('quantityInput');
    const unitPriceInput = document.getElementById('unitPrice');
    const totalPriceInput = document.getElementById('totalPrice');
    const stockInfo = document.getElementById('stockInfo');
    const prescriptionFile = document.getElementById('prescriptionFile');
    const prescriptionWarning = document.getElementById('prescriptionWarning');
    const submitBtn = document.getElementById('submitBtn');

    function updateCalculation() {
        const selectedOption = medicineSelect.options[medicineSelect.selectedIndex];
        const price = parseFloat(selectedOption.dataset.price) || 0;
        const stock = parseInt(selectedOption.dataset.stock) || 0;
        const quantity = parseInt(quantityInput.value) || 0;
        const requiresPrescription = selectedOption.dataset.prescription === 'true';

        unitPriceInput.value = price ? price.toFixed(2) + ' лв.' : '';
        totalPriceInput.value = (price * quantity).toFixed(2) + ' лв.';
        
        stockInfo.textContent = `Наличност: ${stock} бр.`;
        stockInfo.className = stock < quantity ? 'mt-1 text-sm text-red-600' : 'mt-1 text-sm text-gray-500';

        if (requiresPrescription) {
            prescriptionWarning.style.display = 'block';
            prescriptionFile.required = true;
        } else {
            prescriptionWarning.style.display = 'none';
            prescriptionFile.required = false;
        }
    }

    medicineSelect.addEventListener('change', updateCalculation);
    quantityInput.addEventListener('input', updateCalculation);

    // Form validation
    document.querySelector('form').addEventListener('submit', function(e) {
        const selectedOption = medicineSelect.options[medicineSelect.selectedIndex];
        const requiresPrescription = selectedOption.dataset.prescription === 'true';
        
        if (requiresPrescription && !prescriptionFile.files.length) {
            e.preventDefault();
            alert('Това лекарство изисква рецепта. Моля качете рецепта.');
            prescriptionFile.focus();
            return false;
        }
    });
});
</script>
@endsection
