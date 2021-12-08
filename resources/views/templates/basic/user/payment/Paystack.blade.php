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
                                <form action="{{ route('ipn.'.$deposit->gateway->alias) }}" method="POST" class="text-center">
                                    @csrf
                                    <div class="contact-form-group">
                                        <button type="button" id="btn-confirm">@lang('Pay Now')</button>
                                    </div>
                                    <script
                                        src="//js.paystack.co/v1/inline.js"
                                        data-key="{{ $data->key }}"
                                        data-email="{{ $data->email }}"
                                        data-amount="{{$data->amount}}"
                                        data-currency="{{$data->currency}}"
                                        data-ref="{{ $data->ref }}"
                                        data-custom-button="btn-confirm"
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
