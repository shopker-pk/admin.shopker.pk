@include('admin.layouts.header')
    <div class="content-body">
        <section id="basic-form-layouts">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-content collpase show">
                            <div class="card-body">
                                <form class="form form-horizontal form-bordered" action="{{ route('update_child_categories', $query->id) }}" method="post" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="form-body">
                                        <h4 class="form-section">Edit Child Category</h4>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label class="label-control">Category Name</label>
                                                    <input type="text" id="name" name="name" class="form-control" placeholder="Category Name" value="{{ old('name', $query->name) }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label class="label-control">Parent Category</label>
                                                    <select id="parent_category" name="parent_category" class="form-control select_2">
                                                        @if(!empty($parent_categories))
                                                            @foreach($parent_categories as $row)
                                                                <option value="{{ $row->id }}" @if(old('parent_categories') == $row->id) selected @endif @if($query_categories == $row->id) selected @endif>{{ $row->name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="label-control">Category Featured Image</label><br>
                                                    <input type="file" id="single_image" name="image" data-id="1">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row last">
                                                    <label class="label-control">Image Preview</label>
                                                    <div class="col-md-12">
                                                        <img src="{{ asset('public/assets/admin/images/ecommerce/categories/'.$query->featured_image) }}" class="single_image_preview_1" alt="Category Featured Image" style="width:150px; height:150px"/>
                                                    </div>
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
                                            <div class="col-md-6">
                                                <div class="form-group row last">
                                                    <label class="label-control">Category Status</label>
                                                    <div class="input-group">
                                                        <label class="d-inline-block custom-control custom-radio ml-1">
                                                            <input type="radio" id="status" name="status" class="custom-control-input" value="0" @if(old('status') == '0') checked @endif @if($query->status == '0') checked @endif>
                                                            <span class="custom-control-indicator"></span>
                                                            <span class="custom-control-description ml-0">Active</span>
                                                        </label>
                                                        <label class="d-inline-block custom-control custom-radio">
                                                            <input type="radio" id="status" name="status" class="custom-control-input" value="1" @if(old('status') == '1') checked @endif @if($query->status == '1') checked @endif>
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