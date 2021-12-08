@extends($activeTemplate.'layouts.master')
@section('content')
@include($activeTemplate.'partials.breadcrumb')
<div class="transaction-section padding-top padding-bottom">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="primary-bg item-rounded p-3">
                    <div class="support-header mb-25 d-flex flex-wrap justify-content-between align-items-center">
                        <form action="{{route('user.erecharge')}}" method="POST" class="support-search w-100">
                            @csrf
                            <input type="text" placeholder="Enter Pin" name="pin" required="">
                            <button type="submit">@lang('Recharge Now')</button>
                        </form>
                        <a href="javascript:void(0)" data-toggle="modal" data-target="#generatePin" class="theme-button"><i class="fa fa-fw fa-paper-plane"></i> @lang('Create Pin')</a>
                    </div>
                    <table class="deposite-table">
                        <thead>
                            <tr>
                                <th>@lang('User')</th>
                                <th>@lang('Amount')</th>
                                <th>@lang('Pin')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Details')</th>
                                <th>@lang('Date')</th>
                            </tr>
                        </thead>
                        <tbody>
                           @foreach($pins as $pin)
                            <tr>
                                <td data-label="@lang('User')">
                                    @if($pin->user_id)
                                        <span>{{__($pin->user->username)}}</span>
                                    @else
                                        <span>@lang('N/A')</span>
                                    @endif
                                </td>
                                <td data-label="@lang('Amount')">{{getAmount($pin->amount)}} {{$general->cur_text}}</td>
                                <td data-label="@lang('Pin')">{{$pin->pin}}</td>
                                <td data-label="@lang('Status')">
                                    @if($pin->status == 1)
                                        <span class="badge badge--success">@lang('Used')</span>
                                        <br>
                                        {{diffforhumans($pin->updated_at)}}
                                    @elseif($pin->status == 0)
                                        <span class="badge badge--danger">@lang('Unused')</span>
                                    @endif
                                </td>
                                <td data-label="@lang('Details')">{{__($pin->details)}}</td>
                                <td data-label="@lang('Date')">
                                    {{showDateTime($pin->created_at)}}
                                    <br>
                                    {{diffforhumans($pin->created_at)}}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$pins->links()}}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade custom--modal" id="generatePin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">@lang('Created Pin')</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form action="{{route('user.pin.generate')}}" method="post">
                @csrf
                <div class="modal-body">    
                    <div class="contact-form-group">
                        <div class="input-group mb-3">
                          <input type="text" class="form-control" name="amount" placeholder="@lang('Enter Amount')" value="{{old('amount')}}" aria-describedby="basic-addon2" required="">
                           <div class="input-group-prepend">
                              <div class="input-group-text">{{$general->cur_text}}</div>
                          </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn--danger" data-dismiss="modal">@lang('Close')</button>
                  <button type="submit" class="btn btn--success">@lang('Submit')</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
