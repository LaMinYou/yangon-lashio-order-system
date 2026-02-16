<!-- Make sure Alpine.js is loaded in your layout -->
<div class="max-w-md mx-auto text-center my-6 md:my-12" x-data="{ open: false }">
    <!-- Dropdown Button -->
    <button
        @click="open = !open"
        type="button"
        class="px-4 py-2 w-full border border-green-500 text-green-600 font-medium rounded-md shadow-sm hover:bg-green-50 focus:outline-none focus:ring-2 focus:ring-green-500 flex justify-between items-center">
        {{ isset($currentShop) ? $currentShop : 'Filter By Refers To' }}
        <svg class="w-4 h-4 ml-2 transition-transform duration-200" :class="{'rotate-180': open}" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.584l3.71-4.354a.75.75 0 111.14.976l-4 4.688a.75.75 0 01-1.14 0l-4-4.688a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
        </svg>
    </button>

    <!-- Dropdown Menu -->
    <ul
        x-show="open"
        x-transition
        @click.outside="open = false"
        class="mt-2 bg-white border border-gray-200 rounded-md shadow-lg absolute z-50">


        <!-- For all refers to list -->
        <li>
            @if(auth()->user()->role_id == 2)
            <a
                href="/orders/?shop=all{{request('status')?'&status='.request('status'):''}}{{request('from_date')?'&from_date='.request('from_date'):''}}{{request('to_date')?'&to_date='.request('to_date'):''}}{{request('nameunit')?'&nameunit='.request('nameunit'):''}}"
                class="block px-4 py-2 text-gray-700 hover:bg-green-100 hover:text-green-700">
                လွှဲပြောင်းဆိုင်အားလုံး
            </a>
            @elseif(auth()->user()->role_id == 1)
            <a
                href="/user/{{auth()->id()}}/orders/?shop=all{{request('status')?'&status='.request('status'):''}}{{request('from_date')?'&from_date='.request('from_date'):''}}{{request('to_date')?'&to_date='.request('to_date'):''}}{{request('nameunit')?'&nameunit='.request('nameunit'):''}}"
                class="block px-4 py-2 text-gray-700 hover:bg-green-100 hover:text-green-700">
                လွှဲပြောင်းဆိုင်အားလုံး
            </a>
            @endif
        </li>


        @foreach($shops as $shop)
        <li>
            @if(auth()->user()->role_id == 2)
            <a
                href="/orders/?shop={{$shop->name}}{{request('status')?'&status='.request('status'):''}}{{request('from_date')?'&from_date='.request('from_date'):''}}{{request('to_date')?'&to_date='.request('to_date'):''}}{{request('nameunit')?'&nameunit='.request('nameunit'):''}}"
                class="block px-4 py-2 text-gray-700 hover:bg-green-100 hover:text-green-700">
                {{ $shop->name }}
            </a>
            @elseif(auth()->user()->role_id == 1)
            <a
                href="/user/{{auth()->id()}}/orders/?shop={{$shop->name}}{{request('status')?'&status='.request('status'):''}}{{request('from_date')?'&from_date='.request('from_date'):''}}{{request('to_date')?'&to_date='.request('to_date'):''}}{{request('nameunit')?'&nameunit='.request('nameunit'):''}}"
                class="block px-4 py-2 text-gray-700 hover:bg-green-100 hover:text-green-700">
                {{ $shop->name }}
            </a>
            @endif
        </li>
        @endforeach

        {{-- NONE = No Filter --}}
        <li>
            <a href="{{ request()->fullUrlWithQuery(['shop' => null]) }}"
                class="block px-4 py-2 hover:bg-green-100">
                အားလုံး (Filter မလုပ်ပါ)
            </a>
        </li>
    </ul>
</div>