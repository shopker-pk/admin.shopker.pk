@include('admin.layouts.header')
    <div class="content-body">
        <section id="basic-form-layouts">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-content collpase show">
                            <div class="card-body">
                                <form class="form form-horizontal form-bordered" action="{{ route('insert_admins') }}" method="post">
                                    {{ csrf_field() }}
                                    <div class="form-body">
                                        <h4 class="form-section">Add Admin</h4>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="label-control">First Name</label><label class="label-control" style="color:red">*</label>
                                                    <input type="text" id="first_name" name="first_name" class="form-control" placeholder="First Name*" value="{{ old('first_name') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="label-control">Last Name</label><label class="label-control" style="color:red">*</label>
                                                    <input type="text" id="last_name" name="last_name" class="form-control" placeholder="Last Name*" value="{{ old('last_name') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="label-control">Phone NO</label><label class="label-control" style="color:red">*</label>
                                                    <input type="text" id="phone_no" name="phone_no" class="form-control" placeholder="Phone NO*" value="{{ old('phone_no') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label class="label-control">Address</label><label class="label-control" style="color:red">*</label>
                                                    <textarea id="address" name="address" rows="5" class="form-control" placeholder="Address*">{{ old('address') }}</textarea>
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
                                                        <option value="{{ $row->country_code }}">{{ $row->country_name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="label-control">City</label><label class="label-control" style="color:red">*</label>
                                                    <select id="city" name="city" class="form-control select_2">
                                                        <option>Select Country First !!</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="label-control">Email</label><label class="label-control" style="color:red">*</label>
                                                    <input type="text" id="email" name="email" class="form-control" placeholder="Email*" value="{{ old('email') }}">
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
                                                        <option value="0" @if(old('permissions') == 0) selected @endif>Parent Categories</option>
                                                        <option value="1" @if(old('permissions') == 1) selected @endif>Child Categories</option>
                                                        <option value="2" @if(old('permissions') == 2) selected @endif>Sub Child Categories</option>
                                                        <option value="3" @if(old('permissions') == 3) selected @endif>Brands</option>
                                                        <option value="4" @if(old('permissions') == 4) selected @endif>Variations</option>
                                                        <option value="5" @if(old('permissions') == 5) selected @endif>Edit Products</option>
                                                        <option value="6" @if(old('permissions') == 6) selected @endif>Delete Products</option>
                                                        <option value="7" @if(old('permissions') == 7) selected @endif>Copy Products</option>
                                                        <option value="8" @if(old('permissions') == 8) selected @endif>Import Products</option>
                                                        <option value="9" @if(old('permissions') == 9) selected @endif>Export Products</option>
                                                        <option value="10" @if(old('permissions') == 10) selected @endif>Manage Products</option>
                                                        <option value="11" @if(old('permissions') == 11) selected @endif>Orders</option>
                                                        <option value="12" @if(old('permissions') == 12) selected @endif>Advertisements</option>
                                                        <option value="13" @if(old('permissions') == 13) selected @endif>Invoices</option>
                                                        <option value="14" @if(old('permissions') == 14) selected @endif>Customers</option>
                                                        <option value="15" @if(old('permissions') == 15) selected @endif>Vendors</option>
                                                        <option value="16" @if(old('permissions') == 16) selected @endif>Admins</option>
                                                        <option value="17" @if(old('permissions') == 17) selected @endif>CMS</option>
                                                        <option value="18" @if(old('permissions') == 18) selected @endif>Settings</option>
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
                                                            <input type="radio" id="status" name="status" class="custom-control-input" value="0" @if(old('status') == '0') checked @endif>
                                                            <span class="custom-control-indicator"></span>
                                                            <span class="custom-control-description ml-0">Active</span>
                                                        </label>
                                                        <label class="d-inline-block custom-control custom-radio">
                                                            <input type="radio" id="status" name="status" class="custom-control-input" value="1" @if(old('on_sale') == '1') checked @endif>
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