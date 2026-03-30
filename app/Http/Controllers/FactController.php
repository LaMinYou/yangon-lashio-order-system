<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SourceArea;
use App\Models\Gate;
use App\Models\Product;
use App\Models\Shop;
use App\Models\Order;
use App\Models\Unit;

class FactController extends Controller
{
    protected $models = [
        'category'   => Category::class,
        'sourcearea' => SourceArea::class,
        'gate'       => Gate::class,
        'shop'       => Shop::class,
        'product'    => Product::class,
        'unit'       => Unit::class,
        'order'      => Order::class,
    ];

    public function showFactForms()
    {
        $categories = Category::latest()->get();
        return view('addFacts', compact('categories'));
    }

    // 🔹 Update
    public function edit($id, Request $request)
    {
        $request->validate([
            'type' => 'required|string',
            'name' => 'required|string|max:255'
        ]);

        $model = $this->resolveModel($request->type);

        $record = $model::findOrFail($id);
        $record->update(['name' => $request->name]);

        return redirect($this->getRedirectPath($request->type));
    }

    // 🔹 Delete
    public function delete($id, Request $request)
    {
        $request->validate([
            'type' => 'required|string'
        ]);

        $model = $this->resolveModel($request->type);
        $record = $model::findOrFail($id);

        try {
            // 🔥 Special rule for product
            if ($request->type === 'product') {
                if (Order::where('product_id', $id)->exists()) {
                    return back()->with('error', 'ဤအချက်လက်နှင့်ဆိုင်သောတင်ပို့ကုန်စာရင်းများရှိနေပါသဖြင့် ဖျက်၍မရပါ။');
                }
            }

            $record->delete();

            return redirect($this->getRedirectPath($request->type));

        } catch (\Exception $e) {
            return back()->with('error', 'ဖျက်ရာတွင် အမှားတစ်ခုဖြစ်နေပါသည်။');
        }
    }

    // 🔹 Resolve Model
    private function resolveModel($type)
    {
        if (!array_key_exists($type, $this->models)) {
            abort(404, 'Invalid type');
        }

        return $this->models[$type];
    }

    // 🔹 Redirect Path
    private function getRedirectPath($type)
    {
        return match ($type) {
            'category'   => '/categories',
            'sourcearea' => '/sourceareas',
            'gate'       => '/gates',
            'shop'       => '/shops',
            'product'    => '/products',
            'unit'       => '/units',
            'order'      => '/orders',
            default      => '/',
        };
    }
}
