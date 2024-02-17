@extends('layouts.master')
@section('content')
<style>
    .filter{
           border: none;
    background-color: #ffff; 
    }
</style>
 
   
  


   <section>
    <div class="custom-container">
      <h3 class="fw-semibold dark-text">Order More Items</h3>
      <div class="horizontal-product-box mt-3">
        <div class="product-img">
        </div>
        <div class="product-content">
          <h5>Order No: {{$order->id ?? ''}}</h5>
          <h6> Status: {{$order->order_status ?? ''}}</h6>
          <h3 class="product-price">₹ {{$order->order_amount ?? ''}}</h3>
        </div>
      </div>
    </div>
  </section>
<section class="food-filter">
    <div class="custom-container">
        <ul class="food-symbol">


        <form action="{{route('non.filter')}}" method="get">
            @CSRF

            
<input type="hidden" value="veg" name="type">

               <li>
                   <a  class="food-types">
                       <img class="img-fluid img" src="{{asset('public/assets/images/icons/veg.svg')}}" alt="veg" />
                 
                    <h6><input type="submit"  value="Veg" class="filter"/></h6>

                    
                    <i class="ri-close-line close"></i>
                   
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
 <form action="{{route('non.filter')}}" method="get">
            @CSRF

            
             <input type="hidden" value="1" name="type">
            <li>
                <a href="#" class="food-types">
                       <i class="ri-award-fill award"></i>
               
                      <h6><input type="submit"  value="Best Seller" class="filter"/></h6>
                    <i class="ri-close-line close"></i>
                </a>
                </li>
                  </form>
    </ul>
    </div>
    </section>

    
    <section class="food-list-section section-b-space" >
        <div class="custom-container">
            <div class="list-box">
                <h3 class="fw-semibold dark-text" >Recommended</h3>
                @forelse ($category as $data)
                    @php
                        $product = App\Models\Product::where('category_id', $data->id)
                            ->where('status', 1)
                            ->get();

                        $count = App\Models\Product::where('category_id', $data->id)
                            ->where('status', 1)
                            ->count();

                    @endphp
                    <div class="accordion food-accordion" id="accordionPanelsStayOpenaccordion1">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="panelsStayOpen-heading{{ $data->id }}">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#panelsStayOpen-collapse{{ $data->id }}" aria-expanded="true"
                                    aria-controls="collapse{{ $data->id }}">
                                    {{ $data->name ?? '' }} ({{ $count ?? 0 }})
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapse{{ $data->id }}" class="accordion-collapse collapse show"
                                aria-labelledby="heading{{ $data->id }}" data-bs-parent="#accordionExample ">
                                @forelse ($product as $data)
                                    <div class="accordion-body">
                                        <div class="product-box2">
                                            <div class="product-content">
                                                <!--<img class="img" src="{{asset('public/assets/images/svg/nonveg.svg')}}" alt="non-veg" />-->
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
                @empty
                @endforelse
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
 
    @if (Cart::count() > 0)
        <div class="cart-popup">
            <div class="price-items">
                <h3> ₹ {{ Cart::subtotal() ?? 0 }}</h3>
                <h6> {{ Cart::count() ?? 0 }} item Added</h6>
            </div>
            <a href="{{ route('cart.item') }}" class="btn theme-btn cart-btn mt-0">View Cart</a>
        </div>
  
    @endif
@endsection

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
