@extends($activeTemplate.'layouts.master')
@section('content')
@include($activeTemplate.'partials.breadcrumb')
  
@php
    $emptyMessage = "No Withdrawl History";
@endphp
<div class="transaction-section padding-top padding-bottom">
     <div class="container">
        <div class="input-group has_append"> 
            <a class="btn btn--primary" href="{{route('user.create_webinar')}}">Create Webinar</a>
        </div><br>
            <div class="primary-bg item-rounded p-3">
                <table class="deposite-table">
                    <thead class="custom--table">
                    <tr>
                        <th>@lang('Title')</th>
                        <th>@lang('Thumbnail')</th>
                        <th>@lang('Description')</th>
                        <th>@lang('Created At')</th>
                        <th>@lang('Status')</th>
                        <th>@lang('Action')</th>
                         
                    </tr>
                    </thead>
                    <tbody>

                    @forelse($all_webinar as $all_webinars)
                        <tr>
                            <td data-label="#@lang('Title')">{{$all_webinars->webinar_title}}</td>
                            <td data-label="@lang('Thumbnail')">
                                <img src="{{asset('webinar/'.$all_webinars->webinar_thumbnail.' ')}}" alt="" style="width: 50px">
                            </td>
                            <td data-label="@lang('Description')">
                                <strong>{{substr($all_webinars->webinar_descripion, 500)}}...</strong>
                            </td>
                             
                            <td data-label="@lang('Created At')">
                                {{diffForHumans($all_webinars->created_at)}}
                            </td>
                            <td data-label="@lang('Status')"> 
                                @if($all_webinars->status == 0)
                                    <div class="badge badge-danger">Deactivated</div>
                                    @else
                                    <div class="badge badge-primary">Active</div>
                                @endif
                            </td>
                            <td data-label="@lang('Action')" class="text-success">
                                <a href="/user/detail/{{$all_webinars->id }}" class="icon-btn" data-toggle="tooltip" title="" data-original-title="@lang('Details')">
                                    <i class="las la-desktop text--shadow"></i>
                                </a>
                            </td>
                             
                         </tr>
                    @empty
                        <tr>
                            <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                {{$all_webinar->links()}}
                
         
            </div>
           
        </div>
    </div>


 


@endsection