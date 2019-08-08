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
                                        <h4 class="form-section">Manage Child Categories</h4>
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
                                        		<a href="{{ route('add_child_categories') }}"><i class="ft-plus"></i> Add</a>
                                    		</div>
                                    		<div class="col-md-1" id="filter_button">
                                    			<a href="javascript::void(0);" id="add_filter"><i class="ft-filter"></i> Filter</a>
                                                <input type="hidden" id="search_url" value="{{ route('search_child_categories') }}">
                                    		</div>
                                    	</div>
                                    	<div id="filter_section"></div>
                                    </div><br><br>
                                    <div class="table-responsive">          
  										<table class="table">
											<thead>
			                                    <tr>
			                                        <th>Parent Name</th>
                                                    <th>Child Name</th>
                                                    <th>Sorting Order</th>
			                                        <th>Status</th>
			                                        <th>Action</th>
			                                    </tr>
			                                </thead>
			                                <tbody>
                                                @if(!empty($query))
                                                    @foreach($query as $row)
                                                        <tr>
        				                                    <td>{{ $row->parent_name }}</td>
                                                            <td>{{ $row->child_name }}</td>
                                                            <td>{{ $row->sorting_order }}</td>
        				                                    <td>
                                                                <label class="switch">
                                                                    <a href="{{ url('/user/admin/ecommerce/categories/child/ajax/update-status/'. $row->id.'/'. $row->status) }}">
                                                                        <input type="checkbox" id="status" class="form-control" @if($row->status == 0) checked @endif>
                                                                        <span class="slider"></span>
                                                                    </a>
                                                                </label>
                                                            </td>
        				                                    <td>
        				                                    	<div role="group" class="btn-group">
        														    <button id="btnGroupDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-outline-primary dropdown-toggle dropdown-menu-right"><i class="ft-edit icon-left"></i> Action</button>
        														    <div aria-labelledby="btnGroupDrop1" class="dropdown-menu">
        														    	<a href="{{ route('edit_child_categories', $row->id) }}" class="dropdown-item">Edit</a>
        														    	<a href="{{ route('delete_child_categories', $row->id) }}" class="dropdown-item">Delete</a>
        														    </div>
        														</div>
        													</td>
        				                               	</tr>
                                                    @endforeach
                                                @else
                                                    No Data Found
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