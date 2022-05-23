
<form action="">
    <div class="">
        <select id="per_page" class="form-control" style="display: inline-block; width: auto; float: right">
            <option>Per page</option>
            @foreach($perPage as $page)
                <option>{{ $page }}</option>
            @endforeach
        </select>
    </div>

    <div class="">
        <select id="plant" class="form-control" style="display: inline-block; width: auto; float: right">
            <option disabled selected hidden>Plant</option>
            @foreach($uniquePlant as $order)
                <option>{{$order->plant }}</option>
            @endforeach
        </select>
    </div>

    <div class="">
        <select id="unit" class="form-control" style="display: inline-block; width: auto; float: right">
            <option disabled selected hidden>Units</option>
            @foreach($uniqueUnit as $order)
                @if(!empty($order->unit ))
                    <option>{{$order->unit }}</option>
                @endif
            @endforeach
        </select>
    </div>

    <div class="">
        <select id="qty" class="form-control" style="display: inline-block; width: auto; float: right">
            <option disabled selected hidden>Qty</option>
            @foreach($uniqueQty as $order)
                @if(!empty($order->qty ))
                    <option>{{$order->qty }}</option>
                @endif
            @endforeach
        </select>
    </div>

    <div class="">
        <input id="customer_order_number" type="text" class="form-control input-small" style="width: 150px; float: right" placeholder="Customer Order"/>
    </div>

    <div class="">
        <input id="order_number" type="text" class="form-control input-small" style="width: 150px; float: right" placeholder="Order Number"/>
    </div>

    <div class="">
        <input id="transport_group" type="text" class="form-control input-small" style="width: 150px; float: right" placeholder="Transport Group"/>
    </div>

</form>

