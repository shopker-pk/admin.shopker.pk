@include('admin.layouts.header')
    <div class="content-body">
        <section id="basic-form-layouts">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-content collpase show">
                            <div class="card-body">
                                <form class="form form-horizontal form-bordered" action="{{ route('update_admins', $query->id) }}" method="post">
                                    {{ csrf_field() }}
                                    <div class="form-body">
                                        <h4 class="form-section">Edit Admin</h4>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="label-control">First Name</label><label class="label-control" style="color:red">*</label>
                                                    <input type="text" id="first_name" name="first_name" class="form-control" placeholder="First Name*" value="{{ old('first_name', $query->first_name) }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="label-control">Last Name</label><label class="label-control" style="color:red">*</label>
                                                    <input type="text" id="last_name" name="last_name" class="form-control" placeholder="Last Name*" value="{{ old('last_name', $query->last_name) }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="label-control">CNIC</label><label class="label-control" style="color:red">*</label>
                                                    <input type="text" id="cnic" name="cnic" class="form-control" placeholder="CNIC*" value="{{ old('cnic', $query->cnic) }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="label-control">Phone NO</label><label class="label-control" style="color:red">*</label>
                                                    <input type="text" id="phone_no" name="phone_no" class="form-control" placeholder="Phone NO*" value="{{ old('phone_no', $query->phone_no) }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label class="label-control">Address</label><label class="label-control" style="color:red">*</label>
                                                    <textarea id="address" name="address" rows="5" class="form-control" placeholder="Address*">{{ old('address', $query->address) }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="label-control">Country</label><label class="label-control" style="color:red">*</label>
                                                    <select id="country" name="country" class="form-control select_2">
                                                        @if(!empty($countries))
                                                        <option>Select Country</option>
                                                            @foreach($countries as $row)
                                                        <option value="{{ $row->country_code }}" @if($query->country_id == $row->country_code) selected @endif>{{ $row->country_name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="label-control">City</label><label class="label-control" style="color:red">*</label>
                                                    <select id="city" name="city" class="form-control select_2">
                                                        @if(!empty($cities))
                                                        <option>Select Cities</option>
                                                            @foreach($cities as $row)
                                                        <option value="{{ $row->id }}" @if($query->city_id == $row->id) selected @endif>{{ $row->name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="label-control">Email</label><label class="label-control" style="color:red">*</label>
                                                    <input type="text" id="email" name="email" class="form-control" placeholder="Email*" value="{{ old('email', $query->email) }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="label-control">Password</label><label class="label-control" style="color:red">*</label>
                                                    <input type="password" id="password" name="password" class="form-control" placeholder="Password*" value="{{ old('password') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label class="label-control">Permissions</label><label class="label-control" style="color:red">*</label>
                                                    <select id="permissions" name="permissions[]" class="form-control select_2" multiple>
                                                        @if(!empty($permission_0) == 0)
                                                        <option value="0" selected>Parent Categories</option>
                                                        @else
                                                            <option value="0">Parent Categories</option>
                                                        @endif

                                                        @if(!empty($permission_1) == 1)
                                                        <option value="1" selected>Child Categories</option>
                                                        @else
                                                        <option value="1">Child Categories</option>
                                                        @endif

                                                        @if(!empty($permission_2) == 2)
                                                        <option value="2" selected>Sub Child Categories</option>
                                                        @else
                                                        <option value="2">Sub Child Categories</option>
                                                        @endif

                                                        @if(!empty($permission_3) == 3)
                                                        <option value="3" selected>Brands</option>
                                                        @else
                                                        <option value="3">Brands</option>
                                                        @endif

                                                        @if(!empty($permission_4) == 4)
                                                        <option value="4" selected>Variations</option>
                                                        @else
                                                        <option value="4">Variations</option>
                                                        @endif

                                                        @if(!empty($permission_5) == 5)
                                                        <option value="5" selected>Edit Products</option>
                                                        @else
                                                        <option value="5">Edit Products</option>
                                                        @endif

                                                        @if(!empty($permission_6) == 6)
                                                        <option value="6" selected>Delete Products</option>
                                                        @else
                                                        <option value="6">Delete Products</option>
                                                        @endif

                                                        @if(!empty($permission_7) == 7)
                                                        <option value="7" selected>Copy Products</option>
                                                        @else
                                                        <option value="7">Copy Products</option>
                                                        @endif

                                                        @if(!empty($permission_8) == 8)
                                                        <option value="8" selected>Import Products</option>
                                                        @else
                                                            <option value="8">Import Products</option>
                                                        @endif

                                                        @if(!empty($permission_9) == 9)
                                                        <option value="9" selected>Export Products</option>
                                                        @else
                                                        <option value="9">Export Products</option>
                                                        @endif

                                                        @if(!empty($permission_10) == 10)
                                                        <option value="10" selected>Manage Products</option>
                                                        @else
                                                        <option value="10">Manage Products</option>
                                                        @endif

                                                        @if(!empty($permission_11) == 11)
                                                        <option value="11" selected>Orders</option>
                                                        @else
                                                        <option value="11">Orders</option>
                                                        @endif

                                                        @if(!empty($permission_12) == 12)
                                                        <option value="12" selected>Advertisements</option>
                                                        @else
                                                        <option value="12">Advertisements</option>
                                                        @endif

                                                        @if(!empty($permission_13) == 13)
                                                        <option value="13" selected>Invoices</option>
                                                        @else
                                                        <option value="13">Invoices</option>
                                                        @endif

                                                        @if(!empty($permission_14) == 14)
                                                        <option value="14" selected>Customers</option>
                                                        @else
                                                        <option value="14">Customers</option>
                                                        @endif

                                                        @if(!empty($permission_15) == 15)
                                                        <option value="15" selected>Vendors</option>
                                                        @else
                                                        <option value="15">Vendors</option>
                                                        @endif

                                                        @if(!empty($permission_16) == 16)
                                                        <option value="16" selected>Admins</option>
                                                        @else
                                                        <option value="16">Admins</option>
                                                        @endif

                                                        @if(!empty($permission_17) == 17)
                                                        <option value="17" selected>CMS</option>
                                                        @else
                                                        <option value="17">CMS</option>
                                                        @endif

                                                        @if(!empty($permission_18) == 18)
                                                        <option value="18" selected>Settings</option>
                                                        @else
                                                        <option value="18">Settings</option>
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row last">
                                                    <label class="label-control">Status</label>
                                                    <div class="input-group">
                                                        <label class="d-inline-block custom-control custom-radio ml-1">
                                                            <input type="radio" id="status" name="status" class="custom-control-input" value="0" @if(old('status') == '0') checked @endif @if($query->status == '0') checked @endif>
                                                            <span class="custom-control-indicator"></span>
                                                            <span class="custom-control-description ml-0">Active</span>
                                                        </label>
                                                        <label class="d-inline-block custom-control custom-radio">
                                                            <input type="radio" id="status" name="status" class="custom-control-input" value="1" @if(old('on_sale') == '1') checked @endif @if($query->status == '1') checked @endif>
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