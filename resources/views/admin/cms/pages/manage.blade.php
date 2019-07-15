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
                                        <h4 class="form-section">Manage Pages</h4>
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
                                        		<a href="{{ route('add_pages') }}"><i class="ft-plus"></i> Add</a>
                                    		</div>
                                    		<div class="col-md-1" id="filter_button">
                                    			<a href="javascript::void(0);" id="add_filter"><i class="ft-filter"></i> Filter</a>
                                                <input type="hidden" id="search_url" value="{{ route('search_pages') }}">
                                    		</div>
                                    	</div>
                                    	<div id="filter_section"></div>
                                    </div><br><br>
                                    <div class="table-responsive">          
  										<table class="table">
											<thead>
			                                    <tr>
                                                    <th>Name</th>
			                                        <th>Slug</th>
			                                        <th>Status</th>
			                                        <th>Action</th>
			                                    </tr>
			                                </thead>
			                                <tbody>
                                                @if(!empty($query))
                                                    @foreach($query as $row)
        			                                    <tr>
                                                            <td>{{ $row->title }}</td>
        				                                    <td>{{ $row->slug }}</td>
        				                                    <td>
                                                                <label class="switch">
                                                                    <a href="{{ url('/user/admin/cms/pages/update-status/'.$row->id.'/'.$row->status) }}">
                                                                        <input type="checkbox" id="status" class="form-control" @if($row->status == 0) checked @endif>
                                                                        <span class="slider"></span>
                                                                    </a>
                                                                </label>
                                                            </td>
        				                                    <td>
        				                                    	<div role="group" class="btn-group">
        														    <button id="btnGroupDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-outline-primary dropdown-toggle dropdown-menu-right"><i class="ft-edit icon-left"></i> Action</button>
        														    <div aria-labelledby="btnGroupDrop1" class="dropdown-menu">
        														    	<a href="{{ route('edit_pages', $row->id) }}" class="dropdown-item">Edit</a>
        														    	<a href="{{ route('delete_pages', $row->id) }}" class="dropdown-item">Delete</a>
        														    </div>
        														</div>
        													</td>
        				                               	</tr>
                                                    @endforeach
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