@include('admin.layouts.header')
    <section id="basic-form-layouts">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content collpase show">
                        <div class="card-body">
                            <form class="form form-horizontal form-bordered" action="{{ route('update_shipping_areas', $query->parent_id) }}" method="post">
                                {{ csrf_field() }}
                                <div class="form-body">
                                    <h4 class="form-section">Edit Shipping Areas</h4>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="label-control">Shipping Rate</label>
                                                    <input type="text" id="shipping_rate" name="shipping_rate" class="form-control" placeholder="Shipping Rate" value="{{ $query->shipping_charges }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="label-control">Destination Country</label>
                                                    <select id="country" name="destination_country" class="form-control select_2" style="width: 100%">
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
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div id="wait_section"></div>
                                                <div class="form-group row last" id="cities_section">
                                                    <label class="label-control">Destination City</label>
                                                    <select id="destination_city[]" name="destination_city[]" class="form-control select_2" style="width: 100%" multiple>
                                                        @if($cities)
                                                            <option>No City Selected</option>
                                                            @foreach($cities as $row)
                                                                <option value="{{ $row->id }}" @foreach($query_cities as $city) @if($city->city_id == $row->id) selected @endif @endforeach @if(old('destination_city') == $row->id) selected @endif>{{ $row->name }}</option>
                                                            @endforeach
                                                        @else
                                                            <option>No City Found</option>
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row last">
                                                    <label class="label-control">Status</label>
                                                    <div class="input-group">
                                                        <label class="d-inline-block custom-control custom-radio ml-1">
                                                            <input type="radio" id="status" name="status" class="custom-control-input" value="0" @if($query->status == 0) checked @endif @if(old('status') == 0) checked @endif>
                                                            <span class="custom-control-indicator"></span>
                                                            <span class="custom-control-description ml-0">Active</span>
                                                        </label>
                                                        <label class="d-inline-block custom-control custom-radio">
                                                            <input type="radio" id="status" name="status" class="custom-control-input" value="1" @if($query->status == 1) checked @endif @if(old('status') == 1) checked @endif>
                                                            <span class="custom-control-indicator"></span>
                                                            <span class="custom-control-description ml-0">Inactive</span>
                                                        </label>
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
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@include('admin.layouts.footer')