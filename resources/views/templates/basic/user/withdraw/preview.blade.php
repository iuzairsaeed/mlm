@extends($activeTemplate.'layouts.master')
@section('content')
@include($activeTemplate.'partials.breadcrumb')
<div class="dashboard-section padding-top padding-bottom">
    <div class="container">
        <div class="row justify-content-center mb-30-none">
            <div class="col-lg-12">
                <div class="card custom--card primary-bg h-100">
                    <div class="card-header">
                        <h5 class="card-title">@lang('Current Balance') :
                            <strong>{{ getAmount(auth()->user()->balance)}} {{$general->cur_text}}</strong>
                        </h5>
                    </div>
                    <div class="card-body mt-4">
                        <div class="row">
                            <div class="col-md-4">
                                <ul class="preview-lists mb-30">
                                    <li>
                                        <span class="title">@lang('Request Amount')</span>
                                        <span class="details text-info">{{getAmount($withdraw->amount)  }} {{__($general->cur_text)}}</span>
                                    </li>

                                    <li>
                                        <span class="title">@lang('Withdrawal Charge')</span>
                                        <span class="details text-info">{{getAmount($withdraw->charge) }} {{__($general->cur_text)}}</span>
                                    </li>

                                     <li>
                                        <span class="title">@lang('After Charge')</span>
                                        <span class="details text-info">{{getAmount($withdraw->after_charge) }} {{__($general->cur_text)}}</span>
                                    </li>

                                    <li>
                                        <span class="title">@lang('Conversion Rate')</span>
                                        <span class="details">1 {{__($general->cur_text)}} = {{getAmount($withdraw->rate)  }} {{__($withdraw->currency)}}</span>
                                    </li>

                                     <li>
                                        <span class="title">@lang('You Will Get')</span>
                                        <span class="details text-success">{{getAmount($withdraw->final_amount) }} {{__($withdraw->currency)}}</span>
                                    </li>

                                    <li>
                                        <span class="title">@lang('Balance Will be')</span>
                                        <span class="details text-primary">{{getAmount($withdraw->user->balance - ($withdraw->amount))}} {{ __($general->cur_text) }}</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-8">
                                <form action="{{route('user.withdraw.submit')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    @if($withdraw->method->user_data)
                                    @foreach($withdraw->method->user_data as $k => $v)
                                        @if($v->type == "text")
                                            <div class="contact-form-group">
                                                <label><strong>{{__($v->field_level)}} @if($v->validation == 'required') <span class="text-danger">*</span>  @endif</strong></label>
                                                <input type="text" name="{{$k}}" class="form-control" value="{{old($k)}}" placeholder="{{__($v->field_level)}}" @if($v->validation == "required") required @endif>
                                                @if ($errors->has($k))
                                                    <span class="text-danger">{{ __($errors->first($k)) }}</span>
                                                @endif
                                            </div>
                                        @elseif($v->type == "textarea")
                                            <div class="contact-form-group">
                                                <label><strong>{{__($v->field_level)}} @if($v->validation == 'required') <span class="text-danger">*</span>  @endif</strong></label>
                                                <textarea name="{{$k}}"  class="form-control"  placeholder="{{__($v->field_level)}}" rows="3" @if($v->validation == "required") required @endif>{{old($k)}}</textarea>
                                                @if ($errors->has($k))
                                                    <span class="text-danger">{{ __($errors->first($k)) }}</span>
                                                @endif
                                            </div>
                                        @elseif($v->type == "file")
                                            <label><strong>{{__($v->field_level)}} @if($v->validation == 'required') <span class="text-danger">*</span>  @endif</strong></label>
                                             <div class="contact-form-group">
                                                <div class="fileinput fileinput-new " data-provides="fileinput">
                                                    <div class="fileinput-new thumbnail withdraw-thumbnail"
                                                         data-trigger="fileinput">
                                                        <img class="w-100" src="{{ getImage('/')}}" alt="@lang('Image')">
                                                    </div>
                                                    <div class="fileinput-preview fileinput-exists thumbnail wh-200-150"></div>
                                                    <div class="img-input-div">
                                                        <span class="btn btn-info btn-file">
                                                            <span class="fileinput-new "> @lang('Select') {{__($v->field_level)}}</span>
                                                            <span class="fileinput-exists"> @lang('Change')</span>
                                                            <input type="file" name="{{$k}}" accept="image/*" @if($v->validation == "required") required @endif>
                                                        </span>
                                                        <a href="#" class="btn btn-danger fileinput-exists"
                                                        data-dismiss="fileinput"> @lang('Remove')</a>
                                                    </div>
                                                </div>
                                                @if ($errors->has($k))
                                                    <br>
                                                    <span class="text-danger">{{ __($errors->first($k)) }}</span>
                                                @endif
                                            </div>
                                        @endif
                                    @endforeach
                                    @endif
                                      <div class="contact-form-group">
                                            <label>@lang('Google Authenticator Code')</label>
                                            <input type="text" name="authenticator_code" class="form-control" required>
                                        </div>
                                    <button type="submit" class="btn btn--success btn-block btn-lg mt-4 text-center">@lang('Confirm')</
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script-lib')
    <script src="{{asset($activeTemplateTrue.'/frontend/js/bootstrap-fileinput.js')}}"></script>
@endpush
@push('style-lib')
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'/frontend/css/bootstrap-fileinput.css')}}">
@endpush

