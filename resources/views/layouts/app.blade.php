<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Shipping Record System</title>
    <link rel="icon" href="{{ asset('images/logo1.png') }}" type="image/png">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.15.4/dist/cdn.min.js"></script>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div id="app" class="d-flex flex-column min-vh-100">
        <header class="sticky top-0 z-50 h-20 bg-white/80 backdrop-blur-md border-b border-slate-200 w-full px-6 md:px-18 flex items-center justify-between">
            {{-- Logo --}}
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo1.png') }}" alt="" class="h-10">
                <a  href="{{ url('/home') }}" class="h1 text-xl font-bold italic">
                    <span class="text-green-600">Shipping</span>
                    <span class="text-indigo-600">Record</span>
                </a>
            </div>

            {{-- Navigation --}}
            <nav class="hidden md:flex">
                <ul class="flex items-center gap-6 font-medium text-slate-600">
                    @auth
                        @if(auth()->user()->role_id == 1)
                            <li><a href="{{ url('/order/add') }}" class="hover:text-indigo-600 transition">တင်ပို့ကုန်ထည့်သွင်းရန်</a></li>
                            <li><a href="{{ url('/user/'.auth()->user()->id.'/orders') }}" class="hover:text-indigo-600 transition">အချက်လက်ကြည့်ရန်</a></li>
                        @endif

                        @if(auth()->user()->role_id == 2)
                            <li><a href="{{ url('/orders') }}" class="hover:text-indigo-600 transition">ပို့ကုန်စာရင်းကြည့်ရန်</a></li>
                            <li><a href="{{ url('/facts/add') }}" class="hover:text-indigo-600 transition">အချက်လက်ထည့်သွင်းရန်</a></li>

                            {{-- Data Dropdown (Removed Dots/Discs) --}}
                            <li class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                                <button class="cursor-pointer hover:text-indigo-600 transition flex items-center gap-1 py-4">
                                    အချက်အလက်ကြည့်ရန်
                                    <svg class="w-4 h-4 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>

                                {{-- Dropdown Menu --}}
                                <div x-show="open"
                                    x-transition:enter="transition ease-out duration-150"
                                    x-transition:enter-start="opacity-0 translate-y-2"
                                    x-transition:enter-end="opacity-100 translate-y-0"
                                    class="absolute left-0 top-[85%] w-56 bg-white shadow-2xl rounded-2xl border border-slate-100 py-2 z-[100]"
                                    style="display: none;">

                                    {{-- No more discs/dots here --}}
                                    <a href="{{ url('/categories') }}" class="block px-5 py-2.5 text-sm text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 transition">ကုန်ပစ္စည်းအမျိုးအစားများ</a>
                                    <a href="{{ url('/products') }}" class="block px-5 py-2.5 text-sm text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 transition">ကုန်အမည်များ</a>
                                    <a href="{{ url('/sourceareas') }}" class="block px-5 py-2.5 text-sm text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 transition">ပွဲရုံများ</a>
                                    <a href="{{ url('/gates') }}" class="block px-5 py-2.5 text-sm text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 transition">တင်ပို့ဂိတ်များ</a>
                                    <a href="{{ url('/shops') }}" class="block px-5 py-2.5 text-sm text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 transition">ဆိုင်များ</a>
                                    <a href="{{ url('/units') }}" class="block px-5 py-2.5 text-sm text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 transition">အသုံးပြုသော ယူနစ်များ</a>
                                </div>
                            </li>
                        @endif
                    @endauth
                </ul>
            </nav>

            {{-- Right Side --}}
            <div class="flex items-center gap-4">
                @guest
                    <a href="{{ route('login') }}" class="text-slate-600 font-medium hover:text-indigo-600 transition">Login</a>
                    <a href="{{ route('register') }}" class="bg-indigo-600 text-white px-5 py-2 rounded-full font-medium hover:bg-indigo-700 transition shadow-lg shadow-indigo-100">Register</a>
                @else
                    <div class="relative" x-data="{ open: false }" @click.away="open = false">
                        <button @click="open = !open" class="flex items-center gap-2 px-3 py-1.5 bg-slate-50 rounded-xl hover:bg-indigo-50 transition">
                            <span class="font-bold text-indigo-600 text-sm">{{ Auth::user()->name }}</span>
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" /></svg>
                        </button>

                        <div x-show="open" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-slate-100 py-2 z-[100]" style="display: none;">
                            <a href="{{ url('change-password') }}" class="block px-4 py-2 hover:bg-indigo-50 text-slate-600 text-sm">စကားဝှက်ပြောင်းရန်</a>
                            <hr class="my-1 border-slate-50">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 hover:bg-red-50 text-red-600 text-sm font-bold">ထွက်ရန်</button>
                            </form>
                        </div>
                    </div>
                @endguest
            </div>
        </header>
        {{-- <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/home') }}" style="font-style:italic">
                    <img src="{{ asset('images/logo1.png') }}" alt="" style="max-height:40px;">
                    <span style="color: green;">Shipping</span><span style="color: #3335e8;">Record</span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto ms-md-5">
                        @if(auth()->user()->role_id == 1)
                        <li class="mx-md-3 my-3">
                            <a href="{{ url('/order/add') }}" class="text-decoration-none fw-bold text-success">တင်ပို့ကုန်ထည့်သွင်းရန်</a>
                        </li>
                        <li class="mx-md-3 my-3">
                            <a href="{{ url('/user/'.auth()->user()->id.'/orders') }}" class="text-decoration-none fw-bold text-success">အချက်လက်ကြည့်ရန်</a>
                        </li>
                        @endif
                        @if(auth()->user()->role_id == 2)
                        <li class="mx-md-3 my-3">
                            <a href="{{ url('/orders') }}" class="text-decoration-none fw-bold text-success">ပို့ကုန်စာရင်းကြည့်ရန်</a>
                        </li>
                        <li class="mx-md-3 my-3">
                            <a href="{{ url('/facts/add') }}" class="text-decoration-none fw-bold text-success">အချက်လက်ထည့်သွင်းရန်</a>
                        </li>
                        <li class="mx-md-3 my-3">
                            <div class="dropdown">
                                <a href="#" class="dropdown-toggle text-success text-decoration-none fw-bold" data-bs-toggle="dropdown" aria-expanded="false">
                                    အချက်အလက်ကြည့်ရန်
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item text-success fw-bold" href="{{ url('/categories') }}">ကုန်ပစ္စည်းအမျိုးအစားများ</a></li>
                                    <li><a class="dropdown-item text-success fw-bold" href="{{ url('/products') }}">ကုန်အမည်များ</a></li>
                                    <li><a class="dropdown-item text-success fw-bold" href="{{ url('/sourceareas') }}">ပွဲရုံများ</a></li>
                                    <li><a class="dropdown-item text-success fw-bold" href="{{ url('/gates') }}">တင်ပို့ဂိတ်များ</a></li>
                                    <li><a class="dropdown-item text-success fw-bold" href="{{ url('/shops') }}">ဆိုင်များ</a></li>
                                    <li><a class="dropdown-item text-success fw-bold" href="{{ url('/shops') }}">အသုံးပြုသော ယူနစ်များ</a></li>
                                </ul>
                            </div>
                        </li>

                        @endif
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                        @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @endif

                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @endif
                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle fw-bold text-success" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item fw-bold text-success" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    ထွက်ရန်
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                                <a href="{{url('change-password')}}" class="dropdown-item fw-bold text-success">စကားဝှက်ပြောင်းရန်</a>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav> --}}
        <main class="flex-grow-1 py-4">
            @yield('content')
        </main>
    </div>
    <footer class="bg-white border-t border-slate-200 pt-20 pb-10 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-16">
                <div class="md:col-span-2 space-y-6">
                    <h3 class="text-2xl font-bold">Yangon–Lashio Shipping</h3>
                    <p class="text-slate-500 max-w-sm leading-relaxed">
                        Redefining logistics in Myanmar with technology-driven solutions for retail and wholesale businesses.
                    </p>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Products</h4>
                    <ul class="text-slate-500 space-y-2">
                        <!-- <li>Features</li>
                        <li>Pricing</li>
                        <li>Integrations</li> -->
                        <li>ငါးခြောက်</li>
                        <li>ပုစွန်ခြောက်</li>
                        <li>ငါးပိ</li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Support</h4>
                    <ul class="text-slate-500 space-y-2">
                        <li>ကုန်စည်တင်ပို့ခြင်း</li>
                    </ul>
                </div>
            </div>
            <div class="pt-8 border-t border-slate-100 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-slate-400 text-sm">2026 &copy; Yangon–Lashio Shipping Record System. All rights reserved.</p>
                <div class="flex gap-6 grayscale opacity-50">
                    </div>
            </div>
        </div>
    </footer>
    <script src="//unpkg.com/alpinejs" defer></script>
</body>

</html>
