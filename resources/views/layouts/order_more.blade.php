<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>QRDine-In</title>

    <link rel="stylesheet" href="{{asset('assets/css/vendors/metropolis.min.css')}}" />


    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/remixicon.css')}}" />


    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/swiper-bundle.min.css')}}" />


    <link rel="stylesheet" id="rtl-link" type="text/css" href="{{asset('assets/css/vendors/bootstrap.min.css')}}" />


    <link rel="stylesheet" id="change-link" type="text/css" href="{{asset('assets/css/style.css')}}" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
</head>

<body>




    <main>
        @yield('content')
    </main>


    <script src="{{asset('assets/js/swiper-bundle.min.js')}}"></script>
    <script src="{{asset('assets/js/custom-swiper.js')}}"></script>

    <script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>

    <script src="{{asset('assets/js/script.js')}}"></script>

    <script>
        function extra(id) {
            // var id = $('#valueid').val();
            $.ajax({
                type: "get",
                url: "{{ route('moreorder.popup') }}",
                data: {
                    id: id
                },
                success: function(data) {
                   
                    $('#popup').html(data)

                }
            });
        }
    </script>

      <script>
        function modeldata(id) {
       
            // var id = $('#valueid').val();
            $.ajax({
                type: "get",
                url: "{{ route('model.modeldata') }}",
                data: {
                    id: id
                },
                success: function(data) {
                 $('#product-popup').html(data)

                }
            });
        }
    </script>


    <script>
        function setDayGreeting() {
            const today = new Date();
            const hour = today.getHours();
            let greeting;
            let color;

            if (hour < 12) {
                greeting = "Good morning!";
                color = "#FF9843";
            } else if (hour < 17) {
                greeting = "It's Lunnch Time!";
                color = "#FF9843";
            } else {
                greeting = "Good evening!";
                color = "#D24545";
            }

            // Set the greeting and color in the day-greeting element
            const dayGreetingElement = document.getElementById("day-greeting");
            dayGreetingElement.innerText = greeting;
            dayGreetingElement.style.color = color;
        }

        // Call the function to set the initial day greeting
        setDayGreeting();
    </script>

    <script>
        $(document).ready(function() {
            $(".add").on("click", function() {
                var dataId = $(this).attr("data-id");
                var qty = $(this).attr("data-qty");

                $.ajax({
                    type: "get",
                    url: "{{ route('cart.plus') }}",
                    data: {
                        dataId: dataId,
                        qty: qty
                    },

                    success: function(data) {
                        location.reload(true);

                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $(".sub").on("click", function() {
                var dataId = $(this).attr("data-id");
                var qty = $(this).attr("data-qty");
                $.ajax({
                    type: "get",
                    url: "{{ route('cart.minus') }}",
                    data: {
                        dataId: dataId,
                        qty: qty
                    },

                    success: function(data) {
                        location.reload(true);

                    }
                });
            });
        });
    </script>
</body>

</html>
