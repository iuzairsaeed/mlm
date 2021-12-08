@extends($activeTemplate.'layouts.master')
@section('content')
@include($activeTemplate.'partials.breadcrumb')
    <section class="profile-section padding-top padding-bottom">
        <div class="container">
            <div class="item-rounded primary-bg profile-wrapper align-items-start">
                <div class="profile-user mb-lg-0">
                    <div class="thumb">
                        <img src="{{getImage('assets/images/user/profile/'.auth()->user()->image, '400x400')}}" alt="@lang('user')">
                    </div>
                    <div class="content">
                        <h6 class="title">@lang('Email Address') : {{__($user->email)}}</h6>
                        <div class="subtitle">@lang('Username') : {{__($user->username)}}</div>
                        <div class="subtitle">@lang('Phone Number') : {{__($user->mobile)}}</div>
                        <div class="subtitle">@lang('Country') : {{__(@$user->address->country)}}</div>
                    </div>
                </div>
                <div class="profile-form-area">
                    <form class="profile-edit-form row mb--25" action="" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="contact-form-group col-md-6">
                            <label for="first-name">@lang('First Name')</label>
                            <input type="text" id="first-name" name="firstname" value="{{__($user->firstname)}}" required="">
                        </div>
                        <div class="contact-form-group col-md-6">
                            <label for="last-name">@lang('Last Name')</label>
                            <input type="text" id="last-name" name="lastname" value="{{__($user->lastname)}}" required="">
                        </div>
                     
                        <div class="contact-form-group col-md-6">
                            <label for="address">@lang('Address')</label>
                            <input type="text" id="address" name="address" placeholder="@lang('Enter Address')" value="{{__(@$user->address->address)}}" required="">
                        </div>

                        <div class="contact-form-group col-md-6">
                            <label for="city">@lang('City')</label>
                            <input type="text" id="city" name="city" placeholder="@lang('Enter City')" value="{{__(@$user->address->city)}}" required="">
                        </div>

                        <div class="contact-form-group col-md-6">
                            <label for="state">@lang('State')</label>
                            <input type="text" id="state" name="state" placeholder="@lang('Enter State')" value="{{__(@$user->address->state)}}" required="">
                        </div>

                        <div class="contact-form-group col-md-6">
                            <label for="zip">@lang('Zip')</label>
                            <input type="text" id="zip" name="zip" placeholder="@lang('Enter Zip')" value="{{__(@$user->address->zip)}}" required="">
                        </div>

                        <div class="contact-form-group col-md-12">
                            <label for="file">@lang('Change Profile Picture')</label>
                            <input type="file" id="file" name="image">
                        </div>

                        <div class="contact-form-group w-100 col-md-6">
                            <button type="submit">@lang('Update Profile')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
