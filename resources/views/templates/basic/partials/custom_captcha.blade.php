@php
	$captcha = loadCustomCaptcha();
@endphp
@if($captcha)
    <div class="col-md-12">
    	<div class="contact-form-group">
        	@php echo $captcha @endphp
        </div>
    </div>

    <div class="col-md-12">
    	<div class="contact-form-group">
        	<input type="text" name="captcha" placeholder="@lang('Enter Code')" required="">
        </div>
    </div>
@endif
