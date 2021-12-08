@extends($activeTemplate.'layouts.master')
@section('content')
@include($activeTemplate.'partials.breadcrumb')
<div class="transaction-section padding-top padding-bottom">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="primary-bg item-rounded p-3">
                    <div class="support-header  d-flex flex-wrap justify-content-end align-items-center ">
                        <form action="{{route('user.level.position')}}" method="GET" class="support-search w-100">
                            <div class="contact-form-group">
                                <div class="select-item">
                                    <select name="level" id="level" class="select-bar">
                                        <option>-----@lang('Select Level')-----</option>
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
                                </div>
                            </div>
                            <button type="submit">@lang('Submit')</button>
                        </form>
                    </div>
                    <table class="deposite-table">
                        <thead>
                            <tr>
                                <th>@lang('ID')</th>
                                <th>@lang('Username')</th>
                                <th>@lang('Email')</th>
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
                                    <td data-label="@lang('ID')">{{$loop->iteration}}</td>
                                    <td data-label="@lang('Username')">{{__($user->username)}}</td>
                                    <td data-label="@lang('Email')">{{__($user->email)}}</td>
                                    <td data-label="@lang('Under Position')">{{__($user->positions->username)}}</td>
                                    <td data-label="@lang('Referrer By')">{{__($user->referral->username)}}</td>
                                    <td data-label="@lang('Balance')">{{getAmount($user->balance)}} {{$general->cur_text}}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="100%">{{ __($emptyMessage) }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
