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
use App\Models\Unit;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Response;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;


use function PHPUnit\Framework\isEmpty;

class OrderController extends Controller
{
    public function orderForm()
    {
        $categories = Category::latest()->get();
        $areas = SourceArea::latest()->get();
        $shops = Shop::latest()->get();
        $gates = Gate::latest()->get();
        $units = Unit::latest()->get();
        return view('productform', compact('categories', 'areas', 'shops', 'gates', 'units'));
    }
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'export_date' => 'required|date',
            'source_area_id' => 'required|exists:source_areas,id',
            'category_id' => 'required|exists:categories,id',
            'product' => 'required|string',
            'count' => 'required',
            'weight' => 'required|numeric',
            'netweight' => 'required|numeric',
            'price' => 'required|numeric',
            'unit_id' => 'required|exists:units,id',
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
            $order->count = $request->count;
            $order->weight = $request->weight;
            $order->net_weight = $request->netweight;
            $order->unit_id = $request->unit_id;
            $order->price = $request->price;
            $order->total = $request->total;
            $order->status = "ပို့နေဆဲ";
            //$order->shop_id = $request->shop_id;
            $order->gate_id = $request->gate_id;
            $order->weightfee = $request->weight_price;
            $order->save();
            return back()->with('success', 'အောင်မြင်စွာ တင်သွင်းပြီးပါပြီ။');
        } catch (\Exception $e) {
            return back()->with('error', 'တင်သွင်းရာတွင် အမှားအယွင်းတစ်ခု ဖြစ်နေပါသည်။' . $e);
        }
    }
    public function index()
    {
        $orders = Order::query()
            ->orderBy('status', 'asc')
            ->orderBy('created_at', 'desc')
            ->filter(request(['shop', 'status', 'from_date', 'to_date', 'nameunit']))
            ->simplePaginate(5)
            ->withQueryString(); // Keeps filters active when clicking 'Next/Previous'

        $exportOrders = Order::query()
            ->with(['user', 'sourceArea', 'category', 'unit', 'gate', 'shop'])
            ->orderBy('status', 'asc')
            ->orderBy('created_at', 'desc')
            ->filter(request(['shop', 'status', 'from_date', 'to_date', 'nameunit']))
            ->get();

        $shops = Shop::latest()->get();

        return view('orders', compact('orders', 'shops', 'exportOrders'));
    }
    public function show($id)
    {
        $orders = Order::where('user_id', $id)
            ->orderBy('status', 'asc')
            ->orderBy('created_at', 'desc')
            ->filter(request(['shop', 'status', 'from_date', 'to_date', 'nameunit']))
            ->simplePaginate(5)
            ->withQueryString();

        $exportOrders = Order::where('user_id', $id)
            ->with(['user', 'sourceArea', 'category', 'unit', 'gate', 'shop'])
            ->orderBy('status', 'asc')
            ->orderBy('created_at', 'desc')
            ->filter(request(['shop', 'status', 'from_date', 'to_date', 'nameunit']))
            ->get();

        $shops = Shop::latest()->get();
        return view('orders', compact('orders', 'shops', 'exportOrders'));
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
        elseif (!empty(request()->remark) || !empty(request()->shop_id)) {
            $order->update(['shop_id' => request()->shop_id, 'remark' => request()->remark]);
        }
        //Otherwise, update data by id
        else {
            $categories = Category::latest()->get();
            $areas = SourceArea::latest()->get();
            $gates = Gate::latest()->get();
            $units = Unit::latest()->get();
            $shops = Shop::latest()->get();
            $products = Product::where('category_id', $order->category->id)->get();
            return view('editOrder', compact('order', 'categories', 'areas', 'gates', 'units', 'shops', 'products'));
        }

        return back();
    }
    public function update(Request $request, Order $order)
    {
        // Check if this is a Status Update from the Order Card
        if ($request->has('status')) {
            $status = (int)$request->status;
            $statusText = match ($status) {
                0 => 'ပို့နေဆဲ',
                1 => 'ရောက်ပြီး',
                2 => 'ရောင်းပြီး',
                default => 'ပို့နေဆဲ',
            };
            $order->update(['status' => $statusText]);
            return back()->with('success', 'အခြေအနေပြောင်းလဲပြီးပါပြီ');
        }

        // Check if this is a Remark/Shop Update from the Order Card
        if ($request->has('remark') || $request->has('shop_id')) {
            $order->update([
                'shop_id' => $request->shop_id,
                'remark' => $request->remark
            ]);
            return back()->with('success', 'မှတ်ချက်သိမ်းဆည်းပြီးပါပြီ');
        }

        // --- Otherwise, this is a FULL EDIT from the Edit Page ---
        $validator = Validator::make($request->all(), [
            'export_date' => 'required|date',
            'source_area_id' => 'required|exists:source_areas,id',
            'product_name' => 'required',
            'count' => 'required',
            'weight' => 'required|numeric',
            'netweight' => 'required|numeric',
            'unit_id' => 'required',
            'price' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return back()->with('error', 'အချက်အလက်များကိုပြည့်စုံစွာထည့်ပါ');
        }

        try {
            $order->update([
                'export_date' => $request->export_date,
                'source_area_id' => $request->source_area_id,
                'product_name' => $request->product_name,
                'count' => $request->count,
                'weight' => $request->weight,
                'net_weight' => $request->netweight,
                'unit_id' => $request->unit_id,
                'price' => $request->price,
                'total' => $request->total,
                'gate_id' => $request->gate_id,
                'weightfee' => $request->weight_price,
            ]);
            return redirect("/user/" . Auth::id() . "/orders")->with('success', 'ပြင်ဆင်မှုအောင်မြင်ပါသည်။');
        } catch (\Exception $e) {
            return back()->with('error', 'အမှားအယွင်းတစ်ခု ဖြစ်နေပါသည်။');
        }
    }
    public function destroy(Order $order)
    {
        try {
            $order->delete();
            if (Auth::user()->role_id == 2) {
                return redirect('/orders');
            } else {
                return redirect('/user/' . Auth::user()->id . '/orders');
            }
        } catch (\Exception $e) {
            if (Auth::user()->role_id == 2) {
                return redirect('/orders')->with('error', 'အမှားအယွင်းတစ်ခု ဖြစ်နေပါသည်။');
            } else {
                return redirect('/user/' . Auth::user()->id . '/orders')->with('error', 'အမှားအယွင်းတစ်ခု ဖြစ်နေပါသည်။');
            }
        }
    }

    // public function exporting(Request $request)
    // {
    //     $orders = json_decode(base64_decode($request->exportOrders), true);

    //     if (!$orders || count($orders) == 0) {
    //         return back()->with('error', 'No orders available for export.');
    //     }

    //     $spreadsheet = new Spreadsheet();
    //     $sheet = $spreadsheet->getActiveSheet();

    //     // Headings
    //     $sheet->fromArray([
    //         [
    //             'Export Date',
    //             'Exporter',
    //             'Source Area',
    //             'Category',
    //             'Product Name',
    //             'Weight',
    //             'Net Weight',
    //             'Unit',
    //             'Count',
    //             'Price',
    //             'Total Price',
    //             'Status',
    //             'Gate',
    //             'Shop(Refer To)',
    //             'Weight Fee'
    //         ]
    //     ]);

    //     $sheet->getStyle('A1:O1')->getFont()->setBold(true);

    //     // Number format for MMK with Comma
    //     $mmkFormat = '#,##0 "MMK"';

    //     $row = 2;
    //     foreach ($orders as $orderData) {
    //         $order = (object)$orderData;

    //         $sheet->fromArray([
    //             [
    //                 $order->export_date ?? '',
    //                 $order->user['name'] ?? '',
    //                 $order->source_area['name'] ?? '',
    //                 $order->category['name'] ?? '',
    //                 $order->product_name ?? '',
    //                 $order->weight ?? 0,
    //                 $order->net_weight ?? 0,
    //                 $order->unit['name'] ?? '',
    //                 $order->count ?? 1,
    //                 $order->price ?? 0,
    //                 $order->total ?? 0,
    //                 $order->status ?? '',
    //                 $order->gate['name'] ?? '',
    //                 $order->shop['name'] ?? '',
    //                 $order->weightfee ?? 0
    //             ]
    //         ], null, "A{$row}");

    //         // Price နဲ့ Total Column တွေကို MMK format သတ်မှတ်ခြင်း
    //         $sheet->getStyle("J{$row}:K{$row}")
    //             ->getNumberFormat()
    //             ->setFormatCode($mmkFormat);

    //         $row++;
    //     }

    //     $lastDataRow = $row - 1;

    //     // Grand Total Row
    //     $sheet->setCellValue("J{$row}", 'Grand Total');
    //     $sheet->setCellValue("K{$row}", "=SUM(K2:K{$lastDataRow})");

    //     // Grand Total ကို Comma + MMK format သတ်မှတ်ပြီး Bold တင်ခြင်း
    //     $sheet->getStyle("K{$row}")
    //         ->getNumberFormat()
    //         ->setFormatCode($mmkFormat);

    //     $sheet->getStyle("J{$row}:K{$row}")->getFont()->setBold(true);

    //     // Auto fit column width
    //     foreach (range('A', 'O') as $columnID) {
    //         $sheet->getColumnDimension($columnID)->setAutoSize(true);
    //     }

    //     $fileName = 'orders_export_' . now()->format('Y-m-d') . '.xlsx';
    //     $writer = new Xlsx($spreadsheet);

    //     $tempFile = tempnam(sys_get_temp_dir(), 'export');
    //     $writer->save($tempFile);

    //     return response()->download($tempFile, $fileName)->deleteFileAfterSend(true);
    // }

    public function exporting(Request $request)
    {
        $orders = json_decode(base64_decode($request->exportOrders), true);

        if (!$orders || count($orders) == 0) {
            return back()->with('error', 'No orders available for export.');
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // 1. Headings (နံပါတ်စဉ် 'No.' ကို ရှေ့ဆုံးက ထည့်ထားပါတယ်)
        $sheet->fromArray([
            [
                'No.',
                'Export Date',
                'Exporter',
                'Source Area',
                'Category',
                'Product Name',
                'Weight',
                'Net Weight',
                'Unit',
                'Count',
                'Price',
                'Total Price',
                'Status',
                'Gate',
                'Shop(Refer To)',
                'Weight Fee'
            ]
        ]);

        // Range ပြောင်းသွားတဲ့အတွက် A1:P1 ဖြစ်သွားပါမယ် (Column တစ်ခုတိုးသွားလို့)
        $sheet->getStyle('A1:P1')->getFont()->setBold(true);

        $mmkFormat = '#,##0 "MMK"';
        $row = 2;
        $no = 1; // နံပါတ်စဉ်အတွက် variable

        foreach ($orders as $orderData) {
            $order = (object)$orderData;

            // 2. Date Format ပြောင်းလဲခြင်း (Apr 07, 2026)
            $formattedDate = '';
            if (!empty($order->export_date)) {
                $formattedDate = \Carbon\Carbon::parse($order->export_date)->format('M d, Y');
            }

            $sheet->fromArray([
                [
                    $no++, // နံပါတ်စဉ် ထည့်ခြင်းနှင့် auto increment လုပ်ခြင်း
                    $formattedDate, // format ပြောင်းထားသော date
                    $order->user['name'] ?? '',
                    $order->source_area['name'] ?? '',
                    $order->category['name'] ?? '',
                    $order->product_name ?? '',
                    $order->weight ?? 0,
                    $order->net_weight ?? 0,
                    $order->unit['name'] ?? '',
                    $order->count ?? 1,
                    $order->price ?? 0,
                    $order->total ?? 0,
                    $order->status ?? '',
                    $order->gate['name'] ?? '',
                    $order->shop['name'] ?? '',
                    $order->weightfee ?? 0
                ]
            ], null, "A{$row}");

            // Column Index များ တစ်ဆင့်စီ ရွေ့သွားသည့်အတွက် J, K မှ K, L သို့ ပြောင်းရပါမည်
            $sheet->getStyle("K{$row}:L{$row}")
                ->getNumberFormat()
                ->setFormatCode($mmkFormat);

            $row++;
        }

        $lastDataRow = $row - 1;

        // Grand Total Row (Column K နှင့် L သို့ ရွှေ့လိုက်ပါသည်)
        $sheet->setCellValue("K{$row}", 'Grand Total');
        $sheet->setCellValue("L{$row}", "=SUM(L2:L{$lastDataRow})");

        $sheet->getStyle("L{$row}")
            ->getNumberFormat()
            ->setFormatCode($mmkFormat);

        $sheet->getStyle("K{$row}:L{$row}")->getFont()->setBold(true);

        // Auto fit column width (A မှ P အထိ)
        foreach (range('A', 'P') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $fileName = 'orders_export_' . now()->format('Y-m-d') . '.xlsx';
        $writer = new Xlsx($spreadsheet);

        $tempFile = tempnam(sys_get_temp_dir(), 'export');
        $writer->save($tempFile);

        return response()->download($tempFile, $fileName)->deleteFileAfterSend(true);
    }
}
