@extends($activeTemplate.'layouts.master')
@section('content')
@include($activeTemplate.'partials.breadcrumb')
    <div class="dashboard-section padding-top padding-bottom">
        <div class="container">
            <div class="row justify-content-center mb-30-none">
            <div class="col-md-10">
                <div class="card custom--card primary-bg h-100">
                    <div class="card-header">
                        <h5 class="card-title">@lang('Stripe Payment')</h5>
                    </div>
                    <div class="card-body border-radius-0">
                        <div class="card-wrapper"></div>
                        <form role="form" id="payment-form" method="{{$data->method}}" action="{{$data->url}}">
                            @csrf
                            <input type="hidden" value="{{$data->track}}" name="track">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="contact-form-group">
                                        <label for="name">@lang('Name on Card')</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control form-control-lg" name="name" placeholder="@lang('Name on Card')" autocomplete="off" autofocus/>
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="fa fa-font"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="contact-form-group">
                                        <label for="cardNumber">@lang('Card Number')</label>
                                        <div class="input-group">
                                            <input type="tel" class="form-control form-control-lg" name="cardNumber" placeholder="@lang('Valid Card Number')" autocomplete="off" required autofocus/>
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="fa fa-credit-card"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <div class="contact-form-group">
                                        <label for="cardExpiry">@lang('Expiration Date')</label>
                                        <input type="tel" class="form-control form-control-lg" name="cardExpiry" placeholder="@lang('MM / YYYY')" autocomplete="off" required/>
                                    </div>
                                </div>

                                <div class="col-md-6 ">
                                    <div class="contact-form-group">
                                        <label for="cardCVC">@lang('CVC Code')</label>
                                        <input type="tel" class="form-control form-control-lg" name="cardCVC" placeholder="@lang('CVC')" autocomplete="off" required/>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 pt-3">
                                <div class="contact-form-group">
                                    <button type="submit">@lang('PAY NOW')</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


@push('script')
    <script src="{{ asset('assets/global/js/card.js') }}"></script>

    <script>
        (function ($) {
            "use strict";
            var card = new Card({
                form: '#payment-form',
                container: '.card-wrapper',
                formSelectors: {
                    numberInput: 'input[name="cardNumber"]',
                    expiryInput: 'input[name="cardExpiry"]',
                    cvcInput: 'input[name="cardCVC"]',
                    nameInput: 'input[name="name"]'
                }
            });
        })(jQuery);
    </script>
@endpush
