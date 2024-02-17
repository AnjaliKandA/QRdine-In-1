@extends('layouts.master')
@section('content')
    <meta http-equiv="Refresh" content="5">
    <header class="section-t-space">
        <div class="custom-container">
            <div class="header-panel">
                <a href="{{ route('home') }}">
                    <i class="ri-arrow-left-s-line"></i>
                </a>
                <h2>Order Tracking</h2>
            </div>
        </div>
    </header>
    <!-- Add the missing opening tag for the div with class "tracking-product" -->
    <div class="tracking-product">
        <div class="tracking-head">
            <img class="img-fluid profile-pic"
                src="{{ env('URL') . 'backend/storage/app/public/profile/' . $tabledata->waiter->image }}" alt="pro1" />
            <div>
                <h5>{{ Str::ucfirst($tabledata->waiter->f_name) ?? 'Asign Waiter Waiting..' }}
                    {{ Str::ucfirst($tabledata->waiter->l_name) ?? 'Asign Waiter Waiting..' }}
                </h5>
                <h6>Waiter</h6>


            </div>
            <div class="content-option">
                {{-- <a href="chatting.html">
                    <img class="img-fluid message-icon" src="assets/images/svg/message.svg" alt="message" />
                </a> --}}
                <a href="#">
                    <a href="tel:{{ $tabledata->waiter->phone ?? 0 }}">
                        <img class="img-fluid call-icon" src="assets/images/svg/call.svg" alt="call" />



                    </a>
            </div>
        </div>
        <div class="tracking-body">
            @php
                $createdAt = Carbon\Carbon::parse($orderdetail->created_at);
                $createtime = $createdAt->format('h:i A');

                $updateAt = Carbon\Carbon::parse($orderdetail->updated_at);
                $update = $updateAt->format('h:i A');

            @endphp

            <p>#{{ $orderdetail->id ?? 0 }}</p>
            <ul class="tracking-place">
                @if ($orderdetail->order_status == 'pending')
                    <li class="active">
                        <span></span>
                        <div class="d-flex justify-content-between theme-color w-100">
                            <h6>Placed</h6>
                            <h6>{{ $createtime ?? 0 }}</h6>
                        </div>
                    </li>
                @else
                    <li>
                        <span></span>
                        <div class="d-flex justify-content-between light-text w-100">
                            <h6>Placed</h6>
                            <h6>{{ $createtime ?? 0 }}</h6>
                        </div>
                    </li>
                @endif
                @if ($orderdetail->order_status == 'canceled')
                    <li class="active">
                        <span></span>
                        <div class="d-flex justify-content-between theme-color w-100">
                            <h6>Canceled Order</h6>
                            <h6>{{ $update ?? 0 }}</h6>
                        </div>
                    </li>
                @else
                @endif

                @if ($orderdetail->order_status == 'confirmed')
                    <li class="active">
                        <span></span>
                        <div class="d-flex justify-content-between theme-color w-100">
                            <h6>Confirm</h6>
                            <h6>{{ $update ?? 0 }}</h6>
                        </div>
                    </li>
                @else
                    <li>
                        <span></span>
                        <div class="d-flex justify-content-between light-text w-100">
                            <h6>Confirm</h6>

                        </div>
                    </li>
                @endif

                @if ($orderdetail->order_status == 'cooking')
                    <li class="active">
                        <span></span>
                        <div class="d-flex justify-content-between theme-color w-100">
                            <h6>Cooking</h6>
                            <h6>{{ $update ?? 0 }}</h6>
                        </div>
                    </li>
                @else
                    <li>
                        <span></span>
                        <div class="d-flex justify-content-between light-text w-100">
                            <h6>Cooking</h6>

                        </div>
                    </li>
                @endif


                @if ($orderdetail->order_status == 'serve')
                    <li class="active">
                        <span></span>
                        <div class="d-flex justify-content-between theme-color w-100">
                            <h6>Ready To Serve</h6>
                            <h6>{{ $update ?? 0 }}</h6>
                        </div>
                    </li>
                @else
                    <li>
                        <span></span>
                        <div class="d-flex justify-content-between light-text w-100">
                            <h6>Ready To Serve</h6>

                        </div>
                    </li>
                @endif


                @if ($orderdetail->order_status == 'completed')
                    <script>
                        window.location = 'ordersuccess';
                    </script>


                    <li class="active">
                        <span></span>
                        <div class="d-flex justify-content-between theme-color w-100">
                            <h6>Served</h6>
                            <h6>{{ $update ?? 0 }}</h6>
                        </div>
                    </li>
                @else
                    <li>
                        <span></span>
                        <div class="d-flex justify-content-between light-text w-100">
                            <h6>Served</h6>
                        </div>
                    </li>
                @endif
            </ul>
        </div>
        {{-- <div class="d-flex gap-3 justify-content-center text-center container">
            <a href="{{ route('order.more') }}" class="btn btn-success flex-fill">Order More
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="16" height="16">
                    <path
                        d="M8 16A8 8 0 1 1 8 0a8 8 0 0 1 0 16Zm3.78-9.72a.751.751 0 0 0-.018-1.042.751.751 0 0 0-1.042-.018L6.75 9.19 5.28 7.72a.751.751 0 0 0-1.042.018.751.751 0 0 0-.018 1.042l2 2a.75.75 0 0 0 1.06 0Z">
                    </path>
                </svg>
            </a>

            @if ($orderdetail->payment_method == 1)
                <a href="#" class="btn btn-warning flex-fill">PhonePe
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="16" height="16">
                        <path
                            d="M8 16A8 8 0 1 1 8 0a8 8 0 0 1 0 16Zm3.78-9.72a.751.751 0 0 0-.018-1.042.751.751 0 0 0-1.042-.018L6.75 9.19 5.28 7.72a.751.751 0 0 0-1.042.018.751.751 0 0 0-.018 1.042l2 2a.75.75 0 0 0 1.06 0Z">
                        </path>
                    </svg>
                </a>
            @else
                <a href="#" class="btn btn-warning flex-fill">Cash
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="16" height="16">
                        <path
                            d="M8 16A8 8 0 1 1 8 0a8 8 0 0 1 0 16Zm3.78-9.72a.751.751 0 0 0-.018-1.042.751.751 0 0 0-1.042-.018L6.75 9.19 5.28 7.72a.751.751 0 0 0-1.042.018.751.751 0 0 0-.018 1.042l2 2a.75.75 0 0 0 1.06 0Z">
                        </path>
                    </svg>
                </a>
            @endif
        </div> --}}

        {{-- <section class="categories section-lg-b-space">
            <h3 class="text-center mb-3">Ask For</h3>
            <div class="custom-container">
                <div class="row gy-5 ratio_square">
                    <div class="col-4">
                        <div class="food-categories food">
                            <input type="checkbox" name="foodSelection" id="biryaniRadio">
                            <label for="biryaniRadio" class="img-container">
                                <img class="img-fluid categories-img" src="assets/images/product/biryani.png"
                                    alt="biryani" />
                            </label>
                        </div>
                        <h6>Water</h6>
                    </div>
                    <div class="col-4">
                        <div class="food-categories food">
                            <input type="checkbox" name="foodSelection" id="biryaniRadio">
                            <label for="biryaniRadio" class="img-container">
                                <img class="img-fluid categories-img" src="assets/images/product/biryani.png"
                                    alt="biryani" />
                            </label>
                        </div>
                        <h6>Cuttleries</h6>
                    </div>
                    <div class="col-4">
                        <div class="food-categories food">
                            <input type="checkbox" name="foodSelection" id="biryaniRadio">
                            <label for="biryaniRadio" class="img-container">
                                <img class="img-fluid categories-img" src="assets/images/product/biryani.png"
                                    alt="biryani" />
                            </label>
                        </div>
                        <h6>Other</h6>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end" style="margin-right: 27px;
    margin-top: 12px;">
                <a href="#" class='btn btn-success cart-btn'>Ask</a>
            </div>
        </section> --}}
    </div>
@endsection
