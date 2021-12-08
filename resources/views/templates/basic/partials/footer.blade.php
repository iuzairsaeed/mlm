@php
    $content = getContent('footer.content', true);
    $footer_menu = getContent('policy_pages.element', false);
    $socialIcons = getContent('social_icon.element', false);
    $cookie = App\Models\Frontend::where('data_keys','cookie.data')->first();
@endphp

@if(@$cookie->data_values->status && !session('cookie_accepted'))
    <div class="cookie__wrapper bg-dark py-5">
        <div class="container">
          <div class="d-flex flex-wrap align-items-center justify-content-between">
            <p class="txt my-2">
               @php echo @$cookie->data_values->description @endphp
              <a href="{{ @$cookie->data_values->link }}" class="text-theme" target="_blank">@lang('Read Policy')</a>
            </p>
              <a href="javascript:void(0)" class="theme-button  my-2 border-0 text--white policy">@lang('Accept')</a>
          </div>
        </div>
    </div>
 @endif

<footer class="padding-top primary-overlay bg_img" data-background="{{ getImage('assets/images/frontend/footer/'. @$content->data_values->background_image, '1000x421')}}">
    <div class="footer-top padding-bottom">
        <div class="container">
            <div class="footer-wrapper cl-white">
                <div class="footer-logo">
                    <a href="{{route('home')}}">
                        <img src="{{getImage(imagePath()['logoIcon']['path'] .'/logo.png')}}" alt="@lang('images')">
                    </a>
                </div>
                <p>{{__(@$content->data_values->heading)}}</p>
                <ul class="social__icons">
                    @foreach($socialIcons as $element)
                        <li>
                            <a href="{{@$element->data_values->url}}" target="__blank" class="facebook">@php echo $element->data_values->social_icon @endphp</a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <ul class="footer-menu">
                @foreach($footer_menu as $value)
                    <li>
                        <a href="{{route('footer.menu', [slug($value->data_values->menu), $value->id])}}">{{__($value->data_values->menu)}}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <p>&copy; @lang('All Right Reserved By') <a href="{{route('home')}}">{{__($general->sitename)}}</a></p>
        </div>
    </div>
</footer>


@push('script')
    <script>
        'use strict';
        $('.policy').on('click',function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.get('{{route('cookie.accept')}}', function(response){
                $('.cookie__wrapper').addClass('d-none');
                iziToast.success({message: response, position: "topRight"});
            });
        });
    </script>

    <!-- Start of Async ProveSource Code --><script>!function(o,i){window.provesrc&&window.console&&console.error&&console.error("ProveSource is included twice in this page."),provesrc=window.provesrc={dq:[],display:function(){this.dq.push(arguments)}},o._provesrcAsyncInit=function(){provesrc.init({apiKey:"eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJhY2NvdW50SWQiOiI2MWE4Zjk4M2IyMGUzMzU3MjhlYjNmNTAiLCJpYXQiOjE2Mzg0NjM4NzV9.yVAs358DZSsy7OjER9KsHX62h2MpDvP8BxGOiYnXl2E",v:"0.0.4"})};var r=i.createElement("script");r.type="text/javascript",r.async=!0,r["ch"+"ar"+"set"]="UTF-8",r.src="https://cdn.provesrc.com/provesrc.js";var e=i.getElementsByTagName("script")[0];e.parentNode.insertBefore(r,e)}(window,document);</script><!-- End of Async ProveSource Code -->
@endpush