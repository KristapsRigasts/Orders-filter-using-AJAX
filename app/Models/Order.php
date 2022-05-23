<?php

namespace App\Models;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'customer_order_number',
        'order_customer_id',
        'carrier_id',
        'carrier_id_from_orders',
        'carrier_id_from_update',
        'carrier_code_from_update',
        'item',
        'qty',
        'unit',
        'plant',
        'desired_date',
        'transport_group',
        'shipping_type',
        'line_num',
        'incoterm',
        'load_date',
        'load_time',
        'delivery_date',
        'delivery_time'
    ];


    public static function getOrders($desiredLoadingDate, $searchKeyword, $transportGroup, $orderNumber,
                                     $customerOrderNumber, $qty, $unit, $plant, $perPage): LengthAwarePaginator
    {
        $ordersPerPage = 20;

        $orders = DB::table('orders')->orderBy('created_at');

        if (!empty($searchKeyword)) {
            $orders->where(function ($q) use ($searchKeyword) {
                $q->where('orders.order_number', 'like', '%' . $searchKeyword . '%')
                    ->orWhere('orders.customer_order_number', 'like', '%' . $searchKeyword . '%')
                    ->orWhere('orders.qty', 'like', '%' . $searchKeyword . '%')
                    ->orWhere('orders.unit', 'like', '%' . $searchKeyword . '%')
                    ->orWhere('orders.plant', 'like', '%' . $searchKeyword . '%')
                    ->orWhere('orders.transport_group', 'like', '%' . $searchKeyword . '%')
                    ->orWhere(DB::raw("FROM_UNIXTIME( orders.desired_date, '%d.%m.%Y' )"), 'like', '%' . $searchKeyword . '%');
            });
        }

        if (!empty($desiredLoadingDate) && $desiredLoadingDate != '') {
            $orders = $orders->where(DB::raw("FROM_UNIXTIME(desired_date, '%d.%m.%Y' )"), $desiredLoadingDate);
        }

        if (!empty($transportGroup)) {
            $orders->where('orders.transport_group', 'like', '%' . $transportGroup . '%');
        }

        if (!empty($orderNumber)) {
            $orders->where('orders.order_number', 'like', '%' . $orderNumber . '%');
        }

        if (!empty($customerOrderNumber)) {
            $orders->where('orders.customer_order_number', 'like', '%' . $customerOrderNumber . '%');
        }

        if (!empty($qty) && $qty != 'Qty') {
            $orders = $orders->where('qty', $qty);
        }

        if (!empty($unit) && $unit != 'Units') {
            $orders = $orders->where('unit', $unit);
        }

        if (!empty($plant) && $plant != 'Plant') {
            $orders = $orders->where('plant', $plant);
        }

        if (!empty($perPage) && $perPage != 'Per page' && $perPage != $ordersPerPage) {
            $ordersPerPage = $perPage;
        }

        return $orders->paginate($ordersPerPage);
    }

    public static function removeDuplicate(string $columnName): Collection
    {
        return DB::table('orders')
            ->select($columnName)->where($columnName, '!=', '')->orderBy($columnName)
            ->get($columnName)->unique();
    }
}
