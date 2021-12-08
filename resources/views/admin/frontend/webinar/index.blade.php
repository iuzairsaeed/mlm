@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                            <tr> 
                                <th>@lang('Title')</th>
                                <th>@lang('Thumbnail')</th>
                                <th>@lang('Link')</th>
                                <th>@lang('Joined At')</th>
                                <th>Status</th>
                                <th>@lang('Description')</th>
                                <th>@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($all_wbinars as $all_wbinar)
                            <tr> 
                                <td data-label="@lang('User')">
                                    <span class="font-weight-bold">{{$all_wbinar->webinar_title}}</span>
                                </td>


                                <td data-label="@lang('Thumbnail')">
                                   <img src="{{asset('/webinar/'.$all_wbinar->webinar_thumbnail.' ')}}" alt=""style="width:50px;">
                                </td>
                                <td data-label="@lang('Link')">
                                    <span class="font-weight-bold" data-toggle="tooltip" data-original-title="{{ $all_wbinar->webinar_link }}">{{ $all_wbinar->webinar_link }}</span>
                                </td> 
                                <td data-label="@lang('Created At')">
                                    {{ showDateTime($all_wbinar->created_at) }} <br> {{ diffForHumans($all_wbinar->created_at) }}
                                </td>

                                <td>
                                    @if($all_wbinar->status == 1)
                                        <div class="badge badge-primary">Active</div>
                                    @else 
                                    <div class="badge badge-danger">Deactivated</div>
                                    @endif
                                </td>

                                <td data-label="@lang('Balance')">
                                    <span class="font-weight-bold">
                                        
                                    {{ $all_wbinar->webinar_descripion }}
                                    </span>
                                </td>



                                <td data-label="@lang('Action')">
                                    <a href="/admin/frontend/edit/{{$all_wbinar->id}}" class="icon-btn" data-toggle="tooltip" title="" data-original-title="@lang('Details')">
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
                        </table><!-- table end -->
                    </div>
                </div>
                <div class="card-footer py-4">
                    {{ paginateLinks($all_wbinars) }}
                </div>
            </div>
        </div>
    </div>


    @push('breadcrumb-plugins')
        <div class="input-group has_append input-group has_append d-flex justify-content-center">
            <a href="/admin/frontend/create-webinar" class="btn btn-primary">Create Webinar</a>
        </div>
     @endpush
@endsection


 