@extends('layouts.master')
@section('content')
    <header class="section-t-space">
        <div class="custom-container">
            <div class="header-panel">
                <a href="{{ route('cart.item') }}">
                    <i class="ri-arrow-left-s-line"></i>
                </a>
                <h2>Apply Coupon</h2>
            </div>
        </div>
    </header>
    <!-- header end -->

    <!-- coupon section start -->
    <section class="section-lg-b-space">
        <div class="custom-container">
            <h3 class="mb-3 dark-text">Available Coupons</h3>
            @foreach ($data as $value)
                <div class="row gy-3" style="margin-top: 5px;">
                    <div class="col-12">
                        <form action="{{ route('product.applycoupon') }}" method="post">
                            @csrf
                            <div class="coupon-box">
                                <div class="coupon-discount color-1">{{ $value->discount ?? '' }}
                                    {{ $value->discount_type ?? '' }}</div>
                                <div class="coupon-details">
                                    <div class="coupon-content">
                                        <div class="coupon-name">
                                            <img class="img-fluid coupon-img" src="assets/images/icons/google-pay.png"
                                                alt="c1" />
                                            <div>
                                                <h5 class="fw-semibold dark-text">{{ $value->title ?? '' }}</h5>
                                                <h6 class="light-text mt-1">{{ $value->coupon_type ?? '' }}</h6>
                                            </div>
                                        </div>
                                        <div class="coupon-code">
                                            <h6 class="light-text">{{ $value->code ?? '' }}</h6>
                                        </div>
                                    </div>
                                    <input type="hidden" name="coupon_code" value="{{ $value->code ?? '' }}" />
                                    <div class="coupon-apply">
                                        <h6 class="unlock"></h6>

                                        <input type="submit" class="theme-color fw-semibold" value="Apply"
                                            style="    border: none;
    background-color: white;">
                                    </div>
                                </div>
                        </form>
                        <img class="img-fluid coupon-left" src="assets/images/svg/coupon-left.svg" alt="right-border" />
                        <img class="img-fluid coupon-right" src="assets/images/svg/coupon-right.svg" alt="right-border" />
                    </div>
                </div>

        </div>
        @endforeach
        </div>
    </section>
@endsection
