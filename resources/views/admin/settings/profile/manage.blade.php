@include('admin.layouts.header')
    <section id="basic-form-layouts">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content collpase show">
                        <div class="card-body">
                            <form class="form form-horizontal form-bordered" action="{{ route('update_admin_profile_settings') }}" method="post" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="form-body">
                                    <h4 class="form-section">Profile Setting</h4>
                                    <form action="#" method="post"> 
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="label-control">First Name</label>
                                                    <input type="text" id="first_name" name="first_name" class="form-control" placeholder="First Name" value="{{ old('first_name', $query->first_name) }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row last">
                                                    <label class="label-control">Last Name</label>
                                                    <input type="text" id="last_name" name="last_name" class="form-control" placeholder="Last Name" value="{{ old('last_name', $query->last_name) }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label class="label-control">Address</label>
                                                    <textarea id="address" name="address" class="form-control">{{ old('address', $query->address) }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="label-control">Phone NO#</label>
                                                    <input type="text" id="phone_no" name="phone_no" class="form-control" placeholder="Phone# 1" value="{{ old('phone_no', $query->phone_no) }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="label-control">Email</label>
                                                    <input type="text" id="email" name="email" class="form-control" placeholder="Email" value="{{ old('email', $query->email) }}" disabled>
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
                                            <div class="col-md-6">
                                                <div class="form-group row last">
                                                    <label class="label-control">Date OF Birth</label>
                                                    <input type="text" id="dob" name="dob" class="form-control datepicker" value="{{ old('dob', date('m/d/Y', strtotime($query->dob))) }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row last">
                                                    <label class="label-control">Gender</label>
                                                    <select id="gender" name="gender" class="form-control" style="width: 100%">
                                                        <option>No Gender Selected</option>
                                                        <option value="0" @if(old('gender', $query->gender_id) == '0') selected @endif>Male</option>
                                                        <option value="1" @if(old('gender', $query->gender_id) == '1') selected @endif>Female</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
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
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="label-control">Select Profile Image</label>
                                                    <input type="file" id="single_image" name="profile" data-id="1">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row last">
                                                    <label class="label-control">Image Preview</label>
                                                    <div class="col-md-12">
                                                        <img src="{{ asset('public/assets/admin/images/profile_images/'.$query->image) }}" class="single_image_preview_1" alt="Store Favicon Image" style="width:150px; height:150px"/>
                                                    </div>
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
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@include('admin.layouts.footer')