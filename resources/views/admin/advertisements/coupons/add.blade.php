@include('admin.layouts.header')
    <div class="content-body">
        <section id="basic-form-layouts">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-content collpase show">
                            <div class="card-body">
                                <form class="form form-horizontal form-bordered" action="{{ route('insert_coupon') }}" method="post" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="form-body">
                                        <h4 class="form-section">Add Coupon</h4>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="label-control">Coupon Code</label><label class="label-control" style="color:red">*</label>
                                                    <input type="text" id="code" name="code" class="form-control" placeholder="Coupon Code *" value="{{ old('code') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row last">
                                                    <label class="label-control">Discount Type</label><label class="label-control" style="color:red">*</label>
                                                    <select id="discount_type" name="discount_type" class="form-control select_2">
                                                        <option>Select Discount Type</option>
                                                        <option value="0" @if(old('discount_type') == 0) selected @endif>Percentage</option>
                                                        <option value="1" @if(old('discount_type') == 0) selected @endif>Fixed Amount</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="label-control">Coupon Start Date</label><label class="label-control" style="color:red">*</label>
                                                    <input type="text" id="start_date" name="start_date" class="form-control advertise_datepicker" value="{{ old('start_date') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row last">
                                                    <label class="label-control">Coupon End Date</label><label class="label-control" style="color:red">*</label>
                                                    <input type="text" id="end_date" name="end_date" class="form-control advertise_datepicker" value="{{ old('end_date') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="label-control">Amount Of Discount</label><label class="label-control" style="color:red">*</label>
                                                    <input type="text" id="discount_offer" name="discount_offer" class="form-control" placeholder="Amount Of Discount *" value="{{ old('discount_offer') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row last">
                                                    <label class="label-control">Limit Of Coupon Use</label><label class="label-control" style="color:red">*</label>
                                                    <input type="text" id="no_of_uses" name="no_of_uses" class="form-control" placeholder="Limit Of Coupon Use *" value="{{ old('no_of_uses') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="label-control">Minimum Order Amount</label><label class="label-control" style="color:red">*</label>
                                                    <input type="text" id="min_order_amount" name="min_order_amount" class="form-control" placeholder="Minimum Amount of Order For Using Coupon *" value="{{ old('min_order_amount') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row last">
                                                    <label class="label-control">Maximum Order Amount</label><label class="label-control" style="color:red">*</label>
                                                    <input type="text" id="max_order_amount" name="max_order_amount" class="form-control" placeholder="Maximum Amount of Order For Using Coupon *" value="{{ old('max_order_amount') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row last">
                                                    <label class="label-control">Useage Limit Per Customer</label><label class="label-control" style="color:red">*</label>
                                                    <input type="text" id="limit_per_customer" name="limit_per_customer" class="form-control" placeholder="Useage Limit Per Customer *" value="{{ old('limit_per_customer') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="label-control">Apply To</label><label class="label-control" style="color:red">*</label>
                                                    <select id="order_type" name="order_type" class="form-control select_2">
                                                        <option selected>Select Type</option>
                                                        <option value="0">Product</option>
                                                        <option value="1">Complete Shop</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="coupons_products"></div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row last">
                                                    <label class="label-control">Coupon Status</label><label class="label-control" style="color:red">*</label>
                                                    <div class="input-group">
                                                        <label class="d-inline-block custom-control custom-radio ml-1">
                                                            <input type="radio" id="status" name="status" class="custom-control-input" value="0" @if(old('status') == 0) checked @endif>
                                                            <span class="custom-control-indicator"></span>
                                                            <span class="custom-control-description ml-0">Active</span>
                                                        </label>
                                                        <label class="d-inline-block custom-control custom-radio">
                                                            <input type="radio" id="status" name="status" class="custom-control-input" value="1" @if(old('status') == 1) checked @endif>
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