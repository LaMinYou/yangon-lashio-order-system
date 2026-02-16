@extends("layouts.app")

@section("title", "Orders")

@section("content")
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-10">

    <!-- Export Button -->
    @if(isset($orders) && $orders->isNotEmpty())
    <form action="{{ route('orders.export') }}" method="post" class="mb-6">
        @csrf
        <input type="hidden" name="orders" value="{{ base64_encode(json_encode($orders)) }}">
        <button type="submit"
            class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-md shadow">
            Export All
        </button>
    </form>
    @endif

    <!-- Filter Box -->
    @if(auth()->user()->role_id == 2 || auth()->user()->role_id == 1)
    <div class="flex flex-col md:flex-row md:space-x-6 space-y-4 md:space-y-0 mb-6 items-start">

        <!-- Status Dropdown -->
        <div class="md:w-1/4 w-full">
            <x-status-dropdown></x-status-dropdown>
            <x-referto-dropdown></x-referto-dropdown>
        </div>

        <!-- Date Filter Form -->
        <form
            action="{{ auth()->user()->id == 2 ? url('/orders/') : url('/user/'.auth()->id().'/orders') }}"
            method="get"
            class="md:w-3/4 w-full grid grid-cols-1 md:grid-cols-12 gap-4">

            @if(request('shop'))
            <input type="hidden" name="shop" value="{{ request('shop') }}">
            @endif

            @if(request('status'))
            <input type="hidden" name="status" value="{{ request('status') }}">
            @endif

            <!-- From Date -->
            <div class="md:col-span-5">
                <label for="fromDate" class="block text-gray-700 font-medium mb-1">From Date</label>
                <input type="date" id="fromDate" name="from_date"
                    value="{{ request('from_date') }}"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 text-gray-700">
            </div>

            <!-- To Date -->
            <div class="md:col-span-5">
                <label for="toDate" class="block text-gray-700 font-medium mb-1">To Date</label>
                <input type="date" id="toDate" name="to_date"
                    value="{{ request('to_date') }}"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 text-gray-700">
            </div>

            <!-- name,unit search -->
            <div class="md:col-span-2">
                <label for="nameunit" class="block text-gray-700 font-medium mb-1">Product Name or Unit</label>
                <input type="text" id="nameunit" name="nameunit"
                    value="{{ request('nameunit') }}"
                    placeholder="ကုန်ပစ္စည်းအမည် (သို့) unit ဖြင့်ရှာရန် "
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 text-gray-700">
            </div>

            <!-- Search Button -->
            <div class="md:col-span-2 flex items-end">
                <button type="submit"
                    class="w-full px-3 py-2 border border-blue-500 text-blue-600 font-medium rounded-md hover:bg-blue-50 flex justify-center items-center space-x-2">
                    <span>Search</span>
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </div>

        </form>
    </div>
    @endif

    <div class="space-y-4">
        <h2 class="text-xl font-bold text-slate-800 px-2 flex justify-between items-center">
            တင်ပို့ကုန်စာရင်း
            <span class="text-sm font-normal text-slate-400 italic">
                Showing {{ $orders->count() }} records
            </span>
        </h2>
        @forelse($orders as $order)
        <x-orderCard :order="$order" />
        @empty
        <div class="flex justify-center my-10">
            <img src="{{ asset('images/empty.gif') }}" alt="empty" class="max-w-xs">
        </div>

        <div class="text-center py-3">
            <p class="text-slate-500">လက်တလောတင်ပို့ကုန်များမရှိသေးပါ</p>
        </div>
        @endforelse
    </div>

    <div class="mt-6 flex justify-center">
        {{ $orders->links() }}
    </div>
</div>
@endsection