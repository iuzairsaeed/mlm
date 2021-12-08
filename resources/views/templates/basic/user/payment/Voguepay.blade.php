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
                            <div class="col-md-8 text-center">
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
                                <div class="contact-form-group">
                                    <button type="button" id="btn-confirm">@lang('Pay Now')</button>
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
    <script src="//pay.voguepay.com/js/voguepay.js"></script>
    <script>
        "use strict";
        var closedFunction = function() {
        }
        var successFunction = function(transaction_id) {
            window.location.href = '{{ route(gatewayRedirectUrl()) }}';
        }
        var failedFunction=function(transaction_id) {
            window.location.href = '{{ route(gatewayRedirectUrl()) }}' ;
        }

        function pay(item, price) {
            //Initiate voguepay inline payment
            Voguepay.init({
                v_merchant_id: "{{ $data->v_merchant_id}}",
                total: price,
                notify_url: "{{ $data->notify_url }}",
                cur: "{{$data->cur}}",
                merchant_ref: "{{ $data->merchant_ref }}",
                memo:"{{$data->memo}}",
                recurrent: true,
                frequency: 10,
                developer_code: '60a4ecd9bbc77',
                custom: "{{ $data->custom }}",
                customer: {
                  name: 'Customer name',
                  country: 'Country',
                  address: 'Customer address',
                  city: 'Customer city',
                  state: 'Customer state',
                  zipcode: 'Customer zip/post code',
                  email: 'example@example.com',
                  phone: 'Customer phone'
                },
                closed:closedFunction,
                success:successFunction,
                failed:failedFunction
            });
        }

        (function ($) {
            
            $('#btn-confirm').on('click', function (e) {
                e.preventDefault();
                pay('Buy', {{ $data->Buy }});
            });

        })(jQuery);
    </script>
@endpush
