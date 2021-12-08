@extends($activeTemplate.'layouts.master')
@section('content')
@include($activeTemplate.'partials.breadcrumb')
<div class="dashboard-section padding-top padding-bottom">
    <div class="container">
        <div class="row justify-content-center mb-30-none">
            <div class="col-xl-10">
                <div class="card custom--card primary-bg h-100">
                <div class="card-header">
                    <h5 class="card-title">@lang('Payment Preview')</h5>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <div class="deposit-item active mb-lg-0 primary-bg-2">
                                <div class="deposit-thumb">
                                    <img src="{{ $deposit->gatewayCurrency()->methodImage() }}" alt="deposit">
                                </div>
                                <div class="deposit-content">
                                    <h5 class="title">{{ $deposit->gatewayCurrency()->name}}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8 ">
                            <ul class="preview-lists mb-30">
                                <li>
                                    <span class="title text-white">@lang('Please Pay')</span>
                                    <span class="details text-info text-white">{{getAmount($deposit->final_amo)}} {{__($deposit->method_currency)}}</span>
                                </li>
                                <li>
                                    <span class="title text-white">@lang('To Get')</span>
                                    <span class="details text-success text-white">{{getAmount($deposit->amount)}}  {{__($general->cur_text)}}</span>
                                </li>
                            </ul>
                            <div class="contact-form-group text-center">
                                <button type="button" id="btn-confirm" onClick="payWithRave()">@lang('Pay Now')</button>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('script')
    <script src="https://api.ravepay.co/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script>
    <script>
        "use strict"
        var btn = document.querySelector("#btn-confirm");
        btn.setAttribute("type", "button");
        const API_publicKey = "{{$data->API_publicKey}}";

        function payWithRave() {
            var x = getpaidSetup({
                PBFPubKey: API_publicKey,
                customer_email: "{{$data->customer_email}}",
                amount: "{{$data->amount }}",
                customer_phone: "{{$data->customer_phone}}",
                currency: "{{$data->currency}}",
                txref: "{{$data->txref}}",
                onclose: function () {
                },
                callback: function (response) {
                    var txref = response.tx.txRef;
                    var status = response.tx.status;
                    var chargeResponse = response.tx.chargeResponseCode;
                    if (chargeResponse == "00" || chargeResponse == "0") {
                        window.location = '{{ url('ipn/flutterwave') }}/' + txref + '/' + status;
                    } else {
                        window.location = '{{ url('ipn/flutterwave') }}/' + txref + '/' + status;
                    }
                        // x.close(); // use this to close the modal immediately after payment.
                    }
                });
        }
    </script>
@endpush