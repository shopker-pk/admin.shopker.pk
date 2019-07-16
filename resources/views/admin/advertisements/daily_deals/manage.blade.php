@include('admin.layouts.header')
    <div class="content-body">
        <section id="basic-form-layouts">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-content collpase show">
                            <div class="card-body">
                                <div class="form-body">
                                    <h4 class="form-section">Manage Daily Deals Products</h4>
                                    <div class="row">
                                    	<div class="col-md-3">
                                    		@if($total_records > 1)
                                                Total {{ $total_records }} Record Found
                                            @elseif($total_records == 1)
                                                Total {{ $total_records }} Record Found
                                            @else
                                                No records found
                                            @endif 
                                    	</div>
                                		<div class="col-md-9" id="filter_button">
                                			<form action="{{ route('search_daily_deals') }}" method="get">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <input type="text" id="name" name="name" class="form-control" placeholder="Product name">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input type="text" id="sku" name="sku" class="form-control" placeholder="Product SKU">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <select id="is_daily_deal" name="is_daily_deal" class="form-control select_2">
                                                            <option value="2">Deals & Products Both</option>
                                                            <option value="0">Active Deals</option>
                                                            <option value="1">All Deals</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <button type="submit" class="btn btn-primary"><i class="ft-search"></i></button>
                                                    </div>
                                                </div>
                                            </form> 
                                		</div>
                                	</div>
                                </div><br><br>
                                <div class="table-responsive">          
										<table class="table">
										<thead>
		                                    <tr>
                                                <th>Added By</th>
                                                <th>Name</th>
		                                        <th>SKU</th>
                                                <th>Created</th>
                                                <th>Retail Price</th>
                                                <th>Sale Price</th>
                                                <th>Available</th>
                                                <th>Visible</th>
                                                <th>Active</th>
		                                    </tr>
		                                </thead>
		                                <tbody>
                                            @if(!empty($query))
                                                <input type="hidden" value="{{ $count = 0 }}">
                                                @foreach($query as $row)
    			                                    <tr>
                                                        <td>{{ $row->first_name }} {{ $row->last_name }}</td>
                                                        <td><a href="javascript::void(0);">{{ $row->name }}</a></td>
    				                                    <td>{{ $row->sku_code }}</td>
                                                        <td>{{ date('d-m-Y', strtotime($row->created_date)) }}</td>
                                                        <td>{{ $row->regural_price }}</td>
                                                        <td>
                                                            @if(!empty($row->sale_price))
                                                                <a href="javascript::void(0);" class="sale_price" data-id="{{ $count }}">{{ $row->sale_price }}</a>
                                                            @else
                                                                <a href="javascript::void(0);" class="sale_price" data-id="{{ $count }}">00.00</a>
                                                            @endif
                                                        </td>
                                                        <td>{{ $row->quantity }}</td>
                                                        <td>
                                                            @if($row->is_approved == 0)
                                                                <img src="{{ asset('public/assets/admin/images/icons/check.png') }}" style="height: 25px;width: 30px;">
                                                            @else
                                                                <img src="{{ asset('public/assets/admin/images/icons/cross.png') }}" style="height: 25px;width: 30px;">
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <label class="switch">
                                                                <a href="{{ url('/user/admin/ecommerce/products/ajax/update-status/'. $row->id.'/'. $row->status) }}">
                                                                    <input type="checkbox" id="status" class="form-control" @if($row->status == 0) checked @endif>
                                                                    <span class="slider"></span>
                                                                </a>
                                                            </label>
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
                                        {{ $query->appends(\Input::except('page'))->links() }}
                                    </div>
                                </div>

                                @if(!empty($query))
                                    <input type="hidden" value="{{ $count = 0 }}">
                                    @foreach($query as $row)
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
                                                    <form action="{{ route('insert_daily_deals', $row->id) }}" method="post">
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
                                                                        <input type="text" id="{{ uniqid() }}" name="from_date" class="form-control datetime_picker" placeholder="From Date" value="{{ old('from_date', date('Y/m/d H:i', strtotime($row->from_date.' '.$row->deal_start_time))) }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="label-control">To Date</label>
                                                                        <input type="datetime" id="{{ uniqid() }}" name="to_date" class="form-control datetime_picker" placeholder="To Date" value="{{ old('to_date', date('Y/m/d H:i', strtotime($row->to_date.' '.$row->deal_end_time))) }}">
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
                                        <input type="hidden" value="{{ $count++ }}">
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@include('admin.layouts.footer')