@extends($activeTemplate.'layouts.master')
@section('content')
@include($activeTemplate.'partials.breadcrumb')
    <div class="dashboard-section padding-top padding-bottom">
        <div class="container">
            <div class="row justify-content-center mb-30-none">
            	<div class="col-lg-12">
            		<div class="contact-wrapper">
			            <form action="{{route('user.balance.transfer.anotheruser')}}" method="POST" class="contact-form row mb--25 align-items-center">
			            	@csrf
			                <div class="col-md-12">
			                    <div class="contact-form-group">
			                        <label>@lang('Username')</label>
			                        <input type="text" placeholder="@lang('Enter Username')" value="{{old('username')}}" required name="username">
			                    </div>
			                </div>

			                <div class="col-md-12">
			                    <div class="contact-form-group">
			                        <label for="amount">@lang('Amount') <span class="text-success">(@lang('Charge:') {{showAmount($general->balance_transfer_fixed_charge)}} {{$general->cur_text}} @lang('+') {{$general->balance_transfer_percent_charge}} %)</span> </label>
			                        <input type="text" placeholder="@lang('Enter Amount')" onkeyup="subtracted()" id="amount" value="{{old('amount')}}" required name="amount">
			                    </div>
			                </div>

							<div class="col-md-12">
			                    <div class="contact-form-group">
					                <label for="amount">@lang('Amount Will Cut From Your Account')</label>
					                <div class="input-group mb-3">
										<input type="text" class="calculation form-control" aria-label="Recipient's username" aria-describedby="basic-addon2" readonly>
										<div class="input-group-prepend">
									        <div class="input-group-text">{{$general->cur_text}}</div>
									    </div>
									</div>
								</div>
							</div>

			                <div class="col-md-12">
			                    <div class="contact-form-group">
			                        <button type="submit" class="mt-3">@lang('Transfer Balance')</button>
			                    </div>
			                </div>
			            </form>
			        </div>
			    </div>
			</div>
		</div>
	</div>
@endsection

@push('script')
	<script>
		"use strict";
		function subtracted(){
			const userBalance = {{auth()->user()->balance}};
	        var amount = $('input[name="amount"]').val();
	        var charge = ((amount / 100) * {{$general->balance_transfer_percent_charge}}) + {{$general->balance_transfer_fixed_charge}};
	        var calculation = parseFloat(amount) + parseFloat(charge);
	        if (userBalance < amount) {
                notify('warning', 'Your Account Balance {{ getAmount(auth()->user()->balance) }} {{$general->cur_text}} Not Enough! For Balance Transfer');
            } else if (isNaN(amount) || amount <= 0) {
                notify('warning', 'Please Enter Valid Amount')
            }else
            {
	        	$('.calculation').val(calculation);
            }
    	};
	</script>
@endpush
