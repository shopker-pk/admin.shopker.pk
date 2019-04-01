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
                                        <h4 class="form-section">Manage Vendors</h4>
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
                                                <input type="hidden" id="search_url" value="{{ route('search_vendors') }}">
                                    		</div>
                                    	</div>
                                    	<div id="filter_section"></div>
                                    </div><br><br>
                                    <div class="table-responsive">          
  										<table class="table">
											<thead>
			                                    <tr>
			                                        <th>Image</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
			                                        <th>Status</th>
			                                        <th>Action</th>
			                                    </tr>
			                                </thead>
			                                <tbody>
                                                @if(!empty($query))
                                                    @foreach($query as $row)
        			                                    <tr>
        				                                    <td><img src="{{ asset('public/assets/admin/images/profile_images/'.$row->image) }}" class="m_image" alt="User Profile Image"></td>
                                                            <td>{{ $row->first_name }} {{ $row->last_name }}</td>
        				                                    <td>{{ $row->email }}</td>
        				                                    <td>
                                                                <label class="switch">
                                                                    <a href="{{ url('/user/admin/crm/vendors/update-status/'.$row->id.'/'.$row->status) }}">
                                                                        <input type="checkbox" id="status" class="form-control" @if($row->status == 0) checked @endif>
                                                                        <span class="slider"></span>
                                                                    </a>
                                                                </label>                  
                                                            </td>
        				                                    <td>
        				                                    	<div role="group" class="btn-group">
        														    <button id="btnGroupDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-outline-primary dropdown-toggle dropdown-menu-right"><i class="ft-edit icon-left"></i> Action</button>
        														    <div aria-labelledby="btnGroupDrop1" class="dropdown-menu">
                                                                        <a href="javascript::void(0);" class="dropdown-item" data-toggle="modal" data-target="#vendor_status_{{ $row->id }}">Edit Status</a>
        														    	<a href="javascript::void(0);" class="dropdown-item" data-toggle="modal" data-target="#vendor_details_{{ $row->id }}">View Details</a>
                                                                        <a href="javascript::void(0);" class="dropdown-item" data-toggle="modal" data-target="#assign_commission_{{ $row->id }}">Edit Commision</a>
        														    </div>
        														</div>
        													</td>
        				                               	</tr>
                                                    @endforeach
                                                @endif
			                               	</tbody>
										</table>
									</div>
                                    {{ $query->links() }}
                                </form>
                                @if(!empty($query))
                                    @foreach($query as $row)
                                        <!-- Edit Vendor Status Modal Start -->
                                            <div class="modal fade text-left" id="vendor_status_{{ $row->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" style="display: none;" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <label class="Vendor-title text-text-bold-600" id="myModalLabel33">Vendor Name : {{ $row->first_name }} {{ $row->last_name }}</label>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>
                                                        <form action="{{ route('update_customers', $row->id) }}" method="post">
                                                            {{ csrf_field() }}
                                                            <div class="modal-body">
                                                                <label class="modal-title text-text-bold-600" id="myModalLabel33">Vendor Email : {{ $row->email }}</label><br><br>
                                                                <label class="label-control">Vendor Status</label><br>
                                                                <select id="status" name="status" class="form-control select_2" style="width:100%">
                                                                    <option value="0" @if($row->status == 0) selected @endif>Active</option>
                                                                    <option value="1" @if($row->status == 1) selected @endif>Inactive</option>
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
                                        <!-- Edit Vendor Status Modal End -->

                                        <!-- Manage Vendor Details Modal Start -->
                                            <div class="modal fade text-left" id="vendor_details_{{ $row->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" style="display: none;" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <label class="modal-title text-text-bold-600" id="myModalLabel33">Vendor Name : {{ $row->first_name }} {{ $row->last_name }}</label>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <span>Name :</span>
                                                                    <span>{{ $row->first_name }} {{ $row->last_name }}</span>
                                                                    <br>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <span>CNIC# :</span>
                                                                    <span>{{ $row->cnic }}</span>
                                                                    <br>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <span>Phone # :</span>
                                                                    <span>{{ $row->phone_no }}</span>
                                                                    <br>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <span>Email :</span>
                                                                    <span>{{ $row->email }}</span>
                                                                    <br>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <span>Address :</span>
                                                                    <span>{{ $row->address }}</span>
                                                                    <br>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <span>Country :</span>
                                                                    <span>{{ $row->country_name }}</span>
                                                                    <br>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <span>City :</span>
                                                                    <span>{{ $row->city_name }}</span>
                                                                    <br>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <span>Status :</span>
                                                                    @if($row->status == 0)
                                                                        <span class="badge badge-default badge-success">Active</span>
                                                                    @elseif($row->status == 1)
                                                                        <span class="badge badge-default badge-danger">Inactive</span>
                                                                    @endif 
                                                                    <br>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <!-- Manage Vendor Details Modal End -->

                                        <!-- Edit Vendor Commision Modal Start -->
                                            <div class="modal fade text-left" id="assign_commission_{{ $row->id }}" role="dialog" aria-labelledby="myModalLabel33" style="display: none;" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <label class="Vendor-title text-text-bold-600" id="myModalLabel33">Vendor Name : {{ $row->first_name }} {{ $row->last_name }}</label>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>
                                                        <form action="{{ route('add_commission', $row->id) }}" method="post">
                                                            {{ csrf_field() }}
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label class="label-control">Select Commission Type</label>
                                                                            <label class="label-control" style="color:red">*</label>
                                                                            <select id="commision_type" name="commision_type" class="form-control select_2" style="width:100%">
                                                                                <option>Select Commission Type</option>
                                                                                <option value="0">Total Commission</option>
                                                                                <option value="1">Category Wise Commission</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div id="additional_divs"></div>
                                                                <div id="add_btn"></div>
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
                                        <!-- Edit Vendor Commision Modal End -->
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