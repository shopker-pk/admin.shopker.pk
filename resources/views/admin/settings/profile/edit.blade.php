@include('admin.layouts.header')
    <section id="basic-form-layouts">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content collpase show">
                        <div class="card-body">
                            @if(session::get('role') == 0)
                                <form class="form form-horizontal form-bordered" action="{{ route('update_admin_profile_settings') }}" method="post" enctype="multipart/form-data">
                            @else
                                <form class="form form-horizontal form-bordered" action="{{ route('update_user_profile_settings') }}" method="post" enctype="multipart/form-data">
                            @endif
                                {{ csrf_field() }}
                                <div class="form-body">
                                    <h4 class="form-section">Profile Setting</h4>
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="personal_details-tab" data-toggle="tab" href="#personal_details" role="tab" aria-controls="personal_details" aria-selected="true">Personal Details</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="contact_details-tab" data-toggle="tab" href="#contact_details" role="tab" aria-controls="contact_details" aria-selected="false">Contact Details</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="account_credentials-tab" data-toggle="tab" href="#account_credentials" role="tab" aria-controls="account_credentials" aria-selected="false">Account Credentials</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="profile_image-tab" data-toggle="tab" href="#profile_image" role="tab" aria-controls="profile_image" aria-selected="false">Profile Image</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="social_profile_links-tab" data-toggle="tab" href="#social_profile_links" role="tab" aria-controls="social_profile_links" aria-selected="false">Social Profile Links</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="personal_details" role="tabpanel" aria-labelledby="personal_details-tab">
                                            <form action="#" method="post"> 
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group row">
                                                            <label class="label-control">First Name</label>
                                                            <input type="text" id="first_name" name="first_name" class="form-control" placeholder="First Name" value="{{ $query->first_name }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group row last">
                                                            <label class="label-control">Last Name</label>
                                                            <input type="text" id="last_name" name="last_name" class="form-control" placeholder="Last Name" value="{{ $query->last_name }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group row">
                                                            <label class="label-control">CNIC NO#</label>
                                                            <input type="text" id="cnic" name="cnic" class="form-control" placeholder="CNIC NO# without dashes/-" value="{{ $query->cnic }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group row last">
                                                            <label class="label-control">Date OF Birth</label>
                                                            <input type="date" id="dob" name="dob" class="form-control" value="{{ $query->date_of_birth }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group row last">
                                                            <label class="label-control">Gender</label>
                                                            <select id="gender" name="gender" class="form-control" style="width: 100%">
                                                                <option>No Gender Selected</option>
                                                                <option value="0" @if(old('gender') == '0') selected @endif @if($query->gender == '0') selected @endif>Male</option>
                                                                <option value="1" @if(old('gender') == '1') selected @endif @if($query->gender == '1') selected @endif>Female</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <input type="hidden" id="url" value="{{ route('add_shipping_areas') }}">
                                                    <div class="col-md-6">
                                                        <div class="form-group row">
                                                            <label class="label-control">Country</label>
                                                            <select id="country" name="country" class="form-control" style="width: 100%">
                                                                @if($countries)
                                                                    <option>No Country Selected</option>
                                                                    @foreach($countries as $row)
                                                                        <option value="{{ $row->country_code }}"  @if($query->country_id == $row->country_code) selected @endif @if(old('destination_country') == $row->country_code) selected @endif>{{ $row->country_name }}</option>
                                                                    @endforeach
                                                                @else
                                                                    <option>No Country Found</option>
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div id="wait_section"></div>
                                                        <div class="form-group row last" id="cities_area">
                                                            <label class="label-control">City</label>
                                                            <select id="city" name="city" class="form-control" style="width: 100%">
                                                                @if($cities)
                                                                    <option>No City Selected</option>
                                                                    @foreach($cities as $row)
                                                                        <option value="{{ $row->id }}" @if($query->city_id == $row->id) selected @endif @if(old('destination_city') == $row->id) selected @endif>{{ $row->name }}</option>
                                                                    @endforeach
                                                                @else
                                                                    <option>No City Found</option>
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group row">
                                                            <label class="label-control">Residence Address</label>
                                                            <textarea id="address" name="address" class="form-control" rows="5" placeholder="Residence Address">{{ $query->address }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-actions">
                                                    <button type="submit" name="btn" class="btn btn-primary" value="0">
                                                        <i class="fa fa-check-square-o"></i> Update
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="tab-pane fade" id="contact_details" role="tabpanel" aria-labelledby="contact_details-tab">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="label-control">Phone# 1</label>
                                                        <div class="input-group" style="padding : 0.2rem">
                                                            <select class="form-control select_2" id="code_1" name="code_1" style="width: 20%">
                                                                @if(!empty($country_code))
                                                                    <option>Select Code</option>
                                                                    @foreach($country_code as $row)
                                                                    <option value="{{ $row->id }}" @if($query->country_code_1 == $row->id) selected @endif>{{ $row->code }}</option>
                                                                    @endforeach
                                                                @else
                                                                    no country code found !!
                                                                @endif
                                                            </select>
                                                            <input type="text" id="cell_number1" name="cell_number1" class="form-control" placeholder="Phone# 1" value="{{ $query->cell_number1 }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group row last">
                                                        <label class="label-control">Phone# 2</label>
                                                        <div class="input-group" style="padding : 0.2rem">
                                                            <select class="form-control select_2" id="code_2" name="code_2" style="width: 20%">
                                                                @if(!empty($country_code))
                                                                    <option>Select Code</option>
                                                                    @foreach($country_code as $row)
                                                                        <option value="{{ $row->id }}" @if($query->country_code_2 == $row->id) selected @endif>{{ $row->code }}</option>
                                                                    @endforeach
                                                                @else
                                                                    no country code found !!
                                                                @endif
                                                            </select>
                                                            <input type="text" id="cell_number2" name="cell_number2" class="form-control" placeholder="Phone# 2" value="{{ $query->cell_number2 }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-actions">
                                                <button type="submit" name="btn" class="btn btn-primary" value="1">
                                                    <i class="fa fa-check-square-o"></i> Update
                                                </button>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="account_credentials" role="tabpanel" aria-labelledby="account_credentials-tab">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="label-control">Password</label>
                                                        <input type="password" id="password" name="password" class="form-control" placeholder="Password">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group row last">
                                                        <label class="label-control">Confirm Password</label>
                                                        <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="Confirm Password">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-actions">
                                                <button type="submit" name="btn" class="btn btn-primary" value="2">
                                                    <i class="fa fa-check-square-o"></i> Update
                                                </button>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="profile_image" role="tabpanel" aria-labelledby="profile_image-tab">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="label-control">Select Profile Image</label>
                                                        <input type="file" id="image1" name="image">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group row last">
                                                        <label class="label-control">Image Preview</label>
                                                        <div class="col-md-12">
                                                            <img src="{{ asset('public/assets/admin/images/profile_images/'.$query->image) }}" id="preview_image1" alt="Profile Image" style="width:150px; height:150px"/>
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
                                        <div class="tab-pane fade" id="social_profile_links" role="tabpanel" aria-labelledby="social_profile_links-tab">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="label-control">Facebook Profile Link</label>
                                                        <label class="fonticon-classname"></label>
                                                        <input type="text" id="facebook" name="facebook" class="form-control" placeholder="Facebook Profile" value="{{ $query->facebook }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group row last">
                                                        <label class="label-control">Twitter Profile Link</label>
                                                        <input type="text" id="twitter" name="twitter" class="form-control" placeholder="Twitter Profile Link" value="{{ $query->twitter }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="label-control">G+ Profile Link</label>
                                                        <label class="fonticon-classname"></label>
                                                        <input type="text" id="googleplus" name="googleplus" class="form-control" placeholder="G+ Profile Link" value="{{ $query->googleplus }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-actions">
                                                <button type="submit" name="btn" class="btn btn-primary" value="4">
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