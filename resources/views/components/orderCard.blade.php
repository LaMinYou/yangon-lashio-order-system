@props(['order'])

<div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 hover:shadow-md transition group mb-4" x-data="{ open: false }">
    {{-- Header: Date + Status --}}
    <div class="flex flex-col lg:flex-row lg:items-center gap-6">
        <div class="flex lg:flex-col items-center lg:items-start justify-between lg:justify-start lg:w-32 border-b lg:border-b-0 lg:border-r border-slate-100 pb-4 lg:pb-0">
            {{-- Export Date --}}
            <span class="text-slate-400 text-sm font-medium uppercase">
                {{ \Carbon\Carbon::parse($order->export_date)->format('M d, Y') }}
            </span>

            {{-- Status Badge --}}
            @php
                $statusClasses = match($order->status) {
                    'ပို့နေဆဲ' => 'bg-amber-50 text-amber-600',
                    'ရောက်ပြီး' => 'bg-emerald-50 text-emerald-600',
                    'ရောင်းပြီး' => 'bg-indigo-50 text-indigo-600',
                    default => 'bg-slate-50 text-slate-600'
                };
                $dotClasses = match($order->status) {
                    'ပို့နေဆဲ' => 'bg-amber-500',
                    'ရောက်ပြီး' => 'bg-emerald-500',
                    'ရောင်းပြီး' => 'bg-indigo-500',
                    default => 'bg-slate-500'
                };
            @endphp

            <div class="mt-2 inline-flex items-center gap-1.5 px-3 py-1 {{ $statusClasses }} rounded-full text-xs font-bold">
                {{-- Ping Dot --}}
                <span class="relative inline-flex w-1.5 h-1.5">
                    @if($order->status == 'ပို့နေဆဲ')
                        <span class="absolute inline-flex w-full h-full {{ $dotClasses }} rounded-full animate-ping"></span>
                    @endif
                    <span class="relative w-1.5 h-1.5 {{ $dotClasses }} rounded-full"></span>
                </span>
                {{ $order->status }}
            </div>
        </div>

        {{-- Info Grid --}}
        <div class="flex-grow grid grid-cols-1 sm:grid-cols-2 md:grid-cols-{{ auth()->user()->role_id == 2 ? 4 : 3 }} gap-6">
            @if(auth()->user()->role_id == 2)
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">တင်ပို့သူအမည်</p>
                    <p class="text-slate-900 font-semibold truncate">{{ $order->user->name }}</p>
                    <p class="text-indigo-500 text-xs font-medium">{{ $order->user->phone }}</p>
                </div>
            @endif
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">ကုန်အမျိုးအစား</p>
                <p class="text-slate-700 font-semibold">{{ $order->category->name }}</p>
            </div>
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">ပစ္စည်းအမည်</p>
                <p class="text-slate-700 font-semibold italic">{{ $order->product_name }}</p>
            </div>
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">ပွဲရုံအမည်</p>
                <p class="text-slate-700 font-semibold">{{ $order->sourceArea->name }}</p>
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex items-center gap-2 border-t lg:border-t-0 pt-4 lg:pt-0 justify-end">
            {{-- Details Toggle --}}
            <button @click="open = !open" class="bg-slate-50 hover:bg-indigo-50 text-indigo-600 px-4 py-2 rounded-xl text-sm font-bold transition flex-grow lg:flex-grow-0">
                Details
            </button>

            {{-- Role 1: Edit --}}
            @if(auth()->user()->role_id == 1)
                <a href="{{ route('orders.edit', $order->id) }}" class="p-2 text-slate-300 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                </a>
            @endif

            {{-- Role 2: Delete --}}
            @if(auth()->user()->role_id == 2)
            <x-deleteDialog :item="$order" :type="'order'" />
            @endif
        </div>
    </div>

    {{-- Collapse Content --}}
    <div x-show="open" x-transition class="mt-6 pt-6 border-t border-slate-100">
        {{-- Status Update (Role 2) --}}
        @if(auth()->user()->role_id == 2 && $order->status != 'ရောင်းပြီး')
            <div class="flex gap-2 mb-4 flex-wrap">
                @if($order->status == 'ပို့နေဆဲ')
                    <form action="{{ route('orders.update', $order->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="status" value="1">
                        <button type="submit" class="text-xs font-bold bg-emerald-600 text-white px-3 py-1.5 rounded-lg hover:bg-emerald-700 transition">ရောက်ပြီးသို့ပြောင်းရန်</button>
                    </form>
                @endif
                <form action="{{ route('orders.update', $order->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="status" value="2">
                    <button type="submit" class="text-xs font-bold bg-indigo-600 text-white px-3 py-1.5 rounded-lg hover:bg-indigo-700 transition">ရောင်းပြီးသို့ပြောင်းရန်</button>
                </form>
            </div>
        @endif

        {{-- Order Details Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 bg-slate-50 p-4 rounded-2xl">
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase">အတိုက်ချိန် / အသားချိန်</p>
                <p class="text-slate-700 font-medium">{{ $order->weight }} / {{ $order->net_weight }} ပိဿာ</p>
            </div>
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase">ဈေးနှုန်း / Unit</p>
                <p class="text-slate-700 font-medium">{{ number_format($order->price) }} MMK ({{ $order->unit->name }})</p>
            </div>
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase">လွှဲပြောင်းထားသောဆိုင်</p>
                <p class="text-slate-700 font-medium">{{ isset($order->shop_id)? $order->shop->name : ' - ' }}</p>
            </div>
            @if(auth()->user()->role_id == 2)
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase">သင့်ငွေ</p>
                    <p class="text-emerald-600 font-bold">{{ number_format($order->total) }} MMK</p>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase">ဂိတ် / တန်ဆာခ</p>
                    <p class="text-slate-700 font-medium">{{ $order->gate->name }} ({{ number_format($order->weightfee) }} MMK)</p>
                </div>
            @endif
        </div>

        {{-- Remark Section --}}
        <div class="mt-4">
            <p class="text-[10px] font-bold text-slate-400 uppercase">မှတ်ချက် (Remark)</p>
            @if(auth()->user()->role_id == 2)
                <form action="{{ route('orders.update', $order->id) }}" method="POST" class="flex gap-2 mt-1">
                    @csrf
                    <input type="text" name="remark" class="flex-grow min-w-0 text-sm border-slate-200 px-3 rounded-xl focus:ring-indigo-500" value="{{ $order->remark }}" placeholder="မှတ်ချက်ထည့်ပါ။">
                    <button type="submit" class="bg-slate-800 text-white px-4 py-2 rounded-xl text-xs font-bold">သိမ်းရန်</button>
                </form>
            @else
                <p class="text-slate-600 text-sm">{{ $order->remark ?? '-' }}</p>
            @endif
        </div>
    </div>

</div>

{{-- Delete Dialog --}}

