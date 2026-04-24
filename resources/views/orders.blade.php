@extends("layouts.app")

@section("title", "Orders")
@section("content")
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    @if(session('error'))
    <div x-data="{ show: true }" x-show="show" class="fixed inset-0 z-[100] flex items-start my-3 justify-center px-4">
        <div class="bg-white/90 backdrop-blur-xl p-8 rounded-3xl shadow-2xl border border-white max-w-sm w-full text-center">
            <div class="mb-4 text-6xl">
                <i class="fa-solid fa-xmark text-2xl text-red-600"></i>
            </div>
            <p class="font-bold text-lg mb-6 text-red-500">
                {{ session('error') }}
            </p>
            <button @click="show = false" class="w-full py-3 bg-slate-900 text-white rounded-xl font-bold">
                Done
            </button>
        </div>
    </div>
    @endif
    {{-- 1. Export Form (POST orders/export) --}}
    @if(isset($orders) && $orders->isNotEmpty())
    <div class="flex justify-end mb-6">
        <form action="{{ route('orders.export') }}" method="POST">
            @csrf
            {{-- Encode items only to avoid Paginator serialization errors --}}
            <input type="hidden" name="exportOrders" value="{{ base64_encode(json_encode($exportOrders)) }}">
            <button type="submit" class="flex items-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold rounded-xl shadow-sm transition-all active:scale-95">
                <i class="fa-solid fa-file-export"></i> Export Records
            </button>
        </form>
    </div>
    @endif

    {{-- 2. Search Form (GET orders.index or orders.user) --}}
    @if(auth()->user()->role_id == 2 || auth()->user()->role_id == 1)
    <div class="bg-white rounded-2xl border border-slate-200 p-6 mb-8 shadow-sm">
        {{-- DYNAMIC ROUTE SELECTION --}}
        @php
        $searchRoute = (auth()->user()->role_id == 2)
        ? route('orders.index')
        : route('orders.user', auth()->id());
        @endphp

        <form action="{{ $searchRoute }}" method="GET" class="space-y-6">
            {{-- Force pagination back to page 1 on new search --}}
            <input type="hidden" name="page" value="1">
            {{-- Keep existing filters in the URL when searching --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-wider ml-1">Status</label>
                    <x-status-dropdown></x-status-dropdown>
                </div>
                <div class="space-y-1">
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-wider ml-1">Refer To</label>
                    <x-referto-dropdown></x-referto-dropdown>
                </div>
            </div>

            <hr class="border-slate-100">

            <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                @if(request('shop'))
                <input type="hidden" name="shop" value="{{ request('shop') }}">
                @endif

                @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
                @endif
                <div class="md:col-span-3">
                    <label class="block text-sm font-semibold text-slate-600 mb-1">From Date</label>
                    <input type="date" name="from_date" value="{{ request('from_date') }}" class="w-full bg-slate-50 border-transparent rounded-xl px-4 py-3">
                </div>

                <div class="md:col-span-3">
                    <label class="block text-sm font-semibold text-slate-600 mb-1">To Date</label>
                    <input type="date" name="to_date" value="{{ request('to_date') }}" class="w-full bg-slate-50 border-transparent rounded-xl px-4 py-3">
                </div>

                <div class="md:col-span-4">
                    <label class="block text-sm font-semibold text-slate-600 mb-1">Quick Search</label>
                    <input type="text" name="nameunit" value="{{ request('nameunit') }}" placeholder="ကုန်ပစ္စည်းအမည်ဖြင့်ရှာရန်" class="w-full bg-slate-50 border-transparent rounded-xl px-4 py-3">
                </div>

                <div class="md:col-span-2">
                    <button type="submit" class="w-full py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-md transition-all active:scale-95">
                        <i class="fa-solid fa-magnifying-glass text-sm"></i> <span>Search</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
    @endif

    {{-- 3. Header & Record Count Fix --}}
    <div class="flex flex-col sm:flex-row justify-between items-baseline mb-6 px-2">
        <h2 class="text-2xl font-bold text-slate-800">တင်ပို့ကုန်စာရင်း</h2>
        <p class="text-sm text-slate-400 font-medium">
            @php
            $shippingCount = $orders->where('status', 'ပို့နေဆဲ')->count();
            @endphp
            ပို့နေဆဲအရေတွက် <span class="text-orange-600 font-bold">{{ $shippingCount }} </span>
        </p>
    </div>

    {{-- 4. List Items --}}
    <div class="grid grid-cols-1 gap-4">
        @forelse($orders as $order)
        <x-orderCard :order="$order" :shops="$shops" />
        @empty
        <div class="bg-white rounded-3xl p-12 flex flex-col items-center justify-center">
            <div class="relative mb-6">
                <div class="absolute inset-0 bg-indigo-100 rounded-full blur-3xl opacity-30"></div>
                <img src="{{ asset('images/empty.gif') }}" alt="empty" class="relative w-64 mix-blend-multiply">
            </div>
            <h3 class="text-lg font-bold text-slate-700">မှတ်တမ်းများမရှိသေးပါ</h3>

        </div>
        @endforelse
    </div>

    {{-- Modern Pagination --}}
    <div class="mt-10 flex justify-center">
        <div class=" p-2   rounded-2xl  gap-4  shadow-sm">
            {{ $orders->links() }}
        </div>
    </div>

</div>
@endsection