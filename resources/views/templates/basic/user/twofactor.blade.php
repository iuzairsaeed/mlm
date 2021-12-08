@extends($activeTemplate.'layouts.master')
@section('content')
@include($activeTemplate.'partials.breadcrumb')
    <div class="two-section padding-top padding-bottom">
        <div class="container">
            <div class="row mb-30-none">
                <div class="col-lg-6">
                    <div class="card custom--card primary-bg h-100">
                        <div class="card-header">
                            <h5 class="card-title">@lang('Two Factor Authenticator')</h5>
                        </div>
                        @if(Auth::user()->ts)
                            <div class="card-body border-radius-0">
                                <div class="text-center mt-5">
                                    <button type="button" class="btn btn--danger" data-toggle="modal" data-target="#disableModal">
                                        @lang('Disable Two Factor Authenticator')
                                    </button>
                                </div>
                            </div>
                        @else
                            <div class="card-body border-radius-0">
                                <div class="two-factor-content">
                                    <div class="referral-input mt-30 mb-0 ref-small">
                                        <input type="text" value="{{$secret}}" readonly="" id="referralURL">
                                        <div class="btn btn-info copytext"><i class="fa fa-files-o"></i>@lang('Copy')</div>
                                    </div>
                                    <div class="two-factor-scan text-center my-4">
                                        <img class="mw-100" src="{{$qrCodeUrl}}" alt="@lang('images')">
                                    </div>
                                    <div class="text-center">
                                        <button type="button" class="btn btn--primary" data-toggle="modal" data-target="#enableModal">
                                            @lang('Enable Two Factor Authenticator')
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card custom--card primary-bg h-100">
                        <div class="card-header">
                            <h5 class="card-title">@lang('Google Authenticator')</h5>
                        </div>
                        <div class="card-body border-radius-0">
                            <div class="two-factor-content">
                                <h6 class="subtitle--bordered">@lang('USE GOOGLE AUTHENTICATOR TO SCAN THE QR CODE OR USE THE CODE')</h6>
                                <p class="two__fact__text">
                                    @lang('Google Authenticator is a multifactor app for mobile devices. It generates timed codes used during the 2-step verification process. To use Google Authenticator, install the Google Authenticator application on your mobile device.')
                                </p>
                                <a href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en" target="__blank" class="custom-button theme btn-sm">@lang('DOWNLOAD APP')</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade custom--modal" id="enableModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">@lang('Verify Your Otp')</h5>
              <button type="button" class="close text-white " data-dismiss="modal" aria-label="Close">
                <i class="fas fa-times"></i>
              </button>
            </div>
            <form action="{{route('user.twofactor.enable')}}" method="POST">
                @csrf
                <div class="modal-body">
                   <input type="hidden" name="key" value="{{$secret}}">
                   <div class="contact-form-group">
                        <input type="text" name="code" placeholder="@lang('Enter Google Authenticator Code')" required="">
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn--danger" data-dismiss="modal">@lang('Close')</button>
                  <button type="submit" class="btn btn--success">@lang('Verify')</button>
                </div>
            </form>
          </div>
        </div>
    </div>


    <div class="modal fade custom--modal" id="disableModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">@lang('Verify Your Otp')</h5>
              <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                <i class="fas fa-times"></i>
              </button>
            </div>
            <form action="{{route('user.twofactor.disable')}}" method="POST">
                @csrf
                <div class="modal-body">
                   <div class="contact-form-group">
                        <input type="text" name="code" placeholder="@lang('Enter Google Authenticator Code')" required="">
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn--danger" data-dismiss="modal">@lang('Close')</button>
                  <button type="submit" class="btn btn--success">@lang('Verify')</button>
                </div>
            </form>
          </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        (function($){
            "use strict";
            $('.copytext').on('click',function(){
                var copyText = document.getElementById("referralURL");
                copyText.select();
                copyText.setSelectionRange(0, 99999);
                document.execCommand("copy");
                iziToast.success({message: "Copied: " + copyText.value, position: "topRight"});
            });
        })(jQuery);
    </script>
@endpush


