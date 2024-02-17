@extends('layouts.admin.app')

@section('title', translate('verify_offline_payments'))
@if(session('status') == 'ok')
    <div class="alert alert-success">
        {{ translate('Status updated successfully.') }}
    </div>
@elseif(session('status') == 'error')
    <div class="alert alert-danger">
        {{ translate('Error updating status: ') . session('message') }}
    </div>
@endif
<meta name="base-url" content="{{ url('/') }}">
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')

    <div class="content container-fluid">
        <!-- Page Header Start -->
        <div class="">
            <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
                <h2 class="h1 mb-0 d-flex align-items-center gap-1">
                    <img width="20" class="avatar-img" src="{{asset('public/assets/admin/img/icons/all_orders.png')}}" alt="">
                    <span class="page-header-title">
                    {{translate('verify_offline_payments')}}
                </span>
                </h2>
                <span class="badge badge-soft-dark rounded-50 fz-14">{{ $orders->total() }}</span> 
            </div>
            <ul class="nav nav-tabs border-0 my-2">
                <li class="nav-item">
                    <a class="nav-link {{Request::is('admin/verify-offline-payment/pending')?'active':''}}"  href="{{route('admin.verify-offline-payment', ['pending'])}}">{{ translate('Pending Orders') }}</a>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link {{Request::is('admin/verify-offline-payment/denied')?'active':''}}"  href="{{route('admin.verify-offline-payment', ['denied'])}}">{{ translate('Denied Orders') }}</a>
                </li> --}}
            </ul>
        </div>
        <!-- Page Header End -->
        <!-- Card -->
        <div class="card">
            <!-- End Header -->

            <!-- Card Top -->
            <div class="card-top px-card pt-4">
                <div class="row justify-content-between align-items-center gy-2">
                    <div class="col-sm-8 col-md-6 col-lg-4">
                        <form action="{{url()->current()}}" method="GET">
                            <div class="input-group">
                                <input id="datatableSearch_" type="search" name="search"
                                       class="form-control"
                                       placeholder="{{translate('Search by Order ID, Order Status or Transaction Reference')}}" aria-label="Search"
                                       value="{{$search}}" required autocomplete="off">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary">
                                        {{translate('Search')}}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- End Card Top -->

            <!-- Table -->
            <div class="py-4">
                <div class="table-responsive datatable-custom">
                    <table class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                        <thead class="thead-light">
                        <tr>
                            <th>{{translate('SL')}}</th>
                            <th>{{translate('Order_ID')}}</th>
                            <th>{{translate('User_ID')}}</th>
                            <th>{{translate('Table_No.')}}</th>
                            <th>{{translate('Customer_Info')}}</th>
                            <th>{{translate('Total_Amount')}}</th>
                            <th>{{translate('Payment_method')}}</th>
                            <th>{{translate('Verification_status')}}</th>
                            <th class="text-center">{{translate('actions')}}</th>
                        </tr>
                        </thead>

                        <tbody id="set-rows">
                        @foreach($orders as $key=>$order)
                            <tr class="status-{{$order['order_status']}} class-all">
                                {{-- <td>{{$orders->firstitem()+$key}}</td> --}}
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <a class="text-dark" href="{{route('admin.orders.details',['id'=>$order['id']])}}">{{$order['id']}}</a>
                                </td>
                                <td>
                                    {{$order['user_id']}}
                                </td>
                                <td>
                                    {{$order['table_id']}}
                                </td>
                                <td>
                                    @if($order->is_guest == 0)
                                        @if($order->customerAddress)
                                            <h6 class="text-capitalize mb-1">
                                                <a class="text-dark" href="{{route('admin.customer.list')}}">
                                                    {{ $order->customerAddress->contact_person_name }}
                                                </a>          
                                            </h6>
                                            <a class="text-dark fz-12" href="tel:{{ $order->customerAddress->contact_person_number }}">
                                                {{ $order->customerAddress->contact_person_number }}
                                            </a>
                                        @else
                                            <span class="text-capitalize text-muted">
                                            {{translate('Anonymous')}}
                                            </span>
                                        @endif
                                    @else
                                        <h6 class="text-capitalize text-info">
                                            {{translate('Guest Customer')}}
                                        </h6>
                                    @endif
                                </td>

                                <td>
                                    {{-- <div>{{ \App\CentralLogics\Helpers::set_symbol($order['order_amount'] + $order['delivery_charge']) }}</div> --}}
                                    <div>{{ number_format($order['order_amount'], 2, '.', ',') }}</div>
                                </td>

                                <td>
                                    @if($order['payment_method'] == 2)
                                        <p>This order was paid with cash.</p>
                                    @else
                                        <p>This order was paid using a different payment method.</p>
                                    @endif
                                </td>
                                <td class="text-capitalize">
                                    @if ($order['payment_method'] == 2)
                                        @if ($order['order_status'] == 'pending')
                                            <span class="badge badge-soft-danger" id="statusValue">
                                                {{ translate('pending') }}
                                            </span>
                                        @elseif ($order['order_status'] == 'confirmed')
                                            <span class="badge badge-soft-info" id="statusValue">
                                                {{ translate('confirmed') }}
                                            </span>
                                        @elseif ($order['order_status'] == 'completed')
                                        <span class="badge badge-soft-success" id="statusValue">
                                            {{ translate('completed') }}
                                        </span>
                                        @endif
                                    @endif
                                    {{-- @elseif($order->status == 2)
                                        <span class="badge badge-soft-danger" id="statusValue">
                                            {{ translate('denied') }}
                                        </span> --}}
                                   
                                </td>
                                <td>
                                    <div class="btn--container justify-content-center">
                                        <button class="btn btn-primary" type="button" id="offline_details" onclick="openCustomModal({{ $order['id'] }})">
                                            {{ translate('Verify_Payment') }}
                                        </button>
                                    </div>
                                </td>
                            </tr>

                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
            <!-- End Table -->

            <div class="table-responsive mt-4 px-3">
                <div class="d-flex justify-content-lg-end">
                    <!-- Pagination -->
                   {!!$orders->links()!!}
                </div>
            </div>
        </div>
        <!-- End Card -->
    </div>

    {{-- <div class="modal fade" id="quick-view" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered coupon-details modal-lg" role="document">
            <div class="modal-content" id="quick-view-modal">
            </div>
        </div>
    </div> --}}

<!-- Your custom modal -->
@foreach($orders as $order)
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <i class="tio-clear"></i>
</button>
<div class="modal fade" id="customModal" tabindex="-1" role="dialog" aria-labelledby="customModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <h4 class="modal-title pb-2">{{translate('Payment_Verification')}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <!-- Add your content here -->
                @if($order['order_status'] == 'completed')
                    <p class="text-success">{{ translate('Verification Successfully Completed.') }}</p>
                @else
                <p class="text-danger">{{translate('Please Check & Verify the payment information whether it is correct or not before confirm the order.')}}</p>
        
                <button class="btn btn-success" onclick="verifyOfflinePayment({{ $order['id'] }})">
                    {{ translate('Payment_Received') }}
                </button>
                @endif
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection

@push('script_2')

<script>
    function openCustomModal(orderId) {
        $('#customModal').modal('show');
    }

    function verifyOfflinePayment(orderId) {
        
       var csrfToken = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
         
            url: '/admin/orders/verify-offline-payment/'+ orderId,
            type: 'PUT',
            dataType: 'json',
            headers: {
                    'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                // Update the UI based on the response
                if (response.success) {
                    $('#statusValue').removeClass('badge-soft-info').addClass('badge-soft-success').text('{{ translate('completed') }}');
                    $('#customModal').modal('hide');
                     // Reload the page after successful verification
                    location.reload();
                } else {
                    console.error('Failed to update order status.');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    }



</script>

@endpush