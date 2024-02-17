<header>
    <div class="header-panel-lg">
        <div class="custom-container">
            <div class="panel">
                <a href="" style="display: none;"><i class=""></i></a>
                <a href="#" style="display: none;"><i class=""></i></a>
            </div>
        </div>
    </div>
</header>

<section>
    <div class="custom-container">
        <div class="restaurant-details-box">
            <div class="restaurant-head">
                <div class="name">
                    <img class="img-fluid restaurant-logo"
                        src="{{ env('URL') . 'backend/storage/app/public/restaurant/' . $logo->value }}"
                        alt="starbucks-logo" />
                    <div class="d-block ms-2">
                        <h3>{{ $detail->value ?? '' }}</h3>
                        <h6>{{ $address->value ?? '' }}</h6>
                    </div>
                </div>
                <!--<div class="option">-->
                <!--    <a href="#">-->
                <!--        <i class="ri-share-line share"></i>-->
                <!--    </a>-->

                <!--    <a href="#">-->
                <!--        <i class="toggle-heart ri-heart-3-fill heart"></i>-->
                <!--    </a>-->
                <!--</div>-->
            </div>

            <div class="restaurant-details d-flex justify-content-center">
                <div id="day-greeting" class='text-center fw-semibold fs-1 custom-font'>

                </div>
            </div>
        </div>
    </div>
</section>
