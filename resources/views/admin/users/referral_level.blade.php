@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                                <th>@lang('User')</th>
                                <th>@lang('Email-Phone')</th>
                                <th>@lang('Under Position')</th>
                                <th>@lang('Referrer By')</th>
                                <th>@lang('Balance')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($nextArray as $value)
                                @php 
                                    $user  = App\Models\User::where('id', $value)->with('positions', 'referral')->first();
                                @endphp

                                <tr>
                                    <td data-label="@lang('User')">
                                        <span class="font-weight-bold">{{$user->fullname}}</span>
                                        <br>
                                        <span class="small">
                                        <a href="{{ route('admin.users.detail', $user->id) }}"><span>@</span>{{ $user->username }}</a>
                                        </span>
                                    </td>

                                    <td data-label="@lang('Email-Phone')">
                                        {{ $user->email }}<br>{{ $user->mobile }}
                                    </td>

                                    <td data-label="@lang('Under Position')">
                                        <span class="font-weight-bold">{{$user->positions->fullname}}</span>
                                        <br>
                                        <span class="small">
                                        <a href="{{ route('admin.users.detail', $user->position_id) }}"><span>@</span>{{__($user->positions->username)}}</a>
                                        </span>
                                    </td>

                                    <td data-label="@lang('Referrer By')">
                                        <span class="font-weight-bold">{{$user->referral->fullname}}</span>
                                        <br>
                                        <span class="small">
                                        <a href="{{ route('admin.users.detail', $user->ref_by) }}"><span>@</span>{{$user->referral->username }}</a>
                                        </span>
                                    </td>

                                    <td data-label="@lang('Balance')">
                                        <span class="font-weight-bold">
                                            
                                        {{ $general->cur_sym }}{{ getAmount($user->balance) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('breadcrumb-plugins')
<form action="{{ route('admin.users.referral.level.log', $userDataInfo->id) }}" method="GET" class="form-inline float-sm-right bg--white">
    <div class="input-group has_append">
       <select class="form-control" name="level">
            <option>----@lang('Select Level')----</option>
            @if($order)
                @foreach($order->plan->totalLevel($order->plan_id) as $value)
                    @if($value->level == @$levelId)
                        <option value="{{$value->level}}" selected="">@lang('Level')-{{$value->level}}</option>
                    @else
                        <option value="{{$value->level}}">@lang('Level')-{{$value->level}}</option>
                    @endif
                @endforeach
            @endif
       </select>

        <div class="input-group-append">
            <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
        </div>
    </div>
</form>
@endpush
