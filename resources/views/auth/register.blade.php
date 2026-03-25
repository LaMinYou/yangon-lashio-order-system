@extends('layouts.layout')

@section('title', 'User Registration Form')
@section('content')
 <section class="relative flex flex-col items-center justify-center min-h-screen">
     {{-- <div class="absolute inset-0 -z-10 h-screen">
        <img src="{{ asset('images/circle.svg') }}" alt="" class="w-full h-full object-cover">
    </div> --}}

    <div class="w-full max-w-sm space-y-1 md:space-y-10 md:p-6 p-6">
        <div class="space-y-3 text-center">
            <h1 class="text-4xl font-bold text-stone-900">အကောင့်ဖွင့်ရန်</h1>
            <p class="text-stone-500 text-base leading-relaxed">
                အချက်အလက်များကို မှန်ကန်စွာ ဖြည့်သွင်းပါ
            </p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-6">
            @csrf

            {{-- Name Field --}}
            <div>
                <label class="block text-sm font-medium text-stone-700">နာမည်</label>
                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    autocomplete="name"
                    autofocus
                    class="input-box @error('name') border-red-500 bg-red-50 ring-1 ring-red-500 animate-shake @enderror"
                    placeholder="Maung Maung"
                >
                @error('name')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            {{-- Phone Field --}}
            <div>
                <label class="block text-sm font-medium text-stone-700">ဖုန်းနံပါတ်</label>
                <input
                    type="tel"
                    name="phone"
                    value="{{ old('phone') }}"
                    autocomplete="tel"
                    class="input-box @error('phone') border-red-500 bg-red-50 ring-1 ring-red-500 animate-shake @enderror"
                    placeholder="09xxxxxxxx"
                >
                @error('phone')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            {{-- Password Field --}}
            <div>
                <label class="block text-sm font-medium text-stone-700">စကားဝှက်</label>
                <input
                    type="password"
                    name="password"
                    autocomplete="password"
                    class="input-box @error('password') border-red-500 bg-red-50 ring-1 ring-red-500 animate-shake @enderror"
                    placeholder="******"
                >
                @error('password')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            {{-- Password Confirmation --}}
            <div>
                <label class="block text-sm font-medium text-stone-700">စကားဝှက်အတည်ပြုပါ</label>
                <input
                    type="password"
                    name="password_confirmation"
                    autocomplete="password"
                    class="input-box @error('password_confirmation') border-red-500 bg-red-50 ring-1 ring-red-500 animate-shake @enderror"
                    placeholder="*******"
                >
                @error('password_confirmation')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            {{-- Birth Date --}}
            <div>
                <label class="block text-sm font-medium text-stone-700">မွေးသက္ကရာဇ်</label>
                <input
                    type="date"
                    name="birth_date"
                    value="{{ old('birth_date') }}"
                    class="input-box @error('birth_date') border-red-500 bg-red-50 ring-1 ring-red-500 animate-shake @enderror"
                >
                @error('birth_date')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div class="pt-4">
                <button type="submit" class="btn-primary w-full">
                    အကောင့်အသစ်ဖန်တီးမည်
                </button>
            </div>
        </form>

        <p class="text-center text-stone-500 text-sm">
            Account ရှိပြီးသားလား?
            <a href="{{ route('login') }}" class="text-indigo-500 font-bold">
                အကောင့်၀င်ရန်
            </a>
        </p>
    </div>

</section>
@endsection


{{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <h2 class="text-center pt-3 pb-5">အချက်အလက်များကိုမှန်ကန်စွာဖြည့်ပါ</h2>
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">အမည်</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="phone" class="col-md-4 col-form-label text-md-end">ဖုန်းနံပါတ်</label>

                            <div class="col-md-6">
                                <input id="phone" type="tel" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="email">

                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">စကားဝှက်</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">စကားဝှက်အတည်ပြုပါ</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="birth-date" class="col-md-4 col-form-label text-md-end">မွေးသက္ကရာဇ်</label>

                            <div class="col-md-6">
                                <input id="birth-date" type="date" class="form-control" name="birth_date" required>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="submit w-100">
                                    အကောင့်အသစ်ဖန်တီးမည်
                                </button>
                                <a href="{{ route('user.login') }}" class="back text-center my-2">အကောင့်ဝင်ရန်</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> --}}
 <!--login css-->
