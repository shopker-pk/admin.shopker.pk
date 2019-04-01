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
                                        <h4 class="form-section">Manage Invoices</h4>
                                        <div class="row">
                                        	<div class="col-md-11">
                                        		@if($total_records > 1)
                                                    Total {{ $total_records }} Record Found
                                                @elseif($total_records == 1)
                                                    Total {{ $total_records }} Record Found
                                                @else
                                                    No records found
                                                @endif 
                                        	</div>
                                    		<div class="col-md-1" id="filter_button">
                                    			<a href="javascript::void(0);" id="add_filter"><i class="ft-filter"></i> Filter</a>
                                    		</div>
                                    	</div>
                                    	<div id="filter_section"></div>
                                    </div><br><br>
                                    <div class="table-responsive">          
  										<table class="table">
											<thead>
			                                    <tr>
			                                        <th>Order NO#</th>
                                                    <th>Transaction ID</th>
                                                    <th>Customer Name</th>
                                                    <th>Order Amount</th>
                                                    <th>Order Date</th>
                                                    <th>Order Status</th>
			                                        <th>Payment Status</th>
			                                        <th>Action</th>
			                                    </tr>
			                                </thead>
			                                <tbody>
                                                @if(!empty($query))
                                                    @foreach($query as $row)
        			                                    <tr>
                                                            <td>{{ $row->order_no }}</td>
                                                            <td>{{ $row->transaction_id }}</td>
                                                            <td>{{ $row->first_name }} {{ $row->last_name }}</td>
                                                            <td>{{ $row->total }}</td>
        				                                    <td>{{ date('d-m-Y', strtotime($row->order_date)) }}</td>
                                                            <!-- //0 for delivered, 1 for active, 2 for in process & 3 for rejected -->
                                                            <td>
                                                                @if($row->order_status == 0)
                                                                    <span class="badge badge-success">Delivered</span>
                                                                @elseif($row->order_status == 1)
                                                                    <span class="badge badge-primary">Active</span>
                                                                @elseif($row->order_status == 2)
                                                                    <span class="badge badge-warning">In Process</span>
                                                                @else
                                                                    <span class="badge badge-danger">Rejected</span>
                                                                @endif
        				                                    <td>
                                                                @if($row->invoice_status == 0)
                                                                    <span class="badge badge-default badge-success">Paid</span>
                                                                @else
                                                                    <span class="badge badge-default badge-danger">Unpaid</span>
                                                                @endif
                                                            </td>
        				                                    <td>
        				                                    	<div role="group" class="btn-group">
        														    <button id="btnGroupDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-outline-primary dropdown-toggle dropdown-menu-right"><i class="ft-edit icon-left"></i> Action</button>
        														    <div aria-labelledby="btnGroupDrop1" class="dropdown-menu">
        														    	<a href="{{ route('manage_admin_invoices_details', $row->order_no) }}" class="dropdown-item">View Invoice Details</a>
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