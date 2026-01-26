@props(['item', 'delete' => null, 'type'])

<div x-data="{ editOpen: false, deleteOpen: false }" class="bg-white p-4 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-all mb-4 max-w-2xl mx-auto">
    <div class="flex items-center justify-between">
        {{-- Left Side: Icon and Name --}}
        <div class="flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400">
                <i class="fa-solid fa-layer-group"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest leading-none mb-1">
                    {{ $type }} Name
                </p>
                <h3 class="text-slate-700 font-bold text-lg leading-tight">
                    {{ $item->name }}
                </h3>
            </div>
        </div>

        {{-- Right Side: Actions --}}
        <div class="flex items-center gap-2">
            <button @click="editOpen = true" type="button"
                class="p-2 text-slate-300 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition">
                <i class="fa-regular fa-pen-to-square text-lg"></i>
            </button>
            
            @if(!empty($delete))
            <button @click="deleteOpen = true" type="button"
                class="p-2 text-slate-300 hover:text-red-500 hover:bg-red-50 rounded-lg transition">
                <i class="fa-solid fa-trash-can text-lg"></i>
            </button>
            @endif
        </div>
    </div>

    {{-- Tailwind Edit Modal --}}
    <x-editDialog :item="$item" :type="$type" />

    {{-- Tailwind Delete Modal --}}
    <x-deleteDialog :item="$item" :type="$type" />
</div>
