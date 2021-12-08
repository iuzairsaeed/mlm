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
                                        <img src="{{$data->img}}" alt="deposit">
                                    </div>
                                    <div class="deposit-content">
                                        <h4 class="text-white bold my-4">@lang('SCAN TO SEND')</h4>
                                    </div>
                                </div>
                            </div>
                             <div class="col-md-8 text-center">
                                <ul class="preview-lists mb-30">
                                    <li>
                                        <span class="title text-white">@lang('PLEASE SEND EXACTLY')</span>
                                        <span class="details text-success text-white">{{ $data->amount }} {{__($data->currency)}}</span>
                                    </li>
                                    <li>
                                        <span class="title text-white">@lang('To')</span>
                                        <span class="details text-success text-white">{{ $data->sendto }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
