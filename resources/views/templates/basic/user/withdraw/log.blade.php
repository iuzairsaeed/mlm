@extends($activeTemplate.'layouts.master')
@section('content')
@include($activeTemplate.'partials.breadcrumb')
@php
    $emptyMessage = "No Withdrawl History";
@endphp
<div class="transaction-section padding-top padding-bottom">
     <div class="container">
            <div class="primary-bg item-rounded p-3">
                <table class="deposite-table">
                    <thead class="custom--table">
                    <tr>
                        <th>@lang('Transaction ID')</th>
                        <th>@lang('Gateway')</th>
                        <th>@lang('Amount')</th>
                        <th>@lang('Charge')</th>
                        <th>@lang('After Charge')</th>
                        <th>@lang('Rate')</th>
                        <th>@lang('Receivable')</th>
                        <th>@lang('Status')</th>
                        <th>@lang('Time')</th>
                    </tr>
                    </thead>
                    <tbody>

                    @forelse($withdraws as $k=>$data)
                        <tr>
                            <td data-label="#@lang('Trx')">{{$data->trx}}</td>
                            <td data-label="@lang('Gateway')">
                                @if($data->method_id != 0)
                                    {{ __($data->method->name) }}
                                @else
                                    @lang('E-pin')
                                @endif
                            </td>
                            <td data-label="@lang('Amount')">
                                <strong>{{getAmount($data->amount)}} {{__($general->cur_text)}}</strong>
                            </td>
                            <td data-label="@lang('Charge')" class="text-danger">
                                {{getAmount($data->charge)}} {{__($general->cur_text)}}
                            </td>
                            <td data-label="@lang('After Charge')">
                                {{getAmount($data->after_charge)}} {{__($general->cur_text)}}
                            </td>
                            <td data-label="@lang('Rate')">
                                {{getAmount($data->rate)}} {{__($data->currency)}}
                            </td>
                            <td data-label="@lang('Receivable')" class="text-success">
                                <strong>{{getAmount($data->final_amount)}} {{__($data->currency)}}</strong>
                            </td>
                            <td data-label="@lang('Status')">
                                @if($data->status == 2)
                                    <span class="badge badge--warning">@lang('Pending')</span>
                                @elseif($data->status == 1)
                                    <span class="badge badge--success">@lang('Completed')</span>
                                    @if($data->method_id != 0)
                                      <span class="badge badge--info approveBtn defaultWithdraw" data-admin_feedback="{{$data->admin_feedback}}"><i class="fa fa-info"></i></span>
                                    @endif
                                @elseif($data->status == 3)
                                    <span class="badge badge--danger">@lang('Rejected')</span>
                                    <span class="badge badge--info approveBtn defaultWithdraw" data-admin_feedback="{{$data->admin_feedback}}"><i class="fa fa-info"></i></span>
                                @endif
                            </td>
                            <td data-label="@lang('Time')">{{showDateTime($data->created_at)}}</td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                {{$withdraws->links()}}
            </div>
        </div>
    </div>

    <div id="detailModal" class="modal fade custom--modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Details')</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="withdraw-detail"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">@lang('Close')</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        (function($){
            "use strict";
            $('.approveBtn').on('click', function() {
                var modal = $('#detailModal');
                var feedback = $(this).data('admin_feedback');
                modal.find('.withdraw-detail').html(`<p> ${feedback} </p>`);
                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush






