@extends('layouts.app')

@section('title', 'Edit Order Form')
@section('content')


<div class="mx-auto w-full max-w-4xl p-2 sm:p-6">
    <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
        <div class="bg-gradient-to-r from-green-600 to-emerald-500 p-6">
            <h2 class="text-center text-2xl font-bold text-white tracking-wide">
                တင်ပို့ကုန်အချက်လက်ပြင်ဆင်ရန်
            </h2>
        </div>

        {{-- Success/Error Modal Logic --}}
        @if(session('success') || session('error'))
        <div x-data="{ show: true }" x-show="show" class="fixed inset-0 z-[100] flex items-start my-3 justify-center px-4">
            <div class="bg-white/90 backdrop-blur-xl p-8 rounded-3xl shadow-2xl border border-white max-w-sm w-full text-center">
                <div class="mb-4 text-6xl">
                    @if(session('success'))
                    <i class="fa-solid fa-check text-2xl text-green-600"></i>
                    @else
                    <i class="fa-solid fa-xmark text-2xl text-red-600"></i>
                    @endif
                </div>
                <p class="font-bold text-lg mb-6
                    {{ session('success')? 'text-green-700' : 'text-red-700' }}">
                    {{ session('success') ?? session('error') }}
                </p>
                <button @click="show = false" class="w-full py-3 bg-slate-900 text-white rounded-xl font-bold">
                    Done
                </button>
            </div>
        </div>
        @endif

        <form class="p-6 sm:p-8" action="{{ route('orders.update',$order->id) }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-6 gap-x-6 gap-y-5">

                <div class="md:col-span-3">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">တင်ပို့သည့်ရက်စွဲ</label>
                    <input type="date" name="export_date" required
                        class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                        value="{{ $order->export_date }}">
                </div>

                <div class="md:col-span-3">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">ပွဲရုံ</label>
                    <select name="source_area_id" required
                        class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all">
                        <option value="{{$order->source_area_id}}">{{ $order->sourceArea->name }}</option>
                        @foreach($areas as $area)
                        @if($area->id != $order->source_area_id)
                        <option value="{{ $area->id }}">{{ $area->name }}</option>
                        @endif
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-3">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">ကုန်အမျိုးအစား</label>
                    <input type="text" step="0.01" id="category" readonly
                        value="{{$order->category->name}}"
                        class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                </div>

                <div class="md:col-span-3">
                    <label for="productName" class="block text-sm font-semibold text-gray-700 mb-1">ကုန်အမည်</label>
                    <select name="product_name" id="productName" class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all" required>
                        <option value="{{$order->product_name}}">{{$order->product_name}}</option>
                        @foreach($products as $product)
                        @if($product->name != $order->product_name)
                        <option value="{{$product->name}}">{{$product->name}}</option>
                        @endif
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label for="weight" class="block text-sm font-semibold text-gray-700 mb-1">အတိုက်ချိန် (ပိဿာ)</label>
                    <input type="number" step="0.01" name="weight" id="weight" placeholder="0.00" required 
                        value="{{$order->weight}}"
                        class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                </div>

                <div class="md:col-span-2">
                    <label for="netweight" class="block text-sm font-semibold text-gray-700 mb-1">အသားချိန် (ပိဿာ)</label>
                    <input type="number" step="0.01" name="netweight" id="netweight" placeholder="0.00" required 
                        value="{{$order->net_weight}}"
                        class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                </div>

                <div class="md:col-span-2">
                    <label for="unit" class="block text-sm font-semibold text-gray-700 mb-1">ယူနစ်</label>
                    <select name="unit_id" required 
                        id="unit" 
                        class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        <option value="{{ $order->unit->id }}">{{ $order->unit->name }}</option>
                        @foreach($units as $unit)
                        @if($unit->id !== $order->unit_id)
                        <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                        @endif
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label for="price" class="block text-sm font-semibold text-gray-700 mb-1">စျေးနှုန်း (၁ ပိဿာ)</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">Ks</span>
                        <input type="number" name="price" id="price" required 
                            value="{{$order->price}}"
                            class="w-full pl-10 rounded-lg border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    </div>
                </div>

                <div class="md:col-span-4">
                    <label for="total" class="block text-sm font-semibold text-emerald-700 mb-1">စုစုပေါင်းကျသင့်ငွေ</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-emerald-600 font-bold">Ks</span>
                        <input type="text" id="total" name="total" readonly 
                            value="{{$order->total}}"
                            class="w-full pl-10 bg-emerald-50 border-emerald-200 text-emerald-700 font-bold rounded-lg cursor-not-allowed">
                    </div>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">အရေအတွက်</label>
                    <input type="number" name="count" id="count" placeholder="eg. 1" value="{{ $order->count }}" required
                        class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                </div>

                <div class="md:col-span-3">
                    <label for="gate" class="block text-sm font-semibold text-gray-700 mb-1">ဂိတ်</label>
                    <select name="gate_id" id="gate" required
                        class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        <option value="{{$order->gate_id}}">{{ $order->gate->name }}</option>
                        @foreach($gates as $gate)
                        @if($gate->id != $order->gate_id)
                        <option value="{{ $gate->id }}">{{ $gate->name }}</option>
                        @endif
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-3">
                    <label for="weight_price" class="block text-sm font-semibold text-gray-700 mb-1">တန်ဆာခ</label>
                    <input type="number" name="weight_price" placeholder="0" 
                        value="{{$order->weightfee}}" id="weight_price"
                        class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                </div>

                {{-- @if(isset($order->shop_id))
                <div class="md:col-span-6">
                    <label for="shop" class="block text-sm font-semibold text-gray-700 mb-1">ပို့ဆောင်မည့်ဆိုင် (Refer To)</label>
                    <select name="shop_id" id="shop" class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        <option value="{{$order->shop_id}}">{{$order->shop->name}}</option>
                        @foreach($shops as $shop)
                        @if($shop->id != $order->shop_id)
                        <option value="{{ $shop->id }}">{{ $shop->name }}</option>
                        @endif
                        @endforeach
                    </select>
                </div>
                @endif --}}
            </div>

            <div class="mt-8">
                <button type="submit"
                    class="w-full block bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-md shadow-lg hover:shadow-xl transform transition hover:-translate-y-0.5 active:scale-95">
                    <i class="fa-regular fa-floppy-disk"></i> သိမ်းမည်
                </button>
                <a href="{{ url('/user/'.auth()->user()->id.'/orders') }}" 
                    class="w-full block mt-3 text-center text-white bg-[#e92e4a] font-bold py-3 px-6 rounded-md">
                    <i class="fa-solid fa-xmark"></i> ပယ်ဖျက်မည်
                </a>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    $(document).ready(function() {
        const baseUrl = "{{ url('') }}";

        // 1️⃣ Category → Product AJAX
        $('#category').on('change', function() {
            const categoryId = $(this).val();
            $('#product').html('<option value="">ကုန်အမည်ရွေးပါ</option>');

            if (categoryId) {
                $.ajax({
                    url: baseUrl + '/api/products/' + categoryId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(res) {
                        $.each(res, function(_, product) {
                            $('#product').append('<option value="' + product.name + '">' + product.name + '</option>');
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', error);
                    }
                });
            }
        });

        // 2️⃣ Price Calculation
        function calculateTotal() {
            const price = parseFloat($('#price').val().replace(/[^\d.]/g, '')) || 0;
            const netWeight = parseFloat($('#netweight').val().replace(/[^\d.]/g, '')) || 0;
            $('#total').val((price * netWeight).toFixed(2));
        }

        $('#price, #netweight').on('input', calculateTotal);
    });
</script>

<!--product css and products js-->
@endsection