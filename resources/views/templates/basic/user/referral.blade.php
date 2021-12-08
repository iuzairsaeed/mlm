@extends($activeTemplate.'layouts.master')
@section('content')
@include($activeTemplate.'partials.breadcrumb')
<div class="transaction-section padding-top padding-bottom">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="primary-bg item-rounded p-3">
                    <div class="support-header  d-flex flex-wrap justify-content-end align-items-center">
                        <form action="{{route('user.level.position')}}" method="GET" class="support-search w-100">
                            <div class="contact-form-group">
                                <div class="select-item">
                                    <select name="level" id="level" class="select-bar">
                                        <option>-----@lang('Select Level')-----</option>
                                        @if($order)
                                            @foreach($order->plan->totalLevel($order->plan_id) as $value)
                                                <option value="{{$value->level}}">@lang('Level')-{{$value->level}}</option>
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
                                <th>@lang('Balance')</th>
                                <th>@lang('Joined At')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($referrals as $referral)
                                <tr>
                                    <td data-label="@lang('ID')">{{$loop->iteration}}</td>
                                    <td data-label="@lang('Username')">{{$referral->username}}</td>
                                    <td data-label="@lang('Email')">{{$referral->email}}</td>
                                    <td data-label="@lang('Balance')">{{getAmount($referral->balance)}} {{$general->cur_text}}</td>
                                    <td data-label="@lang('Joined At')">
                                        {{showDateTime($referral->created_at)}}
                                        <br>
                                        {{diffforhumans($referral->created_at)}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$referrals->links()}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
