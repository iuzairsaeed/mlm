@extends($activeTemplate.'layouts.master')
@section('content')
@include($activeTemplate.'partials.breadcrumb')
<div class="transaction-section padding-top padding-bottom">
     <div class="container">
            <div class="primary-bg item-rounded p-3">
                <table class="deposite-table">
                    <thead class="custom--table">
                        <tr>
                            <th>@lang('User')</th>
                            <th>@lang('TRX')</th>
                            <th>@lang('Amount')</th>
                            <th>@lang('Post Balance')</th>
                            <th>@lang('Date')</th>
                            <th>@lang('Detail')</th>
                        </tr>
                    </thead>
                    <tbody>
                      
                        @forelse($commissions as $commission)
                            @php
                                $from_user = App\Models\User::where('id',$commission->from_user_id)->first();
                            @endphp
                            <tr>
                                 <td data-label="@lang('User')">{{$from_user->username ?? 'na'}}</td>
                                <td data-label="@lang('TRX')" class="font-weight-bold">{{$commission->trx}}</td>
                                <td data-label="@lang('Amount')" class="budget">
                                    <strong class="text-success">+ {{getAmount($commission->amount)}} {{__($general->cur_text)}}</strong>
                                </td>
                                <td data-label="@lang('Post Balance')">{{ getAmount($commission->post_balance) }} {{__($general->cur_text)}}</td>
                                <td data-label="@lang('Date')">
                                    {{ showDateTime($commission->created_at) }}
                                    <br>
                                    {{ diffForHumans($commission->created_at) }}
                                </td>
                                <td data-label="@lang('Detail')">{{ __($commission->details) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="100%">{{ __($emptyMessage) }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                    {{$commissions->links()}}
            </div>
        </div>
    </div>
@endsection



