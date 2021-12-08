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
                                    <th>@lang('User')</th>
                                    <th>@lang('Plan')</th>
                                    <th>@lang('Amount')</th>
                                    <th>@lang('Order Number')</th>
                                    <th>@lang('Joined At')</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($subscriptions as $subscription)
                                <tr>
                                    <td data-label="@lang('User')">
                                        <span class="font-weight-bold">{{ $subscription->user->fullname }}</span>
                                        <br>
                                        <span class="small">
                                        <a href="{{ route('admin.users.detail', $subscription->user_id) }}"><span>@</span>{{$subscription->user->username }}</a>
                                        </span>
                                    </td>
                                    <td data-label="@lang('Plan')">
                                        {{$subscription->plan->name}}
                                    </td>
                                    <td data-label="@lang('Amount')">
                                        <span class="font-weight-bold">{{ getAmount($subscription->amount) }} {{$general->cur_text}}</span>
                                    </td>
                                    <td data-label="@lang('subscription Number')">
                                        {{$subscription->order_number}}
                                    </td>
                                    <td data-label="@lang('Joined At')">{{showDateTime($subscription->created_at) }} <br> {{ diffForHumans($subscription->created_at) }}
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
                    {{ paginateLinks($subscriptions) }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
<form action="{{route('admin.plan.subscribers.search')}}" method="GET" class="form-inline float-sm-right bg--white mb-2 ml-0 ml-xl-2 ml-lg-0">
    <div class="input-group has_append  ">
        <input type="text" name="search" class="form-control" placeholder="@lang('Order Number/Username')" value="{{ $search ?? '' }}">
        <div class="input-group-append">
            <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
        </div>
    </div>
</form>
@endpush


