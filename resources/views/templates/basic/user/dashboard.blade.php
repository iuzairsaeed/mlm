@extends($activeTemplate.'layouts.master')
@section('content')
@include($activeTemplate.'partials.breadcrumb')
@php

$subs_details_count = App\Models\PlanSubscription::where('user_id',Auth::user()->id)->count();
if($subs_details_count > 0){

    $subs_details = App\Models\PlanSubscription::where('user_id',Auth::user()->id)->first();
    $package_details = App\Models\Plan::where('id',$subs_details->plan_id)->first();
    $shares_on_hold = $package_details->price * 100;
}else{

    $shares_on_hold = 0;

}
    
@endphp

    <div class="dashboard-section padding-top padding-bottom">
        <div class="container">
            <div class="row justify-content-center mb-30-none">
                <div class="col-md-12">
                     <div class="referral-input mb-30">
                        <input type="url" id="referralURL" value="{{route('home')}}?reference={{auth()->user()->username}}" readonly="">
                        <div class="btn btn--info" onclick="myFunction()"><i class="fa fa-files-o"></i>&nbsp;@lang('copy')</div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6">
                    <div class="dashboard-item">
                        <div class="dashboard-thumb">
                            <i class="fas fa-money-bill"></i>
                        </div>
                        <div class="dashboard-content">
                            <h5 class="title">@lang('Shares You Hold')</h5>
                            <h4 class="amount">{{$shares_on_hold}}</h4>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-6">
                    <div class="dashboard-item">
                        <div class="dashboard-thumb">
                            <i class="fas fa-money-bill"></i>
                        </div>
                        <div class="dashboard-content">
                            <h5 class="title">@lang('MemberShip')</h5>
                            <h4 class="amount">{{Auth::user()->member_ship ?? 'No membership'}}</h4>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-4">
                    <div class="dashboard-item">
                        <div class="dashboard-thumb">
                            <i class="fas fa-money-bill"></i>
                        </div>
                        <div class="dashboard-content">
                            <h5 class="title">@lang('Current Balance')</h5>
                            <h4 class="amount">{{$general->cur_sym}}{{getAmount(auth()->user()->balance)}}</h4>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="dashboard-item">
                        <div class="dashboard-thumb">
                            <i class="fas fa-wallet"></i>
                        </div>
                        <div class="dashboard-content">
                            <h5 class="title">@lang('Deposit')</h5>
                            <h4 class="amount">{{$general->cur_sym}}{{getAmount($deposit)}}</h4>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="dashboard-item">
                        <div class="dashboard-thumb">
                            <i class="far fa-credit-card"></i>
                        </div>
                        <div class="dashboard-content">
                            <h5 class="title">@lang('Withdraw')</h5>
                            <h4 class="amount">{{$general->cur_sym}}{{getAmount($withdraw)}}</h4>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="dashboard-item">
                        <div class="dashboard-thumb">
                           <i class="fas fa-money-check-alt"></i>
                        </div>
                        <div class="dashboard-content">
                            <h5 class="title">@lang('Total Transactions')</h5>
                            <h4 class="amount">{{$transaction}}</h4>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="dashboard-item">
                        <div class="dashboard-thumb">
                           <i class="fas fa-money-bill"></i>
                        </div>
                        <div class="dashboard-content">
                            <h5 class="title">@lang('Total Commission')</h5>
                            <h4 class="amount">{{$general->cur_sym}}{{getAmount($commission)}}</h4>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="dashboard-item">
                        <div class="dashboard-thumb">
                            <i class="fas fa-coins"></i>
                        </div>
                        <div class="dashboard-content">
                            <h5 class="title">@lang('Total Invest')</h5>
                            <h4 class="amount">{{$general->cur_sym}}{{getAmount($order)}}</h4>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 mt-5">
                    <div class="primary-bg item-rounded p-3">
                        <table class="deposite-table">
                            <thead class="custom--table">
                                <tr>
                                    <th>@lang('Date')</th>
                                    <th>@lang('TRX')</th>
                                    <th>@lang('Amount')</th>
                                    <th>@lang('Charge')</th>
                                    <th>@lang('Post Balance')</th>
                                    <th>@lang('Detail')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transactions as $trx)
                                    <tr>
                                        <td data-label="@lang('Date')">
                                            {{ showDateTime($trx->created_at) }}
                                            <br>
                                            {{diffforhumans($trx->created_at)}}
                                        </td>
                                        <td data-label="@lang('TRX')" class="font-weight-bold">{{ $trx->trx }}</td>
                                        <td data-label="@lang('Amount')" class="budget">
                                            <strong @if($trx->trx_type == '+') class="text-success" @else class="text-danger" @endif> {{($trx->trx_type == '+') ? '+':'-'}} {{getAmount($trx->amount)}} {{__($general->cur_text)}}</strong>
                                        </td>
                                        <td data-label="@lang('Charge')" class="budget">{{ __(__($general->cur_sym)) }} {{ getAmount($trx->charge) }} </td>
                                        <td data-label="@lang('Post Balance')">{{ getAmount($trx->post_balance) }} {{__($general->cur_text)}}</td>
                                        <td data-label="@lang('Detail')">{{ __($trx->details) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@push('script')
    <script>
        "use strict";
        function myFunction() {
            var copyText = document.getElementById("referralURL");
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            document.execCommand("copy");
            iziToast.success({message: "Referral Url Copied: " + copyText.value, position: "topRight"});
        }
    </script>
@endpush
@endsection