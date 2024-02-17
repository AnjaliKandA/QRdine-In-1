@extends('layouts.master')
@section('content')

<meta http-equiv="Refresh" content="5">
    <header class="section-t-space">
        <div class="custom-container">
            <div class="header-panel">
                <a href="{{ route('home') }}">
                    <i class=""></i>
                </a>
                <h2>Order Tracking</h2>
            </div>
        </div>
    </header>
    <!-- Add the missing opening tag for the div with class "tracking-product" -->
    <div class="tracking-product" style="margin-top:30px;">
        {{-- <input type="hidden" id="orderId" value="{{ $orderdetail->id }}"> --}}
        <div class="tracking-body">
        
            @php
                $createdAt = isset($orderdetail[0]['order']->created_at) ? Carbon\Carbon::parse($orderdetail[0]['order']->created_at) : null;
                
                $createtime = $createdAt ? $createdAt->format('h:i A') : null;

                $updatedAt = isset($orderdetail[0]['order']->updated_at) ? Carbon\Carbon::parse($orderdetail[0]['order']->updated_at) : null;
                $update = $updatedAt ? $updatedAt->format('h:i A') : null;
            @endphp

            {{-- <h3 style="text-align: center">#{{ $orderdetail->id ?? 0 }}</h3> --}}
            @foreach ($orderdetail as $orderDetails)
                <h3 style="text-align: center">Order ID: {{ $orderDetails['order']->id ?? 'N/A' }}</h3>
          
            <ul class="tracking-place">
                @if (isset($orderDetails['order']['order_status']) && $orderDetails['order']['order_status'] == 'pending')
                    <li class="active">
                        <span></span>
                        <div class="d-flex justify-content-between theme-color w-100">
                            <h6>Placed</h6>
                               <h6>{{ $createtime ?? 'N/A' }}</h6>
                        </div>
                    </li>
                @else
                    <li>
                        <span></span>
                        <div class="d-flex justify-content-between light-text w-100">
                            <h6>Placed</h6>
                            {{-- <h6>{{ $createtime ?? 0 }}</h6> --}}
                            <h6>{{ $createtime ?? 'N/A' }}</h6>
                        </div>
                    </li>
                @endif
               
                @if (isset($orderDetails['order']['order_status']) && $orderDetails['order']['order_status'] == 'canceled')
                    <li class="active">
                        <span></span>
                        <div class="d-flex justify-content-between theme-color w-100">
                            <h6>Canceled Order</h6>
                            <h6>{{ $update ?? 'N/A' }}</h6>
                        </div>
                    </li>
                @else
                @endif
                
                @if (isset($orderDetails['order']['order_status']) && $orderDetails['order']['order_status'] == 'confirmed')
                    <li class="active">
                        <span></span>
                        <div class="d-flex justify-content-between theme-color w-100">
                            <h6>Confirm</h6>
                            <h6>{{ $update ?? 'N/A' }}</h6>
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
                
                @if (isset($orderDetails['order']['order_status']) && $orderDetails['order']['order_status'] == 'cooking')
                    <li class="active">
                        <span></span>
                        <div class="d-flex justify-content-between theme-color w-100">
                            <h6>Cooking</h6>
                            <h6>{{ $update ?? 'N/A' }}</h6>
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

                @if (isset($orderDetails['order']['order_status']) && $orderDetails['order']['order_status'] == 'serve')
                    <li class="active">
                        <span></span>
                        <div class="d-flex justify-content-between theme-color w-100">
                            <h6>Ready To Serve</h6>
                            <h6>{{ $update ?? 'N/A' }}</h6>
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

                @if (isset($orderDetails['order']['order_status']) && $orderDetails['order']['order_status'] == 'completed')
                    <script>
                        window.location = 'ordersuccess';
                    </script>


                    <li class="active">
                        <span></span>
                        <div class="d-flex justify-content-between theme-color w-100">
                            <h6>Served</h6>
                            <h6>{{ $update ?? 'N/A' }}</h6>
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
        @endforeach  
        </div>
   <div class="d-flex gap-3 justify-content-center text-center container">
            @foreach ($orderdetail as $orderDetails)
            <a href="" class="btn btn-success flex-fill">Click Here For Payment
                
            </a>
            @if (isset($orderDetails['order']['payment_method']))
            @if ($orderDetails['order']['payment_method'] == 1)
                <a href="#" class="btn btn-warning flex-fill">PhonePe
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="16" height="16">
                        <path
                            d="M8 16A8 8 0 1 1 8 0a8 8 0 0 1 0 16Zm3.78-9.72a.751.751 0 0 0-.018-1.042.751.751 0 0 0-1.042-.018L6.75 9.19 5.28 7.72a.751.751 0 0 0-1.042.018.751.751 0 0 0-.018 1.042l2 2a.75.75 0 0 0 1.06 0Z">
                        </path>
                    </svg>
                </a>
            @elseif ($orderDetails['order']['payment_method'] == 2)
                <a href="{{ route('send.cash.notification') }}" class="btn btn-warning flex-fill">Cash
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="16" height="16">
                        <path
                            d="M8 16A8 8 0 1 1 8 0a8 8 0 0 1 0 16Zm3.78-9.72a.751.751 0 0 0-.018-1.042.751.751 0 0 0-1.042-.018L6.75 9.19 5.28 7.72a.751.751 0 0 0-1.042.018.751.751 0 0 0-.018 1.042l2 2a.75.75 0 0 0 1.06 0Z">
                        </path>
                    </svg>
                </a>
            @endif
            @endif
            @endforeach
        </div>
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
          {{-- <!-- Add a loading screen -->
        <div id="loading-screen">
            <p style="font-weight: bold; text-align: center; color: #000" id="loading-message">Please Wait ........</p>
        </div> --}}
    </div>
{{-- <script>
    document.getElementById('cashButton').addEventListener('click', function (event) {
        event.preventDefault();

        showLoadingScreen();

        verifyOffPayment()
            .then((response) => {
                if (response.success) {
                    if (response.confirmed) {
                        document.getElementById('loading-message').innerText = 'Process Completed!';
                    } else {
                        document.getElementById('loading-message').innerText = 'Pending...';
                    }

                    setTimeout(() => {
                        hideLoadingScreen();
                    }, 2000);
                } else {
                    throw new Error('Verification failed: ' + response.error);
                }
            })
            .catch((error) => {
                // console.error('Error during the process:', error);
                hideLoadingScreen();
            });
    });

    function showLoadingScreen() {
        document.getElementById('loading-screen').style.display = 'flex'; // Show the loading screen
    }

    function hideLoadingScreen() {
        document.getElementById('loading-screen').style.display = 'none'; // Hide the loading screen
    }

    function verifyOffPayment() {
        const orderId = document.getElementById('orderId').value;
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        const url = '/admin/orders/verify-offline-payment/' + orderId;

        return fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                // Add any other headers if needed
            },
        })
        .then(response => response.json())
        .then(data => ({
            success: true,
            confirmed: data.confirmed,
        }))
        .catch(error => ({ success: false, error: error.message }));
    }
</script> --}}
{{-- <style>
    #loading-screen {
        position: fixed;
        top: 250px;
        left: 200px;
        width: 50%;
        height: 15%;
        background-color:#198754;
        display: none;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        border-radius: 15px;
    }
    </style> --}}
@endsection