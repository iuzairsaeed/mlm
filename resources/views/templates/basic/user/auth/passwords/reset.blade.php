@extends($activeTemplate.'layouts.auth')
@section('content')

<section class="account-section">
    <div class="left" style="background-image: url('{{ getImage('assets/images/frontend/auth/'.getContent('auth.content',true)->data_values->image) }}');">
        <div class="left-inner text-center">
            <h3 class="title text-white mt-2">@lang('Reset Password')</h3>
        </div>
    </div>

    <div class="right">
        <div class="top w-100 text-center">
            <a href="{{route('home')}}" class="account-logo"><img src="{{getImage(imagePath()['logoIcon']['path'] .'/logo.png')}}" alt="@lang('logo')"></a>
        </div>
        <div class="middle w-100">
            <form method="POST" action="{{ route('user.password.update') }}" class="contact-form row mb--25 align-items-center">
            @csrf
                <input type="hidden" name="email" value="{{ $email }}">
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="col-md-12">
                    <div class="contact-form-group">
                        <label for="password">@lang('Your Password')</label>
                        <div class="hover-input-popup">
                        <input type="password" placeholder="@lang('Enter Password')" id="password" required name="password">
                            @if($general->secure_password)
                                <div class="input-popup">
                                  <p class="error lower">@lang('1 small letter minimum')</p>
                                  <p class="error capital">@lang('1 capital letter minimum')</p>
                                  <p class="error number">@lang('1 number minimum')</p>
                                  <p class="error special">@lang('1 special character minimum')</p>
                                  <p class="error minimum">@lang('6 character password')</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>


                <div class="col-md-12">
                    <div class="contact-form-group">
                        <label for="password">@lang('Confirm Password')</label>
                        <input type="password" placeholder="@lang('Confirm Password')" id="password" required name="password_confirmation">
                    </div>
                </div>

                <div class="col-md-12 pt-3">
                    <div class="contact-form-group">
                        <button type="submit">@lang('Reset Password')</button>
                    </div>
                </div>

                <div class="col-md-12 text-right">
                    <div class="contact-form-group">
                      <a href="{{ route('user.login') }}" class="text-theme">@lang('Sign In Here')</a>
                    </div>
                </div>
            </form>
        </div>
        <div class="bottom w-100 text-center">
            <p class="text-white">&copy; @lang('All Right Reserved By') <a href="{{route('home')}}" class="text--base">{{__($general->sitename)}}</a></p>
        </div>
    </div>
</section>
@endsection
@push('style')
<style>
    .hover-input-popup {
        position: relative;
    }
    .hover-input-popup:hover .input-popup {
        opacity: 1;
        visibility: visible;
    }
    .input-popup {
        position: absolute;
        bottom: 130%;
        left: 50%;
        width: 280px;
        background-color: #1a1a1a;
        color: #fff;
        padding: 20px;
        border-radius: 5px;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        -ms-border-radius: 5px;
        -o-border-radius: 5px;
        -webkit-transform: translateX(-50%);
        -ms-transform: translateX(-50%);
        transform: translateX(-50%);
        opacity: 0;
        visibility: hidden;
        -webkit-transition: all 0.3s;
        -o-transition: all 0.3s;
        transition: all 0.3s;
    }
    .input-popup::after {
        position: absolute;
        content: '';
        bottom: -19px;
        left: 50%;
        margin-left: -5px;
        border-width: 10px 10px 10px 10px;
        border-style: solid;
        border-color: transparent transparent #1a1a1a transparent;
        -webkit-transform: rotate(180deg);
        -ms-transform: rotate(180deg);
        transform: rotate(180deg);
    }
    .input-popup p {
        padding-left: 20px;
        position: relative;
    }
    .input-popup p::before {
        position: absolute;
        content: '';
        font-family: 'Line Awesome Free';
        font-weight: 900;
        left: 0;
        top: 4px;
        line-height: 1;
        font-size: 18px;
    }
    .input-popup p.error {
        text-decoration: line-through;
    }
    .input-popup p.error::before {
        content: "\f057";
        color: #ea5455;
    }
    .input-popup p.success::before {
        content: "\f058";
        color: #28c76f;
    }
</style>
@endpush
@push('script-lib')
<script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
@endpush
@push('script')
<script>
    (function ($) {
        "use strict";
        @if($general->secure_password)
            $('input[name=password]').on('input',function(){
                secure_password($(this));
            });
        @endif
    })(jQuery);
</script>
@endpush