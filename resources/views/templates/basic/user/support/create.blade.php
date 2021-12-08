@extends($activeTemplate.'layouts.master')
@section('content')
@include($activeTemplate.'partials.breadcrumb')
    <!-- <Message> Section -->
    <div class="message__chatbox-section padding-top padding-bottom">
        <div class="container">
            <div class="message__chatbox ">
                <div class="message__chatbox__header">
                    <h5 class="title text-white">{{__($pageTitle)}}</h5>
                    <a href="{{route('ticket') }}" class="custom-button theme btn-sm">@lang('Support Ticket')</a>
                </div>
                <div class="message__chatbox__body">
                    <form  action="{{route('ticket.store')}}" method="post" enctype="multipart/form-data" onsubmit="return submitUserForm();" class="message__chatbox__form row g-4">
                    @csrf
                        <div class="contact-form-group col-sm-6">
                            <label for="fname" class="form--label">@lang('Name')</label>
                            <input type="text" name="name" id="fname" value="{{@$user->firstname . ' '.@$user->lastname}}">
                        </div>
                        <div class="contact-form-group col-sm-6">
                            <label for="email" class="form--label">@lang('Email Address')</label>
                            <input type="text" name="email" id="email" value="{{@$user->email}}">
                        </div>
                        <div class="contact-form-group col-sm-6">
                            <label for="subject" class="form--label">@lang('Subject')</label>
                            <input type="text" id="subject" placeholder="@lang('Enter Subject')" name="subject" value="{{old('subject')}}" required="">
                        </div>

                         
                         <div class="contact-form-group col-sm-6">
                            <label for="priority">@lang('Priority')</label>
                            <div class="select-item">
                                <select name="priority" id="priority" class="select-bar">
                                    <option value="3">@lang('High')</option>
                                    <option value="2">@lang('Medium')</option>
                                    <option value="1">@lang('Low')</option>
                                </select>
                            </div>
                        </div>

                        <div class="contact-form-group col-sm-12">
                            <label for="message" class="form--label">@lang('Message')</label>
                            <textarea id="message" placeholder="@lang('Enter Message')" name="message" required="">{{old('message')}}</textarea>
                        </div>

                        <div class="contact-form-group col-sm-12">
                            <div class="d-flex">
                                <div class="left-group col p-0">
                                    <label for="file2" class="form--label">@lang('Attachments')</label>
                                    <input type="file" class="form-control form--control mb-2" name="attachments[]" id="file2">
                                </div>
                                <div class="add-area">
                                    <label class="form--label d-block">&nbsp;</label>
                                    <button class="cmn--btn btn--sm bg--primary ml-2 ml-md-4 cmn--form--control addFile" type="button"><i class="fas fa-plus"></i></button>
                                </div>
                            </div>
                            <div id="fileUploadsContainer"></div>
                            <span class="info text-white fs--14">@lang('Allowed File Extensions'): .@lang('jpg'), .@lang('jpeg'), .@lang('png'), .@lang('pdf'), .@lang('doc'), .@lang('docx')</span>
                        </div>
                        <div class="contact-form-group col-sm-12 mb-0">
                            <button type="submit" class="cmn--btn">@lang('Send Message')</button>
                        </div>
                    </form> 
                </div>
            </div>
        </div>
    </div>
@endsection


@push('script')
    <script>
        (function ($) {
            $('.addFile').on('click',function(){
                $("#fileUploadsContainer").append(
                    `<div class="d-flex removeFile">
                            <div class="left-group col p-0">
                                <input type="file" class="form-control form--control mb-2" name="attachments[]" id="file2" required>
                            </div>
                            <div class="add-area">
                                <button class="btn--sm bg--danger ml-md-4 cmn--form--control remove-btn" type="button"><i class="fas fa-times-circle"></i></button>
                        </div>`
                )
            });
            $(document).on('click','.remove-btn',function(){
                $(this).closest('.removeFile').remove();
            });
        })(jQuery);
    </script>
@endpush
