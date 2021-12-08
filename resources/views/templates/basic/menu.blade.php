@extends($activeTemplate.'layouts.frontend')
@section('content')
@include($activeTemplate . 'partials.breadcrumb')
<section class="faq-section padding-bottom padding-top-half">
    <div class="container">
        <div class="row flex-wrap-reverse justify-content-center mb--50">
            <div class="col-lg-12 mb-20">
                @php echo $data->data_values->description @endphp
            </div>
        </div>
    </div>
</section>
@endsection