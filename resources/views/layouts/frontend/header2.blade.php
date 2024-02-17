   <!-- header start -->

   @php
       $detail = App\Model\BusinessSetting::where(['key' => 'restaurant_name'])->first();
   @endphp
   <header class="section-t-space">
       <div class="custom-container">
           <div class="header-panel">
               <a href="{{ route('home') }}">
                   <i class="ri-arrow-left-s-line"></i>
               </a>
               <h2>{{ $detail->value ?? '' }}</h2>
           </div>
       </div>
   </header>
   <!-- header end -->

   <!-- Add Cart section start -->
