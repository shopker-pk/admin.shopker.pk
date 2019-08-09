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
                                        <h4 class="form-section">Manage Orders Overview</h4>
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
                                                <a class="export_orders_overview" href="javascript::void(0);" class="fa fa-file-excel-o">
                                                    Export
                                                </a>
                                            </div>
                                            <div class="col-md-1" id="filter_button">
                                                <a href="javascript::void(0);" id="add_filter"><i class="ft-filter"></i> Filter</a>
                                                <input type="hidden" id="search_url" value="{{ route('search_orders_overview') }}">
                                            </div>
                                        </div>
                                        <div id="filter_section"></div>
                                    </div><br><br>
                                    <div class="table-responsive">          
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Order NO#</th>
                                                    <th>Order Date</th>
                                                    <th>Product SKU</th>
                                                    <th>Sale Price</th>
                                                    <th>Commision</th>
                                                    <th>Payout Amount</th>
                                                    <th>Operational Status</th>
                                                    <th>Payout Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(!empty($query))
                                                    @foreach($query as $row)
                                                        <tr>
                                                            <td>{{ $row->order_no }}</td>
                                                            <td>{{ date('D-M-Y', strtotime($row->order_date)) }}</td>
                                                            <td>{{ $row->sku_code }}</td>
                                                            <td>{{ $row->product_amount }}</td>
                                                            <td>@(explode('%', $row->commission_percent)[0] != '') {{ floor((explode('%', $row->commission_percent)[0] / 100) * $row->product_amount) }} @else {{ floor(($row->commission_percent / 100) * $row->product_amount) }} @endif</td>
                                                            <td>@(explode('%', $row->commission_percent)[0] != '') {{ floor(($row->product_amount) - (explode('%', $row->commission_percent)[0] / 100) * $row->product_amount) }} @else {{ floor(($row->product_amount) - ($row->commission_percent / 100) * $row->product_amount) }} @endif</td>
                                                            <td>
                                                                @if($row->operational_status == 0)
                                                                    <span class="badge badge-warning">Pending</span>
                                                                @elseif($row->operational_status == 1)
                                                                    <span class="badge badge-info">In Process</span>
                                                                @elseif($row->operational_status == 2)
                                                                    <span class="badge badge-info">Ready To Ship</span>
                                                                @elseif($row->operational_status == 3)
                                                                    <span class="badge badge-info">Shipped</span>
                                                                @elseif($row->operational_status == 4)
                                                                    <span class="badge badge-success">Delivered</span>
                                                                @elseif($row->operational_status == 5)
                                                                    <span class="badge badge-danger">Canceled</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if($row->payout_status == 0)
                                                                    <span class="badge badge-default badge-success">Paid</span>
                                                                @elseif($row->payout_status == 1)
                                                                    <span class="badge badge-danger">Unpaid</span>
                                                                @endif
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
                            </div>
                            <!-- Export Orders Overview -->
                            <div class="modal fade text-left" id="export_orders_overview" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <label class="modal-title text-text-bold-600" id="myModalLabel33">Export Orders Overview</label>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('export_orders_overview') }}" method="post" enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label class="label-control">Order From Date</label><br>
                                                        <input type="text" name="from_date" class="form-control datepicker">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="label-control">Order End Date</label><br>
                                                        <input type="text" id="end_date" class="form-control datepicker">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label class="label-control">Order No#</label><br>
                                                        <input type="text" name="order_no" class="form-control">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="label-control">Write File Name</label><br>
                                                        <input type="text" name="file_name" class="form-control" placeholder="Write File Name*">
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
        </section>
    </div>
@include('admin.layouts.footer')