@extends($activeTemplate.'layouts.master')
@section('content')
@include($activeTemplate.'partials.breadcrumb')
<div class="deposit-section padding-top padding-bottom">
    <div class="container">
        <div class="row mb-30-none justify-content-center">
            @foreach($withdrawMethod as $data)
                <div class="col-sm-8 col-md-6 col-lg-4">
                    <div class="deposit-item">
                        <div class="deposit-thumb">
                            <img src="{{getImage(imagePath()['withdraw']['method']['path'].'/'. $data->image,imagePath()['withdraw']['method']['size'])}}" alt="{{__($data->name)}}">
                            <div class="thumb-content">
                                <ul>
                                    <li>
                                        @lang('Limit') : {{getAmount($data->min_limit)}} - {{getAmount($data->max_limit)}} {{__($general->cur_text)}}
                                    </li>
                                    <li>
                                        @lang('Charge') : {{getAmount($data->fixed_charge)}} {{__($general->cur_text)}} + {{getAmount($data->percent_charge)}}%
                                    </li>
                                    <li>
                                        @lang('Processing Time') - {{$data->delay}}
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="deposit-content">
                            <h5 class="title">{{__($data->name)}}</h5>
                            <a href="javascript:void(0)" data-toggle="modal" data-target="#depositModal"
                               data-id="{{$data->id}}"
                               data-resource="{{$data}}"
                               data-min_amount="{{getAmount($data->min_limit)}}"
                               data-max_amount="{{getAmount($data->max_limit)}}"
                               data-fix_charge="{{getAmount($data->fixed_charge)}}"
                               data-percent_charge="{{getAmount($data->percent_charge)}}"
                               data-base_symbol="{{__($general->cur_text)}}"
                             class="theme-button withdraw">@lang('Withdraw Now')</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<div class="modal fade custom--modal" id="depositModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title method-name" id="exampleModalLabel">@lang('Withdraw')</h5>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
            <i class="fas fa-times"></i>
          </button>
        </div>
        <form action="{{route('user.withdraw.money')}}" method="post">
            @csrf
            <div class="modal-body">
                <p class="text-danger withdrawLimit"></p>
                <p class="text-danger withdrawCharge"></p>
                <input type="hidden" name="currency"  class="edit-currency form-control">
                <input type="hidden" name="method_code" class="edit-method-code  form-control">
                        
                        
                <div class="contact-form-group">
                    <div class="input-group mb-3">
                      <input type="text" class="form-control" onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')" name="amount" placeholder="@lang('Enter Amount')" value="{{old('amount')}}" aria-describedby="basic-addon2">
                     <div class="input-group-prepend">
                          <div class="input-group-text">{{$general->cur_text}}</div>
                      </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn--danger" data-dismiss="modal">@lang('Close')</button>
              <button type="submit" class="btn btn--success">@lang('Confirm')</button>
            </div>
        </form>
      </div>
    </div>
  </div>
@endsection
@push('script')
    <script>
        (function ($) {
            "use strict";
            $('.withdraw').on('click', function () {
                var id = $(this).data('id');
                var result = $(this).data('resource');
                var minAmount = $(this).data('min_amount');
                var maxAmount = $(this).data('max_amount');
                var fixCharge = $(this).data('fix_charge');
                var percentCharge = $(this).data('percent_charge');

                var withdrawLimit = `@lang('Withdraw Limit'): ${minAmount} - ${maxAmount}  {{__($general->cur_text)}}`;
                $('.withdrawLimit').text(withdrawLimit);
                var withdrawCharge = `@lang('Charge'): ${fixCharge} {{__($general->cur_text)}} ${(0 < percentCharge) ? ' + ' + percentCharge + ' %' : ''}`
                $('.withdrawCharge').text(withdrawCharge);
                $('.method-name').text(`@lang('Withdraw Via') ${result.name}`);
                $('.edit-currency').val(result.currency);
                $('.edit-method-code').val(result.id);
            });
        })(jQuery);
    </script>

@endpush

