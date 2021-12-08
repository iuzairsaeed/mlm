@extends('admin.layouts.app')
@section('panel')
    <div class="row mb-none-30">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                   <form action="{{ route('admin.plan.update', $plan->id) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label for="name" class="form-control-label font-weight-bold">@lang('Name')</label>
                                <input type="text" class="form-control form-control-lg" name="name" value="{{__($plan->name)}}"  maxlength="191" required="">
                            </div>

                            <div class="form-group col-lg-6">
                                 <label for="referral_bonus" class="form-control-label font-weight-bold">@lang('Price')</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control form-control-lg" placeholder="@lang('Enter Amount')" name="price" value="{{getAmount($plan->price)}}" onkeyup="planPriceCommission()" id="planAmount"  aria-describedby="basic-addon2" required="">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon2">{{$general->cur_text}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-lg-6">
                                 <label for="referral_bonus" class="form-control-label font-weight-bold">@lang('Referral Bonus')</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control form-control-lg" id="referralBonus"  placeholder="@lang('Enter Amount')" name="referral_bonus" onkeyup="planPriceCommission()"  value="{{getAmount($plan->referral_bonus)}}" aria-describedby="basic-addon2" required="">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon2">{{$general->cur_text}}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-lg-6">
                                <label class="form-control-label font-weight-bold">@lang('Status') </label>
                                <input type="checkbox" class="form-control-lg" data-width="100%" data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle" data-on="@lang('Enable')" data-off="@lang('Disabled')" @if($plan->status) checked @endif name="status">
                            </div>
                        </div>

                        <h4 class="text-center m-4">@lang('Level Commissions')</h4>
                    
                        <div class="row">
                            @for($i=0; $i < $general->matrix_height; $i++)
                                <div class="form-group col-lg-3">
                                    <label for="referral_bonus" class="form-control-label font-weight-bold">@lang('Level-'){{$i+1}}</label>
                                    <div class="input-group mb-3">
                                          <input type="text" onkeyup="planPriceCommission()"  class="form-control form-control-lg commissionAmount" placeholder="@lang('Enter Amount')" name="level[{{$i+1}}]" aria-label="Recipient's username" value="{{getAmount(@$plan->level[$i]->amount)}}" aria-describedby="basic-addon2" required="">
                                          <div class="input-group-append">
                                            <span class="input-group-text" id="basic-addon2">{{$general->cur_text}}</span>
                                          </div>
                                    </div>
                                </div>
                            @endfor
                        </div>

                        <div class="text-center mb-4">
                            @php
                                $totalAmount = $plan->sumLevelOfCommission($plan->id) + $plan->referral_bonus;
                                $finalAmount = $plan->price - $totalAmount;
                            @endphp

                            <div id="adminProfit"> 
                                @if($plan->price >  $totalAmount)
                                    <strong class="text-success">@lang('Admin Benefit') {{abs(getAmount($finalAmount))}} {{$general->cur_text}}</strong>
                                @else
                                    <strong class="text-danger">@lang('Admin Loss') {{abs(getAmount($finalAmount))}} {{$general->cur_text}}</strong>
                                @endif
                            </div>
                            <div class="adminGain"></div>
                            <div class="adminLoss"></div>
                        </div>
                       
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn--primary btn-block"><i class="fa fa-fw fa-paper-plane"></i>@lang('Plan Update')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <a href="{{route('admin.plan.index')}}" class="btn btn-sm btn--primary box--shadow1 text--small" ><i class="las la-angle-double-left"></i>@lang('Go Back')</a>
@endpush

@push('script')
<script>
    "use strict";
    function planPriceCommission(){
        $("#adminProfit").hide();
        var levelAmount= 0;
        var planAmount = $('#planAmount').val();
        var referralBonus = $('#referralBonus').val();
        $('.commissionAmount').each(function(e){
            if($(this).val()!=''){
                levelAmount += +$(this).val();
            }
        })
        var totalAmount = levelAmount + Number(referralBonus);
        var currency = "{{$general->cur_text}}";
        var finalAmount = planAmount - totalAmount;
        if(planAmount > totalAmount){
            $('.adminGain').html('<strong class="text-success">Admin Benefit : ' + parseFloat(finalAmount.toFixed(8)) +' '+currency + '</strong>');
            $('.adminLoss').empty();
        }else {
            $('.adminLoss').html('<strong class="text-danger">Admin Loss : ' + parseFloat(finalAmount.toFixed(8)) +' '+currency + '</strong>');
            $('.adminGain').empty();
        }
    };
</script>
@endpush

