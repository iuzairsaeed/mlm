@extends('admin.layouts.app')
@section('panel')

<div class="row">
    <div class="col-lg-12">
                <div class="col-xl-9 col-lg-7 col-md-7 mb-30">
                    <div class="card mt-50">
                        <div class="card-body">
                            <h5 class="card-title border-bottom pb-2">Information of Hiram Douglas</h5>

                            <form action="/admin/frontend/store-webinar" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group ">
                                            <label class="form-control-label font-weight-bold">Webinar Title<span
                                                    class="text-danger">*</span></label>
                                            <input class="form-control" required type="text" name="webinar_title" value="">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label  font-weight-bold">Webinar Description<span class="text-danger">*</span>
                                            </label>
                                            <textarea class="form-control" required name="webinar_descripion">

                                            </textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group ">
                                            <label class="form-control-label font-weight-bold">Webinar Link <span
                                                    class="text-danger">*</span></label>
                                            <input class="form-control" type="text" name="webinar_link" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label  font-weight-bold">Webinar Thumbnail
                                                 <span class="text-danger">*</span></label>
                                            <input class="form-control" type="file" required name="webinar_thumbnail">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-xl-4 col-md-6  col-sm-3 col-12">
                                        <label class="form-control-label font-weight-bold">Status </label>
                                        <div class="toggle btn btn--success" data-toggle="toggle"
                                            style="width: 100%; height: 35.8667px;"><input type="checkbox"
                                                data-onstyle="-success" name="status" data-offstyle="-danger" data-toggle="toggle"
                                                data-on="Active" data-off="Deactive" data-width="100%" name="status"
                                                checked="">
                                            <div class="toggle-group"><label
                                                    class="btn btn--success toggle-on">Active</label><label
                                                    class="btn btn--danger active toggle-off">DeActive</label><span
                                                    class="toggle-handle btn btn-default"></span></div>
                                        </div>
                                    </div>  
                                   
                                </div>


                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn--primary btn-block btn-lg">Save Changes
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
 
        </div><!-- bodywrapper__inner end -->
    </div>
@endsection
