@extends($activeTemplate.'layouts.frontend')
@section('content')
@php
    $content = getContent('banner.content', true);
@endphp
<style>
	.banner-thumb .sub-thumb:nth-child(1) {
    left: 177px;
    bottom: 72px;
}
</style>
	<section class="banner-section oh bg_img primary-overlay" data-background="{{ getImage('assets/images/frontend/banner/'. @$content->data_values->background_image, '1200x798')}}">
	    <div class="banner-thumb d-none d-lg-block">
			<img src="https://uploads-ssl.webflow.com/615d67c97853134828739d2b/61730814d27188e9267c9129_Captain.png" loading="lazy" data-w-id="c206fa85-d60b-7c5d-a409-df1465f45cdb" class="sub-thumb" sizes="(max-width: 479px) 100vw, (max-width: 991px) 200px, 378px" srcset="https://uploads-ssl.webflow.com/615d67c97853134828739d2b/61730814d27188e9267c9129_Captain-p-500.png 500w, https://uploads-ssl.webflow.com/615d67c97853134828739d2b/61730814d27188e9267c9129_Captain.png 638w" alt="Captain flying" class="captain cta" style="transform: translate3d(0px, -7px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d;">

	    </div>

	    <div class="container">
	        <div class="banner-content">
	            <h1 class="title">{{__(@$content->data_values->first_heading)}}<span class="d-block text-theme">{{__(@$content->data_values->second_heading)}}</span></h1>
	            <h3 class="subtitle">{{__(@$content->data_values->sub_heading)}}</h3>
	            <p>{{__(@$content->data_values->description)}}</p>
	            <div class="button-area">
	                <a href="{{url(@$content->data_values->first_button_url)}}" class="custom-button cl-light">{{__(@$content->data_values->first_button_name)}}</a>
	                <a href="{{url(@$content->data_values->second_button_url)}}" class="custom-button theme hover-cl-light">{{__(@$content->data_values->second_button_name)}}</a>
	            </div>
	        </div>
	    </div>
	</section>

	
    @if($sections->secs != null)
        @foreach(json_decode($sections->secs) as $sec)
            @include($activeTemplate.'sections.'.$sec)
        @endforeach
    @endif

	<section class="blog-section padding-top padding-bottom">
		<div class="container">
			<div class="section-header">
				<h3 class="title">Webinar By Admin</h3>
				<p>Hic tenetur nihil ex. Doloremque ipsa velit, ea molestias expedita sed voluptatem ex voluptatibus temporibus sequi. sddd</p>
			</div>
			<div class="row justify-content-center mb-30-none">
				@php
					$all_webinar = App\Models\Webinar::where('status',1)->where('created_by','admin')->get();
				@endphp
				@foreach($all_webinar as $all_webinars)
				 <div class="col-md-6 col-xl-4 col-sm-10">
						<div class="post-item">
							<div class="post-thumb c-thumb">
							   <img src="{{asset('webinar/'.$all_webinars->webinar_thumbnail.' ')}}" alt="blog">
							 </div>
							<div class="post-content">
								<div class="blog-header">
									<h6 class="title">
										<a href="{{$all_webinars->webinar_link}}">
											{{$all_webinars->webinar_title}}
										</a>
									</h6>
								</div>
								<div class="meta-post">
									<div class="date">
										<div>
											<i class="flaticon-calendar"></i>
											{{diffForHumans($all_webinars->created_at)}}
										</div>
									</div>
								</div>
								<div class="entry-content">
									<p>{{$all_webinars->webinar_descripion}}</p>
								</div>
							</div>
						</div>
					</div>
				 @endforeach
			 </div>
		</div>
	</section>

@endsection
