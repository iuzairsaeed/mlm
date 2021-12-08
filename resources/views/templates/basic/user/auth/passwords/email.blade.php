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
            <form action="{{ route('user.password.email') }}" method="POST" class="contact-form row mb--25 align-items-center">
                @csrf
                <div class="col-md-12">
                     <div class="contact-form-group">
                        <label for="type">{{__('Select One')}}</label>
                        <div class="select-item">
                            <select name="type" id="type" class="select-bar">
                                <option value="email">@lang('E-Mail Address')</option>
                                <option value="username">@lang('Username')</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="contact-form-group">
                        <label class="my_value"></label>
                        <input type="text" class="@error('value') is-invalid @enderror" value="{{old('username')}}" name="value" value="{{ old('value') }}" required autofocus="off">
                    </div>
                </div>

                <div class="col-md-12 pt-3">
                    <div class="contact-form-group">
                        <button type="submit">@lang('Send Password Code')</button>
                    </div>
                </div>
                <div class="col-xl-8">
                        <div class="contact-form-group">
                            <p class="text-white m-0">@lang("Back to?") <a href="{{route('user.login')}}"
                                    class="text-theme">@lang('login')</a></p>
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

    (function($){
        "use strict";
        
        myVal();
        $('select[name=type]').on('change',function(){
            myVal();
        });
        function myVal(){
            $('.my_value').text($('select[name=type] :selected').text());
        }
    })(jQuery)
</script>
@endpush