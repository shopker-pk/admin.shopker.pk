@include('admin.layouts.header')
    <section id="basic-form-layouts">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content collpase show">
                        <div class="card-body">
                            <form class="form form-horizontal form-bordered" action="{{ route('insert_products') }}" method="post" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="form-body">
                                    <h4 class="form-section">Add Products</h4>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label class="label-control">Product Name</label><label class="label-control" style="color:red">*</label>
                                                <input type="text" id="name" name="name" class="form-control" placeholder="Product Name" value="{{ old('name') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group row">
                                                <label class="label-control">Product Category</label><label class="label-control" style="color:red">*</label>
                                                <select id="parent_category" name="parent_category" class="form-control select_2" style="width: 100%">
                                                    @if(!empty($parent_categories))
                                                        <option>No cateogry selected</option>
                                                        @foreach($parent_categories as $row)
                                                            <option value="{{ $row->id }}" @if(old('parent_category') == $row->id) selected @endif>{{ $row->name }}</option>
                                                        @endforeach
                                                    @else
                                                        <option>No parent cateogry found</option>
                                                    @endif 
                                                </select>  
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group row">
                                                <label class="label-control">Product Category</label><label class="label-control" style="color:red">*</label>
                                                <select id="child_category" name="child_category" class="form-control select_2" style="width: 100%">
                                                </select>  
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group row">
                                                <label class="label-control">Product Category</label><label class="label-control" style="color:red">*</label>
                                                <select id="sub_child_category" name="sub_child_category" class="form-control select_2" style="width: 100%">
                                                </select>  
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label class="label-control">Product Brand</label><label class="label-control" style="color:red">*</label>
                                                <select id="brand" name="brand" class="form-control select_2" style="width: 100%">
                                                    @if(!empty($brands))
                                                        <option>No Brand selected</option>
                                                        @foreach($brands as $row)
                                                            <option value="{{ $row->id }}" @if(old('brand') == $row->id) selected @endif>{{ $row->name }}</option>
                                                        @endforeach
                                                    @else
                                                        <option>No Brands Found</option>
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row"> 
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="label-control">Product High Light</label><label class="label-control" style="color:red">*</label>
                                                <textarea id="high_light" name="high_light" class="form-control ckeditor" rows="5" placeholder="Product HightLight">{{ old('high_light') }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row"> 
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="label-control">Product Details</label><label class="label-control" style="color:red">*</label>
                                                <textarea id="details" name="details" class="form-control ckeditor" rows="5" placeholder="Product Details">{{ old('details') }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row"> 
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="label-control">Product Warranty Type</label><label class="label-control" style="color:red">*</label>
                                                <select id="warranty_type" name="warranty_type" class="form-control select_2" style="width:100%">
                                                    <option>No warranty type selected</option>
                                                    <option value="0" @if(old('warranty_type') == 0) selected @endif>Brand warranty</option>
                                                    <option value="1" @if(old('warranty_type') == 1) selected @endif>International manufacture warranty</option>
                                                    <option value="2" @if(old('warranty_type') == 2) selected @endif>International seller warranty</option>
                                                    <option value="3" @if(old('warranty_type') == 3) selected @endif>International warranty</option>
                                                    <option value="4" @if(old('warranty_type') == 4) selected @endif>Local warranty</option>
                                                    <option value="5" @if(old('warranty_type') == 5) selected @endif>Seller Shop warranty</option>
                                                    <option value="6" @if(old('warranty_type') == 6) selected @endif>Shopker warranty</option>
                                                    <option value="7" @if(old('warranty_type') == 7) selected @endif>No warranty</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row"> 
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="label-control">What's in the Box</label><label class="label-control" style="color:red">*</label>
                                                <input id="what_in_the_box" name="what_in_the_box" class="form-control" placeholder="What's in the box??" value="{{ old('what_in_the_box') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row"> 
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="label-control">Package Weight (KG)</label><label class="label-control" style="color:red">*</label>
                                                <input id="weight" name="weight" class="form-control" placeholder="Weight" value="{{ old('weight') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="label-control">Package Dimensions (cm)</label>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <input id="length" name="length" class="form-control" placeholder="Length" value="{{ old('length') }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <input id="width" name="width" class="form-control" placeholder="Width" value="{{ old('width') }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <input id="height" name="height" class="form-control" placeholder="Height" value="{{ old('height') }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <br>
                                                <div class="form-group row">
                                                    <a href="javascript::void(0);" id="add_variations"><i class="ft-plus"></i> Add Product Variations</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="variations"></div>
                                    </div>
                                    <div class="row"> 
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="label-control">Product Meta Keywords</label>
                                                <textarea id="meta_keywords" name="meta_keywords" class="form-control" rows="5" placeholder="Product Meta Keywords">{{ old('meta_keywords') }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row"> 
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="label-control">Product Meta Description</label>
                                                <textarea id="meta_description" name="meta_description" class="form-control" rows="5" placeholder="Product Meta Description">{{ old('meta_description') }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-actions">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-check-square-o"></i> Add
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@include('admin.layouts.footer')