@extends($activeTemplate.'layouts.master')
@section('content')
@include($activeTemplate.'partials.breadcrumb')
<div class="message__chatbox-section padding-top-half padding-bottom">
    <div class="container">
        <div class="message__chatbox ">
            <div class="message__chatbox__header">
                <h5 class="title text-white">
                    @if($my_ticket->status == 0)
                        <span class="badge badge--success">@lang('Open')</span>
                    @elseif($my_ticket->status == 1)
                        <span class="badge badge--primary">@lang('Answered')</span>
                    @elseif($my_ticket->status == 2)
                        <span class="badge badge--warning">@lang('Replied')</span>
                    @elseif($my_ticket->status == 3)
                        <span class="badge badge--danger">@lang('Closed')</span>
                    @endif
                    @lang('Ticket ID'):<span class="cl-theme">[#{{ $my_ticket->ticket }}] {{ $my_ticket->subject }}</span></h5>
                  <a href="javascript:void(0)" data-toggle="modal" data-target="#DelModal" class="btn btn--sm d-block btn--danger text-center">@lang('Close Ticket')</a>
            </div>
            <div class="message__chatbox__body">
            @if($my_ticket->status != 4)
                <form method="post" action="{{ route('ticket.reply', $my_ticket->id) }}" class="message__chatbox__form row" enctype="multipart/form-data">
                    @csrf
                     <div class="contact-form-group col-sm-12">
                        <label for="message">@lang('Your Message')</label>
                        <textarea id="message" name="message" placeholder="@lang('Enter Message')" required=""></textarea>
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
                    <div class="contact-form-group col-sm-12">
                        <button type="submit" name="replayTicket" value="1">@lang('Send Message')</button>
                    </div>
                </form>
            @endif
            </div>
        </div>
    </div>
</div>


<!-- <Message> Section -->
<div class="message__chatbox-section padding-bottom">
    <div class="container">
        <div class="message__chatbox">
            <div class="message__chatbox__body">
                <ul class="reply-message-area">
                @foreach($messages as $message)
                        <li>
                    @if($message->admin_id == 0)
                            <div class="reply-item">
                                <div class="name-area">
                                    <h6 class="title">{{__($message->ticket->name)}}</h6>
                                </div>
                                <div class="content-area">
                                    <span class="meta-date">
                                        @lang('Posted on') <span class="cl-theme">{{ $message->created_at->format('l, dS F Y @ H:i') }}</span>
                                    </span>
                                    <p>
                                        {{__($message->message)}}
                                    </p>
                                     @if($message->attachments()->count() > 0)
                                        <div class="mt-2">
                                            @foreach($message->attachments as $k=> $image)
                                                <a href="{{route('ticket.download',encrypt($image->id))}}" class="mr-3"><i class="fa fa-file"></i>  @lang('Attachment') {{++$k}} </a>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @else
                            <ul>
                                <li>
                                    <div class="reply-item">
                                        <div class="name-area">
                                            <div class="reply-thumb">
                                                <img src="{{getImage('assets/admin/images/profile/'. $message->admin->image, '400x400')}}" alt="@lang('Admin Image')">
                                            </div>
                                            <h6 class="title">{{__($message->admin->name)}}</h6>
                                        </div>
                                        <div class="content-area">
                                            <span class="meta-date">
                                                @lang('Posted on'), <span class="cl-theme">{{ $message->created_at->format('l, dS F Y @ H:i') }}</span>
                                            </span>
                                            <p>
                                                {{__($message->message)}}
                                            </p>
                                            @if($message->attachments()->count() > 0)
                                                <div class="mt-2">
                                                    @foreach($message->attachments as $k=> $image)
                                                        <a href="{{route('ticket.download',encrypt($image->id))}}" class="mr-3"><i class="fa fa-file"></i>  @lang('Attachment') {{++$k}} </a>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        @endif
                @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>


<div class="modal fade custom--modal" id="DelModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="{{ route('ticket.reply', $my_ticket->id) }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title"> @lang('Confirmation')!</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <strong class="text-white">@lang('Are you sure you want to close this support ticket')?</strong>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--danger btn--sm" data-dismiss="modal">
                        @lang('Close')
                    </button>
                    <button type="submit" class="btn btn--success btn--sm" name="replayTicket" value="2">@lang("Confirm")
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('script')
    <script>
        (function ($) {
            "use strict";
            $('.delete-message').on('click', function (e) {
                $('.message_id').val($(this).data('id'));
            });
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
