<div class="modal-content">
    <div class="custom-container">
        <div class="filter-header section-t-space">
            <h1 class="title">Custom Food</h1>
            <a href="#" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
        </div>
        <div class="filter-body section-t-space">




            <div class="horizontal-product-box">
                <div class="product-img">
                    <img class="img-fluid img"
                        src="{{asset('storage/app/public/product/' . $products->image)}}"
                        alt="rp1" />
                </div>
                <div class="product-content">
                    <h5>{{ $products->name ?? '' }}</h5>
                    <h6>{{ Str::limit($products->description, 40) }}</h6>
                    {{-- <div class="plus-minus">
                        <i class="ri-subtract-line sub"></i>
                        <input type="number" value="1" min="1" max="10" />
                        <i class="ri-add-line add"></i>
                    </div> --}}
                    <img class="red-symbol" src="assets/images/svg/nonveg.svg" alt="non-veg" />
                    {{-- <h3 class="product-price price">$40</h3> --}}

                </div>
            </div>

       

        
        @if(!empty(json_decode($products->variations)))

 @foreach (json_decode($products->variations) as $value)
                <div class="filter-box section-t-space">
                    <h3 class="fw-semibold dark-text">Choose Size</h3>
                    @foreach ($value->values as $value)
                 
                        <ul class="filter-list mt-3">
                            <li>
                                <h5 class="product-size">{{ ucfirst($value->label ?? '') }}</h5>
                                <div class="form-check product-price">
                                    <label class="form-check-label" for="reverseCheck1"> ₹
                                        {{ $value->optionPrice }}</label>

                                    <input type="hidden" name="" class="id" value="{{ $products->id }}">
                                    <div id="label">

                                    </div>

                                    <input class="form-check-input select" name="select" type="radio"
                                        value="{{ $value->optionPrice }}" data-alldata={{ $value->label }} />
                                </div>
                            </li>

                        </ul>
                    @endforeach
                </div>
            @endforeach

        @else



        @endif

           

@if(!empty(json_decode($products->add_ons)))


            <div class="filter-box section-t-space">
                    <h3 class="fw-semibold dark-text">Addons</h3>
                     @foreach (json_decode($products->add_ons) as $value)
             

             @php
             $add_ons=DB::table('add_ons')->where('id',$value)->get();
                 
             @endphp
                    @foreach ($add_ons as $value)
                   
                        <ul class="filter-list mt-3">
                            <li>
                                <h5 class="product-size">{{ ucfirst($value->name ?? '') }}</h5>
                                <div class="form-check product-price">
                                    <label class="form-check-label" for="reverseCheck1"> ₹
                                        {{ $value->price ?? '' }}</label>

                                    <input type="hidden" name="" class="id" value="{{ $products->id }}">
                                    <div id="addons">

                                    </div>

                                    <input class="form-check-input add_on" name="add_on" type="checkbox"
                                        value="{{ $value->price  }}" data-addname={{ $value->id }}  />
                                </div>
                            </li>

                        </ul>
                    @endforeach
                      @endforeach
                </div>
          
@else




@endif

            


@if(!empty(json_decode($products->extras)))

            
            
           
                <div class="filter-box section-t-space">
                    <h3 class="fw-semibold dark-text">Extras</h3>
                    
 @foreach (json_decode($products->extras) as $value)
             

             @php
             $add_ons=DB::table('add_ons')->where('id',$value)->get();
                 
             @endphp
                    @foreach ($add_ons as $value)
                   
                        <ul class="filter-list mt-3">
                            <li>
                                <h5 class="product-size">{{ ucfirst($value->name ?? '') }}</h5>
                                <div class="form-check product-price">
                                    <label class="form-check-label" for="reverseCheck1"> ₹
                                        {{ $value->price ?? '' }}</label>

                                    <input type="hidden" name="" class="id" value="{{ $products->id }}">
                                    <div id="addons">

                                    </div>

                                    <input class="form-check-input extra" name="extra" type="checkbox"
                                        value="{{ $value->price  }}" data-addname={{ $value->id }}  />
                                </div>
                            </li>

                        </ul>
                    @endforeach
                     @endforeach
                </div>
           
@else


@endif

             

            <div class="body-title d-flex justify-content-between section-t-space section-b-space">
                <h3 class="fw-semibold dark-text d-flex align-items-center">
                    Grand Total
                </h3>
                <h2 class="theme-color" id="price"> ₹ 0</h2>

            </div>
        </div>
        <div class="filter-footer">
            <a class="btn theme-btn apply-btn w-100" onclick="cartdata()" data-bs-toggle="offcanvas">Apply</a>
        </div>
    </div>
</div>
<script>
    $('input[name="select"]').on("click", function() {
        var val = $("input[type='radio']:checked").val();
                 
              

        var total = '<input type="hidden" name="" class="choose" value="' + val + '"><h2 class="theme-color" id="price" data-choose=' + val +'>₹ ' + val +
            '</h2>';
            
        var data = $(this).data("alldata");
        var ordertype = '<input type="hidden" name="" class="typeorder" value="' + data + '">';


        $('#price').html(total);
        $('#label').html(ordertype);
    });

          $('input[name="add_on"]').on("click", function() {
            var price=$('.choose').val();
            alert(price);
         
          
          
          if (typeof(price) === "undefined") {
                alert('please Select One Choose Item');
                 $('input:checkbox').attr('checked',false);

            }else{
               
     
              var total = 0;
              $.each($("input[type='checkbox']:checked"), function(){
                  
                   total += isNaN(parseInt($(this).val())) ? 0 : parseInt($(this).val());
              });
               var add_on=total;
            }
            var addid = $(this).data("addname");
             var add_ons = '<input type="hidden" class="add_id" value="' + addid + '">'; 
          
             var totalprice=parseInt(price) + parseInt(add_on);
            
              
var total = '<input type="hidden" name="" class="choose" value="' + totalprice + '"><h2 class="theme-color" id="price" >₹ ' + totalprice +
            '</h2>';
            $('#price').html(total);
            $('#addons').html(add_ons);
});

           $('input[name="extra"]').on("click", function() {
            var price=$('.choose').val();
          
         
             var totalextra = 0;
           $.each($("input[name='extra']:checked"), function(){
                  totalextra +=parseInt($(this).val());
              });
                  var extra=totalextra;
               
                   var totalpricewithextra=parseInt(price) + parseInt(extra);


  var total = '<input type="hidden" name="" class="choose" value="' + totalpricewithextra + '"><h2 class="theme-color" id="price" >₹'+ totalpricewithextra +
            '</h2>';
          
           
            $('#price').html(total);

      });

          
function cartdata(data) {
// var val = $("input[type='radio']:checked").val();
 var val=$('.choose').val();
 
var type = $('.typeorder').val();

var add_on = $("input[type='checkbox']:checked").val();
 var add_onsid=$('.add_id').val();
 var id = $('.id').val();

        if (typeof(val) === "undefined") {
            alert('Plaese Select Choose Option!');
        } else {
            $.ajax({
                type: "get",
                url: "{{ route('ordermorecartitem.item') }}",
                data: {
                    val: val,
                    id: id,
                    type: type,
                    add_onsid:add_onsid
                },
                success: function(data) {
                    location.replace('/order_more');

                }
            });


        }


    }
</script>