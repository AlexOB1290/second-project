@extends('layouts.app')

@section('content')
    <section class="py-16">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-3xl font-bold mb-6 text-center">Оформление заказа</h1>

            @if ($errors->any())
                <div class="bg-red-500 text-white p-4 mb-6 rounded-lg">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-500 text-white p-4 mb-6 rounded-lg">
                    <ul>
                        <li>{{ session('error') }}</li>
                    </ul>
                </div>
            @endif

            <form action="{{ route('order.store') }}" method="POST" class="bg-white shadow-lg rounded-lg p-6">
                @csrf

                <label for="phone" class="block text-sm font-medium text-gray-700 mt-2">Номер телефона:</label>
                <input
                    type="text"
                    name="phone"
                    id="phone"
                    class="mt-1 p-2 w-full border rounded-lg"
                    placeholder="Введите номер телефона"
                    value="{{ old('phone', $phone) }}"
                    required
                    pattern="^\+?[0-9]{10,15}$"
                    title="Номер телефона должен содержать только цифры, и может начинаться с +"
                />
                @error('phone')
                <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                @enderror

                <h2 class="text-xl font-semibold mb-4 mt-6">Выберите способ получения:</h2>
                <div class="space-y-2">
                    <label class="flex items-center">
                        <input type="radio" name="delivery_type" value="delivery" class="mr-2" required
                            {{ old('delivery_type') === 'delivery' ? 'checked' : '' }}>
                        Доставка
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="delivery_type" value="pickup" class="mr-2"
                            {{ old('delivery_type') === 'pickup' ? 'checked' : '' }}>
                        Самовывоз
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="delivery_type" value="local" class="mr-2"
                            {{ old('delivery_type') === 'local' ? 'checked' : '' }}>
                        На месте
                    </label>
                </div>

                <!-- Блок выбора сохраненного или нового адреса -->
                <div class="mt-4" id="address-section" style="display: none;">
                    <h2 class="text-lg font-semibold mb-2">Выберите сохраненный адрес или введите новый:</h2>

                    <label class="block mb-2">
                        <input type="radio" name="address_option" value="saved" class="mr-2"
                               checked>
                        Использовать сохраненный адрес
                    </label>

                    <div id="saved-address">
                        <label for="address_id" class="block text-sm font-medium text-gray-700">Выберите адрес:</label>
                        <select name="address_id" id="address_id" class="mt-1 p-2 w-full border rounded-lg">
                            @foreach ($addresses as $address)
                                <option value="{{ $address->id }}" {{ old('address_id') == $address->id ? 'selected' : '' }}>
                                    {{ $address->country }}, {{ $address->region }}, {{ $address->locality }},
                                    {{ $address->street }}, {{ $address->building_number }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <label class="block mt-4 mb-2">
                        <input type="radio" name="address_option" value="new" class="mr-2">
                        Ввести новый адрес
                    </label>

                    <div id="new-address" style="display: none;">
                        <label>Страна:</label>
                        <input type="text" name="country" class="mt-1 p-2 w-full border rounded-lg" value="{{ old('country') }}">

                        <label>Регион:</label>
                        <input type="text" name="region" class="mt-1 p-2 w-full border rounded-lg" value="{{ old('region') }}">

                        <label>Район:</label>
                        <input type="text" name="district" class="mt-1 p-2 w-full border rounded-lg" value="{{ old('district') }}">

                        <label>Населенный пункт:</label>
                        <input type="text" name="locality" class="mt-1 p-2 w-full border rounded-lg" value="{{ old('locality') }}">

                        <label>Улица:</label>
                        <input type="text" name="street" class="mt-1 p-2 w-full border rounded-lg" value="{{ old('street') }}">

                        <label>Номер дома:</label>
                        <input type="text" name="building_number" class="mt-1 p-2 w-full border rounded-lg" value="{{ old('building_number') }}">

                        <label>Квартира:</label>
                        <input type="text" name="flat_number" class="mt-1 p-2 w-full border rounded-lg" value="{{ old('flat_number') }}">
                    </div>
                </div>

                <h2 class="text-xl font-semibold mt-6 mb-4">Ваш заказ:</h2>
                @foreach ($cart as $product)
                    <div class="flex justify-between border-b py-2">
                        <span>{{ $product->name }} (x{{ $product->pivot->amount }})</span>
                        <span class="text-red-500">{{ number_format($product->price * $product->pivot->amount, 2, ',', ' ') }} ₽</span>
                    </div>
                @endforeach

                <div class="text-right mt-6">
                    <button type="submit" class="bg-green-600 text-white px-6 py-3 rounded-lg text-lg hover:bg-green-700 transition">
                        Подтвердить заказ
                    </button>
                </div>
            </form>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let addressSection = document.getElementById('address-section');
            let deliveryTypeRadios = document.querySelectorAll('input[name="delivery_type"]');
            let addressOptionRadios = document.querySelectorAll('input[name="address_option"]');
            let savedAddress = document.getElementById('saved-address');
            let newAddress = document.getElementById('new-address');

            function toggleAddressFields() {
                let selectedDeliveryType = document.querySelector('input[name="delivery_type"]:checked').value;
                if (selectedDeliveryType === 'delivery') {
                    addressSection.style.display = 'block';
                } else {
                    addressSection.style.display = 'none';
                }
            }

            function toggleNewAddressFields() {
                let selectedOption = document.querySelector('input[name="address_option"]:checked').value;
                if (selectedOption === 'new') {
                    newAddress.style.display = 'block';
                    savedAddress.style.display = 'none';
                } else {
                    newAddress.style.display = 'none';
                    savedAddress.style.display = 'block';
                }
            }

            deliveryTypeRadios.forEach(radio => {
                radio.addEventListener('change', toggleAddressFields);
            });

            addressOptionRadios.forEach(radio => {
                radio.addEventListener('change', toggleNewAddressFields);
            });

            // Вызываем функции сразу для корректного отображения при загрузке
            toggleAddressFields();
            toggleNewAddressFields();
        });
    </script>
@endsection
