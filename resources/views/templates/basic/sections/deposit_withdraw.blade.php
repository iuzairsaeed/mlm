
@php
    $content = getContent('deposit_withdraw.content', true);
    $deposits = App\Models\Deposit::where('status', 1)->with('user', 'gateway')->orderBy('id', 'DESC')->limit(10)->get();
    $withdrwals = App\Models\Withdrawal::where('status', 1)->with('user', 'method')->orderBy('id', 'DESC')->limit(10)->get();
@endphp
<section class="deposit-withdraw padding-bottom padding-top">
    <div class="container">
        <div class="row mb--50">
            <div class="col-lg-6 mb-50">
                <div class="section-header margin-olpo left-style text-center">
                    <h3 class="title">{{__(@$content->data_values->deposit_heading)}}</h3>
                    <p>{{__(@$content->data_values->deposit_sub_heading)}}</p>
                </div>
                <table class="deposit-table">
                    <thead>
                    <tr>
                        <th>@lang('Name')</th>
                        <th>@lang('Amount')</th>
                        <th>@lang('Date')</th>
                        <th>@lang('Gateway')</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($deposits as $deposit)
                            <tr>
                                <td data-label="@lang('Name')">{{__($deposit->user->fullname)}}</td>
                                <td data-label="@lang('Amount')">{{getAmount($deposit->amount)}} {{$general->cur_text}}</td>
                                <td data-label="@lang('Date')">{{showdateTime($deposit->created_at, 'd M Y')}}</td>
                                <td data-label="@lang('Gateway')">
                                    @if($deposit->method_code != 0)
                                        {{__(@$deposit->gateway->name)}}
                                    @else
                                        @lang('E-pin')
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="col-lg-6 mb-50">
                <div class="section-header margin-olpo left-style text-center">
                    <h3 class="title">{{__(@$content->data_values->withdraw_heading)}}</h3>
                    <p>{{__(@$content->data_values->withdraw_sub_heading)}}</p>
                </div>
            
                <table class="deposit-table">
                    <thead>
                        <tr>
                            <th>@lang('Name')</th>
                            <th>@lang('Amount')</th>
                            <th>@lang('Date')</th>
                            <th>@lang('Method')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($withdrwals as $withdrwal)
                            <tr>
                                <td data-label="@lang('Name')">{{__($withdrwal->user->fullname)}}</td>
                                <td data-label="@lang('Amount')">{{getAmount($withdrwal->amount)}} {{$general->cur_text}}</td>
                                <td data-label="@lang('Date')">{{showdateTime($withdrwal->created_at, 'd M Y')}}</td>
                                <td data-label="@lang('Method')">
                                    @if($withdrwal->method_id != 0)
                                        {{__($withdrwal->method->name)}}
                                    @else
                                        @lang('E-pin')
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
