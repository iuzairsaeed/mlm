@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('Name')</th>
                                    <th>@lang('Amount')</th>
                                    <th>@lang('Referral Bonus')</th>
                                    <th>@lang('Benefit / Loss')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($plans as $plan)
                                @php
                                    $totalAmount = ($plan->sumLevelOfCommission($plan->id) + $plan->referral_bonus);
                                    $finalAmount = $plan->price - $totalAmount;
                                @endphp
                                <tr>
                                    <td data-label="@lang('Name')">
                                        {{__($plan->name)}}
                                    </td>

                                    <td data-label="@lang('Amount')">
                                        <span class="font-weight-bold">{{getAmount($plan->price)}} {{$general->cur_text}}</span>
                                    </td>

                                    <td data-label="@lang('Referral Bonus')">
                                         <span class="font-weight-bold">{{getAmount($plan->referral_bonus)}} {{$general->cur_text}}</span>
                                     </td>

                                    <td data-label="@lang('Benefit / Loss')">
                                        @if($plan->price >  $totalAmount)
                                            <span class="text-success">@lang('Admin Benefit') {{getAmount($finalAmount)}} {{$general->cur_text}}</span>
                                        @else
                                            <span class="text-danger">@lang('Admin Loss') {{abs(getAmount($finalAmount))}} {{$general->cur_text}}</span>
                                        @endif
                                    </td>

                                    <td data-label="@lang('Status')">
                                        @if($plan->status == 1)
                                            <span class="badge badge--success">@lang('Enable')</span>
                                        @else
                                            <span class="badge badge--danger">@lang('Disabled')</span>
                                        @endif
                                    </td>

                                    <td data-label="@lang('Action')">
                                        <a href="{{route('admin.plan.edit', $plan->id)}}" class="icon-btn btn--primary ml-1">
                                            <i class="las la-edit"></i>
                                        </a>
                                         <a href="{{route('admin.plan.subscribers', $plan->id)}}" class="icon-btn btn--info ml-1">
                                            @lang('Subscribers')
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{__($emptyMessage) }}</td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer py-4">
                    {{ paginateLinks($plans) }}
                </div>
            </div>
        </div>
    </div>

    <div id="matrixSettingModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Matrix Setting Update')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.matrix.setting') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="matrix_height" class="form-control-label font-weight-bold">@lang('Matrix Height') <sup class="text--danger">*</sup></label>
                            <input type="text" class="form-control form-control-lg" name="matrix_height" value="{{$general->matrix_height}}" placeholder="@lang("Enter Matrix Height")"  maxlength="191" required="">
                            <small>@lang('Must be integer value')</small>
                        </div>

                        <div class="form-group">
                            <label for="matrix_width" class="form-control-label font-weight-bold">@lang('Matrix Width') <sup class="text--danger">*</sup></label>
                            <input type="text" class="form-control form-control-lg" name="matrix_width" value="{{$general->matrix_width}}" placeholder="@lang("Enter Matrix Width")" required="">
                             <small>@lang('Must be integer value')</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--primary">@lang('Update')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
 <a href="javascript:void(0)" class="btn btn-md bg--10 text-white box--shadow1 text--small matrixSetting"><i class="fa fa-fw fa-paper-plane"></i>@lang('Matrix Setting')</a>

    <a href="{{route('admin.plan.create')}}" class="btn btn-md btn--primary box--shadow1 text--small addPlan"><i class="las la-plus"></i>@lang('Add Plan')</a>
@endpush

@push('script')
    <script>
        "use strict";
        $('.matrixSetting').on('click', function() {
            $('#matrixSettingModal').modal('show');
        });
    </script>
@endpush
