@extends('layouts.master')
@section('content')
    @include('layouts.frontend.header2')

    <section>
        <div class="custom-container">
            <h3 class="fw-semibold dark-text">Food Items</h3>
            @forelse ($items as $data)
                <div class="horizontal-product-box mt-3">
                    <div class="product-img">
                        <img class="img-fluid img"
                            src="{{ env('URL') . 'backend/storage/app/public/product/' . $data->options->image }}"
                            alt="rp1" />
                    </div>
                    <div class="product-content">
                        <h5>{{ $data->name ?? '' }}</h5>
                        <h6>{{ Str::limit($data->options->desc, 30) }}</h6>
                        {{-- <div class="plus-minus">
                            <i class="ri-subtract-line sub"></i>
                            <input type="number" value="{{ $data->qty }}" min="1" max="10" />
                            <i class="ri-add-line add"></i>
                        </div> --}}
                        <div class="plus-minus">
                            <i class="ri-subtract-line sub" data-id={{ $data->rowId }} data-qty={{ $data->qty }}></i>

                            <input type="number" value="{{ $data->qty ?? 0 }}" min="1" max="10"
                                class="qty" />
                            <i class="ri-add-line add" data-id={{ $data->rowId }} data-qty={{ $data->qty }}>
                            </i>
                        </div>
                        <img class="red-symbol" src="assets/images/svg/nonveg.svg" alt="non-veg" />
                        <h3 class="product-price">₹ {{ $data->price * $data->qty ?? 0 }}</h3>
                    </div>
                </div>
            @empty
            @endforelse



        </div>
    </section>
    <!-- Add Cart section end -->

    {{-- <section>
        <div class="custom-container">
            <a href="{{ route('home') }}" class="apply-coupon">
                <div>
                    <h5 class="dark-text">Add More</h5>
                </div>
                <i class="ri-arrow-right-s-line"></i>
            </a>
        </div>
    </section> --}}
    <section>
        <div class="custom-container">
            <a href="#" class="apply-coupon">
                <div>
                    <h5 class="dark-text">Add Cooking Instruction</h5>
                    <input class="dark-text form-control" id='ins' placeholder="Enter your cooking instruction here"
                        style="border: none; width: 300px" />

                </div>

            </a>
        </div>
    </section>
    <!-- Coupon section start -->
    {{-- <section>
        <div class="custom-container">
            <a href="{{ route('apply.coupon') }}" class="apply-coupon">
                <div>
                    <h5 class="dark-text">Apply Coupon</h5>
                    <h6 class="coupon-code">{{ $coupondata->code ?? '' }}</h6>
                </div>
                <i class="ri-arrow-right-s-line"></i>
            </a>
        </div>
    </section> --}}
    <!-- Coupon section end -->

    <!-- Bill details section start -->
    <section class="bill-details">
        <div class="custom-container">
            <h3 class="fw-semibold dark-text">Bill Details</h3>
            <div class="total-detail mt-3">
                <div class="sub-total">
                    <h5>Sub Total</h5>
                    <h5 class="fw-semibold">₹{{ Cart::subtotal() ?? 0 }}</h5>
                </div>
                <div class="sub-total pb-3">
                    <h5>Discount </h5>
                    <h5 class="fw-semibold">₹{{ $coupondata->discount ?? 0.0 }}</h5>
                </div>
                <div class="sub-total pb-3">
                    <h5>Tax</h5>
                    <h5 class="fw-semibold">₹0.0</h5>
                </div>

                <div class="grand-total">
                    <h5 class="fw-semibold">Grand Total</h5>
                    @if (!empty($coupondata->discount))
                        @php

                            $total = Cart::subtotal() - $coupondata->discount ?? 0;
                        @endphp

                        <h5 class="fw-semibold amount">₹ {{ $total }}</h5>
                    @else
                        <h5 class="fw-semibold amount">₹ {{ Cart::subtotal() ?? 0 }}</h5>
                    @endif
                </div>
                <img class="dots-design" src="assets/images/svg/dots-design.svg" alt="dots" />
            </div>
        </div>
    </section>

    {{-- <ul class="payment-list section-lg-b-space">
        <li class="cart-add-box payment-card-box gap-0 mt-3">
            <div class="payment-detail">
                <div class="add-img">
                    <img class="img-fluid img" src="assets/images/icons/svg/google-pay.svg" alt="google-pay" />
                </div>
                <div class="add-content">
                    <div>
                        <h5 class="fw-semibold">Google Pay</h5>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" value="1" type="radio" name="flexRadioDefault" />
                    </div>
                </div>
            </div>
        </li>
        <li class="cart-add-box payment-card-box gap-0 mt-3">
            <div class="payment-detail">
                <div class="add-img">
                    <img class="img-fluid img" src="assets/images/icons/svg/cash.svg" alt="cash" />
                </div>
                <div class="add-content">
                    <div>
                        <h5 class="fw-semibold">Cash</h5>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" value="2" type="radio" name="flexRadioDefault" />
                    </div>
                </div>
            </div>
        </li>
    </ul> --}}
    <!-- Bill details section end -->
    <!-- pay popup start -->
    @if (Cart::count() > 0)
        <div class="pay-popup">
            <div class="price-items">
                @if (!empty($coupondata->discount))
                    @php

                        $total = Cart::subtotal() - $coupondata->discount ?? 0;
                    @endphp


                    <h3>₹ {{ $total }}.00</h3>
                @else
                    <h5 class="fw-semibold amount" style="color: white;">₹ {{ Cart::subtotal() ?? 0 }}</h5>
                @endif

                <h6>{{ Cart::count() ?? 0 }} item Added</h6>
            </div>
            {{-- href="{{ route('cart.checkout') }}" --}}
            <a onclick="cartdata()" class="btn theme-btn pay-btn mt-0">Select Your Preferences</a>
        </div>
    @endif



    <script>
        function cartdata(data) {



            var ins = $('#ins').val();


            $.ajax({
                type: "get",
                url: "{{ route('ordermorecart.checkout') }}",
                data: {

                    ins: ins

                },
                success: function(data) {

                    location.replace('/ordermore_preferences');

                }
            });





        }
    </script>
@endsection
