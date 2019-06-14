@include('admin.layouts.header')
    <div class="content-body">
        <section id="basic-form-layouts">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-content collpase show">
                            <div class="card-body">
                                <form class="form form-horizontal form-bordered">
                                    <div class="form-body">
                                        <h4 class="form-section">Manage Products</h4>
                                        <div class="row">
                                        	<div class="col-md-8">
                                        		@if($total_records > 1)
                                                    Total {{ $total_records }} Record Found
                                                @elseif($total_records == 1)
                                                    Total {{ $total_records }} Record Found
                                                @else
                                                    No records found
                                                @endif 
                                        	</div>
                                        	<div class="col-md-1">
                                        		<a href="{{ route('add_products') }}"><i class="ft-plus"></i> Add</a>
                                    		</div>
                                    		<div class="col-md-1" id="filter_button">
                                    			<a href="javascript::void(0);" id="add_filter"><i class="ft-filter"></i> Filter</a>
                                                <input type="hidden" id="search_url" value="{{ route('search_products') }}">
                                    		</div>
                                            <div class="col-md-1">
                                                <a href="javascript::void(0);" class="import_products">Import</a>
                                            </div>
                                            <div class="col-md-1">
                                                <a href="javascript::void(0);" class="export_products">Export</a>
                                            </div>
                                    	</div>
                                    	<div id="filter_section"></div>
                                    </div><br><br>
                                    <div class="table-responsive">          
  										<table class="table">
											<thead>
			                                    <tr>
                                                    <th>Added By <input type="text" value="asd" data-id="{{ config('app.frontend_url') }}"></th>
                                                    <th>Name</th>
			                                        <th>SKU</th>
                                                    <th>Created</th>
                                                    <th>Retail Price</th>
                                                    <th>Sale Price</th>
                                                    <th>Available</th>
                                                    <th>Visible</th>
                                                    <th>Active</th>
                                                    <th>Action</th>
			                                    </tr>
			                                </thead>
			                                <tbody>
                                                @if(!empty($query))
                                                    <input type="hidden" value="{{ $count = 0 }}">
                                                    <div class="show_featured_image"></div>
                                                    @foreach($query as $row)
        			                                    <tr>
                                                            <td>{{ $row->first_name }} {{ $row->last_name }}</td>
                                                            @if($row->is_approved == 0)
                                                            <td><a href="{{ config('app.frontend_url').$row->slug }}" class="featured_image" data-id="{{ $count }}" target="_blank">{{ $row->name }}</a></td>
                                                            @elseif($row->is_approved == 1)
                                                            <td><a href="javascript::void(0);" class="featured_image" data-id="{{ $count }}">{{ $row->name }}</a></td>
                                                            @endif
        				                                    <td>{{ $row->sku_code }}</td>
                                                            <td>{{ date('d-m-Y', strtotime($row->created_date)) }}</td>
                                                            <td><a href="javascript::void(0);" class="cost_price" data-id="{{ $count }}">{{ $row->regural_price }}</a></td>
                                                            <td><a href="javascript::void(0);" class="sale_price" data-id="{{ $count }}">{{ $row->sale_price }}</a></td>
                                                            <td><a href="javascript::void(0);" class="quantity" data-id="{{ $count }}">{{ $row->quantity }}</a></td>
                                                            <td>
                                                                @if($row->is_approved == 0)
                                                                <a href="{{ url('/user/admin/ecommerce/products/ajax/update-visibility/'.$row->id.'/1') }}">
                                                                    <img src="{{ asset('public/assets/admin/images/icons/check.png') }}" style="height: 25px;width: 30px;">
                                                                </a>
                                                                @else
                                                                <a href="{{ url('/user/admin/ecommerce/products/ajax/update-visibility/'.$row->id.'/0') }}">
                                                                    <img src="{{ asset('public/assets/admin/images/icons/cross.png') }}" style="height: 25px;width: 30px;">
                                                                </a>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <label class="switch">
                                                                    <a href="{{ url('/user/admin/ecommerce/products/ajax/update-status/'.$row->id.'/'.$row->status) }}">
                                                                        <input type="checkbox" id="status" class="form-control" @if($row->status == 0) checked @endif>
                                                                        <span class="slider"></span>
                                                                    </a>
                                                                </label>
                                                            </td>
                                                            <td>
        				                                    	<div role="group" class="btn-group">
        														    <button id="btnGroupDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-outline-primary dropdown-toggle dropdown-menu-right"><i class="ft-edit icon-left"></i> Action</button>
        														    <div aria-labelledby="btnGroupDrop1" class="dropdown-menu">
                                                                    <a href="{{ route('copy_product', $row->id) }}" class="dropdown-item">Copy Listing</a>
        														    	<a href="{{ route('edit_products', $row->id) }}" class="dropdown-item">Edit</a>
        														    	<a href="{{ route('delete_products', $row->id) }}" class="dropdown-item">Delete</a>
        														    </div>
        														</div>
        													</td>
        				                               	</tr>
                                                        <input type="hidden" value="{{ $count++ }}">
                                                    @endforeach
                                                @else
                                                    No records found !!
                                                @endif
			                               	</tbody>
										</table>
									</div>
                                    <div class="row">
                                        <div class="col-md-10">
                                            {{ $query->links() }}
                                        </div>
                                    </div>
                                </form>

                                @if(!empty($query))
                                    <input type="hidden" value="{{ $count = 0 }}">
                                    @foreach($query as $row)
                                        <!-- Update Retail Price -->
                                        <div class="modal fade text-left" id="cost_price_modal_{{ $count }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <label class="modal-title text-text-bold-600" id="myModalLabel33">Product Name : {{ $row->name }}</label>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>
                                                    <form action="{{ route('ajax_update_cost_price', $row->id) }}" method="post">
                                                        {{ csrf_field() }}
                                                        <div class="modal-body">
                                                            <label class="label-control">Retail Price</label><br>
                                                            <input type="text" id="cost_price" name="cost_price" class="form-control" placeholder="Retail Price" value="{{ old('cost_price', $row->regural_price) }}">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary">
                                                                <i class="fa fa-check-square-o"></i> Update
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Sale Price -->
                                        <div class="modal fade text-left" id="sale_price_modal_{{ $count }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <label class="modal-title text-text-bold-600" id="myModalLabel33">Product Name : {{ $row->name }}</label>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>
                                                    <form action="{{ route('ajax_update_sale_price', $row->id) }}" method="post">
                                                        {{ csrf_field() }}
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label class="label-control">Sale Price</label>
                                                                        <input type="text" id="sale_price" name="sale_price" class="form-control" placeholder="Retail Price" value="{{ old('sale_price', $row->sale_price) }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="label-control">From Date</label>
                                                                        <input type="text" id="from_date" name="from_date" class="form-control advertise_datepicker" placeholder="From Date" value="{{ old('from_date', $row->from_date) }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="label-control">To Date</label>
                                                                        <input type="text" id="to_date" name="to_date" class="form-control advertise_datepicker" placeholder="To Date" value="{{ old('to_date', $row->to_date) }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary">
                                                                <i class="fa fa-check-square-o"></i> Update
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Sale Price -->
                                        <div class="modal fade text-left" id="quantity_modal_{{ $count }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <label class="modal-title text-text-bold-600" id="myModalLabel33">Product Name : {{ $row->name }}</label>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>
                                                    <form action="{{ route('ajax_update_quantity', $row->id) }}" method="post">
                                                        {{ csrf_field() }}
                                                        <div class="modal-body">
                                                            <label class="label-control">Quantity</label><br>
                                                            <input type="text" id="quantity" name="quantity" class="form-control" placeholder="Retail Price" value="{{ old('quantity', $row->quantity) }}">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary">
                                                                <i class="fa fa-check-square-o"></i> Update
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Product Featured Image -->
                                        <input type="hidden" value="{{ asset('public/assets/admin/images/ecommerce/products/'.$row->featured_image) }}" id="featured_image_{{ $count }}">
                                        <input type="hidden" value="{{ $count++ }}">
                                    @endforeach
                                @endif

                                <!-- Export Products -->
                                <div class="modal fade text-left" id="export_products" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <label class="modal-title text-text-bold-600" id="myModalLabel33">Export Products</label>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <form action="{{ route('export_products') }}" method="post">
                                                {{ csrf_field() }}
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="label-control">Select Product Status</label>
                                                                <select id="product_status" name="product_status" class="form-control select_2" style="width: 100%">
                                                                    <option value="2">All</option>
                                                                    <option value="0">Active</option>
                                                                    <option value="1">Inactive</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="label-control">Select Product Type</label>
                                                                <select id="product_type" name="product_type" class="form-control select_2" style="width: 100%">
                                                                    <option value="2">All</option>
                                                                    <option value="0">Visible</option>
                                                                    <option value="1">Invisible</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="label-control">Select Vendor</label>
                                                                <select id="vendor" name="vendor" class="form-control select_2" style="width: 100%">
                                                                    @if(!empty($vendors))
                                                                        <option value="0">All</option>
                                                                        @foreach($vendors as $row)
                                                                            <option value="{{ $row->id }}">{{ $row->first_name }} {{ $row->last_name }}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="label-control">Write File Name</label><br>
                                                                <input type="text" id="name" name="name" class="form-control" placeholder="Write File Name*">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="fa fa-check-square-o"></i> Export
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- Import Products -->
                                <div class="modal fade text-left" id="import_products" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <label class="modal-title text-text-bold-600" id="myModalLabel33">Import Products</label>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <form action="{{ route('import_products') }}" method="post" enctype="multipart/form-data">
                                                {{ csrf_field() }}
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="label-control">Select Product Type</label><br>
                                                                <input type="file" id="products" name="products" data-id="1">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="fa fa-check-square-o"></i> Import
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@include('admin.layouts.footer')