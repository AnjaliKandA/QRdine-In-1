@extends('layouts.master')
@section('content')


<style>
    .filter{
           border: none;
    background-color: #ffff; 
    }
</style>
    @include('layouts.frontend.header')
    <section>
        <div class="custom-container">
            <div class="swiper coupon">
                {{-- <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="offer-box">
                            <div class="offer-icon">
                                <img class="img-fluid offer" src="{{asset('public/assets/images/icons/Offer-Discount.png')}}" alt="offer" />
                            </div>
                            <div class="offer-content">
                                <h5>50% OFF upto & ₹25</h5>
                                <h6 class="light-text">Use Code DEMO</h6>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="offer-box">
                            <div class="offer-icon">
                                <img class="img-fluid offer" src="{{asset('public/assets/images/icons/Offer-Discount.png')}}" alt="offer" />
                            </div>
                            <div class="offer-content">
                                <h5>50% OFF upto & ₹25</h5>
                                <h6 class="light-text">Use Code DEMO</h6>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="offer-box">
                            <div class="offer-icon">
                                <img class="img-fluid offer" src="{{asset('public/assets/images/icons/Offer-Discount.png')}}" alt="offer" />
                            </div>
                            <div class="offer-content">
                                <h5>50% OFF upto & ₹25</h5>
                                <h6 class="light-text">Use Code DEMO</h6>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </section>
<section class="food-filter">
    <div class="custom-container">
        <ul class="food-symbol">

{{-- 
        < action="{{route('non.filter')}}" method="post">
            @CSRF --}}

            

            @if($type == 'veg')
             <form action="{{route('non.filter')}}" method="get">
            @CSRF

            
              <input type="hidden" value="veg" name="type" class="filter">
 <li>
                <a href="#" class="food-types  active">
                    <img class="img-fluid img" src="{{asset('public/assets/images/svg/veg.svg')}}" alt="veg" />
                    <h6><input type="submit"  value="Veg"  class="filter"/></h6>
                    
                    <i class="ri-close-line close"></i>
                    
                </a>
            </li>
             </form>
                 <form action="{{route('non.filter')}}" method="get">
            @CSRF

            
            <input type="hidden" value="non_veg" name="type" class="filter">

            <li>
                <a href="#" class="food-types ">
                    <img class="img-fluid img" src="{{asset('public/assets/images/svg/nonveg.svg')}}" alt="non-veg" />
                 <h6><input type="submit"  value="Non Veg" class="filter"/></h6>
                  
                </a>
            </li>
                 </form>
                   <i class="ri-close-line close"></i>

            <form action="{{route('non.filter')}}" method="get">
            @CSRF

            
             <input type="hidden" value="1" name="type">
           
                  <li>
                <a href="#" class="food-types filter">
                       <i class="ri-award-fill award"></i>
                  <h6><input type="submit"  value="Best Seller" class="filter"/></h6>
                    <i class="ri-close-line close"></i>
                </a>
                </li>
                  </form>
          

            @elseif($type == 'non_veg')
              <form action="{{route('non.filter')}}" method="get">
            @CSRF

            
              <input type="hidden" value="veg" name="type" >

<li>
                <a href="#" class="food-types filter">
                    <img class="img-fluid img" src="{{asset('public/assets/images/svg/veg.svg')}}" alt="non-veg" />
                   <h6 ><input type="submit"  value="Veg" class="filter"/></h6>
                    <i class="ri-close-line close"></i>
                </a>
            </li>
              </form>
               <form action="{{route('non.filter')}}" method="get">
            @CSRF

            
            <input type="hidden" value="non_veg" name="type">

            <li>
                <a href="#" class="food-types active">
                    <img class="img-fluid img" src="{{asset('public/assets/images/svg/nonveg.svg')}}" alt="non-veg" />
                    <h6><input type="submit"  value="Non Veg" class="filter"/></h6>
                    <i class="ri-close-line close"></i>
                </a>
            </li>
               </form>
             <form action="{{route('non.filter')}}" method="get">
            @CSRF

            
             <input type="hidden" value="1" name="type">
           
                  <li>
                <a href="#" class="food-types filter">
                       <i class="ri-award-fill award"></i>
                  <h6><input type="submit"  value="Best Seller" class="filter"/></h6>
                    <i class="ri-close-line close"></i>
                </a>
                </li>
                  </form>

                @elseif($type==1)

  <form action="{{route('non.filter')}}" method="get">
            @CSRF

            
              <input type="hidden" value="veg" name="type" >

<li>
                <a href="#" class="food-types filter">
                    <img class="img-fluid img" src="{{asset('public/assets/images/svg/veg.svg')}}" alt="non-veg" />
                   <h6 ><input type="submit"  value="Veg" class="filter"/></h6>


                    <i class="ri-close-line close" id="home"></i>

                </a>
            </li>
              </form>
               <form action="{{route('non.filter')}}" method="get">
            @CSRF

            
            <input type="hidden" value="non_veg" name="type">

            <li>
                <a href="#" class="food-types ">
                    <img class="img-fluid img" src="{{asset('public/assets/images/svg/nonveg.svg')}}" alt="non-veg" />
                    <h6><input type="submit"  value="Non Veg" class="filter"/></h6>
                    <i class="ri-close-line close"></i>
                </a>
            </li>
               </form>
           
           
                  <li>
                <a href="#" class="food-types filter active ">
                       <i class="ri-award-fill award"></i>
                  <h6><input type="submit"  value="Best Seller" class="filter"/></h6>
                    <i class="ri-close-line close" ></i>
                </a>
                </li>
                 
                  

                @else





            @endif
              
           




    </ul>
    </div>
    </section>

    
    <section class="food-list-section section-b-space">
        <div class="custom-container">
            <div class="list-box">
                
               
                  
                    <div class="accordion food-accordion" id="accordionPanelsStayOpenaccordion1">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="panelsStayOpen-heading">
                                
                            </h2>
                            <div id="panelsStayOpen-collapse" class="accordion-collapse collapse show"
                                aria-labelledby="heading" data-bs-parent="#accordionExample ">
                                @forelse ($product as $data)
                                    <div class="accordion-body">
                                        <div class="product-box2">
                                            <div class="product-content">

                                                @if($type == 'veg')
  <img class="img" src="{{asset('assets/images/svg/veg.svg')}}" alt="veg" />
                                                @elseif($type == 'non_veg')
  <img class="img" src="{{asset('assets/images/svg/nonveg.svg')}}" alt="non-veg" />
  @elseif($type == 1)
 <i class="ri-award-fill award" style="    color: blue;"></i>

  @else




                                                @endif
                                              

                                                <h5 class="product-name">{{ $data->name ?? '' }}</h5>
                                                <!--<div class="d-flex align-items-center gap-1">-->
                                                <!--    <ul class="rating-stars">-->
                                                <!--        <li><i class="ri-star-fill stars"></i></li>-->
                                                <!--        <li><i class="ri-star-fill stars"></i></li>-->
                                                <!--        <li><i class="ri-star-fill stars"></i></li>-->
                                                <!--        <li><i class="ri-star-fill stars"></i></li>-->
                                                <!--        <li><i class="ri-star-fill stars"></i></li>-->
                                                <!--    </ul>-->
                                                <!--    {{-- <h5 class="dark-text">{{ $data->id }}k+ Rating</h5> --}}-->
                                                <!--</div>-->
                                                <div class="product-price">
                                                    <h6 class="fw-semibold"><span> ₹ {{ $data->price ?? '' }}</span> /
                                                        ₹ {{ $data->price + $data->discount }}.00
                                                    </h6>
                                                </div>
                                                <p class="mb-0 mt-2 pt-2">
                                                    {{ Str::limit($data->description, 50) }}.Read More
                                                </p>
                                            </div>
                                            <div class="product-img">
                                                <a href="#product-popup" data-bs-toggle="offcanvas">
                                                    <img class=" img"
                                                        src="{{ env('URL') . 'backend/storage/app/public/product/' . $data->image }}"
                                                        alt="rp1" style="    width: 120px;height: 100px;" onclick="modeldata({{ $data->id }})"/>
                                                </a>
                                                <div class="add-btn">

                                                    @if (Cart::count() > 0)
                                                        @php
                                                            $items = Cart::content();
                                                        @endphp
                                                        @foreach ($items as $key => $value)
                                                            @if ($value->id == $data->id)
                                                                <div class="plus-minus">
                                                                    <i class="ri-subtract-line sub"
                                                                        data-id={{ $value->rowId }}
                                                                        data-qty={{ $value->qty }}></i>
                                                                    {{-- <input type="text" name="" id="cartid"
                                                                        value="{{ $value->rowId }}"> --}}
                                                                    <input type="number" value="{{ $value->qty ?? 0 }}"
                                                                        min="1" max="10" class="qty" />
                                                                    <i class="ri-add-line add" data-id={{ $value->rowId }}
                                                                        data-qty={{ $value->qty }}>
                                                                    </i>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                        <a class="btn
                                                        btn-outline"
                                                            onclick="extra({{ $data->id }})"
                                                            data-value="{{ $data->id }}"
                                                            data-bs-target="#add-product" data-bs-toggle="modal"><i
                                                                class="ri-add-line"></i>
                                                            ADD</a>
                                                    @else
                                                        <a class="btn
                                                    btn-outline"
                                                            onclick="extra({{ $data->id }})"
                                                            data-value="{{ $data->id }}"
                                                            data-bs-target="#add-product" data-bs-toggle="modal"><i
                                                                class="ri-add-line"></i>
                                                            ADD</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                @endforelse
                            </div>
                        </div>

                    </div>
               
            </div>
        </div>
        </div>
    </section>
    
    <section class="panel-space"></section>
  
    <div class="modal filter-modal" id="add-product" tabindex="-1">
        <div class="modal-dialog modal-fullscreen" id="popup">

        </div>
    </div>
    <div
      class="offcanvas fade offcanvas-bottom product-detail-popup"
      tabindex="-1"
      id="product-popup"
    >

    </div>
  @if (session()->has('generatecode'))
        <div class="cart-popup">
            <div class="price-items">
                <h3>Order Place</h3>
                
            </div>
            <a href="{{ route('order.order_track') }}" class="btn theme-btn cart-btn mt-0">Track Now</a>
        </div>
    @endif
    @if (Cart::count() > 0)
        <div class="cart-popup">
            <div class="price-items">
                <h3> ₹ {{ Cart::subtotal() ?? 0 }}</h3>
                <h6> {{ Cart::count() ?? 0 }} item Added</h6>
            </div>
            <a href="{{ route('cart.item') }}" class="btn theme-btn cart-btn mt-0">View Cart</a>
        </div>
    @else
    @endif
@endsection

<script>
    $( document ).ready(function() {
        alert('ytext');
    $('.close').click(function(){
        alert('text');
        //  location.replace('/home');
    })
});
</script>
<script>
    function searchdata(){
     
var type='veg';
$.ajax({
    url:'{{route('non.filter')}}',
    type:'get',
    data:{type:type},
    success:function(data){
        alert(data);

    }
})

    }
</script>

