@include('admin.layouts.header')
    <section id="basic-form-layouts">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content collpase show">
                        <div class="card-body">
                            <form class="form form-horizontal form-bordered" action="{{ route('insert_copy_product') }}" method="post" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="form-body">
                                    <h4 class="form-section">Copy Product</h4>
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="details" role="tabpanel" aria-labelledby="details-tab">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group row">
                                                        <label class="label-control">Product Name</label><label class="label-control" style="color:red">*</label>
                                                        <input type="text" id="name" name="name" class="form-control" placeholder="Product Name" value="{{ old('name', $query_product->name) }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group row">
                                                        <label class="label-control">Product Category</label><label class="label-control" style="color:red">*</label>
                                                        @if(!empty($parent_categories))
                                                            <select id="parent_category" name="parent_category" class="form-control select_2" style="width: 100%">
                                                                <option>No cateogry selected</option>
                                                                @foreach($parent_categories as $row)
                                                                    <option value="{{ $row->id }}" @if($query_categories->p_id == $row->id) selected @endif>{{ $row->name }}</option>
                                                                @endforeach
                                                            </select> 
                                                        @else
                                                            <select id="parent_category" name="parent_category" class="form-control select_2" style="width: 100%">
                                                                <option>No paent cateogry found</option>
                                                            </select> 
                                                        @endif  
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group row">
                                                        <label class="label-control">Product Category</label><label class="label-control" style="color:red">*</label>
                                                        @if(!empty($child_categories))
                                                            <select id="child_category" name="child_category" class="form-control select_2" style="width: 100%">
                                                                <option>No cateogry selected</option>
                                                                @foreach($child_categories as $row)
                                                                    <option value="{{ $row->id }}" @if(old('child_category') == $row->id) selected @endif @if($query_categories->c_id == $row->id) selected @endif>{{ $row->name }}</option>
                                                                @endforeach
                                                            </select> 
                                                        @else
                                                            <select id="child_category" name="child_category" class="form-control select_2" style="width: 100%">
                                                                <option>No child cateogry found</option>
                                                            </select> 
                                                        @endif  
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group row">
                                                        <label class="label-control">Product Category</label><label class="label-control" style="color:red">*</label>
                                                        @if(!empty($sub_child_categories))
                                                            <select id="sub_child_category" name="sub_child_category" class="form-control select_2" style="width: 100%">
                                                                <option>No cateogry selected</option>
                                                                @foreach($sub_child_categories as $row)
                                                                    <option value="{{ $row->id }}" @if(old('sub_child_category') == $row->id) selected @endif @if($query_categories->s_c_id == $row->id) selected @endif>{{ $row->name }}</option>
                                                                @endforeach
                                                            </select> 
                                                        @else
                                                            <select id="sub_child_category" name="sub_child_category" class="form-control select_2" style="width: 100%">
                                                                <option>No sub child cateogry found</option>
                                                            </select> 
                                                        @endif  
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group row">
                                                        <label class="label-control">Product Brand</label><label class="label-control" style="color:red">*</label>
                                                        @if(!empty($brands))
                                                            <select id="brand" name="brand" class="form-control select_2" style="width: 100%">
                                                                <option>No Brand selected</option>
                                                                @foreach($brands as $row)
                                                                    <option value="{{ $row->id }}" @if(old('brand') == $row->id) selected @endif @if($query_brand->id == $row->id) selected @endif>{{ $row->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        @else
                                                            <select id="brand" name="brand" class="form-control select_2" style="width: 100%">
                                                                <option>No Brands Found</option>
                                                            </select>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row"> 
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="label-control">Product High Light</label><label class="label-control" style="color:red">*</label>
                                                        <textarea id="high_light" name="high_light" class="form-control ckeditor" rows="5" placeholder="Product HightLight">{{ old('high_light', $query_product->high_light) }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row"> 
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="label-control">Product Details</label><label class="label-control" style="color:red">*</label>
                                                        <textarea id="details" name="details" class="form-control ckeditor" rows="5" placeholder="Product Details">{{ old('details', $query_product->description) }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row"> 
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="label-control">Product Warranty Type</label><label class="label-control" style="color:red">*</label>
                                                        <select id="warranty_type" name="warranty_type" class="form-control select_2" style="width:100%">
                                                            <option>No warranty type selected</option>
                                                            <option value="0" @if(old('warranty_type') == 0) selected @endif @if($query_product->warranty_type == 0) selected @endif>Brand warranty</option>
                                                            <option value="1" @if(old('warranty_type') == 1) selected @endif @if($query_product->warranty_type == 1) selected @endif>International manufacture warranty</option>
                                                            <option value="2" @if(old('warranty_type') == 2) selected @endif @if($query_product->warranty_type == 2) selected @endif>International seller warranty</option>
                                                            <option value="3" @if(old('warranty_type') == 3) selected @endif @if($query_product->warranty_type == 3) selected @endif>International warranty</option>
                                                            <option value="4" @if(old('warranty_type') == 4) selected @endif @if($query_product->warranty_type == 4) selected @endif>Local warranty</option>
                                                            <option value="5" @if(old('warranty_type') == 5) selected @endif @if($query_product->warranty_type == 5) selected @endif>Seller Shop warranty</option>
                                                            <option value="6" @if(old('warranty_type') == 6) selected @endif @if($query_product->warranty_type == 6) selected @endif>Shopker warranty</option>
                                                            <option value="7" @if(old('warranty_type') == 7) selected @endif @if($query_product->warranty_type == 7) selected @endif>No warranty</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row"> 
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="label-control">What's in the Box</label><label class="label-control" style="color:red">*</label>
                                                        <input id="what_in_the_box" name="what_in_the_box" class="form-control" placeholder="What's in the box??" value="{{ old('what_in_the_box', $query_product->what_in_the_box) }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row"> 
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="label-control">Package Weight (KG)</label><label class="label-control" style="color:red">*</label>
                                                        <input id="weight" name="weight" class="form-control" placeholder="Weight" value="{{ old('weight', $query_product->weight) }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="label-control">Package Dimensions (cm)</label>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <input id="length" name="length" class="form-control" placeholder="Length" value="{{ old('length', $query_product->length) }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <input id="width" name="width" class="form-control" placeholder="Width" value="{{ old('width', $query_product->width) }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <input id="height" name="height" class="form-control" placeholder="Height" value="{{ old('height', $query_product->height) }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group row">
                                                        <label class="label-control">Product Video Url</label>
                                                        <input type="text" id="video_url" name="video_url" class="form-control" placeholder="Product Video Url" value="{{ old('video_url', $query_product->video_url) }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <div id="variations">
                                                    <div class="row main">
                                                        <div class="col-md-4 main1">
                                                            <h6>Variation Information</h6>
                                                        </div>
                                                        <div class="col-md-5 main1"></div>
                                                        <div class="col-md-3 main1">
                                                            <h6>Avaliability : </h6>
                                                            <label class="switch">
                                                                <input type="checkbox" id="status" name="status" class="form-control" @if($query_product->status == 0) value="0" checked @endif>
                                                                <span class="slider"></span>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-12 contain">
                                                            <input type="hidden" name="variation" value="{{ $query_product->variation_id }}">
                                                            <select name="variation" id="variation[]" class="form-control select select_2 variation_{{ $query_product->variation_id }}" data-id="{{ $query_product->variation_id }}" style="width:100%" disabled>
                                                                <option>Select Variant</option>
                                                                @foreach($variations as $variant)
                                                                    <option value="{{ $variant->id }}" @if($query_product->variation_id == $variant->id) selected @endif @if(old('variation') == $variant->id) selected @endif>{{ $variant->value }}</option>
                                                                @endforeach
                                                            </select>
                                                            <p style="color: red;padding: 1%;margin-top: 2%;margin-bottom: 2%;padding-left: 0%;">
                                                            Drag and drop pictures below to upload.Multiple images can be uploaded at once.Maximum 5 pictures.First image will created as featured image.</p>
                                                        </div>
                                                        <div class="col-md-12" style="margin-left: 1%; border: 1px solid lightgray; padding: 15px;max-width: 98%;">
                                                            <div class="image-upload-wrap">
                                                                <input type="file" id="multi_image" name="product_images[]" multiple data-id="{{ $query_product->variation_id }}">
                                                            </div>
                                                            <div class="file-upload-content">
                                                                <div class="col-md-12" id="preview_images_{{ $query_product->variation_id }}">
                                                                    <ul id="sortable" class="sortable_dragable_image_ul preview_images_{{ $query_product->variation_id }}">
                                                                        @foreach($query_images as $image)
                                                                            <li class='ui-state-default sortable_dragable_image_li remove_image_{{ $image->id }}' style='float:left;'>
                                                                                <input type='hidden' id="images" name='images[{{ $query_product->variation_id }}][]' value="{{ $image->image }}">
                                                                                <input type='hidden' id="url" name='url[{{ $query_product->variation_id }}][]' value="{{ asset('public/assets/admin/images/ecommerce/products/'.$image->image) }}">
                                                                            <span class="pip" data-id="{{ $image->id }}">     
                                                                                <img src="{{ asset('public/assets/admin/images/ecommerce/products/'.$image->image) }}" alt="Product Images" style="width:135px; height:110px"/> 
                                                                                <span class="remove remove_product_image" id="{{ $image->id }}" data-id="remove_image_{{ $image->id }}">Remove</span>
                                                                            </span>
                                                                        </li>
                                                                        @endforeach
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 items1" style="margin-left:1%;max-width: 98%;">
                                                            <br><div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="row">
                                                                        <div class="col-md-5">
                                                                            <label>Product SKU</label><label class="label-control" style="color:red">*</label> 
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <input type="text" id="sku" name="sku" class="form-control" value="{{ old('sku', $query_product->sku_code) }}">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="row">
                                                                        <div class="col-md-5">
                                                                            <label>Quantity</label><label class="label-control" style="color:red">*</label> 
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <input type="text" id="quantity" name="quantity" class="form-control"

                                                                                value="{{ old('quantity', $query_product->quantity) }}" 
                                                                                >
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="row">
                                                                        <div class="col-md-5">
                                                                            <label>Price</label><label class="label-control" style="color:red">*</label> 
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <input type="text" id="price" name="price" class="form-control"
                                                                                value="{{ old('price', $query_product->regural_price) }}" 
                                                                                >
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="row">
                                                                        <div class="col-md-5">
                                                                            <label>Special Price</label>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <input type="text" id="sale_price" name="sale_price" class="form-control"
                                                                                value="{{ old('sale_price', $query_product->sale_price) }}" 
                                                                                >
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="row">
                                                                        <div class="col-md-5">
                                                                            <label>Promotion Start Date</label>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                @if(!empty($query_product->from_date))
                                                                                    <input type="text" id="from" name="from" class="form-control advertise_datepicker" value="{{ old('from', date('d-M-Y', strtotime($query_product->from_date))) }}" style="width: 100%;height: 38px;">
                                                                                @else
                                                                                    <input type="text" id="from" name="from" class="form-control advertise_datepicker" value="{{ old('from') }}" style="width: 100%;height: 38px;">
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="row">
                                                                        <div class="col-md-5">
                                                                            <label>Promotion End Date</label>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                @if(!empty($query_product->to_date))
                                                                                    <input type="text" id="to" name="to" class="form-control datepicker" value="{{ old('to', date('d-M-Y', strtotime($query_product->to_date))) }}" style="width: 100%;height: 38px;">
                                                                                @else
                                                                                    <input type="text" id="to" name="to" class="form-control datepicker" value="{{ old('to') }}" style="width: 100%;height: 38px;">
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>  
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row"> 
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="label-control">Product Meta Keywords</label>
                                                        <textarea id="meta_keywords" name="meta_keywords" class="form-control" rows="5" placeholder="Product Meta Keywords">{{ old('meta_keywords', $query_product->meta_keywords) }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row"> 
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="label-control">Product Meta Description</label>
                                                        <textarea id="meta_description" name="meta_description" class="form-control" rows="5" placeholder="Product Meta Description">{{ old('meta_description', $query_product->meta_description) }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                            <div class="form-actions">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fa fa-check-square-o"></i> Add
                                                </button>
                                            </div>
                                        </div>
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