@extends('layouts.admin.app')

@section('title', translate('QR code'))

@push('css_or_js')
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <section class="qr-code-section">
            <div class="card">
                <div class="card-body">
                    <div class="qr-area">

                        <div class="left-side pr-xl-4">
                            <div class="col-md-12 mb-3">
                                <center>
                                    <input type="button" class="btn btn-primary non-printable"
                                        onclick="printDiv('printableArea')" value="{{ translate('Print') }}" />
                                    <a href="{{ url()->previous() }}"
                                        class="btn btn-danger non-printable">{{ translate('Back') }}</a>
                                </center>
                            </div>
                            @php($restaurant_logo = \App\Model\BusinessSetting::where(['key' => 'logo'])->first()?->value)
                            <div class="qr-wrapper"
                                style="background: url({{ asset('public/assets/admin/img/qr-bg.png') }}) no-repeat scroll 0% 0% / 100% 100% !important; -webkit-print-color-adjust: exact !important; color-adjust: exact !important; print-color-adjust: exact !important; "
                                id="printableArea">
                                <div class="d-flex justify-content-center py-3">
                                    <a href="" class="qr-logo">
                                        <img src="{{ asset('storage/app/public/restaurant/' . $restaurant_logo) }}"
                                            class="mw-100"
                                            onerror="this.src='{{ asset('public/assets/admin/img/logo2.png') }}'"
                                            alt="" width="164">
                                    </a>
                                </div>


                                <div class="text-center mt-4">
                                    <div>
                                        {!! QrCode::size(240)->generate(env('APP_URL') . '?table=' . $tables->number) !!}
                                    </div>
                                    <div class="my-3">

                                    </div>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <div class="view-menu"
                                        style="border-top: 1px solid #f7c446; border-bottom: 1px solid #f7c446; padding-bottom: .25rem; margin-top: 1rem;">
                                        Table Number: {{ $tables->number ?? 0 }}
                                    </div>
                                </div>



                            </div>
                        </div>
                        <div class="right-side">

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('script')
    <script>
        function printDiv(divName) {

            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;

        }
    </script>
@endpush
