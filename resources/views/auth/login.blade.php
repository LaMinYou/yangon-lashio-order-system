@extends('layouts.layout')

@section('title')
User Login Form
@endsection
@section('content')
<section class="relative flex flex-col items-center justify-center min-h-screen">

    {{-- Success Message ပြသရန် (Optional) --}}
    @if (session('success'))
        <div class="absolute top-10 max-w-sm w-full bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded text-center">
            {{ session('success') }}
        </div>
    @endif

    <div class="w-full max-w-sm space-y-10 p-6 z-10">
        <div class="space-y-3 text-center">
            <h1 class="text-3xl font-bold text-stone-900">Sign in</h1>
            <p class="text-stone-500 text-base leading-relaxed">
                အသုံးပြုသူ အကောင့်ဝင်ရန်
            </p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            {{-- Phone Field --}}
            <div>
                <label for="phone" class="block text-sm font-medium text-stone-700">ဖုန်းနံပါတ်</label>
                <input type="tel" name="phone" id="phone" value="{{ old('phone') }}"  autofocus
                    class="input-box mt-1.5 w-full @error('phone') border-red-500 ring-1 ring-red-500 @enderror"
                    placeholder="09-xxxxxxx">

                @error('phone')
                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            {{-- Password Field --}}
            <div>
                <label for="password" class="block text-sm font-medium text-stone-700">စကားဝှက်</label>
                <input type="password" name="password" id="password"
                    class="input-box mt-1.5 w-full @error('password') border-red-500 ring-1 ring-red-500 @enderror"
                    placeholder="********">

                @error('password')
                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            {{-- Remember Me & Forgot Password --}}
            <div class="flex items-center justify-between text-sm">
                <div class="flex items-center">
                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}
                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                    <label for="remember" class="ml-2 text-stone-600">Remember me</label>
                </div>
                <a href="{{ route('user.forgot-password') }}" class="text-indigo-500 hover:underline">စကားဝှက်မေ့နေပါသလား?</a>
            </div>

            <div class="pt-2">
                <button type="submit" class="btn-primary w-full py-2  bg-indigo-400 text-white rounded-lg hover:bg-indigo-500 transition shadow-md">
                    အကောင့်ဝင်ရန်
                </button>
                <a href="{{ url('/role') }}" class="block text-center mt-4 text-sm text-stone-500 hover:text-stone-800">
                    ← နောက်သို့
                </a>
            </div>
        </form>

        <p class="text-center text-stone-500 text-sm font-medium">
            အကောင့်မရှိဘူးလား?
            <a href="{{ route('user.register') }}" class="text-indigo-500 font-bold hover:underline">အကောင့်ဖွင့်ရန်</a>
        </p>
    </div>
</section>
{{-- <div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            @session('success')
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endsession
            <form method="POST" action="{{ route('login') }}" class="shadow-lg p-5 rounded-3">
                @csrf
                <h2 class="text-center">အသုံးပြုသူ အကောင့်ဝင်ရန်</h2>
                <div class="form-group mb-3">
                    <label for="phone" class="d-block py-3">ဖုန်းနံပါတ်</label>
                    <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror"
                        name="phone" value="{{ old('phone') }}" placeholder="09XXXXXXXXX" required autofocus>

                    @error('phone')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="password" class="d-block py-3">စကားဝှက်</label>
                    <input id="password" type="password"
                        class="form-control @error('password') is-invalid @enderror"
                        name="password" required>

                    @error('password')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-check mb-3">
                    <input type="checkbox" name="remember" id="remember" class="form-check-input" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">အကောင့်လက်ခံထားမယ်</label>
                </div>

                <button type="submit" class="submit w-100">အကောင့်ဝင်ရန်</button>
                <a href="{{ url('/role') }}" class="back text-center my-2">နောက်သို့</a>
                <p class="text-center">
                    <a href="{{ route('user.forgot-password') }}">စကားဝှက်မေ့နေသလား?</a>
                </p>
                <p class="text-center">
                    အကောင့်မရှိဘူးလား?
                    <a href="{{ route('user.register') }}">မှတ်ပုံတင်ပါ</a>
                </p>
            </form>
        </div>
    </div>
</div> --}}
<!--login css-->
@endsection
