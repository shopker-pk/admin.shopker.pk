@include('admin.layouts.header')
    <section id="basic-form-layouts">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content collpase show">
                        <div class="card-body">
                            <form class="form form-horizontal form-bordered" action="{{ route('update_store_setting') }}" method="post" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="form-body">
                                    <h4 class="form-section">Store Settings</h4>
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="store-tab" data-toggle="tab" href="#store" role="tab" aria-controls="store" aria-selected="true">Store Settings</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="shipping-tab" data-toggle="tab" href="#shipping" role="tab" aria-controls="shipping" aria-selected="false">Shipping Settings</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="shipping-charges-tab" data-toggle="tab" href="#shipping_charges" role="tab" aria-controls="shipping_charges" aria-selected="false">Shipping Charges</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="tax-tab" data-toggle="tab" href="#tax_tab" role="tab" aria-controls="tax_tab" aria-selected="false">Tax Settings</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="logo-tab" data-toggle="tab" href="#logo" role="tab" aria-controls="logo" aria-selected="false">Store Images</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="social-tab" data-toggle="tab" href="#social" role="tab" aria-controls="social" aria-selected="false">Store Social Links</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="store" role="tabpanel" aria-labelledby="store-tab">
                                            <input type="hidden" id="url" value="{{ route('edit_store_setting') }}">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group row last">
                                                        <label class="label-control">Site Title</label>
                                                        <input type="text" id="title" name="title" class="form-control" placeholder="Site Title" value="{{ old('title', $query->title) }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group row">
                                                        <label class="label-control">Store Address</label>
                                                        <textarea id="address" name="address" class="form-control" rows="5" placeholder="Store Address">{{ old('address', $query->address) }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="label-control">Country</label>
                                                        <select id="country" name="country" class="form-control select_2" style="width: 100%">
                                                            @if(!empty($countries))
                                                                <option>Select Country First !!</option>
                                                                @foreach($countries as $row)
                                                                    <option value="{{ $row->country_code }}"  @if(old('country', $query->country_id) == $row->country_code) selected @endif>{{ $row->country_name }}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="label-control">City</label>
                                                        <select id="city" name="city" class="form-control select_2" style="width: 100%">
                                                            @if(!empty($cities))
                                                                @foreach($cities as $row)
                                                                    <option value="{{ $row->id }}" @if(old('city', $query->city_id) == $row->id) selected @endif>{{ $row->name }}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group row">
                                                        <label class="label-control">Zip Code</label>
                                                        <input type="text" id="zip_code" name="zip_code" class="form-control" placeholder="Zip Code" value="{{ old('zip_code', $query->zip_code) }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="label-control">Phone# 1</label>
                                                        <input type="text" id="phone_1" name="phone_1" class="form-control" placeholder="Phone# 1" value="{{ old('phone_1', $query->phone_1) }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group row last">
                                                        <label class="label-control">Phone# 2</label>
                                                        <input type="text" id="phone_2" name="phone_2" class="form-control" placeholder="Phone# 2" value="{{ old('phone_2', $query->phone_2) }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="label-control">Email 1</label>
                                                        <input type="text" id="email_1" name="email_1" class="form-control" placeholder="Email 1" value="{{ old('email_1', $query->email_1) }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group row last">
                                                        <label class="label-control">Email 2</label>
                                                        <input type="text" id="email_2" name="email_2" class="form-control" placeholder="Email 2" value="{{ old('email_2', $query->email_2) }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="shipping" role="tabpanel" aria-labelledby="shipping-tab">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="label-control">Shipping Mode</label>
                                                        <select id="country" name="shipping_mood" class="form-control select_2" style="width: 100%">
                                                            <option value="0" @if((old('shipping_mood', $query->shipping_mood)) == '0') selected @endif>Active</option>
                                                            <option value="1" @if((old('shipping_mood', $query->shipping_mood)) == '1') selected @endif>Inactive</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group row last">
                                                        <label class="label-control">International Shipping Mode</label>
                                                        <select id="city" name="international_shipping_mood" class="form-control select_2" style="width: 100%">
                                                            <option value="0" @if((old('shipping_mood', $query->international_shipping_mood)) == '0') selected @endif>Active</option>
                                                            <option value="1" @if((old('shipping_mood', $query->international_shipping_mood)) == '1') selected @endif>Inactive</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="shipping_charges" role="tabpanel" aria-labelledby="shipping-charges-tab">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="label-control">Half Kg Price Within City</label>
                                                        <input type="text" id="half_kg_0" name="half_kg_0" class="form-control" placeholder="Half Kg Price Within City" value="{{ old('half_kg_0', $query->half_kg_0) }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group row last">
                                                        <label class="label-control">Half Kg Price Outside City</label>
                                                        <input type="text" id="half_kg_1" name="half_kg_1" class="form-control" placeholder="Half Kg Price Outside City" value="{{ old('half_kg_1', $query->half_kg_1) }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="label-control">Per Kg Price Within City</label>
                                                        <input type="text" id="per_kg_0" name="per_kg_0" class="form-control" placeholder="Per Kg Price Within City" value="{{ old('per_kg_0', $query->per_kg_0) }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group row last">
                                                        <label class="label-control">Per Kg Price Outside City</label>
                                                        <input type="text" id="per_kg_1" name="per_kg_1" class="form-control" placeholder="Per Kg Price Outside City" value="{{ old('per_kg_1', $query->per_kg_1) }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="label-control">Additional Per Kg Price Within City</label>
                                                        <input type="text" id="additional_per_kg_0" name="additional_per_kg_0" class="form-control" placeholder="Additional Per Kg Price Within City" value="{{ old('additional_per_kg_0', $query->additional_per_kg_0) }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group row last">
                                                        <label class="label-control">Additional Per Kg Price Outside City</label>
                                                        <input type="text" id="additional_per_kg_1" name="additional_per_kg_1" class="form-control" placeholder="Additional Per Kg Price Outside City" value="{{ old('additional_per_kg_1', $query->additional_per_kg_1) }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="tax_tab" role="tabpanel" aria-labelledby="tax-tab">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="label-control">Tax Calculation</label>
                                                        <select id="tax" name="tax_mood" class="form-control select_2" style="width: 100%">
                                                            <option value="0" @if(old('tax_mood', $query->tax_mood) == '0') selected @endif>Active</option>
                                                            <option value="1" @if(old('tax_mood', $query->tax_mood) == '1') selected @endif>Inactive</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="logo" role="tabpanel" aria-labelledby="logo-tab">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="label-control">Select Header Logo</label>
                                                        <input type="file" id="single_image" name="header_image" data-id="1">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group row last">
                                                        <label class="label-control">Image Preview</label>
                                                        <div class="col-md-12">
                                                            <img src="{{ asset('public/assets/admin/images/settings/logo/'.$query->header_image) }}" class="single_image_preview_1" alt="Store Header Logo" style="width:150px; height:150px"/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="label-control">Select Footer Logo</label>
                                                        <input type="file" id="single_image" name="footer_image" data-id="2">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group row last">
                                                        <label class="label-control">Image Preview</label>
                                                        <div class="col-md-12">
                                                            <img src="{{ asset('public/assets/admin/images/settings/logo/'. $query->footer_image) }}" class="single_image_preview_2" alt="Store Header Logo" style="width:150px; height:150px"/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="label-control">Select Favicon Image</label>
                                                        <input type="file" id="single_image" name="favicon_image" data-id="3">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group row last">
                                                        <label class="label-control">Image Preview</label>
                                                        <div class="col-md-12">
                                                            <img src="{{ asset('public/assets/admin/images/settings/logo/'.$query->favicon_image) }}" class="single_image_preview_3" alt="Store Favicon Image" style="width:150px; height:150px"/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="social" role="tabpanel" aria-labelledby="social-tab">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="label-control">Facebook Profile Link</label>
                                                        <label class="fonticon-classname"></label>
                                                        <input type="text" id="facebook" name="facebook" class="form-control" placeholder="Facebook Profile" value="{{ old('facebook', $query->facebook) }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group row last">
                                                        <label class="label-control">Twitter Profile Link</label>
                                                        <input type="text" id="twitter" name="twitter" class="form-control" placeholder="Twitter Profile Link" value="{{ old('twitter', $query->twitter) }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="label-control">G+ Profile Link</label>
                                                        <label class="fonticon-classname"></label>
                                                        <input type="text" id="googleplus" name="googleplus" class="form-control" placeholder="G+ Profile Link" value="{{ old('googleplus', $query->googleplus) }}">
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
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@include('admin.layouts.footer')