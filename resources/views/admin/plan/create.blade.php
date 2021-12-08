@extends('admin.layouts.app')
@section('panel')
    <div class="row mb-none-30">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                   <form action="{{ route('admin.plan.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label for="name" class="form-control-label font-weight-bold">@lang('Name') <sup class="text--danger">*</sup></label>
                                <input type="text" class="form-control form-control-lg" name="name" value="{{old('name')}}"  maxlength="191" placeholder="@lang('Enter Name')" required="">
                            </div>

                            <div class="form-group col-lg-6">
                                 <label for="referral_bonus" class="form-control-label font-weight-bold">@lang('Price') <sup class="text--danger">*</sup></label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control form-control-lg" placeholder="@lang('Enter Amount')" name="price" value="{{old('price')}}" onkeyup="planPriceCommission()" id="planAmount"  aria-describedby="basic-addon2" required="">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon2">{{$general->cur_text}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-lg-6">
                                 <label for="referral_bonus" class="form-control-label font-weight-bold">@lang('Referral Bonus') <sup class="text--danger">*</sup></label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control form-control-lg" id="referralBonus"  placeholder="@lang('Enter Amount')" name="referral_bonus" onkeyup="planPriceCommission()"  value="{{old('referral_bonus')}}" aria-describedby="basic-addon2" required="">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon2">{{$general->cur_text}}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-lg-6">
                                <label class="form-control-label font-weight-bold">@lang('Status') </label>
                                <input type="checkbox" class="form-control-lg" data-width="100%" data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle" data-on="@lang('Enable')" data-off="@lang('Disabled')" name="status">
                            </div>
                        </div>

                        <h4 class="text-center m-4">@lang('Level Commissions')</h4>
                        
                        <div class="row">
                            @for($i=0; $i < $general->matrix_height; $i++)
                                <div class="form-group col-lg-3">
                                    <label for="referral_bonus" class="form-control-label font-weight-bold">@lang('Level-'){{$i+1}} <sup class="text--danger">*</sup></label>
                                    <div class="input-group mb-3">
                                          <input type="text" onkeyup="planPriceCommission()"  class="form-control form-control-lg commissionAmount" placeholder="@lang('Enter Amount')" name="level[{{$i+1}}]" aria-label="Recipient's username" aria-describedby="basic-addon2" required="">
                                          <div class="input-group-append">
                                            <span class="input-group-text" id="basic-addon2">{{$general->cur_text}}</span>
                                          </div>
                                    </div>
                                </div>
                            @endfor
                        </div>

                        <div class="text-center mb-4">
                            <div class="adminGain"></div>
                            <div class="adminLoss"></div>
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn--primary btn-md btn-block"><i class="fa fa-fw fa-paper-plane"></i>@lang('Plan Create')</button>
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

