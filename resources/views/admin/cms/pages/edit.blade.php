@include('admin.layouts.header')
    <div class="content-body">
        <section id="basic-form-layouts">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-content collpase show">
                            <div class="card-body">
                                <form class="form form-horizontal form-bordered" action="{{ route('update_pages', $query->id) }}" method="post">
                                    {{ csrf_field() }}
                                    <div class="form-body">
                                        <h4 class="form-section">Edit Pages</h4>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label class="label-control">Page Title</label>
                                                    <input type="text" id="title" name="title" class="form-control" placeholder="Page Title" value="{{ old('title', $query->title) }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="label-control">Page Content</label>
                                                    <textarea id="content" name="content" rows="5" class="form-control ckeditor" placeholder="Page Content">{{ old('content', $query->content) }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="label-control">Meta Keywords</label>
                                                    <textarea id="meta_keywords" name="meta_keywords" rows="5" class="form-control" placeholder="Meta Keywords">{{ old('meta_keywords', $query->meta_keywords) }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row last">
                                                    <label class="label-control">Meta Description</label>
                                                    <textarea id="meta_description" name="meta_description" rows="5" class="form-control" placeholder="Meta Description">{{ old('meta_description', $query->meta_description) }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row last">
                                                    <label class="label-control">Page Status</label>
                                                    <div class="input-group">
                                                        <label class="d-inline-block custom-control custom-radio ml-1">
                                                            <input type="radio" id="status" name="status" class="custom-control-input select_2" value="0" @if(old('status') == '0') checked @endif @if($query->status == '0') checked @endif>
                                                            <span class="custom-control-indicator"></span>
                                                            <span class="custom-control-description ml-0">Active</span>
                                                        </label>
                                                        <label class="d-inline-block custom-control custom-radio">
                                                            <input type="radio" id="status" name="status" class="custom-control-input select_2" value="1" @if(old('status') == '1') checked @endif @if($query->status == '1') checked @endif>
                                                            <span class="custom-control-indicator"></span>
                                                            <span class="custom-control-description ml-0">Inactive</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
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