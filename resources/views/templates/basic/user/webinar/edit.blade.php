@extends($activeTemplate.'layouts.master')
@section('content')
@include($activeTemplate.'partials.breadcrumb')

<section class="profile-section padding-top padding-bottom">
    <div class="container">
        <div class="item-rounded primary-bg profile-wrapper align-items-start">
            <div class="profile-form-area">
                <form class="profile-edit-form row mb--25" action="/user/webinar_update/{{$webianr_details->id}}"
                     method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="contact-form-group col-md-6">
                    <label for="webinar_title">Webinar Title</label>
                        <input type="text" value="{{$webianr_details->webinar_title}}" name="webinar_title" required="">
                    </div>
                    <div class="contact-form-group col-md-6">
                        <label for="last-name">Webinar Link</label>
                        <input type="text"value="{{$webianr_details->webinar_link}}"  name="webinar_link" required="">
                    </div>
                 
                    <div class="contact-form-group col-md-12">
                        <label for="address">Webinar Description</label>
                        <textarea type="text" name="webinar_descripion"required="">
                            {{$webianr_details->webinar_descripion}}
                        </textarea>
                    </div>
  
                    <div class="contact-form-group col-md-12">
                        <label for="file">Webinar Thumbnail</label>
                        <input type="file" id="file" name="webinar_thumbnail">
                    </div>

                    <div class="contact-form-group col-md-12">
                        <label for="file">Webinar Thumbnail Preview</label><br>
                        <img src="{{asset('webinar/'.$webianr_details->webinar_thumbnail.' ')}}" alt="" style="width: 200px">
                    </div>
                    <div class="contact-form-group col-md-12">
                   
                    <select name="status" id="" class="form-control">
                        <option value="1">Active</option>
                        <option value="0">Deactivated</option>
                    </select>
                    </div>
                    <div class="contact-form-group w-100 col-md-6">
                        <button type="submit">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection