@extends('layouts.layout')

@section('title')
    Role Selection Form
@endsection
@section('content')
     <section class="root-container">
      <div class="space-y-10 md:space-y-16">
          <h1 class="text-2xl md:text-4xl font-semibold text-center text-stone-800">အသုံးပြုသူအဆင့်‌‌သတ်မှတ်ပါ</h1>
         <form action="{{ route('role') }}" class=" space-y-7"  method="post" >
        @csrf
          <div class="grid grid-cols-2 gap-6 md:gap-10 max-w-4xl mx-auto w-full">

              <div class="selection-card user admin active:bg-indigo-400 duration-200">
                  <div class="card-icon">
                      <img src="./images/user.svg" alt="Admin" class="h-full">
                  </div>
                  <h2 class="text-xl font-medium text-center text-stone-700 pt-4">အက်ဒ်မင်</h2>
              </div>

              <div class="selection-card user exporter active:bg-indigo-400 duration-200">
                  <div class="card-icon">
                      <img src="./images/users.svg" alt="Users" class="h-full">
                  </div>
                  <h2 class="text-xl font-medium text-center text-stone-700 pt-4">အသုံးပြုသူ</h2>
              </div>

          </div>
         <input type="hidden" name="role" class="role" value="1" required>
          <div class="max-w-xl mx-auto text-center space-y-8">
              <!-- <p class="text-stone-500 tracking-wide">
                  Lorem ipsum dolor sit amet consectetur adipisicing elit. Enim, similique!
              </p> -->
              <div class="max-w-xs mx-auto">
                  <button  type="submit" class="btn-continue">ဆက်လက်လုပ်ဆောင်မည်</button>
              </div>
          </div>
        </form>
      </div>
    </section>
    {{-- <div class="container w-100 m-auto my-5 shadow-lg rounded-2" style="max-width:700px;">
        <form action="{{ route('role') }}" method="post" class="p-3 text-center">
            @csrf

            <h2 class="text-center py-3">အသုံးပြုသူအဆင့်‌‌သတ်မှတ်ပါ</h2>
            <div class="row g-3">
                <div class="col-12 col-sm-6 bg-slate-200">
                    <div class="user exporter text-center p-4 rounded-1">
                        <i class="fa-solid fa-user" style="font-size:2em"></i>
                        <p class="py-3" style="font-size:1.5em;">အသုံးပြုသူ</p>
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="user admin text-center p-4 rounded-1">
                        <i class="fa-solid fa-user-tie" style="font-size:2em"></i>
                        <p class="py-3" style="font-size:1.5em;">အက်ဒ်မင်</p>
                    </div>
                </div>
            </div>
            <input type="hidden" name="role" class="role" value="1" required>
            <button type="submit" class="submit my-3">ဆက်လုပ်ပါ <i class="fa-solid fa-arrow-right"></i></button>
        </form>
    </div> --}}
@endsection
