@extends($activeTemplate.'layouts.master')
@section('content')
@include($activeTemplate.'partials.breadcrumb')
<div class="deposit-section padding-top padding-bottom">
    <div class="container">
        <div class="row mb-30-none justify-content-center">
            @foreach($gatewayCurrency as $data)
                <div class="col-sm-8 col-md-6 col-lg-4">
                    <div class="deposit-item">
                        <div class="deposit-thumb">
                            <img src="{{$data->methodImage()}}" alt="{{__($data->name)}}">
                            <div class="thumb-content">
                                <ul>
                                    <li>
                                        @lang('Limit') : {{getAmount($data->min_amount)}} - {{getAmount($data->max_amount)}} {{$general->cur_text}}
                                    </li>
                                    <li>
                                        @lang('Charge') - {{getAmount($data->fixed_charge)}} {{$general->cur_text}} + {{getAmount($data->percent_charge)}}%
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="deposit-content">
                            <h5 class="title">{{__($data->name)}}</h5>
                            <a href="javascript:void(0)" data-toggle="modal" data-target="#depositModal"
                               data-id="{{$data->id}}"
                               data-name="{{$data->name}}"
                               data-currency="{{$data->currency}}"
                               data-method_code="{{$data->method_code}}"
                               data-min_amount="{{getAmount($data->min_amount)}}"
                               data-max_amount="{{getAmount($data->max_amount)}}"
                               data-base_symbol="{{$data->baseSymbol()}}"
                               data-fix_charge="{{getAmount($data->fixed_charge)}}"
                               data-percent_charge="{{getAmount($data->percent_charge)}}"
                             class="theme-button deposit">@lang('Deposite Now')</a>
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
          <h5 class="modal-title method-name" id="exampleModalLabel"></h5>
           <button type="button" class="close text-white " data-dismiss="modal" aria-label="Close">
              <i class="fas fa-times"></i>
            </button>
        </div>
        <form action="{{route('user.deposit.insert')}}" method="post">
            @csrf
            <div class="modal-body">
                <p class="text-danger depositLimit"></p>
                <p class="text-danger depositCharge"></p>

                <input type="hidden" name="currency" class="edit-currency">
                <input type="hidden" name="method_code" class="edit-method-code">
                        
                <div class="contact-form-group">
                    <div class="input-group mb-3">
                      <input type="text" class="form-control" name="amount" placeholder="@lang('Enter Amount')" value="{{old('amount')}}" aria-describedby="basic-addon2">
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
            $('.deposit').on('click', function () {
                var name = $(this).data('name');
                var currency = $(this).data('currency');
                var method_code = $(this).data('method_code');
                var minAmount = $(this).data('min_amount');
                var maxAmount = $(this).data('max_amount');
                var baseSymbol = "{{$general->cur_text}}";
                var fixCharge = $(this).data('fix_charge');
                var percentCharge = $(this).data('percent_charge');

                var depositLimit = `@lang('Deposit Limit'): ${minAmount} - ${maxAmount}  ${baseSymbol}`;
                $('.depositLimit').text(depositLimit);
                var depositCharge = `@lang('Charge'): ${fixCharge} ${baseSymbol}  ${(0 < percentCharge) ? ' + ' +percentCharge + ' % ' : ''}`;
                $('.depositCharge').text(depositCharge);
                $('.method-name').text(`@lang('Payment By ') ${name}`);
                $('.currency-addon').text(baseSymbol);
                $('.edit-currency').val(currency);
                $('.edit-method-code').val(method_code);
            });
        })(jQuery);
    </script>
@endpush
