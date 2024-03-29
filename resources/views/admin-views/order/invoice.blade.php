@extends('layouts.admin.app')

@section('title', '')

@push('css_or_js')
    <style>
        @media print {
            .non-printable {
                display: none;
            }

            .printable {
                display: block;
            }
        }

        .hr-style-2 {
            border: 0;
            height: 1px;
            background-image: linear-gradient(to right, rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0));
        }

        .hr-style-1 {
            overflow: visible;
            padding: 0;
            border: none;
            border-top: medium double #000000;
            text-align: center;
        }

        #printableAreaContent * {
            font-weight: normal !important;
        }
    </style>

    <style type="text/css" media="print">
        @page {
            size: auto;
            /* auto is the initial value */
            margin: 2px;
        }
    </style>
@endpush

@section('content')

    <div class="content container-fluid" style="color: black">
        <div class="row justify-content-center" id="printableArea">
            <div class="col-md-12">
                <center>
                    <input type="button" class="btn btn-primary non-printable" onclick="printDiv('printableArea')"
                        value="{{ translate('Proceed, If thermal printer is ready.') }}" />
                    <a href="{{ url()->previous() }}" class="btn btn-danger non-printable">{{ translate('Back') }}</a>
                </center>
                <hr class="non-printable">
            </div>
            <div class="col-5" id="printableAreaContent">
                <div class="text-center pt-4 mb-3">
                    <h2 style="line-height: 1">
                        {{ \App\Model\BusinessSetting::where(['key' => 'restaurant_name'])->first()->value }}</h2>
                    <h5 style="font-size: 20px;font-weight: lighter;line-height: 1">
                        {{ \App\Model\BusinessSetting::where(['key' => 'address'])->first()->value }}
                    </h5>
                    <h5 style="font-size: 16px;font-weight: lighter;line-height: 1">
                        Phone : {{ \App\Model\BusinessSetting::where(['key' => 'phone'])->first()->value }}
                    </h5>
                </div>
                <hr class="text-dark hr-style-1">

                <div class="row mt-4">
                    <div class="col-6">
                        <h5>{{ translate('Order ID : ') }}{{ $order['id'] }}</h5>
                    </div>
                    <div class="col-6">
                        <h5 style="font-weight: lighter">
                            <span
                                class="font-weight-normal">{{ date('d/M/Y h:m a', strtotime($order['created_at'])) }}</span>
                        </h5>
                    </div>
                    <div class="col-12">
                        @if ($order->is_guest == 0)
                            @if (isset($order->customer))
                                <h5>
                                    {{ translate('Customer Name : ') }}<span
                                        class="font-weight-normal">{{ $order->customer['f_name'] . ' ' . $order->customer['l_name'] }}</span>
                                </h5>
                                <h5>
                                    {{ translate('Phone : ') }}<span
                                        class="font-weight-normal">{{ $order->customer['phone'] }}</span>
                                </h5>
                                @php($address = \App\Model\CustomerAddress::find($order['delivery_address_id']))
                                <h5>
                                    {{ translate('Address : ') }}<span
                                        class="font-weight-normal">{{ isset($address) ? $address['address'] : '' }}</span>
                                </h5>
                            @endif
                        @endif
                        @if ($order->is_guest == 1)
                            @if ($order->order_type == 'delivery')
                                @if (isset($order->delivery_address))
                                    <h5>
                                        {{ translate('Customer Name : ') }}<span
                                            class="font-weight-normal">{{ $order->delivery_address['contact_person_name'] }}</span>
                                    </h5>
                                    <h5>
                                        {{ translate('Phone : ') }}<span
                                            class="font-weight-normal">{{ $order->delivery_address['contact_person_number'] }}</span>
                                    </h5>
                                    <h5>
                                        {{ translate('Address : ') }}<span
                                            class="font-weight-normal">{{ $order->delivery_address['address'] }}</span>
                                    </h5>
                                @endif
                            @endif
                        @endif
                    </div>
                </div>
                <h5 class="text-uppercase"></h5>
                <hr class="text-dark hr-style-2">
                <table class="table table-bordered mt-3">
                    <thead>
                        <tr>
                            <tr>
                                    <th>{{ translate('SL') }}</th>
                                    <th>{{ translate('Item Details') }}</th>
                               
                                    <th>{{ translate('Price') }}</th>
                                    <th>{{ translate('Discount') }}</th>
                                    <th>{{ translate('Tax') }}</th>
                                    <th class="text-right">{{ translate('Total_price') }}</th>
                                </tr>
                        </tr>
                    </thead>

                   
                            <tbody>
                                <tr>
                                </tr>
                                @php($sub_total = 0)
                                @php($total_tax = 0)
                                @php($total_dis_on_pro = 0)
                                @php($add_ons_cost = 0)
                                @php($add_on_tax = 0)
                                @php($add_ons_tax_cost = 0)
                                @foreach ($order->details as $detail)
                              

                                @php(
                                      $productdetail=App\Models\Product::where('id',$detail->product_id)->first()
                                  )
                                  
                                    @php($product_details = json_decode($detail['product_details'], true))
                                    @php($add_on_qtys = json_decode($detail['add_on_qtys'], true))
                                    @php($add_on_prices = json_decode($detail['add_on_prices'], true))
                                    @php($add_on_taxes = json_decode($detail['add_on_taxes'], true))

                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="media gap-3 w-max-content">

                                                <img class="img-fluid avatar avatar-lg"
                                                    src="{{ env('URL') . 'backend/storage/app/public/product/' . $productdetail->image }}"
                                                    onerror="this.src='{{ asset('public/assets/admin/img/160x160/img2.jpg') }}'"
                                                    alt="Image Description">

                                                   
                                                </div>
                                            </div>
                                        </td>
                                      
                                        
                                        <td>
                                            @php($amount = $detail['price'] * $detail['quantity'])
                                            {{ \App\CentralLogics\Helpers::set_symbol($amount) }}
                                        </td>
                                        <td>
                                            @php($tot_discount = $detail['discount_on_product'] * $detail['quantity'])
                                            {{ \App\CentralLogics\Helpers::set_symbol($tot_discount) }}
                                        </td>
                                        <td>
                                            @php($product_tax = $detail['tax_amount'] * $detail['quantity'])
                                            {{ \App\CentralLogics\Helpers::set_symbol($product_tax + $add_ons_tax_cost) }}
                                        </td>
                                        <td class="text-right">
                                            {{ \App\CentralLogics\Helpers::set_symbol($amount - $tot_discount + $product_tax) }}
                                        </td>
                                    </tr>
                                    @php($total_dis_on_pro += $tot_discount)
                                    @php($sub_total += $amount)
                                    @php($total_tax += $product_tax)

                                @endforeach
                            </tbody>
            </table>


            <div class="row justify-content-md-end mb-3 m-0" style="width: 99%">
                <div class="col-md-10 p-0">
                    <dl class="row text-right" style="color: black!important;">
                        <dt class="col-6">{{ translate('Items Price:') }}</dt>
                        <dd class="col-6">{{ \App\CentralLogics\Helpers::set_symbol($sub_total) }}</dd>
                        <dt class="col-6">{{ translate('Tax / VAT:') }}</dt>
                        <dd class="col-6">{{ \App\CentralLogics\Helpers::set_symbol($total_tax + $add_ons_tax_cost) }}
                        </dd>
                        <dt class="col-6">{{ translate('Addon Cost:') }}</dt>
                        <dd class="col-6">
                            {{ \App\CentralLogics\Helpers::set_symbol($add_ons_cost) }}
                            <hr>
                        </dd>

                        <dt class="col-6">{{ translate('Subtotal:') }}</dt>
                        <dd class="col-6">
                            {{ \App\CentralLogics\Helpers::set_symbol($sub_total + $total_tax + $add_ons_cost + $add_ons_tax_cost) }}
                        </dd>
                        <dt class="col-6">{{ translate('Extra Discount') }}:</dt>
                        <dd class="col-6">
                            - {{ \App\CentralLogics\Helpers::set_symbol($order['extra_discount']) }}</dd>
                        <dt class="col-6">{{ translate('Coupon Discount:') }}</dt>
                        <dd class="col-6">
                            - {{ \App\CentralLogics\Helpers::set_symbol($order['coupon_discount_amount']) }}</dd>
                        <dt class="col-6">{{ translate('Delivery Fee:') }}</dt>
                        <dd class="col-6">
                            @if ($order['order_type'] == 'take_away')
                                @php($del_c = 0)
                            @else
                                @php($del_c = $order['delivery_charge'])
                            @endif
                            {{ \App\CentralLogics\Helpers::set_symbol($del_c) }}
                            <hr>
                        </dd>

                        <dt class="col-6" style="font-size: 20px">{{ translate('Total:') }}</dt>
                        <dd class="col-6" style="font-size: 20px">
                            {{ \App\CentralLogics\Helpers::set_symbol($sub_total + $del_c + $total_tax + $add_ons_cost - $order['coupon_discount_amount'] - $order['extra_discount'] + $add_ons_tax_cost) }}
                        </dd>

                        <!-- partial payment-->
                        @if ($order->order_partial_payments->isNotEmpty())
                            @foreach ($order->order_partial_payments as $partial)
                                <dt class="col-6">
                                    <div class="">
                                        <span>
                                            {{ translate('Paid By') }}
                                            ({{ str_replace('_', ' ', $partial->paid_with) }})
                                        </span>
                                        <span>:</span>
                                    </div>
                                </dt>
                                <dd class="col-6 text-dark text-right">
                                    {{ \App\CentralLogics\Helpers::set_symbol($partial->paid_amount) }}
                                </dd>
                            @endforeach
                            <?php
                            $due_amount = 0;
                            $due_amount = $order->order_partial_payments->first()?->due_amount;
                            ?>
                            <dt class="col-6">
                                <div class="">
                                    <span>
                                        {{ translate('Due Amount') }}</span>
                                    <span>:</span>
                                </div>
                            </dt>
                            <dd class="col-6 text-dark text-right">
                                {{ \App\CentralLogics\Helpers::set_symbol($due_amount) }}
                            </dd>
                        @endif
                    </dl>
                </div>
            </div>
            <hr class="text-dark hr-style-2">
            <h5 class="text-center pt-3">
                {{ translate('"""THANK YOU"""') }}
            </h5>
            <hr class="text-dark hr-style-2">
            <div class="text-center">{{ \App\Model\BusinessSetting::where(['key' => 'footer_text'])->first()->value }}
            </div>
        </div>
    </div>
</div>

@endsection

@push('script')
<script>
    function printDiv(divName) {

        if ($('html').attr('dir') === 'rtl') {
            $('html').attr('dir', 'ltr')
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            $('#printableAreaContent').attr('dir', 'rtl')
            window.print();
            document.body.innerHTML = originalContents;
            $('html').attr('dir', 'rtl')
        } else {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }

    }
</script>
@endpush
