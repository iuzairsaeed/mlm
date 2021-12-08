@extends($activeTemplate.'layouts.frontend')
@section('content')
@include($activeTemplate.'partials.breadcrumb')
<section class="plan-section padding-top padding-bottom oh">
    <div class="container">
        <div class="row justify-content-center">
            @foreach($plans as $plan)
                <div class="col-md-6 col-lg-4">
                    <div class="plan-item">
                        <div class="plan-header">
                                <span class="plan-badge">
                                    {{__($plan->name)}}
                                </span>
                            <div class="icon">
                                <i class="fas fa-piggy-bank"></i>
                            </div>
                            <h3 class="title">{{$general->cur_sym}}{{getAmount($plan->price)}}</h3>
                        </div>
                        <ul class="plan-info">
                            <li>
                                <h6 class="direct">@lang('Direct Referral Bonus') : {{$general->cur_sym}}{{getAmount($plan->referral_bonus)}}</h6>
                            </li>
                            @php 
                                $sumCommission =0;
                            @endphp

                             @foreach($plan->totalLevel($plan->id) as $value)
                                @php
                                    $matrixCal = pow($general->matrix_width, $loop->iteration);
                                    $commission = getAmount($value->amount * $matrixCal);
                                    $sumCommission += $commission;
                                @endphp 

                                <li>
                                    @lang('L'){{$loop->iteration }} : {{__($general->cur_sym)}}{{getAmount($value->amount)}} X {{$matrixCal}} <i class="fa fa-users"></i> = <strong class="profit">{{__($general->cur_sym)}}{{$commission}}</strong>
                                </li>
                            @endforeach
                        </ul>
                        <div class="total-return">
                            <h6 class="title">@lang('Total Level Commission') : {{getAmount($sumCommission)}} {{$general->cur_text}}</h6>
                            <span class="return-remainders">
                                    @lang('Returns') <span class="remainder">{{getAmount(($sumCommission / $plan->price) * 100)}}%</span> @lang('of Invest')
                                </span>
                        </div>

                        <div class="invest-now py-3">
                            <a href="javascript:void(0)" class="custom-button small theme planSubscribe" data-planid="{{$plan->id}}">@lang('Invest Now')</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<div class="modal fade custom--modal" id="planModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">@lang('Subscribe Plan')</h5>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
            <i class="fas fa-times"></i>
          </button>
        </div>
        <form action="{{route('user.plan.order')}}" method="post">
            @csrf
            <input type="hidden" name="planid">
            <div class="modal-body">
                <p class="text-white">@lang('Are you sure you want to subscribe this plan')?</p>
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
        "use strict";
        $('.planSubscribe').on('click', function () {
            var modal = $('#planModal');
            modal.find('input[name=planid]').val($(this).data('planid'));
            modal.modal('show');
        });
    </script>
@endpush