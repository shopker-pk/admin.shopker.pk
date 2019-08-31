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
                                        <h4 class="form-section">Manage Account Statment</h4>
                                        <div class="row">
                                        	<div class="col-md-9"></div>
                                    		<div class="col-md-1" id="filter_button">
                                    			<a href="javascript::void(0);" id="add_filter"><i class="ft-filter"></i> Filter</a>
                                                <input type="hidden" id="search_url" value="{{ route('search_account_statement') }}">
                                    		</div>
                                            <div class="col-md-1">
                                                <a href="{{ url('/user/admin/finance/account-statement/download-pdf?'.'from='.Request::input('from').'&to='.Request::input('to').'') }}">PDF</a>
                                            </div>
                                            <div class="col-md-1">
                                                <a class="export_account_statement" href="javascript::void(0);" class="">Export</a>
                                            </div>
                                    	</div>
                                    	<div id="filter_section"></div>
                                    </div><br><br>
                                    <div class="row">
                                        <div class="col-md-1"></div>
                                        <div class="col-md-10">
                                            <div class="panel-body" style="border: 1px solid #ccc; margin-top: 50px; overflow: hidden; box-shadow: 1px 3px 10px 4px #E1E1DD;">
                                                <div class="row" style="margin-top: 40px;">
                                                    <div class="col-md-1"></div>
                                                    <div class="col-md-2">
                                                        <h4><b>Order Payment</b></h4>
                                                    </div>
                                                    <div class="col-md-8">

                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="paymentitems">
                                                                    <span class="itemsofpayment">Item Charges</span><br/>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6"></div>
                                                            <div class="col-md-3" id="contenright">
                                                                <span class="price1">@if(!empty($query['total_earning'])) {{ $query['total_earning'] }} @lese 00.00 @endif PKR</span><br/>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="paymentitems">
                                                                    <span class="itemsofpayment">Shopker Fees</span><br/>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6"></div>
                                                            <div class="col-md-3" id="contenright">
                                                                <div class="paymentitems">
                                                                    <span class="price1">- @if(!empty($query['total_commission'])) {{ $query['total_commission'] }} @else 00.00 @endif PKR</span><br/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <hr style="border: 1px solid #888888"/>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <span class="price1">Subtotal</span>    
                                                            </div>
                                                            <div class="col-md-2"></div>
                                                            <div class="col-md-7" id="contenright" style="padding-left: 210px;">
                                                                <span class="price1">@if(!empty($query['sub_total'])) {{ $query['sub_total'] }} @else 00.00 @endif PKR</span>   
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr style="border: 1px solid #888888"/>
                                                <div class="row">
                                                    <div class="col-md-1"></div>
                                                    <div class="col-md-2">
                                                        <h4 style="margin-top:0px;"><b>Closing Balance</b></h4>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <span class="price1">Total Balance</span>
                                                    </div>
                                                    <div class="col-md-2"></div>
                                                    <div class="col-md-4" id="contenright" style="padding-left: 160px;">
                                                        <span class="price1">@if(!empty($query['sub_total'])) {{ $query['sub_total'] }} @else 00.00 @endif PKR</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- Export Account Statment -->
                            <div class="modal fade text-left" id="export_account_statement" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <label class="modal-title text-text-bold-600" id="myModalLabel33">Export Account Statment</label>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('export_account_statement') }}" method="post" enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label class="label-control">From Date</label><br>
                                                        <input type="text" name="from_date" class="form-control datepicker">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="label-control">End Date</label><br>
                                                        <input type="text" id="end_date" class="form-control datepicker">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
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