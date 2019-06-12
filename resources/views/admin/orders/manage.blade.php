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
                                        <h4 class="form-section">Manage Orders</h4>
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
                                                <a class="export_orders" href="javascript::void(0);" class="fa fa-file-excel-o">
                                                    Export
                                                </a>
                                            </div>
                                            <div class="col-md-1" id="filter_button">
                                                <a href="javascript::void(0);" id="add_filter"><i class="ft-filter"></i> Filter</a>
                                                <input type="hidden" id="search_url" value="{{ route('search_seller_orders') }}">
                                            </div>
                                        </div>
                                        <div id="filter_section"></div>
                                    </div><br><br>
                                    <div class="table-responsive">          
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Invoice</th>
                                                    <th>Order NO#</th>
                                                    <th>Customer Name</th>
                                                    <th>Payment Type</th>
                                                    <th>Payment Status</th>
                                                    <th>Order Status</th>
                                                    <th>Order Date</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(!empty($query))
                                                    @foreach($query as $row)
                                                        <tr>
                                                            <td><a href="{{ route('manage_admin_invoices_details', $row->order_no) }}" target="_blank">Invoice</a></td>
                                                            <td><a href="{{ route('order_details_seller', $row->order_no) }}" target="_blank">{{ $row->order_no }}</a></td>
                                                            @if(!empty(Session::get('role') == 0))
                                                                <td>{{ $row->first_name }} {{ $row->last_name }}</td>
                                                            @endif
                                                            <td>
                                                                @if($row->payment_method == 0)
                                                                    Jazz Cash
                                                                @elseif($row->payment_method == 1)
                                                                    Easy Paisa
                                                                @else
                                                                    Cash On Delivery
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if($row->p_status == 0)
                                                                    <span class="badge badge-default badge-success">Paid</span>
                                                                @else
                                                                    <span class="badge badge-danger">Unpaid</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if($row->o_status == 0)
                                                                    <span class="badge badge-warning">Pending</span>
                                                                @elseif($row->o_status == 1)
                                                                    <span class="badge badge-info">In Process</span>
                                                                @elseif($row->o_status == 2)
                                                                    <span class="badge badge-info">Ready To Ship</span>
                                                                @elseif($row->o_status == 3)
                                                                    <span class="badge badge-info">Shipped</span>
                                                                @elseif($row->o_status == 4)
                                                                    <span class="badge badge-success">Delivered</span>
                                                                @elseif($row->o_status == 5)
                                                                    <span class="badge badge-danger">Canceled</span>
                                                                @endif
                                                            </td>
                                                            <td>{{ date('d-m-Y', strtotime($row->order_date)) }}</td>
                                                            <td>
                                                                <div role="group" class="btn-group">
                                                                    <button id="btnGroupDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-outline-primary dropdown-toggle dropdown-menu-right"><i class="ft-edit icon-left"></i> Action</button>
                                                                    <div aria-labelledby="btnGroupDrop1" class="dropdown-menu">
                                                                        @if(!empty(Session::get('role') == 0))
                                                                            <a href="javascript::void(0);" class="dropdown-item" data-toggle="modal" data-target="#order_{{ $row->order_no }}">Change Order Status</a>
                                                                            <a href="javascript::void(0);" class="dropdown-item" data-toggle="modal" data-target="#payment_{{ $row->order_no }}">Change Payment Status</a>
                                                                            <a href="{{ route('order_details_seller', $row->order_no) }}" class="dropdown-item">View Order Details</a>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
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

                                <!-- Edit Order Status Modal -->
                                @if(!empty($query))
                                    @foreach($query as $row)
                                        <div class="modal fade text-left" id="order_{{ $row->order_no }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" style="display: none;" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <label class="modal-title text-text-bold-600" id="myModalLabel33">Order NO# : {{ $row->order_no }}</label>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>
                                                    <form action="{{ route('update_seller_order_status', $row->order_no) }}" method="post">
                                                        {{ csrf_field() }}
                                                        <div class="modal-body">
                                                            <label class="label-control">Order Status</label><br>
                                                            <select id="order_status" name="order_status" class="form-control select_2" style="width: 100%">
                                                                <option value="0" @if($row->o_status == 0) selected @endif>Pending</option>
                                                                <option value="1" @if($row->o_status == 1) selected @endif>In Process</option>
                                                                <option value="2" @if($row->o_status == 2) selected @endif>Ready to Ship</option>
                                                                <option value="3" @if($row->o_status == 3) selected @endif>Shiped</option>
                                                                <option value="4" @if($row->o_status == 4) selected @endif>Delivered</option>
                                                                <option value="5" @if($row->o_status == 5) selected @endif>Canceled</option>
                                                            </select>
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
                                    @endforeach
                                @endif

                                <!-- Edit Payment Status Modal -->
                                @if(!empty($query))
                                    @foreach($query as $row)
                                        <div class="modal fade text-left" id="payment_{{ $row->order_no }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" style="display: none;" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <label class="modal-title text-text-bold-600" id="myModalLabel33">Order NO# : {{ $row->order_no }}</label>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>
                                                    <form action="{{ route('update_seller_payment_status', $row->order_no) }}" method="post">
                                                        {{ csrf_field() }}
                                                        <div class="modal-body">
                                                            <label class="label-control">Payment Status</label><br>
                                                            <select id="payment_status" name="payment_status" class="form-control select_2" style="width: 100%">
                                                                <option value="0" @if($row->p_status == 0) selected @endif>Paid</option>
                                                                <option value="1" @if($row->p_status == 1) selected @endif>UnPaid</option>
                                                            </select>
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
                                    @endforeach
                                @endif

                                <!-- Export Variations -->
                                <div class="modal fade text-left" id="export_orders" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <label class="modal-title text-text-bold-600" id="myModalLabel33">Export Orders</label>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <form action="{{ route('export_orders') }}" method="post" enctype="multipart/form-data">
                                                {{ csrf_field() }}
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label class="label-control">Select Orders Type</label><br>
                                                            <select id="order_type" name="order_type" class="form-control select_2" style="width: 100%">
                                                                <option value="0">Pending</option>
                                                                <option value="1">In Process</option>
                                                                <option value="2">Ready to Ship</option>
                                                                <option value="3">Shiped</option>
                                                                <option value="4">Delivered</option>
                                                                <option value="5">Canceled</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="label-control">Write File Name</label><br>
                                                            <input type="text" id="name" name="name" class="form-control" placeholder="Write File Name*">
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@include('admin.layouts.footer')