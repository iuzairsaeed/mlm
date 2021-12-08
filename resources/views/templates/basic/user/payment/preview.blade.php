@extends($activeTemplate.'layouts.master')
@section('content')
@include($activeTemplate.'partials.breadcrumb')
<section class="preview-section padding-top padding-bottom">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-xl-10">
        <div class="item-rounded primary-bg item-padding">
            <div class="row ">
                <div class="col-md-6 col-lg-4 col-xl-4">
                    <div class="deposit-item active mb-lg-0 primary-bg-2">
                        <div class="deposit-thumb">
                            <img src="{{ $data->gatewayCurrency()->methodImage() }}" alt="@lang('Deposit Image')">
                        </div>
                        <div class="deposit-content">
                            <h5 class="title">{{ $data->gatewayCurrency()->name}}</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-xl-8">
                    <div class="preview-header">
                        <h5 class="title">@lang('Preview')</h5>
                    </div>
                    <ul class="preview-lists mb-30">
                        <li>
                            <span class="title">@lang('Amount')</span>
                            <span class="details text-info">{{getAmount($data->amount)}} {{__($general->cur_text)}}</span>
                        </li>
                        <li>
                            <span class="title">@lang('Charge')</span>
                            <span class="details text-danger">{{getAmount($data->charge)}} {{__($general->cur_text)}}</span>
                        </li>
                        <li>
                            <span class="title">@lang('Payable')</span>
                            <span class="details text-success">{{getAmount($data->amount + $data->charge)}} {{__($general->cur_text)}}</span>
                        </li>
                        <li>
                            <span class="title">@lang('Conversion Rate')</span>
                            <span class="details">1 {{__($general->cur_text)}} = {{getAmount($data->rate)}}  {{__($data->baseCurrency())}}</span>
                        </li>
                        <li>
                            <span class="title">@lang('In') {{$data->baseCurrency()}}:</span>
                            <span class="details text-success">{{getAmount($data->final_amo)}}</span>
                        </li>

                        @if($data->gateway->crypto==1)
                            <li> 
                                <span class="title">@lang('Conversion with')</span>
                                <span class="details"><b> {{ __($data->method_currency) }}</b> @lang('and final value will Show on next step')</span>
                            </li>
                        @endif
                    </ul>
                    <div class="text-center mt-30">
                        @if( 1000 >$data->method_code)
                            <a href="{{route('user.deposit.confirm')}}" class="theme-button btn-sm">@lang('Pay Now')</a>
                        @else
                            <a href="{{route('user.deposit.manual.confirm')}}" class="theme-button btn-sm">@lang('Pay Now')</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</section>
@endsection


