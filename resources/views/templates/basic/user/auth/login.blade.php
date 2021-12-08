@extends($activeTemplate.'layouts.auth')
@section('content')

<section class="account-section">
    <div class="left" style="background-image: url('{{ getImage('assets/images/frontend/auth/'.getContent('auth.content',true)->data_values->image) }}');">
        <div class="left-inner text-center">
            <h6 class="text--base">@lang('Welcome back')</h6>
            <h3 class="title text-white mt-2">@lang('Sign In to your account')</h3>
        </div>
    </div>

    <div class="right">
        <div class="top w-100 text-center">
            <a href="{{route('home')}}" class="account-logo"><img src="{{getImage(imagePath()['logoIcon']['path'] .'/logo.png')}}" alt="@lang('logo')"></a>
        </div>
        <div class="middle w-100">
            <form method="POST" action="{{ route('user.login')}}" onsubmit="return submitUserForm();" class="contact-form row mb--25 align-items-center">
                @csrf
                    <div class="col-md-12">
                        <div class="contact-form-group">
                            <label for="username">@lang('Username')</label>
                            <input type="text" placeholder="@lang('Enter Username')" value="{{old('username')}}" id="username" required name="username">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="contact-form-group">
                            <label for="password">@lang('Your Password')</label>
                            <input type="password" placeholder="@lang('Enter Password')" id="password" required name="password">
                        </div>
                    </div>

                    <div class="col-md-12 mb-3">
                        @php echo loadReCaptcha() @endphp
                    </div>

                    @include($activeTemplate.'partials.custom_captcha')
                
                    <div class="col-md-12">
                        <div class="contact-form-group">
                            <button type="submit" class="w-100">@lang('Sign In')</button>
                        </div>
                    </div>
                    <div class="col-xl-8">
                        <div class="contact-form-group">
                            <p class="text-white m-0">@lang("You Don'\t have an account?") <a href="{{route('user.register')}}"
                                    class="text-theme">@lang('Sign Up')</a></p>
                        </div>
                    </div>

                    <div class="col-xl-4 text-xl-right">
                        <div class="contact-form-group">
                        <a href="{{route('user.password.request')}}" class="text-theme">@lang('Forgot Password')</a>
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

@push('script')
    <script>
        "use strict";
        function submitUserForm() {
            var response = grecaptcha.getResponse();
            if (response.length == 0) {
                document.getElementById('g-recaptcha-error').innerHTML = '<span class="text-danger">@lang("Captcha field is required.")</span>';
                return false;
            }
            return true;
        }
    </script>
@endpush
