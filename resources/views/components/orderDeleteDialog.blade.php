@props(['order'])

<div x-show="deleteOrder"
     class="fixed inset-0 z-[100] overflow-y-auto"
     style="display: none;">

    <div x-show="deleteOrder" x-transition @click="deleteOrder = false" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm"></div>

    <div class="flex min-h-full items-center justify-center p-4 text-center">
        <div x-show="deleteOrder" x-transition class="relative w-full max-w-xs bg-white rounded-3xl shadow-2xl p-8">
            <div class="w-16 h-16 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">
                <i class="fa-solid fa-trash-can"></i>
            </div>

            <h3 class="text-xl font-black text-slate-800 mb-2">သေချာပါသလား?</h3>
            <p class="text-slate-500 text-sm mb-6">ဤအချက်အလက်ကို ဖျက်ရန် သေချာပါသလား? ဤလုပ်ဆောင်ချက်ကို ပြန်ပြင်၍မရပါ။</p>

            <div class="flex flex-col gap-2">
                <form action="{{ route('orders.delete', $order->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full py-3 bg-red-500 hover:bg-red-600 text-white rounded-xl font-bold transition shadow-lg shadow-red-100">
                        အတည်ပြုဖျက်မည်
                    </button>
                </form>
                <button @click="deleteOrder = false" type="button" class="w-full py-3 text-slate-400 font-bold hover:bg-slate-50 rounded-xl transition">
                    မဖျက်တော့ပါ
                </button>
            </div>
        </div>
    </div>
</div>
