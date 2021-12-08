@extends($activeTemplate.'layouts.frontend')
@section('content')
@include($activeTemplate.'partials.breadcrumb')
<div class="blog-section padding-bottom padding-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <article>
                        <div class="post-item post-classic post-details">
                            <div class="post-thumb c-thumb">
                                <img src="{{ getImage('assets/images/frontend/blog/'. @$blog->data_values->blog_image, '350x260')}}" alt="@lang('blog')">
                            </div>
                            <div class="post-content">
                                <div class="blog-header">
                                    <h4 class="title">
                                       {{__(@$blog->data_values->title)}}
                                    </h4>
                                </div>
                                <div class="meta-post">
                                    <div class="date">
                                        <a href="javascript:void(0)">
                                            <i class="flaticon-calendar"></i>
                                           {{showDateTime($blog->created_at)}}
                                        </a>
                                    </div>
                                </div>
                                <div class="entry-content">
                                    @php echo $blog->data_values->description_nic @endphp
                                    <div class="tag-options">
                                        <div class="share">
                                            <span><i class="fas fa-share-alt"></i></span>
                                            <a href="http://www.facebook.com/sharer.php?u=http://www.example.com" target="__blank"><i class="fab fa-facebook-f"></i></a>
                                            <a href="http://twitter.com/share?url=http://www.example.com&text=Simple Share Buttons&hashtags=simplesharebuttons" target="__blank"><i class="fab fa-twitter"></i></a>
                                            <a href="http://www.linkedin.com/shareArticle?mini=true&url=http://www.example.com" target="__blank"><i class="fab fa-linkedin-in"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="fb-comments" data-href="{{ route('blog.details',[$blog->id,slug($blog->data_values->title)]) }}" data-numposts="5"></div>
                            </div>
                        </div>
                    </article>
                </div>
                <div class="col-lg-4">
                    <aside class="b-sidebar">
                      
                        <div class="widget widget-post">
                            <h6 class="title">@lang('recent post')</h6>
                            <ul>
                            	@foreach($recentBlogs as $recentBlog)
	                                <li>
	                                    <div class="c-thumb">
	                                        <a href="{{ route('blog.details', [$recentBlog->id, slug($recentBlog->data_values->title)]) }}">
	                                            <img src="{{ getImage('assets/images/frontend/blog/'. @$recentBlog->data_values->blog_image, '350x260')}}" alt="@lang('blog')">
	                                        </a>
	                                    </div>
	                                    <div class="content">
	                                        <h6 class="sub-title">
	                                            <a href="{{ route('blog.details', [$recentBlog->id, slug($recentBlog->data_values->title)]) }}"> {{__(str_limit($recentBlog->data_values->title, 50))}}</a>
	                                        </h6>
	                                        <div class="meta">
	                                            @lang('Post by') - @lang('Admin')
	                                        </div>
	                                    </div>
	                                </li>
	                             @endforeach
                            </ul>
                        </div>
                        
                    </aside>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('fbComment')
	@php echo loadFbComment() @endphp
@endpush