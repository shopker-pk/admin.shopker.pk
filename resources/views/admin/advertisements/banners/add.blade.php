@include('admin.layouts.header')
    <div class="content-body">
        <section id="basic-form-layouts">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-content collpase show">
                            <div class="card-body">
                                <form class="form form-horizontal form-bordered" action="{{ route('insert_banner_advertisements') }}" method="post" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="form-body">
                                        <h4 class="form-section">Add Banners</h4>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="label-control">Banner Images</label><label class="label-control" style="color:red">*</label>
                                                    <div class="col-md-12">
                                                        <label id="image" class="file center-block">
                                                            <input id="multi_image" type="file" multiple>
                                                            <span class="file-custom"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row last">
                                                    <label class="label-control">Images Previews</label>
                                                    <div class="col-md-12 preview_images"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="label-control">Pages</label><label class="label-control" style="color:red">*</label>
                                                    <select id="page" name="page" class="form-control select_2" style="width: 100%">
                                                        <option>No Page Selected</option>
                                                        <option value="0">Page 1</option>
                                                        <option value="1">Page 2</option>
                                                        <option value="2">Page 3</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="label-control">Type</label><label class="label-control" style="color:red">*</label>
                                                    <select id="type" name="type" class="form-control select_2" style="width: 100%">
                                                        <option>No Type Selected</option>
                                                        <option value="0">Header</option>
                                                        <option value="1">Bottom Top</option>
                                                        <option value="2">Bottom Center</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="label-control">Banner Start Date</label><label class="label-control" style="color:red">*</label>
                                                    <input type="text" id="start_date" name="start_date" class="form-control datepicker" style="width: 100%;height: 40px;"/>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row last">
                                                    <label class="label-control">Banner End Date</label><label class="label-control" style="color:red">*</label>
                                                    <input type="text" id="end_date" name="end_date" class="form-control datepicker" style="width: 100%;height: 40px;"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="label-control">Banner Status</label><label class="label-control" style="color:red">*</label>
                                                    <div class="input-group">
                                                        <label class="d-inline-block custom-control custom-radio ml-1">
                                                            <input type="radio" id="status" name="status" class="custom-control-input" value="0" @if(old('status') == 0) checked @endif>
                                                            <span class="custom-control-indicator"></span>
                                                            <span class="custom-control-description ml-0">Active</span>
                                                        </label>
                                                        <label class="d-inline-block custom-control custom-radio">
                                                            <input type="radio" id="status" name="status" class="custom-control-input" value="1" @if(old('status') == 1) checked @endif>
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
                                            <i class="fa fa-check-square-o"></i> Add
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