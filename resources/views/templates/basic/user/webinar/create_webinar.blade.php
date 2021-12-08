@extends($activeTemplate.'layouts.master')
@section('content')
@include($activeTemplate.'partials.breadcrumb')
  

<section class="profile-section padding-top padding-bottom">
    <div class="container">
        <div class="item-rounded primary-bg profile-wrapper align-items-start">
            <div class="profile-form-area">
                <form class="profile-edit-form row mb--25" action="{{route('user.webinar_store')}}" method="post" enctype="multipart/form-data">
                   @csrf
                   <div class="contact-form-group col-md-6">
                    <label for="first-name">Webinar Title</label>
                        <input type="text" name="webinar_title" required="">
                    </div>
                    <div class="contact-form-group col-md-6">
                        <label for="last-name">Webinar Link</label>
                        <input type="text" name="webinar_link" required="">
                    </div>
                 
                    <div class="contact-form-group col-md-12">
                        <label for="address">Webinar Description</label>
                        <textarea type="text" name="webinar_descripion"required=""></textarea>
                    </div>
  
                    <div class="contact-form-group col-md-12">
                        <label for="file">Webinar Thumbnail</label>
                        <input type="file" id="file" name="webinar_thumbnail">
                    </div>

                    <div class="contact-form-group w-100 col-md-6">
                        <button type="submit">Publish Webinar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection