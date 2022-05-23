<div class="row justify-content-end py-4">
    <div class="col-auto ">
        {{ $orders->links() }}
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-auto ">
        <table class="table table-bordered table-hover table-condensed ">
            <thead>
            <tr>
                <th><input type="checkbox" id="select-all" onclick="toggle(this);"></th>
                <th>#</th>
                <th>Transport group</th>
                <th>Order number</th>
                <th>Customer order number</th>
                <th>Qty</th>
                <th>Units</th>
                <th>Desired loading date</th>
                <th>Plant</th>
            </tr>
            </thead>
            <tbody>
            @if(!$orders)
                <b>There are no orders placed!</b>
            @else
                @foreach($orders as $index => $order)
                    <tr>
                        <td><input type="checkbox"></td>
                        <td>{{ $index + 1 }} </td>
                        <td>{{ $order->transport_group }}</td>
                        <td>{{ $order->order_number }}</td>
                        <td>{{ $order->customer_order_number }}</td>
                        <td>{{ $order->qty }}</td>
                        <td>{{ $order->unit }}</td>
                        <td>{{ date( 'd.m.Y', $order->desired_date ) }}</td>
                        <td>{{ $order->plant }}</td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
</div>



