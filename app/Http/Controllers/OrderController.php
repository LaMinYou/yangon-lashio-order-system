<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\SourceArea;
use App\Models\Order;
use App\Models\Shop;
use App\Models\Gate;
use App\Models\Product;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Response;


use function PHPUnit\Framework\isEmpty;

class OrderController extends Controller
{
    public function orderForm()
    {
        $categories = Category::latest()->get();
        $areas = SourceArea::latest()->get();
        $shops = Shop::latest()->get();
        $gates = Gate::latest()->get();
        return view('productform', compact('categories', 'areas', 'shops', 'gates'));
    }
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'export_date' => 'required|date',
            'source_area_id' => 'required|exists:source_areas,id',
            'category_id' => 'required|exists:categories,id',
            'product' => 'required|string',
            'weight' => 'required|numeric',
            'netweight' => 'required|numeric',
            'price' => 'required|numeric',
            'unit' => 'required|string',
        ]);
        if ($validator->fails()) {
            return back()->with('error', 'အချက်အလက်များကိုပြည့်စုံစွာထည့်ပါ');
        }
        try {
            $order = new Order;
            $order->export_date = $request->export_date;
            $order->user_id = Auth::id();
            $order->source_area_id = $request->source_area_id;
            $order->category_id = $request->category_id;
            $order->product_name = $request->product;
            $order->weight = $request->weight;
            $order->net_weight = $request->netweight;
            $order->unit = $request->unit;
            $order->price = $request->price;
            $order->total = $request->total;
            $order->status = "ပို့နေဆဲ";
            $order->shop_id = $request->shop_id;
            $order->gate_id = $request->gate_id;
            $order->weightfee = $request->weight_price;
            $order->save();
            return back()->with('success', 'အောင်မြင်စွာ တင်သွင်းပြီးပါပြီ။');
        } catch (\Exception $e) {
            return back()->with('error', 'တင်သွင်းရာတွင် အမှားအယွင်းတစ်ခု ဖြစ်နေပါသည်။'.$e);
        }
    }
    public function index()
    {
        $orders = Order::query()
            ->orderBy('status', 'asc')
            ->orderBy('created_at', 'desc')
            ->filter(request(['status', 'from_date', 'to_date', 'nameunit']))
            ->simplePaginate(5)
            ->withQueryString(); // Keeps filters active when clicking 'Next/Previous'

        return view('orders', compact('orders'));
    }
    public function show($id)
    {
        $orders = Order::where('user_id', $id)
            ->orderBy('status', 'asc')
            ->orderBy('created_at', 'desc')
            ->filter(request(['status', 'from_date', 'to_date', 'nameunit']))
            ->simplePaginate(5)
            ->withQueryString();
        return view('orders', compact('orders'));
    }

    public function edit(Order $order)
    {
        if (!empty(request()->status)) {
            $status = (int)request()->status;
            $statusText = match ($status) {
                0 => 'ပို့နေဆဲ',
                1 => 'ရောက်ပြီး',
                default => 'ရောင်းပြီး',
            };
            $order->update([
                'status' => $statusText
            ]);

            return back();
        }
        // Otherwise, update remark
        elseif (!empty(request()->remark)) {
            $order->update(['remark' => request()->remark]);
        }
        //Otherwise, update data by id
        else {
            $categories = Category::latest()->get();
            $areas = SourceArea::latest()->get();
            $gates = Gate::latest()->get();
            $products = Product::where('category_id', $order->category->id)->get();
            return view('editOrder', compact('order', 'categories', 'areas', 'gates', 'products'));
        }

        return back();
    }
    public function update(Request $request, Order $order)
    {
        $validator = Validator::make($request->all(), [
            'export_date' => 'required|date',
            'source_area_id' => 'required|exists:source_areas,id',
            'product_name' => 'required',
            'weight' => 'required|numeric',
            'netweight' => 'required|numeric',
            'price' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return back()->with('error', 'အချက်အလက်များကိုပြည့်စုံစွာထည့်ပါ');
        }
        try {
            $order->export_date = $request->export_date;
            $order->source_area_id = $request->source_area_id;
            $order->product_name = $request->product_name;
            $order->weight = $request->weight;
            $order->net_weight = $request->netweight;
            $order->price = $request->price;
            $order->total = $request->total;
            $order->gate_id = $request->gate_id;
            $order->weightfee = $request->weight_price;
            $order->save();
            return redirect("/user/" . Auth::id() . "/orders");
        } catch (\Exception $e) {
            return back()->with('error', 'အမှားအယွင်းတစ်ခု ဖြစ်နေပါသည်။');
        }
    }

    public function exportAll(Request $request)
    {
        $orders = json_decode(base64_decode($request->orders), true);
        //dd($orders);
        if (!$orders || count($orders) == 0) {
            return back()->with('error', 'No orders available for export.');
        }
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // headings
        $sheet->fromArray([
            [
                'Export Date',
                'Exporter',
                'Source Area',
                'Category',
                'Product Name',
                'Weight',
                'Net Weight',
                'Unit',
                'Price',
                'Total Price',
                'Status',
                'Gate',
                'Shop',
                'Weight Fee(တန်ဆာခ)'
            ]
        ]);
        // Make header row bold
        $sheet->getStyle('A1:N1')->getFont()->setBold(true);

        $row = 2;

        foreach ($orders['data'] as $order) {
            $order = (object)$order;
            $sheet->fromArray([
                [
                    $order->export_date,
                    $order->user['name'],
                    $order->source_area['name'],
                    $order->category['name'],
                    $order->product_name,
                    $order->weight,
                    $order->net_weight,
                    $order->unit,
                    $order->price,
                    $order->total,
                    $order->status,
                    $order->gate['name'],
                    $order->shop['name']??'',
                    $order->weightfee
                ]
            ], null, "A{$row}");

            $row++;
        }

        $fileName = 'filtered_orders.xlsx';
        $writer = new Xlsx($spreadsheet);
        $writer->save($fileName);

        return response()->download($fileName)->deleteFileAfterSend(true);
    }
}
