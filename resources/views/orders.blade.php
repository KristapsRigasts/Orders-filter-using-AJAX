@extends('layout')

@section('content')

    <div class="container mt-5 py-5 px-5 ">
        <div class="row ">
            <div class="col-md-10 col-md-offset-1 border rounded py-5 bg-white">
                <div class="">
                    <div class="row i-title-row">
                        <div class="col-xs-8 text-center">

                            <div>
                                @include('inc.date_picker')
                            </div>

                            <div class="mb-5 ">
                                @include('inc.search')
                                @include('inc.filter')

                            </div>

                            <div class="">
                                <button id="reset" class="btn btn-md btn-primary shadow-none active" role="button"
                                        aria-pressed="true">Clear Filters
                                </button>
                            </div>

                            <div id="order_data">
                                @include('pages.order_data')
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

    <script>
        function toggle(source) {
            let checkboxes = document.querySelectorAll('input[type="checkbox"]');
            for (let i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i] != source)
                    checkboxes[i].checked = source.checked;
            }
        }

        $(document).ready(function () {
            $(document).on('click', '.pagination a', function (event) {
                event.preventDefault();
                let page = $(this).attr('href').split('page=')[1];
                getMoreOrders(page);
            });

            $('#desired_loading_date').on('change', function () {
                getMoreOrders();
            });

            $('#search').on('keyup', function () {
                $value = $(this).val();
                getMoreOrders(1);
            });

            $('#transport_group').on('keyup', function () {
                $value = $(this).val();
                getMoreOrders();
            });

            $('#order_number').on('keyup', function () {
                $value = $(this).val();
                getMoreOrders();
            });

            $('#customer_order_number').on('keyup', function () {
                $value = $(this).val();
                getMoreOrders();
            });

            $('#qty').on('change', function () {
                getMoreOrders();
            });

            $('#unit').on('change', function () {
                getMoreOrders();
            });

            $('#plant').on('change', function () {
                getMoreOrders();
            });

            $('#per_page').on('change', function () {
                getMoreOrders();
            })

            $('#reset').click(function () {
                $('#transport_group').val('');
                $('#order_number').val('');
                $('#customer_order_number').val('');
                $('#qty').val('Qty');
                $('#unit').val('Units');
                $('#plant').val('Plant')
                $('#per_page').val('Per page');
                $('#search').val('');
                $('#desired_loading_date').val('');
                getMoreOrders();
            })
        });

        function getMoreOrders(page) {

            let search = $('#search').val();

            let date = $("#desired_loading_date").val();
            let selectedDate = date.split("-").reverse().join(".");

            let selectedTransportGroup = $('#transport_group').val();

            let selectedOrderNumber = $("#order_number").val();

            let selectedCustomerOrderNumber = $("#customer_order_number").val();

            let selectedQty = $("#qty option:selected").val();

            let selectedUnit = $("#unit").val();

            let selectedPlant = $("#plant option:selected").val();

            let selectedPerPage = $("#per_page option:selected").val();

            $.ajax({
                type: "GET",
                data: {
                    'desiredLoadingDate': selectedDate,
                    'searchQuery': search,
                    'transportGroup': selectedTransportGroup,
                    'orderNumber': selectedOrderNumber,
                    'customerOrderNumber': selectedCustomerOrderNumber,
                    'qty': selectedQty,
                    'unit': selectedUnit,
                    'plant': selectedPlant,
                    'perPage': selectedPerPage
                },
                url: "{{ route('get-more-orders') }}" + "?page=" + page,
                success: function (data) {
                    $('#order_data').html(data);
                }
            });
        }
    </script>

@endpush



