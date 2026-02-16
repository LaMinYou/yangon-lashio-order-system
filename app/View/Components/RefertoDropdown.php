<?php

namespace App\View\Components;

use App\Models\Shop;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class RefertoDropdown extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.referto-dropdown',[
            "shops" => Shop::latest()->get(),
            "currentShop" => request('shop') == "all"?"လွှဲပြောင်းဆိုင်အားလုံး": request('shop')
        ]);
    }
}
