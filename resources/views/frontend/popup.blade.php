<div class="modal-content" style="height: 900px;">
    <div class="custom-container">
        <div class="filter-header section-t-space">
            <h1 class="title">Custom Food</h1>
            <a href="#" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
        </div>
        <div class="filter-body section-t-space">




            <div class="horizontal-product-box">
                <div class="product-img">
                    <img class="img-fluid img" src="{{ asset('storage/app/public/product/' . $products->image) }}"
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
                    @if ($products->product_type == 'veg')
                        <img class="img" src="{{ asset('assets/images/icons/veg.svg') }}" alt="veg" />
                    @elseif($products->product_type == 'non_veg')
                        <img class="img" src="{{ asset('assets/images/svg/nonveg.svg') }}" alt="non-veg" />
                    @else
                        <i class="ri-award-fill award" style="    color: blue;"></i>
                    @endif
                    {{-- <h3 class="product-price price">$40</h3> --}}

                </div>
            </div>




            @if (!empty(json_decode($products->variations)))

                @foreach (json_decode($products->variations) as $value)
                    <div class="filter-box section-t-space">
                        <h3 class="fw-semibold dark-text" style="margin-left: 18px;">Choose Size</h3>
                        @foreach ($value->values as $option)
                            <ul class="filter-list mt-3" style="margin-left: 18px;">
                                <li>
                                    <label>
                                        <h5 class="product-size">{{ ucfirst($option->label ?? '') }}</h5>
                                        <div class="form-check product-price" style="margin-left: 210px; margin-top: -15px;">
                                            <label class="form-check-label" for="radioOption{{ $loop->index }}">
                                                ₹{{ $option->optionPrice }}</label>
                                            <input type="hidden" name="" class="id"
                                                value="{{ $products->id }}">
                                            <div id="label"></div>
                                            <input style="margin-left: 5px;" class="form-check-input select" name="select" type="radio"
                                                value="{{ $option->optionPrice }}" data-alldata="{{ $option->label }}"
                                                id="radioOption{{ $loop->index }}"
                                                @if ($loop->index == 0) checked @endif />
                                        </div>
                                    </label>
                                </li>
                            </ul>
                        @endforeach


                    </div>
                @endforeach
            @else
            @endif



            @if (!empty(json_decode($products->add_ons)))


                <div class="filter-box section-t-space" style="margin-left: 18px;">
                    <h3 class="fw-semibold dark-text">Addons</h3>
                    @foreach (json_decode($products->add_ons) as $value)
                        @php
                            $add_ons = DB::table('add_ons')
                                ->where('id', $value)
                                ->get();

                        @endphp
                        @foreach ($add_ons as $value)
                            <ul class="filter-list mt-3">
                                <li>
                                    <label>
                                        <h5 class="product-size">{{ ucfirst($value->name ?? '') }}</h5>
                                        <div class="form-check product-price" style="margin-left: 200px; margin-top: -15px;">
                                            <label class="form-check-label" for="addonCheckbox{{ $value->id }}">
                                                ₹{{ $value->price ?? '' }}</label>
                                            <input type="hidden" name="" class="id"
                                                value="{{ $products->id }}">
                                            <div id="addons"></div>
                                            <input style="margin-left: 5px;"  class="form-check-input add_on" name="add_on" type="checkbox"
                                                value="{{ $value->price }}" data-addname="{{ $value->id }}"
                                                id="addonCheckbox{{ $value->id }}" />
                                        </div>
                                    </label>
                                </li>
                            </ul>
                        @endforeach
                    @endforeach
                </div>
            @else
            @endif




            @if (!empty(json_decode($products->extras)))
                <div class="filter-box section-t-space" style="margin-left: 18px;">
                    <h3 class="fw-semibold dark-text">Extras</h3>
                    @foreach (json_decode($products->extras) as $value)
                        @php
                            $add_ons = DB::table('add_ons')->where('id', $value)->get();

                        @endphp
                        @foreach ($add_ons as $value)
                            <ul class="filter-list mt-3">
                                <li>
                                    <label>
                                        <h5 class="product-size">{{ ucfirst($value->name ?? '') }}</h5>
                                        <div class="form-check product-price" style="margin-left: 200px; margin-top: -15px;">
                                            <label class="form-check-label" for="addonCheckbox{{ $value->id }}">
                                                ₹{{ $value->price ?? '' }}</label>
                                            <input type="hidden" name="" class="id"
                                                value="{{ $products->id }}">
                                            <div id="addons"></div>
                                            <input style="margin-left: 5px;"  class="form-check-input add_on" name="add_on" type="checkbox"
                                                value="{{ $value->price }}" data-addname="{{ $value->id }}"
                                                id="addonCheckbox{{ $value->id }}" />
                                        </div>
                                    </label>
                                </li>
                            </ul>
                        @endforeach
                    @endforeach
                </div>
            @else
            @endif


            <div class="body-title d-flex justify-content-between section-t-space section-b-space"
                style="margin-left: 18px;">
                <h3 class="fw-semibold dark-text d-flex align-items-center">
                    Grand Total
                </h3>
                <h2 class="theme-color" id="price" style="margin-left: 170px;"> ₹ 0</h2>

            </div>
        </div>
        <div class="filter-footer">
            <a class="btn theme-btn apply-btn w-100" onclick="cartdata()" data-bs-toggle="offcanvas">Apply</a>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
       
        $('input[name="select"]').on("click", function() {
            updateTotal();
        });

        $('input[name="select"]:checked').click();

        $('input[name="add_on"]').on("click", function() {
            updateTotal();
        });

        $('input[name="extra"]').on("click", function() {
            updateTotal();
        });

        function updateTotal() {
            var val = $("input[type='radio']:checked").val();
            var total = isNaN(parseInt(val)) ? 0 : parseInt(val);

            var addonTotal = 0;
            $.each($("input[name='add_on']:checked"), function() {
                addonTotal += isNaN(parseInt($(this).val())) ? 0 : parseInt($(this).val());
            });

            var extraTotal = 0;
            $.each($("input[name='extra']:checked"), function() {
                extraTotal += isNaN(parseInt($(this).val())) ? 0 : parseInt($(this).val());
            });

            var finalTotal = total + addonTotal + extraTotal;

            $('#price').html('<input type="hidden" name="" class="choose" value="' + finalTotal +
                '"><h2 class="theme-color" id="price">₹ ' + finalTotal + '</h2>');
        }

    });

    function cartdata(data) {
        var val = $('.choose').val();
        var type = $('.typeorder').val();
        var add_onsid = $('.add_id').val();
        var id = $('.id').val();

        if (typeof(val) === "undefined") {
            alert('Please select a choose option!');
        } else {
            $.ajax({
                type: "get",
                url: "{{ route('cartitem.item') }}",
                data: {
                    val: val,
                    id: id,
                    type: type,
                    add_onsid: add_onsid
                },
                success: function(data) {
                    location.replace('/qrdinetestings');
                }
            });
        }
    }
</script>