@extends($activeTemplate.'layouts.master')
@section('content')
@include($activeTemplate.'partials.breadcrumb')
  

<div class="dashboard-section padding-top padding-bottom">
    <div class="container">
        @if($all_webinar->count() > 0)
        <div class="row">
            @foreach($all_webinar as $all_webinars)
                @php
                    $author_detals = App\Models\User::where('id',$all_webinars->user_id)->first();   
                @endphp
                <div class="container col-sm-4">
                    <div class="card-header">
                        <div class="row">
                            <div class="contianer col-sm-10">{{$all_webinars->webinar_title}}</div>
                            <div class="container col-sm-2">
                                <div class="badge badge-danger">Live</div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <img class="card-img-top img-thumbnail"style="width: 371px;" src="{{asset('webinar/'.$all_webinars->webinar_thumbnail.' ')}}" alt="Card image cap">
                        <div class="card-body">
                          <h5 class="card-title">{{$all_webinars->webinar_title}}</h5>
                          <p class="card-text">
                              {{$all_webinars->webinar_descripion}}
                          </p><hr>
                          <div class="row">
                            <div class="container author col-sm-7">
                                <img src="{{asset('assets/images/user/profile/'.$author_detals->image.'')}}" style="width: 43px;border-radius: 100px;" alt="" class="img-round">
                                 {{$author_detals->firstname}} {{$author_detals->lastname}}
                              </div>
                              <div class="container author col-sm-5">
                                 {{ diffForHumans($all_webinars->created_at) }}
                              </div>
                          </div>
                          <br>
                          <div class="card-footer">
                            <div class="row">
                                <div class="container col-sm-10">
                                    <a href="{{$all_webinars->webinar_link}}" class="btn btn-primary">Join Webinar</a>
                                </div>
                                <div class="container col-sm-2">
                                    <div class="badge badge-danger">Live</div>
                                </div>
                            </div>
                          </div>
                        </div>
                      </div>
                </div>
            @endforeach

            {{$all_webinar->links()}}
        </div>

        @else
            <h3>No Webinar For Now.</h3>
        @endif
    </div>
</div>

@endsection