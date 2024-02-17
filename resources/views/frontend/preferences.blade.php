<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="author" content="" />
    <link rel="manifest" href="manifest.json" />
    <link rel="icon" href="assets/images/logo/favicon.png" type="image/x-icon" />
    <title>QRDine-In</title>
    <link rel="apple-touch-icon" href="assets/images/logo/favicon.png" />
    <meta name="theme-color" content="#ff8d2f" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <meta name="apple-mobile-web-app-title" content="" />
    <meta name="msapplication-TileImage" content="assets/images/logo/favicon.png" />
    <meta name="msapplication-TileColor" content="#FFFFFF" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto&display=swap');
    </style>
    <style>
        .customNoftificationItem {
            font-family: 'Roboto', sans-serif;

        }
    </style>

    <!-- font link -->
    <link rel="stylesheet" href="assets/css/vendors/metropolis.min.css" />

    <!-- remixicon css -->
    <link rel="stylesheet" type="text/css" href="assets/css/vendors/remixicon.css" />

    <!-- bootstrap css -->
    <link rel="stylesheet" id="rtl-link" type="text/css" href="assets/css/vendors/bootstrap.min.css" />

    <!-- Theme css -->
    <link rel="stylesheet" id="change-link" type="text/css" href="assets/css/style.css" />

    <style>
        .customButtonofDropdown {
            margin-top: 0;
            padding-top: 2px;
        }
    </style>
</head>

<body>
    <!-- header start -->
    <header class="section-t-space">
        <div class="custom-container">
            <div class="header-panel">
                <a href="{{ route('cart.item') }}">
                    <i class="ri-arrow-left-s-line"></i>
                </a>
                <h2>Select Your Details</h2>
            </div>
        </div>
    </header>
    <!-- header end -->

    
 
    {{-- <section class="section-b-space pt-0">
        <div class="custom-container text-white fw-normal">
            <ul class="notification">
                <li class="notification-box unread customNoftificationItem">
                    <div class="notification-icon fs-5">
                        <span style="background-color: #FEEA8C; color: black;">1</span>
                    </div>



                    <div class="notification-content d-flex justify-content-between"
                        style="background-color: #FEEA8C; color:black">
                        <div>
                            <h5>Selected Items </h5>
                            @forelse ($prefenecesitem as $value)
                                @if ($value->pre_count == 1)
                                    <h6>{{ Str::limit($value->productData->name, 40) }}</h6>
                                @endif
                            @empty
                            @endforelse

                        </div>
                        <div class="dropdown">
                            <button class="btn btn-light customButtonofDropdown"
                                style="background-color: #FEEA8C; border:none;" type="button" id="dropdownMenuButton1"
                                data-bs-toggle="dropdown" aria-expanded="false">

                                <img class="img" src="{{ asset('assets/images/dropdown.png') }}" alt="veg"
                                    style="margin-left: 164px;
                            width: 15%;" />
                            </button>
                            <form action="{{ route('cart.preferences') }}" method="post">
                                @csrf
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1">


                                    @forelse ($prefeneces as $data)
                                        @if ($data->categoryData->preparation_time < 16 || $data->categoryData->preparation_time == 10)
                                            <li><a class="dropdown-item"
                                                    href="#">{{ $data->productData->name ?? '' }}

                                                    {{ $data->qty ?? '' }}

                                                    <span> &nbsp;&nbsp;
                                                        <input class="form-check-input select" name="select[]"
                                                            type="checkbox" value="{{ $data->id }}" /></span></a>
                                                </a>

                                            </li>
                                        @else
                                            <a href=""></a>
                                            <li>
                                                <a class="dropdown-item" href="#"
                                                    style="color: #b0a9a9;">{{ $data->productData->name ?? '' }}

                                                    {{ $data->qty ?? '' }}



                                                    <span> &nbsp;&nbsp;
                                                        <input class="form-check-input select" name="select[]"
                                                            type="checkbox" value="{{ $data->id }}"
                                                            disabled /></span></a>

                                                </a>
                                            </li>
                                        @endif
                                    @empty
                                    @endforelse

                                    <input type="submit" value="Add"
                                        style="float: inline-end;margin-right: 10px;   
                                     background-color: #ff8d2f;color: #fff;border-color: #ff8d2f;border-radius: 10px;width: 60px;    margin-top: 10px;" />
                            </form>



            </ul>





        </div>
        </div>



        </li>
        </ul>
        </div>
    </section> --}}

    {{-- <section class="section-b-space pt-0">
        <div class="custom-container text-white fw-normal">
            <ul class="notification">
                <li class="notification-box unread customNoftificationItem">
                    <div class="notification-icon fs-5">
                        <span style="background-color: #FEEA8C; color: black;">2</span>
                    </div>



                    <div class="notification-content d-flex justify-content-between" style="background-color: #FEEA8C;">
                        <div>
                            <h5>Selected Items </h5>
                            @forelse ($prefenecesitem as $value)
                                @if ($value->pre_count == 2)
                                    <h6>{{ $value->productData->name ?? '' }}</h6>
                                @endif
                            @empty
                            @endforelse

                        </div>
                        <div class="dropdown">
                            <button class="btn btn-light customButtonofDropdown" type="button"
                                id="dropdownMenuButton1" style="background-color: #FEEA8C; border: none;"
                                data-bs-toggle="dropdown" aria-expanded="false">

                                <img class="img" src="{{ asset('assets/images/dropdown.png') }}" alt="veg"
                                    style="margin-left: 164px;
                                    width: 15%;" />
                            </button>
                            <form action="{{ route('cart.preferences') }}" method="post">
                                @csrf
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1">


                                    @forelse ($prefeneces as $data)
                                        @if ($data->categoryData->preparation_time > 16 && $data->categoryData->preparation_time < 40)
                                            <li><a class="dropdown-item"
                                                    href="#">{{ $data->productData->name ?? '' }}

                                                    {{ $data->qty ?? '' }}



                                                    <span> &nbsp;&nbsp;
                                                        <input class="form-check-input select" name="select[]"
                                                            type="checkbox" value="{{ $data->id }}" /></span></a>
                                                </a>

                                            </li>
                                        @else
                                            <a href=""></a>
                                            <li>
                                                <a class="dropdown-item" href="#"
                                                    style="color: #b0a9a9;">{{ $data->productData->name ?? '' }}

                                                    {{ $data->qty ?? '' }}



                                                    <span> &nbsp;&nbsp;
                                                        <input class="form-check-input select" name="select[]"
                                                            type="checkbox" value="{{ $data->id }}"
                                                            disabled /></span></a>

                                                </a>
                                            </li>
                                        @endif
                                    @empty
                                    @endforelse

                                    <input type="submit" value="Add"
                                        style="float: inline-end;margin-right: 10px;   
                                     background-color: #ff8d2f;color: #fff;border-color: #ff8d2f;border-radius: 10px;width: 60px;    margin-top: 10px;" />
                            </form>



            </ul>





        </div>
        </div>



        </li>
        </ul>
        </div>
    </section> --}}

   

    {{-- <section class="section-b-space pt-0">
        <div class="custom-container text-white fw-normal">
            <ul class="notification">
                <li class="notification-box unread customNoftificationItem">
                    <div class="notification-icon fs-5">
                        <span style="background-color: #FEEA8C; color: black;">3</span>
                    </div>



                    <div class="notification-content d-flex justify-content-between"
                        style="background-color: #FEEA8C; color:black">
                        <div>
                            <h5>Selected Items </h5>
                            @forelse ($prefenecesitem as $value)
                                @if ($value->pre_count == 3)
                                    <h6>{{ $value->productData->name ?? '' }}</h6>
                                @endif
                            @empty
                            @endforelse
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-light customButtonofDropdown" type="button"
                                id="dropdownMenuButton1" style="background-color: #FEEA8C; border: none;"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <!-- Your custom button content here (e.g., plus icon) -->
                                <img class="img" src="{{ asset('assets/images/dropdown.png') }}" alt="veg"
                                    style="margin-left: 164px;
                                width: 15%;" />
                            </button>
                            <form action="{{ route('cart.preferences') }}" method="post">
                                @csrf
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1">
                                    <!-- Add your dropdown items here -->
                                    @forelse ($prefeneces as $data)
                                        @if (30 < $data->categoryData->preparation_time)
                                            <li><a class="dropdown-item"
                                                    href="#">{{ $data->productData->name ?? '' }}

                                                    {{ $data->qty ?? '' }}



                                                    <span> &nbsp;&nbsp;
                                                        <input class="form-check-input select" name="select[]"
                                                            type="checkbox" value="{{ $data->id }}" /></span></a>
                                                </a>

                                            </li>
                                        @else
                                            <li>
                                                <a class="dropdown-item" href="#"
                                                    style="color: #b0a9a9;">{{ $data->productData->name ?? '' }}

                                                    {{ $data->qty ?? '' }}



                                                    <span> &nbsp;&nbsp;
                                                        <input class="form-check-input select" name="select[]"
                                                            type="checkbox" value="{{ $data->id }}"
                                                            disabled /></span></a>

                                                </a>
                                            </li>
                                        @endif
                                    @empty
                                    @endforelse

                                    <input type="submit" value="Add"
                                        style="float: inline-end;margin-right: 10px;   
                                     background-color: #ff8d2f;color: #fff;border-color: #ff8d2f;border-radius: 10px;width: 60px;    margin-top: 10px;" />
                            </form>



            </ul>





        </div>
        </div>



        </li>
        </ul>
        </div>
    </section> --}}


    {{-- <section class="section-b-space pt-0">
        <div class="custom-container text-white fw-normal">
            <ul class="notification">



                @forelse ($prefenecesitem as $data)
                    <li class="notification-box unread customNoftificationItem">
                        <div class="notification-icon fs-5">
                            <span>{{ $data->pre_count ?? 0 }}</span>
                        </div>
                        <div class="notification-content d-flex justify-content-between">
                            <div>
                                <h5>{{ $data->productData->name ?? '' }}</h5>
                               
                            </div>



                    </li>
                @empty
                @endforelse



            </ul>





        </div>
        </div>



        </li>
        </ul>
        </div>
    </section  --}}
    <section class="section-b-space">



        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="text-center fw-normal fs-5 mb-3">Diners</h3>
                            <form action="{{ route('order.place') }}" method="post" onsubmit="return validateForm();">
                                @csrf
                                <div class="mb-3">
                                    <label for="name" class="form-label fs-6">Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="Enter your name">
                                </div>
                                <input type="hidden" name='form' value="2">
                                <div class="mb-3 ">
                                    <label for="mobileNumber" class="form-label fs-6">Mobile Number</label>
                                    <input type="text" class="form-control" id="mobileNumber"
                                        placeholder="Enter your number" name="phone">
                                </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>


    </section>



   <div class='custom-container' onclick="toggleCheckbox()">
    <section class="custom-container shadow rounded-2">
        <div class='d-flex justify-content-between p-3'>
            <label class='fs-5 fw-normal' for="Regular">Anonymous</label>
            <input type="checkbox" name="sizeOption" value="1">
        </div>
    </section>
</div>

<script>
    function toggleCheckbox() {
        // Get the checkbox element
        var checkbox = document.querySelector('input[name="sizeOption"]');

        // Toggle the checkbox state
        checkbox.checked = !checkbox.checked;
    }

    function validateForm() {
        // Get form elements
        var nameInput = document.getElementById('name');
        var mobileInput = document.getElementById('mobileNumber');
        var checkbox = document.querySelector('input[name="sizeOption"]');

        // Check if at least one of Name, Mobile Number, or Anonymous checkbox is filled/selected
        if (nameInput.value.trim() === "" && mobileInput.value.trim() === "" && !checkbox.checked) {
            alert("Please fill Diners Details, or select Anonymous.");
            return false;
        }

        return true;
    }
</script>




    <!-- notification section end -->

    <div class="pay-popup">
      
        
   
         <div class="price-items">
                <h3>₹ {{ Cart::subtotal() }}</h3>
            <h6>{{ Cart::count() }} item Added</h6>
        </div>
        
      

        <input class="btn theme-btn pay-btn mt-0" type="submit" value="Proceed">

    </div>
    </form>
    <!-- bootstrap js -->
    <script src="assets/js/bootstrap.bundle.min.js"></script>

    <!-- script js -->
    <script src="assets/js/script.js"></script>



</body>


</html>
