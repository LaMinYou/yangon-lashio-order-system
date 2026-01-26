@props(['item', 'type'])

<div x-show="editOpen"
     class="fixed inset-0 z-[100] overflow-y-auto"
     style="display: none;">

    {{-- Backdrop --}}
    <div x-show="editOpen"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         @click="editOpen = false"
         class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm"></div>

    {{-- Modal Content --}}
    <div class="flex min-h-full items-center justify-center p-4">
        <div x-show="editOpen"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             class="relative w-full max-w-md bg-white rounded-3xl shadow-2xl overflow-hidden">

            <div class="p-8 text-center">
                <div class="w-16 h-16 bg-indigo-50 text-indigo-500 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">
                    <i class="fa-solid fa-circle-info"></i>
                </div>

                <h3 class="text-xl font-black text-slate-800 mb-2">အချက်အလက် ပြင်ဆင်မည်</h3>
                <p class="text-slate-500 text-sm mb-6">
                    လိုအပ်သော အချက်အလက်များကို ပြင်ဆင်ပြီးနောက် "အပ်ဒိတ်လုပ်ရန်" ကို နှိပ်ပါ။
                </p>

                <form action="{{ route('facts.update', $item->id) }}" method="POST" class="text-left">
                    @csrf
                    <div class="mb-6">
                        <label class="block text-xs font-bold text-slate-400 uppercase mb-2 ml-1">အမည် (Name)</label>
                        <input type="hidden" name="type" value="{{$type}}">
                        <input type="text" name="name" value="{{ $item->name }}"
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-700 focus:ring-2 focus:ring-indigo-500 focus:bg-white outline-none transition">
                    </div>

                    <div class="flex flex-col gap-2">
                        <button type="submit" class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold shadow-lg shadow-indigo-100 transition">
                            အပ်ဒိတ်လုပ်ရန်
                        </button>
                        <button @click="editOpen = false" type="button" class="w-full py-3 text-slate-400 font-bold hover:bg-slate-50 rounded-xl transition">
                            ပိတ်ရန်
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
