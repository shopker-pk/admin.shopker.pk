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
                                        <h4 class="form-section">Manage Order Reviews</h4>
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
                                                <input type="hidden" id="search_url" value="{{ route('search_order_reviews') }}">
                                    		</div>
                                    	</div>
                                    	<div id="filter_section"></div>
                                    </div><br><br>
                                    <div class="table-responsive">          
  										<table class="table">
											<thead>
			                                    <tr>
			                                        <th>Order NO#</th>
                                                    <th>Order Review</th>
                                                    <th>Reply</th>
			                                    </tr>
			                                </thead>
			                                <tbody>
                                                @if(!empty($query))
                                                    @foreach($query as $row)
        			                                    <tr>
                                                            <td>{{ $row->order_no }}</td>
                                                            <td>
                                                                <span>
                                                                    @if($row->buyer_stars == 1)
                                                                        <img src="{{ asset('public/assets/admin/images/icons/star1.png') }}" style="width:12px; height:12px">
                                                                    @elseif($row->buyer_stars == 2)
                                                                        <img src="{{ asset('public/assets/admin/images/icons/star1.png') }}" style="width:12px; height:12px">
                                                                        <img src="{{ asset('public/assets/admin/images/icons/star1.png') }}" style="width:12px; height:12px">
                                                                    @elseif($row->buyer_stars == 3)
                                                                        <img src="{{ asset('public/assets/admin/images/icons/star1.png') }}" style="width:12px; height:12px">
                                                                        <img src="{{ asset('public/assets/admin/images/icons/star1.png') }}" style="width:12px; height:12px">
                                                                        <img src="{{ asset('public/assets/admin/images/icons/star1.png') }}" style="width:12px; height:12px">
                                                                    @elseif($row->buyer_stars == 4)
                                                                        <img src="{{ asset('public/assets/admin/images/icons/star1.png') }}" style="width:12px; height:12px">
                                                                        <img src="{{ asset('public/assets/admin/images/icons/star1.png') }}" style="width:12px; height:12px">
                                                                        <img src="{{ asset('public/assets/admin/images/icons/star1.png') }}" style="width:12px; height:12px">
                                                                        <img src="{{ asset('public/assets/admin/images/icons/star1.png') }}" style="width:12px; height:12px">
                                                                    @elseif($row->buyer_stars == 5)
                                                                        <img src="{{ asset('public/assets/admin/images/icons/star1.png') }}" style="width:12px; height:12px">
                                                                        <img src="{{ asset('public/assets/admin/images/icons/star1.png') }}" style="width:12px; height:12px">
                                                                        <img src="{{ asset('public/assets/admin/images/icons/star1.png') }}" style="width:12px; height:12px">
                                                                        <img src="{{ asset('public/assets/admin/images/icons/star1.png') }}" style="width:12px; height:12px">
                                                                        <img src="{{ asset('public/assets/admin/images/icons/star1.png') }}" style="width:12px; height:12px">
                                                                    @elseif($row->buyer_stars == 0)
                                                                        0 Stars
                                                                    @endif
                                                                </span><br>
                                                                <span>{{ $row->first_name }} {{ $row->last_name }} - {{ date('D-M-Y g:i:s A', strtotime($row->buyer_review_created_date.' '.$row->buyer_review_created_time)) }}</span><br>
                                                                <span>{{ $row->buyer_comment }}</span>
                                                            </td>
                                                            <td>
                                                                @if($row->vendor_comment != '')
                                                                    <span>{{ date('D-M-Y g:i:s A', strtotime($row->vendor_review_created_date.' '.$row->vendor_review_created_time)) }}</span><br>
                                                                <span>{{ $row->vendor_comment }}</span>
                                                                @else
                                                                    <a href="javascript::void(0);" class="dropdown-item" data-toggle="modal" data-target="#reply_{{ $row->order_no }}">Reply</a>
                                                                @endif
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
                                <!-- Add Order Review Modal -->
                                @if(!empty($query)) 
                                    @foreach($query as $row)
                                        <div class="modal fade text-left" id="reply_{{ $row->order_no }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" style="display: none;" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <label class="modal-title text-text-bold-600" id="myModalLabel33">Order NO# : {{ $row->order_no }}</label><br>
                                                        <label class="modal-title text-text-bold-600" id="myModalLabel35">Customer Name : {{ $row->first_name }} {{ $row->last_name }}</label>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>
                                                    <form action="{{ route('reply_order_reviews', $row->order_no) }}" method="post">
                                                        {{ csrf_field() }}
                                                        <div class="modal-body">
                                                            <label class="label-control">Comment</label>
                                                            <br>
                                                            <textarea type="text" name="comment" id="comment" class="form-control" rows="5"></textarea>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary">
                                                                <i class="fa fa-check-square-o"></i> Add
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach 
                                @endif
                                <!-- Add Order Review End -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@include('admin.layouts.footer')