@extends('layouts.app')
@section('title', 'Fact Adding Form')
@section('content')
<style>
    .bg-video {
        position: fixed;
        right: 0; bottom: 0;
        min-width: 100%; min-height: 100%;
        z-index: -2;
        object-fit: cover;
    }
    .overlay {
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background: linear-gradient(135deg, rgba(15, 23, 42, 0.6) 0%, rgba(30, 58, 138, 0.4) 100%);
        z-index: -1;
    }
</style>

<video class="bg-video" autoplay muted loop playsinline>
    <source src="{{ asset('images/shipping.mp4') }}" type="video/mp4">
</video>
<div class="overlay"></div>

<div class="max-w-4xl mx-auto px-6 py-12">

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
                    {{ session('success')? 'text-green-700' : 'text-red-500' }}">
                    {{ session('success') ?? session('error') }}
                </p>
                <button @click="show = false" class="w-full py-3 bg-slate-900 text-white rounded-xl font-bold">
                    Done
                </button>
            </div>
        </div>
    @endif

    <div class="mb-10 text-center">
        <!-- <h2 class="text-3xl font-black text-white mb-2">Management Hub</h2> -->
        <p class="text-3xl font-black text-indigo-100/80 italic">အချက်အလက်အသစ်များ ထည့်သွင်းရန်</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6" x-data="{ activeForm: null }">

        <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-3xl overflow-hidden transition-all duration-300"
             :class="activeForm === 'category' ? 'ring-2 ring-indigo-400 scale-[1.02]' : ''">
            <button @click="activeForm = (activeForm === 'category' ? null : 'category')"
                    class="w-full flex items-center gap-4 p-6 text-white group">
                <div class="w-12 h-12 rounded-2xl bg-indigo-500/20 flex items-center justify-center group-hover:bg-indigo-500 transition-colors">
                    <i class="fa-solid fa-list text-xl"></i>
                </div>
                <span class="font-bold text-lg">ကုန်အမျိုးအစားထည့်ရန်</span>
                <i class="fa-solid fa-chevron-down ml-auto transition-transform" :class="activeForm === 'category' ? 'rotate-180' : ''"></i>
            </button>

            <div x-show="activeForm === 'category'" x-collapse>
                <form action="{{ route('categories.store') }}" method="POST" class="p-6 pt-0">
                    @csrf
                    <input type="text" name="category" placeholder="ဥပမာ - ငါးခြောက်"
                           class="w-full bg-white/10 border border-white/20 rounded-2xl px-4 py-3 text-white placeholder:text-white/40 focus:ring-2 focus:ring-indigo-400 outline-none mb-4">
                    <button class="w-full py-3 bg-indigo-600 hover:bg-indigo-500 text-white rounded-2xl font-bold transition-all flex items-center justify-center gap-2">
                        <i class="fa-solid fa-check"></i> သိမ်းရန်
                    </button>
                </form>
            </div>
        </div>

        <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-3xl overflow-hidden transition-all duration-300"
             :class="activeForm === 'product' ? 'ring-2 ring-rose-400 scale-[1.02]' : ''">
            <button @click="activeForm = (activeForm === 'product' ? null : 'product')"
                    class="w-full flex items-center gap-4 p-6 text-white group">
                <div class="w-12 h-12 rounded-2xl bg-rose-500/20 flex items-center justify-center group-hover:bg-rose-500 transition-colors">
                    <i class="fa-brands fa-product-hunt text-xl"></i>
                </div>
                <span class="font-bold text-lg">ကုန်ပစ္စည်းအသစ်ထည့်ရန်</span>
                <i class="fa-solid fa-chevron-down ml-auto transition-transform" :class="activeForm === 'product' ? 'rotate-180' : ''"></i>
            </button>

            <div x-show="activeForm === 'product'" x-collapse>
                <form action="{{ route('products.store') }}" method="POST" class="p-6 pt-0">
                    @csrf
                    <select name="category_id" class="w-full bg-slate-800/80 border border-white/20 rounded-2xl px-4 py-3 text-white mb-3 outline-none">
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <input type="text" name="product" placeholder="ကုန်ပစ္စည်းအမည်"
                           class="w-full bg-white/10 border border-white/20 rounded-2xl px-4 py-3 text-white placeholder:text-white/40 mb-4">
                    <button class="w-full py-3 bg-rose-600 hover:bg-rose-500 text-white rounded-2xl font-bold transition-all">
                        <i class="fa-solid fa-check"></i> သိမ်းရန်
                    </button>
                </form>
            </div>
        </div>

        <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-3xl overflow-hidden transition-all duration-300">
            <button @click="activeForm = (activeForm === 'area' ? null : 'area')" class="w-full flex items-center gap-4 p-6 text-white group">
                <div class="w-12 h-12 rounded-2xl bg-emerald-500/20 flex items-center justify-center group-hover:bg-emerald-500 transition-colors">
                    <i class="fa-solid fa-building-columns text-xl"></i>
                </div>
                <span class="font-bold text-lg">ပွဲရုံအမည်အသစ်ထည့်ရန်</span>
                <i class="fa-solid fa-chevron-down ml-auto transition-transform" :class="activeForm === 'area' ? 'rotate-180' : ''"></i>
            </button>
            <div x-show="activeForm === 'area'" x-collapse>
                <form action="{{ route('sourceareas.store') }}" method="POST" class="p-6 pt-0">
                    @csrf
                    <input type="text" name="sourceArea" placeholder="ပွဲရုံအမည်" class="w-full bg-white/10 border border-white/20 rounded-2xl px-4 py-3 text-white mb-4">
                    <button class="w-full py-3 bg-emerald-600 text-white rounded-2xl font-bold">သိမ်းရန်</button>
                </form>
            </div>
        </div>

        <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-3xl overflow-hidden transition-all duration-300">
            <button @click="activeForm = (activeForm === 'gate' ? null : 'gate')" class="w-full flex items-center gap-4 p-6 text-white group">
                <div class="w-12 h-12 rounded-2xl bg-amber-500/20 flex items-center justify-center group-hover:bg-amber-500 transition-colors">
                    <i class="fa-solid fa-bus-simple text-xl"></i>
                </div>
                <span class="font-bold text-lg">ဂိတ်အမည်အသစ်ထည့်ရန်</span>
                <i class="fa-solid fa-chevron-down ml-auto transition-transform" :class="activeForm === 'gate' ? 'rotate-180' : ''"></i>
            </button>
            <div x-show="activeForm === 'gate'" x-collapse>
                <form action="{{ route('gates.store') }}" method="POST" class="p-6 pt-0">
                    @csrf
                    <input type="text" name="gate" placeholder="ဂိတ်အမည်" class="w-full bg-white/10 border border-white/20 rounded-2xl px-4 py-3 text-white mb-4">
                    <button class="w-full py-3 bg-amber-600 text-white rounded-2xl font-bold">သိမ်းရန်</button>
                </form>
            </div>
        </div>

        <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-3xl overflow-hidden transition-all duration-300">
            <button @click="activeForm = (activeForm === 'unit' ? null : 'unit')" class="w-full flex items-center gap-4 p-6 text-white group">
                <div class="w-12 h-12 rounded-2xl bg-amber-500/20 flex items-center justify-center group-hover:bg-amber-500 transition-colors">
                    <i class="fa-solid fa-box text-xl"></i>
                </div>
                <span class="font-bold text-lg">Unit အသစ်ထည့်ရန်</span>
                <i class="fa-solid fa-chevron-down ml-auto transition-transform" :class="activeForm === 'unit' ? 'rotate-180' : ''"></i>
            </button>
            <div x-show="activeForm === 'unit'" x-collapse>
                <form action="{{ route('units.store') }}" method="POST" class="p-6 pt-0">
                    @csrf
                    <input type="text" name="unit" placeholder="Unit အမည်" class="w-full bg-white/10 border border-white/20 rounded-2xl px-4 py-3 text-white mb-4">
                    <button class="w-full py-3 bg-amber-600 text-white rounded-2xl font-bold">သိမ်းရန်</button>
                </form>
            </div>
        </div>
        <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-3xl overflow-hidden transition-all duration-300">
            <button @click="activeForm = (activeForm === 'shop' ? null : 'shop')" class="w-full flex items-center gap-4 p-6 text-white group">
                <div class="w-12 h-12 rounded-2xl bg-emerald-500/20 flex items-center justify-center group-hover:bg-emerald-500 transition-colors">
                    <i class="fa-solid fa-building-columns text-xl"></i>
                </div>
                <span class="font-bold text-lg">လွှဲပြောင်းအမည်(Refer to)ထည့်ရန်</span>
                <i class="fa-solid fa-chevron-down ml-auto transition-transform" :class="activeForm === 'shop' ? 'rotate-180' : ''"></i>
            </button>
            <div x-show="activeForm === 'shop'" x-collapse>
                <form action="{{ route('shops.store') }}" method="POST" class="p-6 pt-0">
                    @csrf
                    <input type="text" name="shop" placeholder="လွှဲပြောင်းအမည်" class="w-full bg-white/10 border border-white/20 rounded-2xl px-4 py-3 text-white mb-4">
                    <button class="w-full py-3 bg-emerald-600 text-white rounded-2xl font-bold">သိမ်းရန်</button>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
