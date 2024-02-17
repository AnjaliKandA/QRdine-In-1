 <div class="product-box-modal ratio_40">
     <div class="product-img">
         <img class="bg-img" src="{{ env('URL') . 'backend/storage/app/public/product/' . $products->image }}"
             alt="rp1" style="    width: 100%;
    border-radius: 19px;
    height: 188px;" />
     </div>
     <div class="product-content">
         <div class="product-info">
             <img class="img" src="assets/images/svg/nonveg.svg" alt="non-veg" />
             <h5>{{ $products->name ?? '' }}</h5>
             <div class="d-flex align-items-center gap-2 mb-2">
                 <ul class="rating-stars">
                     <li><i class="ri-star-fill stars"></i></li>
                     <li><i class="ri-star-fill stars"></i></li>
                     <li><i class="ri-star-fill stars"></i></li>
                     <li><i class="ri-star-fill stars"></i></li>
                     <li><i class="ri-star-fill stars"></i></li>
                 </ul>

             </div>
             <div class="product-price">
                 <h6 class="fw-semibold"><span>{{ $products->price ?? 0 }}</span> /
                     {{ $products->price + $products->discount }}</h6>
             </div>
         </div>


         <div class="add-btn">

             @if (Cart::count() > 0)
                 @php
                     $items = Cart::content();
                 @endphp
                 @foreach ($items as $key => $value)
                     @if ($value->id == $products->id)
                         <div class="plus-minus">
                             <i class="ri-subtract-line sub" data-id={{ $value->rowId }}
                                 data-qty={{ $value->qty }}></i>
                             {{-- <input type="text" name="" id="cartid"
                                                                        value="{{ $value->rowId }}"> --}}
                             <input type="number" value="{{ $value->qty ?? 0 }}" min="1" max="10"
                                 class="qty" />
                             <i class="ri-add-line add" data-id={{ $value->rowId }} data-qty={{ $value->qty }}>
                             </i>
                         </div>
                     @endif
                 @endforeach
                 {{-- <div class="plus-minus" style="color: rgba(var(--theme-color), 1);">

                     <a onclick="cartdata({{ $products->id }})"></a>
                 </div> --}}
             @else
                 {{-- <div class="plus-minus" style="color: rgba(var(--theme-color), 1);" >
             
         <a onclick="cartdata({{$products->id}})">Add</a>
          </div> --}}
             @endif
         </div>


     </div>

     <h6>{{ Str::limit($products->description, 100) }}</h6>

 </div>

 <script>
     function cartdata(data) {


         var id = data;


         $.ajax({
             type: "get",
             url: "{{ route('cartitem.item') }}",
             data: {

                 id: id,

             },
             success: function(data) {
                 location.replace('/');

             }
         });





     }
 </script>
