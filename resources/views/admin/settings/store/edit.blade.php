@include('admin.layouts.header')
    <section id="basic-form-layouts">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content collpase show">
                        <div class="card-body">
                            <form class="form form-horizontal form-bordered" action="{{ route('update') }}" method="post" enctype="multipart/form-data">
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
                                            <a class="nav-link" id="tax-tab" data-toggle="tab" href="#tax_tab" role="tab" aria-controls="tax_tab" aria-selected="false">Tax Settings</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="logo-tab" data-toggle="tab" href="#logo" role="tab" aria-controls="logo" aria-selected="false">Store Images</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="map-tab" data-toggle="tab" href="#map" role="tab" aria-controls="map" aria-selected="false">Store Map</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="social-tab" data-toggle="tab" href="#social" role="tab" aria-controls="social" aria-selected="false">Store Social Links</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="store" role="tabpanel" aria-labelledby="store-tab">
                                            <input type="hidden" id="url" value="{{ route('edit_store_setting') }}">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="label-control">Owner Name</label>
                                                        <input type="text" id="owner_name" name="owner_name" class="form-control" placeholder="Owner Name" value="@if(!empty($query->owner_name)) {{ $query->owner_name }} @endif">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group row last">
                                                        <label class="label-control">Store Name</label>
                                                        <input type="text" id="store_name" name="store_name" class="form-control" placeholder="Store Name" value="@if(!empty($query->store_name)) {{ $query->store_name }} @endif">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group row">
                                                        <label class="label-control">Store Address</label>
                                                        <textarea id="store_address" name="store_address" class="form-control" rows="5" placeholder="Store Address">@if(!empty($query->store_address)) {{ $query->store_address }} @endif</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <input type="hidden" id="url" value="{{ route('add_shipping_areas') }}">
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="label-control">Country</label>
                                                        <select id="country" name="country" class="form-control select_2" style="width: 100%">
                                                            <option value="PK">No Country Selected</option>
                                                            @if(!empty($query->country_id))
                                                                @if(!empty($countries))
                                                                    @foreach($countries as $row)
                                                                        <option value="{{ $row->country_code }}"  @if($query->country_id == $row->country_code) selected @endif @if(old('destination_country') == $row->country_code) selected @endif>{{ $row->country_name }}</option>
                                                                    @endforeach
                                                                @else
                                                                    <option>No Country Found</option>
                                                                @endif
                                                            @else
                                                                @if(!empty($countries))
                                                                    @foreach($countries as $row)
                                                                        <option value="{{ $row->country_code }} @if(old('country') == $row->country_code) selected @endif">{{ $row->country_name }}</option>
                                                                    @endforeach
                                                                @else
                                                                    <option>No Country Found</option>
                                                                @endif
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div id="wait_section"></div>
                                                    <div class="form-group row last" id="cities_section">
                                                        <label class="label-control">City</label>
                                                        <select id="city" name="city" class="form-control select_2" style="width: 100%">
                                                            @if(!empty($cities))
                                                                <option value="66015">No City Selected</option>
                                                                @foreach($cities as $row)
                                                                    <option value="{{ $row->id }}" @if(old('city') == $row->id) selected @endif @if($query->city_id == $row->id) selected @endif>{{ $row->name }}</option>
                                                                @endforeach
                                                            @else
                                                                <option>No City Found</option>
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="label-control">Zip Code</label>
                                                        <input type="text" id="zip" name="zip" class="form-control" placeholder="Zip Code" value="@if(!empty($query->zip_code)) {{ $query->zip_code }} @endif">
                                                    </div>
                                                </div>
                                                <div class="col-md-6"></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="label-control">Phone# 1</label>
                                                        <div class="input-group" style="padding : 0.2rem">
                                                            <select class="form-control select_2" id="status" name="code_1" style="width: 20%">
                                                                @if(!empty($query->country_code_1))
                                                                    @if(!empty($country_code))
                                                                        <option value="0">Select Code</option>
                                                                        @foreach($country_code as $row)
                                                                            <option value="{{ $row->id }}" @if($query->country_code_1 == $row->id) selected @endif>{{ $row->code }}</option>
                                                                        @endforeach
                                                                    @else
                                                                        No country code found !!
                                                                    @endif
                                                                @else
                                                                    @if(!empty($country_code))
                                                                        <option value="0">Select Code</option>
                                                                        @foreach($country_code as $row)
                                                                            <option value="{{ $row->id }}" @if(old('code_1') == $row->id) selected @endif>{{ $row->code }}</option>
                                                                        @endforeach
                                                                    @else
                                                                        No country code found !!
                                                                    @endif
                                                                @endif
                                                            </select>
                                                            <input type="text" id="phone_1" name="phone_1" class="form-control" placeholder="Phone# 1" value="@if(!empty($query->cell_number1)) {{ $query->cell_number1 }} @endif">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group row last">
                                                        <label class="label-control">Phone# 2</label>
                                                        <div class="input-group" style="padding : 0.2rem">
                                                            <select class="form-control select_2" id="pages" name="code_2" style="width: 20%">
                                                                @if(!empty($query->country_code_2))
                                                                    @if(!empty($country_code))
                                                                        <option value="0">Select Code</option>
                                                                        @foreach($country_code as $row)
                                                                            <option value="{{ $row->id }}" @if($query->country_code_2 == $row->id) selected @endif>{{ $row->code }}</option>
                                                                        @endforeach
                                                                    @else
                                                                        No country code found !!
                                                                    @endif
                                                                @else
                                                                    @if(!empty($country_code))
                                                                        <option value="0">Select Code</option>
                                                                        @foreach($country_code as $row)
                                                                            <option value="{{ $row->id }}" @if(old('code_1') == $row->id) selected @endif>{{ $row->code }}</option>
                                                                        @endforeach
                                                                    @else
                                                                        No country code found !!
                                                                    @endif
                                                                @endif
                                                            </select>
                                                            <input type="text" id="phone_2" name="phone_2" class="form-control" placeholder="Phone# 2" value="@if(!empty($query->cell_number2)) {{ $query->cell_number2 }} @endif">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="label-control">Email 1</label>
                                                        <input type="text" id="email_1" name="email_1" class="form-control" placeholder="Email 1" value="@if(!empty($query->email1)) {{ $query->email1 }} @endif">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group row last">
                                                        <label class="label-control">Email 2</label>
                                                        <input type="text" id="email_2" name="email_2" class="form-control" placeholder="Email 2" value="@if(!empty($query->email1)) {{ $query->email2 }} @endif">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-actions">
                                                <button type="submit" name="btn" class="btn btn-primary" value="0">
                                                    <i class="fa fa-check-square-o"></i> Update
                                                </button>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="shipping" role="tabpanel" aria-labelledby="shipping-tab">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="label-control">Shipping Mode</label>
                                                        <select id="country" name="shipping_mood" class="form-control" style="width: 100%">
                                                            <option value="0" @if(!empty($shipping_settings->shipping_mood) == '0') selected @endif>Active</option>
                                                            <option value="1" @if(!empty($shipping_settings->shipping_mood) == '1') selected @endif>Inactive</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group row last">
                                                        <label class="label-control">International Shipping Mode</label>
                                                        <select id="city" name="international_shipping_mood" class="form-control" style="width: 100%">
                                                            <option value="0" @if(!empty($shipping_settings->international_shipping_mood) == '0') selected @endif>Active</option>
                                                            <option value="1" @if(!empty($shipping_settings->international_shipping_mood) == '1') selected @endif>Inactive</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-actions">
                                                <button type="submit" name="btn" class="btn btn-primary" value="1">
                                                    <i class="fa fa-check-square-o"></i> Update
                                                </button>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="tax_tab" role="tabpanel" aria-labelledby="tax-tab">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="label-control">Tax Calculation</label>
                                                        <select id="tax" name="tax_mood" class="form-control" style="width: 100%">
                                                            <option value="0" @if(!empty($tax_setting->tax_mood) == '0') selected @endif>Active</option>
                                                            <option value="1" @if(!empty($tax_setting->tax_mood) == '1') selected @endif>Inactive</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-actions">
                                                <button type="submit" name="btn" class="btn btn-primary" value="2">
                                                    <i class="fa fa-check-square-o"></i> Update
                                                </button>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="logo" role="tabpanel" aria-labelledby="logo-tab">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="label-control">Select Header Logo</label>
                                                        <input type="file" id="single_image" name="header_image">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group row last">
                                                        <label class="label-control">Image Preview</label>
                                                        <div class="col-md-12">
                                                            <img src="@if(!empty($images_setting->header_image)) {{ asset('public/assets/admin/images/settings/logo/'.$images_setting->header_image) }} @endif" id="single_image_preview" alt="Store Header Logo" style="width:150px; height:150px"/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="label-control">Select Footer Logo</label>
                                                        <input type="file" id="single_image" name="footer_image">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group row last">
                                                        <label class="label-control">Image Preview</label>
                                                        <div class="col-md-12">
                                                            <img src="@if(!empty($images_setting->footer_image)) {{ asset('public/assets/admin/images/settings/logo/'. $images_setting->footer_image) }} @endif" id="single_image_preview" alt="Store Header Logo" style="width:150px; height:150px"/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="label-control">Select Favicon Image</label>
                                                        <input type="file" id="single_image" name="favicon_image">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group row last">
                                                        <label class="label-control">Image Preview</label>
                                                        <div class="col-md-12">
                                                            <img src="@if(!empty($images_setting->favicon_image)) {{ asset('public/assets/admin/images/settings/logo/'.$images_setting->favicon_image) }} @endif" id="single_image_preview" alt="Store Favicon Image" style="width:150px; height:150px"/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-actions">
                                                <button type="submit" name="btn" class="btn btn-primary" value="3">
                                                    <i class="fa fa-check-square-o"></i> Update
                                                </button>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="map" role="tabpanel" aria-labelledby="map-tab">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group row last">
                                                        <label class="label-control">Map API</label>
                                                        <textarea id="map" name="map" class="form-control" rows="5" placeholder="Map API">@if(!empty($store_map->map)){{ $store_map->map }} @endif</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-actions">
                                                <button type="submit" name="btn" class="btn btn-primary" value="4">
                                                    <i class="fa fa-check-square-o"></i> Update
                                                </button>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="social" role="tabpanel" aria-labelledby="social-tab">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="label-control">Facebook Profile Link</label>
                                                        <label class="fonticon-classname"></label>
                                                        <input type="text" id="facebook" name="facebook" class="form-control" placeholder="Facebook Profile" value="@if(!empty($social_links->facebook)) {{ $social_links->facebook }} @endif">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group row last">
                                                        <label class="label-control">Twitter Profile Link</label>
                                                        <input type="text" id="twitter" name="twitter" class="form-control" placeholder="Twitter Profile Link" value="@if(!empty($social_links->twitter)) {{ $social_links->twitter }} @endif">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="label-control">G+ Profile Link</label>
                                                        <label class="fonticon-classname"></label>
                                                        <input type="text" id="googleplus" name="googleplus" class="form-control" placeholder="G+ Profile Link" value="@if(!empty($social_links->googleplus)) {{ $social_links->googleplus }} @endif">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-actions">
                                                <button type="submit" name="btn" class="btn btn-primary" value="5">
                                                    <i class="fa fa-check-square-o"></i> Update
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