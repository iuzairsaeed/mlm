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
                            <div class="col-md-8">
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
                                <form action="{{$data->url}}" method="{{$data->method}}">
                                    <script src="{{$data->src}}"
                                        class="stripe-button"
                                        @foreach($data->val as $key=> $value)
                                        data-{{$key}}="{{$value}}"
                                        @endforeach
                                    >
                                    </script>
                                </form>
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
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        (function ($) {
            "use strict";
            $('button[type="submit"]').addClass("btn btn--success text-center btn-lg");
        })(jQuery);
    </script>
@endpush

@push('style')
<style>
    .stripe-button-el{
        background: #28C76F !important;
        text-align: center;
    }
    .stripe-button-el span{
        background: #28C76F !important;
        text-align: center;
    }
</style>
@endpush
