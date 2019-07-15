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
                                        <h4 class="form-section">Manage Variations</h4>
                                        <div class="row">
                                        	<div class="col-md-8">
                                                @if($total_records > 1)
                                                    Total {{ $total_records }} Record Found
                                                @elseif($total_records == 1)
                                                    Total {{ $total_records }} Record Found
                                                @else
                                                    No records found
                                                @endif  
                                        	</div>
                                            <div class="col-md-1">
                                                <a class="export_variations" href="javascript::void(0);" class="fa fa-file-excel-o">
                                                    Export
                                                </a>
                                            </div>
                                            <div class="col-md-1">
                                                <a class="import_variations" href="javascript::void(0);" class="fa fa-file-excel-o">
                                                    Import
                                                </a>
                                            </div>
                                        	<div class="col-md-1">
                                        		<a href="{{ route('add_variations') }}"><i class="ft-plus"></i> Add</a>
                                    		</div>
                                    		<div class="col-md-1" id="filter_button">
                                    			<a href="javascript::void(0);" id="add_filter"><i class="ft-filter"></i> Filter</a>
                                                <input type="hidden" id="search_url" value="{{ route('search_variations') }}">
                                    		</div>
                                    	</div>
                                    	<div id="filter_section"></div>
                                    </div><br><br>
                                    <div class="table-responsive">          
  										<table class="table">
											<thead>
			                                    <tr>
			                                        <th>Name</th>
			                                        <th>Status</th>
			                                        <th>Action</th>
			                                    </tr>
			                                </thead>
			                                <tbody>
                                                @if(!empty($query))
                                                    @foreach($query as $row)
        			                                    <tr>
        				                                    <td>{{ $row->label }}</td>
        				                                    <td>
                                                                <label class="switch">
                                                                    <a href="{{ url('/user/admin/ecommerce/variations/ajax/update-status/'. $row->id.'/'. $row->status) }}">
                                                                        <input type="checkbox" id="status" class="form-control" @if($row->status == 0) checked @endif>
                                                                        <span class="slider"></span>
                                                                    </a>
                                                                </label>         
                                                            </td>
        				                                    <td>
        				                                    	<div role="group" class="btn-group">
        														    <button id="btnGroupDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-outline-primary dropdown-toggle dropdown-menu-right"><i class="ft-edit icon-left"></i> Action</button>
        														    <div aria-labelledby="btnGroupDrop1" class="dropdown-menu">
        														    	<a href="{{ route('edit_variations', $row->label) }}" class="dropdown-item">Edit</a>
        														    	<a href="{{ route('delete_variations', $row->label) }}" class="dropdown-item">Delete</a>
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

                                <!-- Import Variations -->
                                <div class="modal fade text-left" id="import_variations" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <label class="modal-title text-text-bold-600" id="myModalLabel33">Import Variations</label>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <form action="{{ route('import_variations') }}" method="post" enctype="multipart/form-data">
                                                {{ csrf_field() }}
                                                <div class="modal-body">
                                                    <label class="label-control">Select File</label><br>
                                                    <input type="file" name="file">
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

                                <!-- Export Variations -->
                                <div class="modal fade text-left" id="export_variations" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <label class="modal-title text-text-bold-600" id="myModalLabel33">Export Variations</label>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <form action="{{ route('export_variations') }}" method="post" enctype="multipart/form-data">
                                                {{ csrf_field() }}
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label class="label-control">Select Variation</label><br>
                                                            <select id="label" name="label" class="form-control select_2" style="width: 100%">
                                                                @if(!empty($query))
                                                                    @foreach($query as $row)
                                                                        <option value="{{ $row->label }}">{{ $row->label }}</option>
                                                                    @endforeach
                                                                @endif
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

                                <!-- Per Page Items -->
                                <div class="row">
                                    <div class="col-md-11"></div>
                                    <div class="col-md-1">
                                        <select class="form-control select_2" id="per_page">
                                            <option value="10">10</option>
                                            <option value="20">20</option>
                                            <option value="30">30</option>
                                            <option value="40">40</option>
                                            <option value="50">50</option>
                                        </select>
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