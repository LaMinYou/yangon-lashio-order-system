@extends('layouts.app')

@section('content')
<div>
    <!-- HERO SECTION -->
    <section class="relative w-full overflow-hidden bg-gradient-to-br from-slate-50 to-indigo-100 pt-16 pb-24 px-6">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center gap-12">

            <div class="md:w-1/2 space-y-8 animate-[fadeIn_0.8s_ease-in-out]">
                <span class="bg-indigo-100 text-indigo-700 px-4 py-1.5 rounded-full text-sm font-semibold uppercase tracking-wider">
                    Reliable Logistics
                </span>

                <h1 class="text-5xl md:text-6xl font-extrabold text-slate-900 leading-tight">
                    Yangon–Lashio <span class="text-indigo-600">Shipping</span> Record System
                </h1>

                <p class="text-xl text-slate-600 leading-relaxed">
                    Yangon–Lashio Shipping System သည် ပင်လယ်ထွက်ကုန်များကို အချိန်မီနှင့် စနစ်တကျ တင်ပို့ပေးသော စနစ်တစ်ခုဖြစ်ပါသည်။ အသုံးပြုသူများအနေဖြင့် တင်ပို့ပြီးသော ထွက်ကုန်များ၏ စာရင်းများကို လွယ်ကူစွာ တွက်ချက်နိုင်ပြီး တင်ပို့ထားသော ပစ္စည်းအချက်အလက်များကို ပြန်လည်ကြည့်ရှုနိုင်ပါသည်။
                </p>

                <div class="flex gap-4">
                    <a href="{{ url('/order/add') }}"
                       class="bg-indigo-600 px-8 py-4 rounded-xl text-white font-bold hover:scale-105 transition shadow-xl">
                       တင်ပို့ကုန်ထည့်သွင်းရန်
                    </a>

                    <a href="#features"
                       class="bg-white border border-slate-200 px-8 py-4 rounded-xl text-slate-700 font-bold hover:bg-slate-50 transition">
                        View Demo
                    </a>
                </div>
            </div>

            <div class="md:w-1/2 relative">
                <div class="absolute -top-10 -right-10 w-64 h-64 bg-indigo-300 rounded-full mix-blend-multiply blur-3xl opacity-30"></div>
                <img
                    src="{{ asset('images/fishandshrimp-1.jpg') }}"
                    alt="Shipping Cargo"
                    loading="lazy"
                    class="rounded-3xl shadow-2xl relative z-10 border-8 border-white"
                >
            </div>
        </div>
    </section>

    <!-- FEATURES -->
    <section id="features" class="max-w-7xl mx-auto py-24 px-6">
        <div class="text-center max-w-3xl mx-auto mb-16 space-y-4">
            <h2 class="text-4xl font-bold text-slate-900">
                ဘာကြောင့် ရွေးချယ်သင့်သလဲ
            </h2>
            
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            <!-- Card 1 -->
            <div class="group p-8 bg-white rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-2 transition">
                <div class="w-14 h-14 bg-indigo-50 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-indigo-600 transition">
                    <i class="fa-solid fa-scale-balanced text-2xl text-indigo-600 group-hover:text-white"></i>
                </div>
                <h3 class="text-xl font-bold mb-4">Weight-Based Pricing</h3>
                <p class="text-slate-600 leading-relaxed">
                    ကျွန်တော်တို့၏ စနစ်သည် အလေးချိန်ပေါ်မူတည်၍ တွက်ချက်ပေးသော စနစ်ဖြစ်ပါသည်။ ထို့ကြောင့် သင့်အနေဖြင့် စာရွက်စာတမ်းများ များစွာမလိုအပ်ဘဲ လွယ်ကူအဆင်ပြေစွာ တွက်ချက်နိုင်ပါသည်။
                </p>
            </div>

            <!-- Card 2 -->
            <div class="group p-8 bg-white rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-2 transition">
                <div class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-emerald-600 transition">
                    <i class="fa-solid fa-route text-2xl text-emerald-600 group-hover:text-white"></i>
                </div>
                <h3 class="text-xl font-bold mb-4">Route Management</h3>
                <p class="text-slate-600 leading-relaxed">
                    ပို့ဆောင်ရေးအတွက် သက်ဆိုင်ရာ ဆိုင်နာမည်ကို စနစ်အတွင်းမှ ရွေးချယ်သတ်မှတ်နိုင်ပါသည်။
                </p>
            </div>

            <!-- Card 3 -->
            <div class="group p-8 bg-white rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-2 transition">
                <div class="w-14 h-14 bg-orange-50 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-orange-600 transition">
                    <i class="fa-solid fa-bolt text-2xl text-orange-600 group-hover:text-white"></i>
                </div>
                <h3 class="text-xl font-bold mb-4">Fast Digital Billing</h3>
                <p class="text-slate-600 leading-relaxed">
                    ငွေကြေးတွက်ချက်မှုကို အချိန်မီနှင့် ထိရောက်စွာ လုပ်ဆောင်နိုင်ပါသည်။
                </p>
            </div>
        </div>
    </section>

    <!-- CTA SECTION -->
    <section class="w-full bg-slate-900 py-20 px-6">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center gap-16">

            <div class="md:w-1/2 space-y-6">
                <h2 class="text-4xl font-bold text-white">
                   Warning 
                </h2>

                <ul class="space-y-4">
                    <li class="flex items-center gap-3 text-slate-300">
                        <span class="w-6 h-6 bg-indigo-500 rounded-full flex items-center justify-center text-white text-xs">✓</span>
                        တင်ပို့ကုန်အချက်လက်များကိုမှန်ကန်တိကျစွာဖြည့်ပါ
                        
                    </li>
                    <li class="flex items-center gap-3 text-slate-300">
                        <span class="w-6 h-6 bg-indigo-500 rounded-full flex items-center justify-center text-white text-xs">✓</span>
                        ပြီးနောက် ထည့်သွင်းပြီးအချက်လက်များကိုပြန်လည်စစ်ဆေး
                    </li>
                    <li class="flex items-center gap-3 text-slate-300">
                        <span class="w-6 h-6 bg-indigo-500 rounded-full flex items-center justify-center text-white text-xs">✓</span>
                        မှားယွင်းမှုရှိပါက ပြန်လည်ပြင်ဆင်နိုင်သည်
                    </li>
                </ul>
            </div>

            <div class="md:w-1/2 rounded-3xl overflow-hidden shadow-2xl">
                <img
                    src="{{ asset('images/delivery-man.jpg') }}"
                    alt="Delivery"
                    loading="lazy"
                    class="hover:scale-105 transition duration-700"
                >
            </div>
        </div>
    </section>
</div>

<!-- Custom Animation -->
<style>
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to   { opacity: 1; transform: translateY(0); }
}
</style>

{{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 box p-5 my-5">
            <div class="row justify-content-center g-3">
                <div class="col-md-6">
                    <div class="card imgBox m-auto">
                        <div class="card-body img" style="max-width:300px;">
                            <img src="images/fish.png" alt="" class="card-img">
                        </div>
                    </div>
                </div>
                <div class="col-md-6 my-sm-5">
                    <div class="content m-auto">
                        <h2 class="pb-3">Yangon–Lashio Shipping Record System</h2>
                        <p>
                            မင်္ဂလာပါ 🙏
                        </p>
                        <p style="max-width:400px;">
                            သင်ပို့ချင်သော ပစ္စည်းများကို အချိန်မရွေး အလွယ်တကူ ကျွုပ်တို့စနစ်မှ စာရင်းသွင်းနိုင်ပါပြီ<br>
                            ကျွန်တော်တို့ စနစ်သည် သင့်ပို့ဆောင်မှုကို ပိုမို ချောမွေ့အောင် ကူညီပေးပါမည်။
                        </p>
                        <ul>
                            <li>တင်ပို့ကုန်အချက်လက်များကိုမှန်ကန်တိကျစွာဖြည့်ပါ</li>
                            <li>ပြီးနောက် ထည့်သွင်းပြီးအချက်လက်များကိုပြန်လည်စစ်ဆေး</li>
                            <li>မှားယွင်းမှုရှိပါက ပြန်လည်ပြင်ဆင်နိုင်သည်</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}
@endsection
