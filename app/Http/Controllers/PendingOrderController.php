<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class PendingOrderController extends Controller
{
    public function index()
    {
        $perPage= [20,50,100];

        $orders = Order::getOrders(
            '',
            '',
            '',
            '',
            '',
            'Qty',
            'Units',
            'Plant',
            'Per page'
        );

        /* If adding new orders clear the cache */

        $uniqueOrderPlant = cache()->rememberForever('unique-order-plant', function (){
           return Order::removeDuplicate('plant');
        });

        $uniqueOrderUnit = cache()->rememberForever('unique-unit', function (){
            return Order::removeDuplicate('unit');
        });

        $uniqueOrderQty =
            cache()->rememberForever('unique-qty', function (){
                return Order::removeDuplicate('qty');
            });

        return view('orders')
            ->with('orders', $orders)
            ->with('uniquePlant', $uniqueOrderPlant)
            ->with('uniqueUnit', $uniqueOrderUnit)
            ->with('uniqueQty', $uniqueOrderQty)
            ->with('perPage', $perPage);
    }

    public function getMoreOrders(Request $request)
    {
        $desiredLoadingDate = $request->desiredLoadingDate;

        $query = $request->searchQuery;

        $transportGroup = $request->transportGroup;
        $orderNumber = $request->orderNumber;
        $customerOrderNumber = $request->customerOrderNumber;
        $qty = $request->qty;
        $unit = $request->unit;
        $plant = $request->plant;
        $perPage = $request->perPage;

        if($request->ajax()) {
            $orders = Order::getOrders($desiredLoadingDate, $query, $transportGroup, $orderNumber, $customerOrderNumber, $qty, $unit, $plant, $perPage);
            return view('pages.order_data', compact('orders'))->render();
        }
    }
}
