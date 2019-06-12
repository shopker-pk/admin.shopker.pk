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
                                        <h4 class="form-section">Manage Coupons</h4>
                                        <div class="row">
                                        	<div class="col-md-10">
                                        		@if($total_records > 1)
                                                    Total {{ $total_records }} Record Found
                                                @elseif($total_records == 1)
                                                    Total {{ $total_records }} Record Found
                                                @else
                                                    No records found
                                                @endif 
                                        	</div>
                                        	<div class="col-md-1">
                                        		<a href="{{ route('add_coupon') }}"><i class="ft-plus"></i> Add</a>
                                    		</div>
                                    		<div class="col-md-1" id="filter_button">
                                    			<a href="javascript::void(0);" id="add_filter"><i class="ft-filter"></i> Filter</a>
                                                <input type="hidden" id="search_url" value="{{ route('search_coupons') }}">
                                    		</div>
                                    	</div>
                                    	<div id="filter_section"></div>
                                    </div><br><br>
                                    <div class="table-responsive">          
  										<table class="table">
											<thead>
			                                    <tr>
                                                    <th>Admin Name</th>
                                                    <th>Vendor Name</th>
                                                    <th>Code</th>
                                                    <th>Discount Type</th>
                                                    <th>Start Date</th>
			                                        <th>End Date</th>
                                                    <th>Discount Offer</th>
                                                    <th>No of uses</th>
                                                    <th>Min Order Amount</th>
                                                    <th>Max Order Amount</th>
                                                    <th>Limit to per Customer</th>
                                                    <th>Order Type</th>
                                                    <th>Status</th>
			                                        <th>Action</th>
			                                    </tr>
			                                </thead>
			                                <tbody>
                                                @if(!empty($query))
                                                    @foreach($query as $row)
        			                                    <tr>
                                                            @foreach($admins as $admin)
                                                                @if($admin->id == $row->admin_id)
                                                            <td>{{ $admin->admin_name }}</td>
                                                                @endif
                                                            @endforeach
                                                            @if(!empty($row->first_name && $row->last_name))
                                                            <td>{{ $row->first_name.' '.$row->last_name }}</td>
                                                            @else
                                                            <td></td>
                                                            @endif
                                                            <td>{{ $row->code }}</td>
                                                            @if($row->discount_type == 0)
                                                            <td>Percentage</td>
                                                            @else
                                                            <td>Fixed Amount</td>
                                                            @endif
                                                            <td>{{ date('D M Y', strtotime($row->start_date)) }}</td>
                                                            <td>{{ date('D M Y', strtotime($row->end_date)) }}</td>
                                                            <td>@if($row->discount_type == 0) {{ $row->discount_offer }}% @else Rs:{{ $row->discount_offer }}  @endif</td>
                                                            <td>{{ $row->no_of_uses }}</td>
                                                            <td>{{ $row->min_order_amount }}</td>
                                                            <td>{{ $row->max_order_amount }}</td>
                                                            <td>{{ $row->limit_per_customer }}</td>
                                                            @if($row->order_type == 0)
                                                            <td>On Products</td>
                                                            @else
                                                            <td>Complete Shop</td>
                                                            @endif
                                                            <td>
                                                                <label class="switch">
                                                                    <a href="{{ url('/user/admin/advertisements/coupons/update-status/'.$row->id.'/'.$row->status) }}">
                                                                        <input type="checkbox" id="status" class="form-control" @if($row->status == 0) checked @endif>
                                                                        <span class="slider"></span>
                                                                    </a>
                                                                </label>            
                                                            </td>
                                                            <td>
        				                                    	<div role="group" class="btn-group">
        														    <button id="btnGroupDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-outline-primary dropdown-toggle dropdown-menu-right"><i class="ft-edit icon-left"></i> Action</button>
        														    <div aria-labelledby="btnGroupDrop1" class="dropdown-menu">
        														    	<a href="{{ route('edit_coupon', $row->id) }}" class="dropdown-item">Edit</a>
                                                                        <a href="{{ route('delete_coupon', $row->id) }}" class="dropdown-item">Delete</a>
        														    </div>
        														</div>
        													</td>
        				                               	</tr>
                                                    @endforeach
                                                @else
                                                    No Records Found !!
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@include('admin.layouts.footer')