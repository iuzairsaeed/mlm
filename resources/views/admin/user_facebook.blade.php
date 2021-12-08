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
                            <th>@lang('User Name')</th>
                            <th>@lang('Email-Phone')</th>
                            <th>@lang('Facebook Link')</th> 
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($user_list as $user_lists)
                        <tr> 
                            <td data-label="@lang('User Name')">
                                <span class="font-weight-bold">{{$user_lists->fullname}}</span>
                                <br>
                                <span class="small">
                                <a href="{{ route('admin.users.detail', $user_lists->id) }}"><span>@</span>{{ $user_lists->username }}</a>
                                </span>
                            </td>


                            <td data-label="@lang('Email-Phone')">
                               <a href="#!">{{$user_lists->email}}</a>
                            </td>

                            <td data-label="@lang('Facebook Link')">
                                <a href="{{$user_lists->facebook_link}}">{{$user_lists->facebook_link}}</a>
                             </td>
                    
                        </tr>
                       
                        @endforeach

                        </tbody>
                    </table><!-- table end -->
                </div>
            </div>
             
        </div>
    </div>


</div>
@push('breadcrumb-plugins')
    <form action="{{ route('admin.users.search', $scope ?? str_replace('admin.users.', '', request()->route()->getName())) }}" method="GET" class="form-inline float-sm-right bg--white">
        <div class="input-group has_append">
            <input type="text" name="search" class="form-control" placeholder="@lang('Username or email')" value="{{ $search ?? '' }}">
            <div class="input-group-append">
                <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </form>
@endpush
@endsection