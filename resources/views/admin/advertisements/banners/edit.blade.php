@include('admin.layouts.header')
    <div class="content-body">
        <section id="basic-form-layouts">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-content collpase show">
                            <div class="card-body">
                                <form class="form form-horizontal form-bordered" action="{{ route('update_banner_advertisements', $query->id) }}" method="post" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="form-body">
                                        <h4 class="form-section">Edit Banners</h4>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="label-control">Banner Images</label><label class="label-control" style="color:red">*</label>
                                                    <div class="col-md-12">
                                                        <label id="image" class="file center-block">
                                                            <input type="file" id="single_image" name="url" data-id="1">
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row last">
                                                    <label class="label-control">Image Preview</label><label class="label-control" style="color:red">*</label>
                                                    <div class="col-md-12">
                                                        <img src="{{ asset('public/assets/admin/images/advertisements/banners/'.$query->image) }}" alt="Product Images" class="single_image_preview_1" style="width:184px; height:100px"/> 
                                                        <br/>
                                                        <input type="text" id="banner_url" name="banner_url" class="form-control" placeholder="Item Link" value="{{ $query->url }}" style="width:184px;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="label-control">Pages</label><label class="label-control" style="color:red">*</label>
                                                    <select id="page" name="page" class="form-control select_2" style="width: 100%">
                                                        <option value="0" @if(old('page', $query->page_id) == 0) selected @endif>Home</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="label-control">Type</label><label class="label-control" style="color:red">*</label>
                                                    <select id="type" name="type" class="form-control select_2" style="width: 100%">
                                                        <option value="0" @if(old('type', $query->type) == 0) selected @endif>Header</option>
                                                        <option value="1" @if(old('type', $query->type) == 1) selected @endif>Middle Banner 1</option>
                                                        <option value="2" @if(old('type', $query->type) == 2) selected @endif>Middle Banner 2</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="label-control">Banner Start Date</label><label class="label-control" style="color:red">*</label>
                                                    <input type="date" id="start_date" name="start_date" class="form-control" value="{{ $query->start_date }}"/>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row last">
                                                    <label class="label-control">Banner End Date</label><label class="label-control" style="color:red">*</label>
                                                    <input type="date" id="end_date" name="end_date" class="form-control" value="{{ $query->end_date }}"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="label-control">Banner Status</label><label class="label-control" style="color:red">*</label>
                                                    <div class="input-group col-md-12">
                                                        <label class="d-inline-block custom-control custom-radio ml-1">
                                                            <input type="radio" id="status" name="status" class="custom-control-input" value="0" @if(old('status') == 0) checked @endif @if($query->status == 0) checked @endif>
                                                            <span class="custom-control-indicator"></span>
                                                            <span class="custom-control-description ml-0">Active</span>
                                                        </label>
                                                        <label class="d-inline-block custom-control custom-radio">
                                                            <input type="radio" id="status" name="status" class="custom-control-input" value="1" @if(old('status') == 1) checked @endif @if($query->status == 1) checked @endif>
                                                            <span class="custom-control-indicator"></span>
                                                            <span class="custom-control-description ml-0">Inactive</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6"></div>
                                        </div>
                                    </div>
                                    <div class="form-actions">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-check-square-o"></i> Update
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@include('admin.layouts.footer')