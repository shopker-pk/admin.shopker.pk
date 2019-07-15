$(document).ready(function(){
	//Add Variation Values For Create Variations Start
		//show box
		$(document).on('click', '#add_values', function(){
			$('#values_section').append('<input type="text" id="value" name="value[]" class="form-control" placeholder="Variation Values">'
			+'<a href="javascript::void(0);" style="color: red" id="remove_row">'
			+'<i class="ft-minus"> Remove</i></a>');
		});

		//Remove Box
		$(document).on('click', '#remove_row', function(){
			if(confirm('Are you sure, you want to remove this input?')){
				$(this).prev().remove(); 
				$(this).remove();
			}
		});
	//Add Variation For Create Variations Values End

	//Add Variation For Products Start
		//show label input
		$(document).on('click', '#add_variations', function(){
			$.ajax({
	            url : document.location.href.split('add')[0].toString()+'variations/ajax-variation-labels',
	            method : 'GET',
	            success:function(response){
	                json_data = $.parseJSON(response);
	                if(json_data.ERROR == false){
	                	$('#variations').append(json_data.DATA);
	                    $('.select_2').select2();
	                    $('.advertise_datepicker').datepicker();
	                }else{
	                    $('#variations').append(json_data.DATA);
	                    $('.select_2').select2();
	                    $('.advertise_datepicker').datepicker();
                 	}
	            }
	        });
		});

		//remove label input
		$(document).on('click', '#remove_variation', function(){
			if(confirm('Are you sure, you want to remove this input?')){
				$(this).closest('div.main').remove();
			}
		});
	//Add Variation For Products End

	//Getting child categories by parent category id start
		$(document).on('change', '#parent_category', function(){
			if(document.location.href.split('ecommerce')[1] == '/categories/sub-child/add'){
				var url = document.location.href.split('ecommerce')[0].toString()+'ecommerce/categories/ajax-get-child-categories/'+$(this).val();
			}else if(document.location.href.split('edit')[0] == document.location.href.split('edit')[0]){
				var url = document.location.href.split('ecommerce')[0].toString()+'ecommerce/categories/ajax-get-child-categories/'+$(this).val();
			}else if(document.location.href.split('ecommerce')[1] == '/products/get-child-categories'){
				var url = document.location.href.split('ecommerce')[0].toString()+'ecommerce/products/get-child-categories/'+$(this).val();
			}

			$.ajax({
				url : url,
				method : 'GET',
				success:function(response){
					json_data = $.parseJSON(response);
					if(json_data.ERROR == 'FALSE'){
						$('#child_category').html(json_data.DATA);
					}else if(json_data.ERROR == 'TRUE'){
						$('#child_category').html('<option value="0">No child category found !!</option>');
					}
				}
			});
		});
	//Getting child categories by parent category id end

	//Getting sub child categories by child category id start
		$(document).on('change', '#child_category', function(){
			$.ajax({
				url : document.location.href.split('ecommerce')[0].toString()+'ecommerce/products/get-sub-child-categories/'+$(this).val(),
				method : 'GET',
				success:function(response){
					json_data = $.parseJSON(response);
					if(json_data.ERROR == 'FALSE'){
						$('#sub_child_category').html(json_data.DATA);
					}else if(json_data.ERROR == 'TRUE'){
						$('#sub_child_category').html('<option value="0">No sub child category found !!</option>');
					}
				}
			});
		});
	//Getting sub child categories by child category id end
	
	//Update Product Status Start
	$(document).on('click', '#status', function(){
		var id = $(this).attr('data-id');
		if($(this).is(':checked') == true){
			$('#'+id).val(0);
		}else{
			$('#'+id).val(1);
		}
	});
	//Update Product Status End

	//Filter Section Start
		//Show Filter
		$(document).on('click', '#add_filter', function(){
            var current_url = $('#search_url').val();
            if(window.location.pathname.split('/user/admin')[1] == '/ecommerce/categories/parent/manage'){
            	$('#filter_section').append('<form action='+current_url+' method="get"><div class="row"><div class="col-md-7"></div>'
					+'<div class="col-md-2"><input type="text" id="name" name="name" class="form-control" placeholder="Category Name"></div>'
					+'<div class="col-md-2"><select id="status" name="status" class="custom-select block select_2"><option value="0">Active</option><option value="1">Inactive</option></select></div>'
					+'<div class="col-md-1"><button type="submit" class="btn btn-primary"><i class="ft-search"></i></button></div>'
					+'</div></form>'
				);
				$('#add_filter').remove();
				$('#filter_button').append('<a href="javascript::void(0)" id="remove_filter"> X</a>');
            }else if(window.location.pathname.split('/user/admin')[1] == '/ecommerce/categories/parent/search'){
            	$('#filter_section').append('<form action='+current_url+' method="get"><div class="row"><div class="col-md-7"></div>'
					+'<div class="col-md-2"><input type="text" id="name" name="name" class="form-control" placeholder="Category Name"></div>'
					+'<div class="col-md-2"><select id="status" name="status" class="custom-select block select_2"><option value="0">Active</option><option value="1">Inactive</option></select></div>'
					+'<div class="col-md-1"><button type="submit" class="btn btn-primary"><i class="ft-search"></i></button></div>'
					+'</div></form>'
				);
				$('#add_filter').remove();
				$('#filter_button').append('<a href="javascript::void(0)" id="remove_filter"> X</a>');
            }else if(window.location.pathname.split('/user/admin')[1] == '/ecommerce/categories/child/manage'){
            	$('#filter_section').append('<form action='+current_url+' method="get"><div class="row"><div class="col-md-5"></div>'
					+'<div class="col-md-2"><input type="text" id="name" name="name" class="form-control" placeholder="Category Name"></div>'
					+'<div class="col-md-2"><input type="text" id="parent_name" name="parent_name" class="form-control" placeholder="Parent Name"></div>'
					+'<div class="col-md-2"><select id="status" name="status" class="custom-select block select_2"><option value="0">Active</option><option value="1">Inactive</option></select></div>'
					+'<div class="col-md-1"><button type="submit" class="btn btn-primary"><i class="ft-search"></i></button></div>'
					+'</div></form>'
				);
				$('#add_filter').remove();
				$('#filter_button').append('<a href="javascript::void(0)" id="remove_filter"> X</a>');
            }else if(window.location.pathname.split('/user/admin')[1] == '/ecommerce/categories/child/search'){
            	$('#filter_section').append('<form action='+current_url+' method="get"><div class="row"><div class="col-md-7"></div>'
					+'<div class="col-md-2"><input type="text" id="name" name="name" class="form-control" placeholder="Category Name"></div>'
					+'<div class="col-md-2"><select id="status" name="status" class="custom-select block select_2"><option value="0">Active</option><option value="1">Inactive</option></select></div>'
					+'<div class="col-md-1"><button type="submit" class="btn btn-primary"><i class="ft-search"></i></button></div>'
					+'</div></form>'
				);
				$('#add_filter').remove();
				$('#filter_button').append('<a href="javascript::void(0)" id="remove_filter"> X</a>');
            }else if(window.location.pathname.split('/user/admin')[1] == '/ecommerce/categories/sub-child/manage'){
            	$('#filter_section').append('<form action='+current_url+' method="get"><div class="row"><div class="col-md-3"></div>'
					+'<div class="col-md-2"><input type="text" id="parent_name" name="parent_name" class="form-control" placeholder="Parent Name"></div>'
					+'<div class="col-md-2"><input type="text" id="child_name" name="child_name" class="form-control" placeholder="Child Name"></div>'
					+'<div class="col-md-2"><input type="text" id="name" name="name" class="form-control" placeholder="Category Name"></div>'
					+'<div class="col-md-2"><select id="status" name="status" class="custom-select block select_2"><option value="0">Active</option><option value="1">Inactive</option></select></div>'
					+'<div class="col-md-1"><button type="submit" class="btn btn-primary"><i class="ft-search"></i></button></div>'
					+'</div></form>'
				);
				$('#add_filter').remove();
				$('#filter_button').append('<a href="javascript::void(0)" id="remove_filter"> X</a>');
            }else if(window.location.pathname.split('/user/admin')[1] == '/ecommerce/categories/sub-child/search'){
            	$('#filter_section').append('<form action='+current_url+' method="get"><div class="row"><div class="col-md-3"></div>'
					+'<div class="col-md-2"><input type="text" id="parent_name" name="parent_name" class="form-control" placeholder="Parent Name"></div>'
					+'<div class="col-md-2"><input type="text" id="child_name" name="child_name" class="form-control" placeholder="Child Name"></div>'
					+'<div class="col-md-2"><input type="text" id="name" name="name" class="form-control" placeholder="Category Name"></div>'
					+'<div class="col-md-2"><select id="status" name="status" class="custom-select block select_2"><option value="0">Active</option><option value="1">Inactive</option></select></div>'
					+'<div class="col-md-1"><button type="submit" class="btn btn-primary"><i class="ft-search"></i></button></div>'
					+'</div></form>'
				);
				$('#add_filter').remove();
				$('#filter_button').append('<a href="javascript::void(0)" id="remove_filter"> X</a>');
            }else if(window.location.pathname.split('/user/admin')[1] == '/ecommerce/brands/manage'){
            	$('#filter_section').append('<form action='+current_url+' method="get"><div class="row"><div class="col-md-7"></div>'
					+'<div class="col-md-2"><input type="text" id="name" name="name" class="form-control" placeholder="Brand Name"></div>'
					+'<div class="col-md-2"><select id="status" name="status" class="custom-select block select_2"><option value="0">Active</option><option value="1">Inactive</option></select></div>'
					+'<div class="col-md-1"><button type="submit" class="btn btn-primary"><i class="ft-search"></i></button></div>'
					+'</div></form>'
				);
				$('#add_filter').remove();
				$('#filter_button').append('<a href="javascript::void(0)" id="remove_filter"> X</a>');
            }else if(window.location.pathname.split('/user/admin')[1] == '/ecommerce/brands/search'){
            	$('#filter_section').append('<form action='+current_url+' method="get"><div class="row"><div class="col-md-7"></div>'
					+'<div class="col-md-2"><input type="text" id="name" name="name" class="form-control" placeholder="Brand Name"></div>'
					+'<div class="col-md-2"><select id="status" name="status" class="custom-select block select_2"><option value="0">Active</option><option value="1">Inactive</option></select></div>'
					+'<div class="col-md-1"><button type="submit" class="btn btn-primary"><i class="ft-search"></i></button></div>'
					+'</div></form>'
				);
				$('#add_filter').remove();
				$('#filter_button').append('<a href="javascript::void(0)" id="remove_filter"> X</a>');
            }else if(window.location.pathname.split('/user/admin')[1] == '/ecommerce/variations/manage'){
            	$('#filter_section').append('<form action='+current_url+' method="get"><div class="row"><div class="col-md-7"></div>'
					+'<div class="col-md-2"><input type="text" id="name" name="name" class="form-control" placeholder="Variation Name"></div>'
					+'<div class="col-md-2"><select id="status" name="status" class="custom-select block select_2"><option value="0">Active</option><option value="1">Inactive</option></select></div>'
					+'<div class="col-md-1"><button type="submit" class="btn btn-primary"><i class="ft-search"></i></button></div>'
					+'</div></form>'
				);
				$('#add_filter').remove();
				$('#filter_button').append('<a href="javascript::void(0)" id="remove_filter"> X</a>');
            }else if(window.location.pathname.split('/user/admin')[1] == '/ecommerce/variations/search'){
            	$('#filter_section').append('<form action='+current_url+' method="get"><div class="row"><div class="col-md-7"></div>'
					+'<div class="col-md-2"><input type="text" id="name" name="name" class="form-control" placeholder="Variation Name"></div>'
					+'<div class="col-md-2"><select id="status" name="status" class="custom-select block select_2"><option value="0">Active</option><option value="1">Inactive</option></select></div>'
					+'<div class="col-md-1"><button type="submit" class="btn btn-primary"><i class="ft-search"></i></button></div>'
					+'</div></form>'
				);
				$('#add_filter').remove();
				$('#filter_button').append('<a href="javascript::void(0)" id="remove_filter"> X</a>');
            }else if(window.location.pathname.split('/user/admin')[1] == '/ecommerce/products/manage'){
            	$('#filter_section').append('<form action='+current_url+' method="get"><div class="row"><div class="col-md-7"></div>'
					+'<div class="col-md-2"><input type="text" id="name" name="name" class="form-control" placeholder="Product name"></div>'
					+'<div class="col-md-2"><input type="text" id="sku" name="sku" class="form-control" placeholder="Product SKU"></div>'
					+'<div class="col-md-1"><button type="submit" class="btn btn-primary"><i class="ft-search"></i></button></div>'
					+'</div></form>'
				);
				$('#add_filter').remove();
				$('#filter_button').append('<a href="javascript::void(0)" id="remove_filter"> X</a>');
            }else if(window.location.pathname.split('/user/admin')[1] == '/ecommerce/products/search'){
            	$('#filter_section').append('<form action='+current_url+' method="get"><div class="row"><div class="col-md-7"></div>'
					+'<div class="col-md-2"><input type="text" id="name" name="name" class="form-control" placeholder="Product name"></div>'
					+'<div class="col-md-2"><input type="text" id="sku" name="sku" class="form-control" placeholder="Product SKU"></div>'
					+'<div class="col-md-1"><button type="submit" class="btn btn-primary"><i class="ft-search"></i></button></div>'
					+'</div></form>'
				);
				$('#add_filter').remove();
				$('#filter_button').append('<a href="javascript::void(0)" id="remove_filter"> X</a>');
            }else if(window.location.pathname.split('/user/admin')[1] == '/orders/manage'){
            	$('#filter_section').append('<br><form action='+current_url+' method="get"><div class="row">'
					+'<div class="col-md-2"><input type="text" id="order_no" name="order_no" class="form-control" placeholder="Order NO#"></div>'
					+'<div class="col-md-2">'
						+'<select id="payment_type" name="payment_type" class="custom-select block select_2">'
							+'<option value="0">Paid</option>'
							+'<option value="1">Un Paid</option>'
						+'</select>'
					+'</div>'
					+'<div class="col-md-2">'
						+'<select id="status" name="status" class="custom-select block select_2">'
							+'<option value="0">Pending</option>'
							+'<option value="1">In Process</option>'
							+'<option value="2">Ready to Ship</option>'
							+'<option value="3">Shiped</option>'
							+'<option value="4">Delivered</option>'
							+'<option value="5">Canceled</option>'
						+'</select>'
					+'</div>'
					+'<div class="col-md-2"><input type="text" id="from_date" name="from_date" class="form-control datepicker" style="height:42px" placeholder="From Date"></div>'
					+'<div class="col-md-2"><input type="text" id="to_date" name="to_date" class="form-control datepicker" style="height:42px" placeholder="To Date"></div>'
					+'<div class="col-md-2"><button type="submit" class="btn btn-primary"><i class="ft-search"></i></button></div>'
					+'</div></form>'
				);
				$('#add_filter').remove();
				$('#filter_button').append('<a href="javascript::void(0)" id="remove_filter"> X</a>');
            }else if(window.location.pathname.split('/user/admin')[1] == '/orders/search'){
            	$('#filter_section').append('<br><form action='+current_url+' method="get"><div class="row">'
					+'<div class="col-md-2"><input type="text" id="order_no" name="order_no" class="form-control" placeholder="Order NO#"></div>'
					+'<div class="col-md-2">'
						+'<select id="payment_type" name="payment_type" class="custom-select block select_2">'
							+'<option value="0">Paid</option>'
							+'<option value="1">Un Paid</option>'
						+'</select>'
					+'</div>'
					+'<div class="col-md-2">'
						+'<select id="status" name="status" class="custom-select block select_2">'
							+'<option value="0">Pending</option>'
							+'<option value="1">In Process</option>'
							+'<option value="2">Ready to Ship</option>'
							+'<option value="3">Shiped</option>'
							+'<option value="4">Delivered</option>'
							+'<option value="5">Canceled</option>'
						+'</select>'
					+'</div>'
					+'<div class="col-md-2"><input type="text" id="from_date" name="from_date" class="form-control datepicker" style="height:42px" placeholder="From Date"></div>'
					+'<div class="col-md-2"><input type="text" id="to_date" name="to_date" class="form-control datepicker" style="height:42px" placeholder="To Date"></div>'
					+'<div class="col-md-2"><button type="submit" class="btn btn-primary"><i class="ft-search"></i></button></div>'
					+'</div></form>'
				);
				$('#add_filter').remove();
				$('#filter_button').append('<a href="javascript::void(0)" id="remove_filter"> X</a>');
            }else if(window.location.pathname.split('/user/admin')[1] == '/advertisements/banners/manage'){
            	$('#filter_section').append('<br><form action='+current_url+' method="get">'
            		+'<div class="row">'
					+'<div class="col-md-2"></div>'
					+'<div class="col-md-2"></div>'
					+'<div class="col-md-2"><input type="text" id="from_date" name="from_date" class="form-control datepicker" style="height:42px" placeholder="From Date"></div>'
					+'<div class="col-md-2"><input type="text" id="to_date" name="to_date" class="form-control datepicker" style="height:42px" placeholder="End Date"></div>'
					+'<div class="col-md-2"><select id="status" name="status" class="custom-select block select_2"><option value="0">Active</option><option value="1">Inactive</option></select></div>'
					+'<div class="col-md-2"><button type="submit" class="btn btn-primary"><i class="ft-search"></i></button></div>'
					+'</div></form>'
				);
				$('#add_filter').remove();
				$('#filter_button').append('<a href="javascript::void(0)" id="remove_filter"> X</a>');
            }else if(window.location.pathname.split('/user/admin')[1] == '/advertisements/banners/search'){
            	$('#filter_section').append('<br><form action='+current_url+' method="get">'
            		+'<div class="row">'
					+'<div class="col-md-2"></div>'
					+'<div class="col-md-2"></div>'
					+'<div class="col-md-2"><input type="text" id="from_date" name="from_date" class="form-control datepicker" style="height:42px" placeholder="From Date"></div>'
					+'<div class="col-md-2"><input type="text" id="to_date" name="to_date" class="form-control datepicker" style="height:42px" placeholder="End Date"></div>'
					+'<div class="col-md-2"><select id="status" name="status" class="custom-select block select_2"><option value="0">Active</option><option value="1">Inactive</option></select></div>'
					+'<div class="col-md-2"><button type="submit" class="btn btn-primary"><i class="ft-search"></i></button></div>'
					+'</div></form>'
				);
				$('#add_filter').remove();
				$('#filter_button').append('<a href="javascript::void(0)" id="remove_filter"> X</a>');
            }else if(window.location.pathname.split('/user/admin')[1] == '/advertisements/coupons/manage'){
            	$('#filter_section').append('<br><form action='+current_url+' method="get">'
            		+'<div class="row">'
					+'<div class="col-md-6"></div>'
					+'<div class="col-md-4"><input type="text" id="name" name="name" class="form-control" placeholder="Search By Coupon Code"></div>'
					+'<div class="col-md-2"><button type="submit" class="btn btn-primary"><i class="ft-search"></i></button></div>'
					+'</div></form>'
				);
				$('#add_filter').remove();
				$('#filter_button').append('<a href="javascript::void(0)" id="remove_filter"> X</a>');
            }else if(window.location.pathname.split('/user/admin')[1] == '/advertisements/coupons/search'){
            	$('#filter_section').append('<br><form action='+current_url+' method="get">'
            		+'<div class="row">'
					+'<div class="col-md-6"></div>'
					+'<div class="col-md-4"><input type="text" id="name" name="name" class="form-control" placeholder="Search By Coupon Code"></div>'
					+'<div class="col-md-2"><button type="submit" class="btn btn-primary"><i class="ft-search"></i></button></div>'
					+'</div></form>'
				);
				$('#add_filter').remove();
				$('#filter_button').append('<a href="javascript::void(0)" id="remove_filter"> X</a>');
            }else if(window.location.pathname.split('/user/admin')[1] == '/payments/invoices/manage'){
            	$('#filter_section').append('<br><form action='+current_url+' method="get"><div class="row">'
					+'<div class="col-md-2"><input type="text" id="order_no" name="order_no" class="form-control" placeholder="Order NO#"></div>'
					+'<div class="col-md-2">'
						+'<select id="payment_type" name="payment_type" class="custom-select block select_2">'
							+'<option value="0">Paid</option>'
							+'<option value="1">Un Paid</option>'
						+'</select>'
					+'</div>'
					+'<div class="col-md-2">'
						+'<select id="status" name="status" class="custom-select block select_2">'
							+'<option value="0">Pending</option>'
							+'<option value="1">In Process</option>'
							+'<option value="2">Ready to Ship</option>'
							+'<option value="3">Shiped</option>'
							+'<option value="4">Delivered</option>'
							+'<option value="5">Canceled</option>'
						+'</select>'
					+'</div>'
					+'<div class="col-md-2"><input type="text" id="from_date" name="from_date" class="form-control datepicker" style="height:42px" placeholder="From Date"></div>'
					+'<div class="col-md-2"><input type="text" id="to_date" name="to_date" class="form-control datepicker" style="height:42px" placeholder="To Date"></div>'
					+'<div class="col-md-2"><button type="submit" class="btn btn-primary"><i class="ft-search"></i></button></div>'
					+'</div></form>'
				);
				$('#add_filter').remove();
				$('#filter_button').append('<a href="javascript::void(0)" id="remove_filter"> X</a>');
            }else if(window.location.pathname.split('/user/admin')[1] == '/payments/invoices/search'){
            	$('#filter_section').append('<br><form action='+current_url+' method="get"><div class="row">'
					+'<div class="col-md-2"><input type="text" id="order_no" name="order_no" class="form-control" placeholder="Order NO#"></div>'
					+'<div class="col-md-2">'
						+'<select id="payment_type" name="payment_type" class="custom-select block select_2">'
							+'<option value="0">Paid</option>'
							+'<option value="1">Un Paid</option>'
						+'</select>'
					+'</div>'
					+'<div class="col-md-2">'
						+'<select id="status" name="status" class="custom-select block select_2">'
							+'<option value="0">Pending</option>'
							+'<option value="1">In Process</option>'
							+'<option value="2">Ready to Ship</option>'
							+'<option value="3">Shiped</option>'
							+'<option value="4">Delivered</option>'
							+'<option value="5">Canceled</option>'
						+'</select>'
					+'</div>'
					+'<div class="col-md-2"><input type="text" id="from_date" name="from_date" class="form-control datepicker" style="height:42px" placeholder="From Date"></div>'
					+'<div class="col-md-2"><input type="text" id="to_date" name="to_date" class="form-control datepicker" style="height:42px" placeholder="To Date"></div>'
					+'<div class="col-md-2"><button type="submit" class="btn btn-primary"><i class="ft-search"></i></button></div>'
					+'</div></form>'
				);
				$('#add_filter').remove();
				$('#filter_button').append('<a href="javascript::void(0)" id="remove_filter"> X</a>');
            }else if(window.location.pathname.split('/user/admin')[1] == '/crm/customers/manage'){
            	$('#filter_section').append('<br><form action='+current_url+' method="get"><div class="row">'
					+'<div class="col-md-2"><input type="text" id="order_no" name="order_no" class="form-control" placeholder="Order NO#"></div>'
					+'<div class="col-md-2"><select id="payment_type" name="payment_type" class="custom-select block select_2"><option value="0">Paypal</option><option value="1">Stripe</option><option value="2">Bank Transaction</option><option value="3">Cash on delivery</option></select></div>'
					+'<div class="col-md-2"><select id="status" name="status" class="custom-select block select_2"><option value="0">Delivered</option><option value="1">Active</option><option value="2">In Process</option><option value="3">Rejected</option></select></div>'
					+'<div class="col-md-2"><input type="text" id="from_date" name="from_date" class="form-control datepicker" style="height:42px"></div>'
					+'<div class="col-md-2"><input type="text" id="to_date" name="to_date" class="form-control datepicker" style="height:42px"></div>'
					+'<div class="col-md-2"><button type="submit" class="btn btn-primary"><i class="ft-search"></i></button></div>'
					+'</div></form>'
				);
				$('#add_filter').remove();
				$('#filter_button').append('<a href="javascript::void(0)" id="remove_filter"> X</a>');
            }else if(window.location.pathname.split('/user/admin')[1] == '/crm/customers/search'){
            	$('#filter_section').append('<br><form action='+current_url+' method="get"><div class="row">'
					+'<div class="col-md-2"><input type="text" id="order_no" name="order_no" class="form-control" placeholder="Order NO#"></div>'
					+'<div class="col-md-2"><select id="payment_type" name="payment_type" class="custom-select block select_2"><option value="0">Paypal</option><option value="1">Stripe</option><option value="2">Bank Transaction</option><option value="3">Cash on delivery</option></select></div>'
					+'<div class="col-md-2"><select id="status" name="status" class="custom-select block select_2"><option value="0">Delivered</option><option value="1">Active</option><option value="2">In Process</option><option value="3">Rejected</option></select></div>'
					+'<div class="col-md-2"><input type="text" id="from_date" name="from_date" class="form-control datepicker" style="height:42px"></div>'
					+'<div class="col-md-2"><input type="text" id="to_date" name="to_date" class="form-control datepicker" style="height:42px"></div>'
					+'<div class="col-md-2"><button type="submit" class="btn btn-primary"><i class="ft-search"></i></button></div>'
					+'</div></form>'
				);
				$('#add_filter').remove();
				$('#filter_button').append('<a href="javascript::void(0)" id="remove_filter"> X</a>');
            }else if(window.location.pathname.split('/user/admin')[1] == '/advertisements/daily-deals/manage'){
            	$('#filter_section').append('<form action='+current_url+' method="get"><div class="row"><div class="col-md-5"></div>'
					+'<div class="col-md-2"><input type="text" id="name" name="name" class="form-control" placeholder="Product name"></div>'
					+'<div class="col-md-2"><input type="text" id="sku" name="sku" class="form-control" placeholder="Product SKU"></div>'
					+'<div class="col-md-2"><select id="is_daily_deal" name="is_daily_deal" class="form-control select_2"><option value="2">Deals & Products Both</option><option value="0">Active Deals</option><option value="1">All Deals</option></select></div>'
					+'<div class="col-md-1"><button type="submit" class="btn btn-primary"><i class="ft-search"></i></button></div>'
					+'</div></form>'
				);
				$('#add_filter').remove();
				$('#filter_button').append('<a href="javascript::void(0)" id="remove_filter"> X</a>');
            }else if(window.location.pathname.split('/user/admin')[1] == '/advertisements/daily-deals/search'){
            	$('#filter_section').append('<form action='+current_url+' method="get"><div class="row"><div class="col-md-5"></div>'
					+'<div class="col-md-2"><input type="text" id="name" name="name" class="form-control" placeholder="Product name"></div>'
					+'<div class="col-md-2"><input type="text" id="sku" name="sku" class="form-control" placeholder="Product SKU"></div>'
					+'<div class="col-md-2"><select id="is_daily_deal" name="is_daily_deal" class="form-control select_2"><option value="2">Deals & Products Both</option><option value="0">Active Deals</option><option value="1">All Deals</option></select></div>'
					+'<div class="col-md-1"><button type="submit" class="btn btn-primary"><i class="ft-search"></i></button></div>'
					+'</div></form>'
				);
				$('#add_filter').remove();
				$('#filter_button').append('<a href="javascript::void(0)" id="remove_filter"> X</a>');
            }else if(window.location.pathname.split('/user/admin')[1] == '/cms/pages/manage'){
            	$('#filter_section').append(''
            		+'<form action='+current_url+' method="get">'
            			+'<div class="row">'
            				+'<div class="col-md-5"></div>'
							+'<div class="col-md-4">'
								+'<input type="text" id="name" name="name" class="form-control" placeholder="Page name">'
							+'</div>'
							+'<div class="col-md-2">'
								+'<select id="status" name="status" class="form-control select_2">'
									+'<option value="2">All</option>'
									+'<option value="0">Active</option>'
									+'<option value="1">Inactive</option>'
								+'</select>'
							+'</div>'
							+'<div class="col-md-1">'
								+'<button type="submit" class="btn btn-primary"><i class="ft-search"></i></button>'
							+'</div>'
						+'</div>'
					+'</form>'
				);
				$('#add_filter').remove();
				$('#filter_button').append('<a href="javascript::void(0)" id="remove_filter"> X</a>');
            }else if(window.location.pathname.split('/user/admin')[1] == '/cms/pages/search'){
            	$('#filter_section').append(''
            		+'<form action='+current_url+' method="get">'
            			+'<div class="row">'
            				+'<div class="col-md-5"></div>'
							+'<div class="col-md-4">'
								+'<input type="text" id="name" name="name" class="form-control" placeholder="Page name">'
							+'</div>'
							+'<div class="col-md-2">'
								+'<select id="status" name="status" class="form-control select_2">'
									+'<option value="2">All</option>'
									+'<option value="0">Active</option>'
									+'<option value="1">Inactive</option>'
								+'</select>'
							+'</div>'
							+'<div class="col-md-1">'
								+'<button type="submit" class="btn btn-primary"><i class="ft-search"></i></button>'
							+'</div>'
						+'</div>'
					+'</form>'
				);
				$('#add_filter').remove();
				$('#filter_button').append('<a href="javascript::void(0)" id="remove_filter"> X</a>');
            }else if(window.location.pathname.split('/user/admin')[1] == '/finance/account-statement/manage'){
            	$('#filter_section').append(''
            		+'<form action='+current_url+' method="get">'
            			+'<div class="row">'
            				+'<div class="col-md-7"></div>'
							+'<div class="col-md-2">'
								+'<input type="text" id="from" name="from" class="form-control datepicker" placeholder="From">'
							+'</div>'
							+'<div class="col-md-2">'
								+'<input type="text" id="to" name="to" class="form-control datepicker" placeholder="To">'
							+'</div>'
							+'<div class="col-md-1">'
								+'<button type="submit" class="btn btn-primary"><i class="ft-search"></i></button>'
							+'</div>'
						+'</div>'
					+'</form>'
				);
				$('#add_filter').remove();
				$('#filter_button').append('<a href="javascript::void(0)" id="remove_filter"> X</a>');
            }else if(window.location.pathname.split('/user/admin')[1] == '/finance/account-statement/search'){
            	$('#filter_section').append(''
            		+'<form action='+current_url+' method="get">'
            			+'<div class="row">'
            				+'<div class="col-md-7"></div>'
							+'<div class="col-md-2">'
								+'<input type="text" id="from" name="from" class="form-control datepicker" placeholder="From">'
							+'</div>'
							+'<div class="col-md-2">'
								+'<input type="text" id="to" name="to" class="form-control datepicker" placeholder="To">'
							+'</div>'
							+'<div class="col-md-1">'
								+'<button type="submit" class="btn btn-primary"><i class="ft-search"></i></button>'
							+'</div>'
						+'</div>'
					+'</form>'
				);
				$('#add_filter').remove();
				$('#filter_button').append('<a href="javascript::void(0)" id="remove_filter"> X</a>');
            }else if(window.location.pathname.split('/user/admin')[1] == '/finance/orders-overview/manage'){
            	$('#filter_section').append(''
            		+'<form action='+current_url+' method="get">'
            			+'<div class="row">'
            				+'<div class="col-md-3"></div>'
							+'<div class="col-md-2">'
								+'<input type="text" id="order_no" name="order_no" class="form-control pull-right" placeholder="Order NO#">'
							+'</div>'
							+'<div class="col-md-2">'
								+'<input type="text" id="sku" name="sku" class="form-control pull-right" placeholder="Product SKU">'
							+'</div>'
							+'<div class="col-md-2">'
								+'<input type="text" id="from" name="from" class="form-control datepicker" placeholder="From">'
							+'</div>'
							+'<div class="col-md-2">'
								+'<input type="text" id="to" name="to" class="form-control datepicker" placeholder="To">'
							+'</div>'
							+'<div class="col-md-1">'
								+'<button type="submit" class="btn btn-primary"><i class="ft-search"></i></button>'
							+'</div>'
						+'</div>'
					+'</form>'
				);
				$('#add_filter').remove();
				$('#filter_button').append('<a href="javascript::void(0)" id="remove_filter"> X</a>');
            }else if(window.location.pathname.split('/user/admin')[1] == '/finance/orders-overview/search'){
            	$('#filter_section').append(''
            		+'<form action='+current_url+' method="get">'
            			+'<div class="row">'
            				+'<div class="col-md-3"></div>'
							+'<div class="col-md-2">'
								+'<input type="text" id="order_no" name="order_no" class="form-control pull-right" placeholder="Order NO#">'
							+'</div>'
							+'<div class="col-md-2">'
								+'<input type="text" id="sku" name="sku" class="form-control pull-right" placeholder="Product SKU">'
							+'</div>'
							+'<div class="col-md-2">'
								+'<input type="text" id="from" name="from" class="form-control datepicker" placeholder="From">'
							+'</div>'
							+'<div class="col-md-2">'
								+'<input type="text" id="to" name="to" class="form-control datepicker" placeholder="To">'
							+'</div>'
							+'<div class="col-md-1">'
								+'<button type="submit" class="btn btn-primary"><i class="ft-search"></i></button>'
							+'</div>'
						+'</div>'
					+'</form>'
				);
				$('#add_filter').remove();
				$('#filter_button').append('<a href="javascript::void(0)" id="remove_filter"> X</a>');
            }

            $('.select_2').select2();
		});

		//Remove Filter
		$(document).on('click', '#remove_filter', function(){
			$('#filter_section').empty();
			$('#remove_filter').remove();
			$('#filter_button').append('<a href="javascript::void(0);" id="add_filter"><i class="ft-filter"></i> Filter</a>');
		});
	//Filter Section End

	//Drag and drop Images Start
		$('#sortable').sortable({
	      	revert: true
	    });

	    $('#draggable').draggable({
	      	connectToSortable: '#sortable',
	      	helper: 'clone',
	      	revert: 'invalid'
	    });

	    $('ul, li').disableSelection();
	//Drag and drop Images End

	//Sortable JS Start
		$('#sortable').sortable('refresh');
	//Sortable JS End

	//Update Product Cost Price Start
		$(document).on('click', '.cost_price', function(){
			$('#cost_price_modal_'+$(this).attr('data-id')+'').modal({
    			show: true
			});
		});
	//Update Product Cost Price End

	//Update Product Sale Price Start
		$(document).on('click', '.sale_price', function(){
			$('#sale_price_modal_'+$(this).attr('data-id')+'').modal({
    			show: true
			});
		});
	//Update Product Sale Price End

	//Update Product Quantity Start
		$(document).on('click', '.quantity', function(){
			$('#quantity_modal_'+$(this).attr('data-id')+'').modal({
    			show: true
			});
		});
	//Update Product Quantity End

	//Show Product Image Mouse Over Start
		/*$(document).on('mouseover', '.featured_image', function(){
			console.log($('#featured_image_'+$(this).attr('data-id')).val());
			$('.show_featured_image').append('<img src="'+$('#featured_image_'+$(this).attr('data-id')).val()+'">');
		});*/
	//Show Product Image Mouse Over End

	//Hide Product Image Mouse Out Start
		/*$(document).one('mouseout', '.featured_image', function(){
			$('#show_featured_image').empty();
		});*/
	//Hide Product Image Mouse Out End

	//Import Variations Start
		$(document).on('click', '.import_variations', function(){
			$('#import_variations').modal({
    			show: true
			});
		});
	//Import Variations End

	//Export Variations Start
		$(document).on('click', '.export_variations', function(){
			$('#export_variations').modal({
    			show: true
			});
		});
	//Export Variations End

	//Export Orders Start
		$(document).on('click', '.export_orders', function(){
			$('#export_orders').modal({
    			show: true
			});
		});
	//Export Orders End

	//Export Products Start
		$(document).on('click', '.export_products', function(){
			$('#export_products').modal({
    			show: true
			});
		});
	//Export Products End

	//Import Products Start
		$(document).on('click', '.import_products', function(){
			$('#import_products').modal({
    			show: true
			});
		});
	//Import Products End
	
	//Export Customers Start
		$(document).on('click', '.export_customers', function(){
			$('#export_customers').modal({
    			show: true
			});
		});
	//Export Customers End
	
	//Export Customers Start
		$(document).on('click', '.export_vendors', function(){
			$('#export_vendors').modal({
    			show: true
			});
		});
	//Export Customers End
	
	//Per Page Records Change Start
		$(document).on('change', '#per_page', function(){
			if(document.location.href.split('parent')[1] == '/manage'){
				var url = document.location.href.split('parent')[0].toString()+'parent/manage';
			}else if(document.location.href.split('parent')[1] == '/search'){
				var url = document.location.href.split('parent')[0].toString()+'parent/search';
			}

			$.ajax({
				url : url,
				method : 'GET',
				data : {per_page : $('#per_page').val()},

				success:function(response){
					if(document.location.href.split('parent')[1] == '/manage'){
						var url = document.location.href.split('parent')[0].toString()+'parent/manage';
					}else if(document.location.href.split('parent')[1] == '/search'){
						var url = document.location.href.split('parent')[0].toString()+'parent/search';
					}
					$('#per_page').val($('#per_page').val());
					window.location.replace(document.location.href.split('parent')[0].toString()+'parent/manage?per_page='+$('#per_page').val());
					$('#per_page').val($('#per_page').val());
				}
			});
		});
	//Per Page Records Change End

	//Print Page Start
		$(document).on('click', '#print', function(){
			var divToPrint = document.getElementById('print_section');
			var newWin = window.open('','Print-Window');
			newWin.document.open();
			newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');
			newWin.document.close();
			setTimeout(function(){newWin.close();},10);
		});
	//Print Page End

	//Getting Cities by country id start
		$(document).on('change', '#country', function(){
			$.ajax({
				url : document.location.href.split('/user/admin')[0].toString()+'/user/admin/common/cities/'+$(this).val(),
				method : 'GET',
				success:function(response){
					json_data = $.parseJSON(response);
					$('#city').html(json_data.DATA);
				}
			});
		});
	//Getting Cities by country id end

	//Show Fields According To Commission Type Start
		$(document).on('change', '#commision_type', function(){
			$('#additional_divs_'+$(this).attr('data-id')).empty();
			$('#add_btn_'+$(this).attr('data-id')).empty();
			var id = Math.floor((Math.random() * 100) + 1);
			var options = '';

			if($(this).val() == 0){
				$('#additional_divs_'+$(this).attr('data-id')).append(''
					+'<div class="row">'
    					+'<div class="col-md-12">'
        					+'<div class="form-group">'
            					+'<label class="label-control">Total Commission</label>'
            					+'<label class="label-control" style="color:red">*</label>'
            					+'<input type="text" id="total_commission" name="total_commission" class="form-control" placeholder="Total Commission*">'
        					+'</div>'
    					+'</div>'
					+'</div>'
				+'');
			}else if($(this).val() == 1){
				$.ajax({
					url : document.location.href.split('/user/admin')[0].toString()+'/user/admin/common/parent-categories',
					method : 'GET',
					async: false,
					success:function(response){
						json_data = $.parseJSON(response);
						options += json_data.DATA;
					}
				});

				$('#additional_divs_'+$(this).attr('data-id')).append(''
					+'<div id="row_'+id+'">'
						+'<div class="row">'
	    					+'<div class="col-md-6">'
	        					+'<div class="form-group">'
	            					+'<label class="label-control">Category</label>'
	            					+'<label class="label-control" style="color:red">*</label>'
	            					+'<select id="category" name="category[]" class="form-control select_2" style="width:100%">'
	            						+'<option>Select Category</option>'
	            						+options
	            					+'</select>'
	        					+'</div>'
	    					+'</div>'
	    					+'<div class="col-md-5">'
	        					+'<div class="form-group">'
	            					+'<label class="label-control">Total Commission%</label>'
	            					+'<label class="label-control" style="color:red">*</label>'
	            					+'<input type="text" id="total" name="total[]" class="form-control" placeholder="Total Commission% *">'
	        					+'</div>'
	    					+'</div>'
	    					+'<div class="col-md-1">'
        					+'<div class="form-group">'
        					+'<a href="javascript::void(0);" id="remove_commission_category" data-id="'+id+'" style="color: red"><i class="ft-minus"></i></a>'
        					+'</div>'
    					+'</div>'
						+'</div>'
					+'</div>'
				+'');

				$('.select_2').select2();
				
				$('#add_btn_'+$(this).attr('data-id')).append(''
					+'<div class="row">'
    					+'<div class="col-md-12">'
        					+'<div class="form-group">'
        						+'<a href="javascript::void(0)" id="add_commission_category"><i class="ft-plus"></i> Add</a>'
        					+'</div>'
    					+'</div>'
					+'</div>'
				+'');
			}
		});
	//Show Fields According To Commission Type End

	//Add More Categories For Commission By Click Button Start
		$(document).on('click', '#add_commission_category', function(){
			var id = Math.floor((Math.random() * 100) + 1);
			var options = '';

			$.ajax({
				url : document.location.href.split('/user/admin')[0].toString()+'/user/admin/common/parent-categories',
				method : 'GET',
				async: false,
				success:function(response){
					json_data = $.parseJSON(response);
					options += json_data.DATA;
				}
			});

			$('#additional_divs').append(''
				+'<div id="row_'+id+'">'
					+'<div class="row">'
    					+'<div class="col-md-6">'
        					+'<div class="form-group">'
            					+'<label class="label-control">Category</label>'
            					+'<label class="label-control" style="color:red">*</label>'
            					+'<select id="category" name="category[]" class="form-control select_2" style="width:100%">'
            						+'<option>Select Category</option>'
            						+options
            					+'</select>'
        					+'</div>'
    					+'</div>'
    					+'<div class="col-md-5">'
        					+'<div class="form-group">'
            					+'<label class="label-control">Total Commission%</label>'
            					+'<label class="label-control" style="color:red">*</label>'
            					+'<input type="text" id="total" name="total[]" class="form-control" placeholder="Total Commission% *">'
        					+'</div>'
    					+'</div>'
    					+'<div class="col-md-1">'
    					+'<div class="form-group">'
    					+'<a href="javascript::void(0);" id="remove_commission_category" data-id="'+id+'" style="color: red"><i class="ft-minus"></i></a>'
    					+'</div>'
					+'</div>'
					+'</div>'
				+'</div>'
			+'');

			$('.select_2').select2();
		});
	//Add More Categories For Commission By Click Button End

	//Show Products If Coupon Type is selected as Product Start
		$(document).on('change', '#order_type', function (){
			var options = '';
			$('#coupons_products').empty();

			if($(this).val() == 0){
				$.ajax({
					url : document.location.href.split('/user')[0].toString()+'/user/user/admin/common/products',
					method : 'GET',
					async: false,
					success:function(response){
						json_data = $.parseJSON(response);
						options += json_data.DATA;
					}
				});

				$('#coupons_products').append(''
					+'<div class="row">'
						+'<div class="col-md-12">'
	    					+'<div class="form-group">'
	        					+'<label class="label-control">Products</label><label class="label-control" style="color:red">*</label>'
	        					+'<select id="products" name="products[]" class="form-control select_2" style="width:100%" multiple>'
	        						+options
	        					+'</select>'
	    					+'</div>'
						+'</div>'
					+'</div>'
				+'');

				$('.select_2').select2();
			}
		});
	//Show Products If Coupon Type is selected as Product End

	//Remove Categories For Commission By Click Button Start
		$(document).on('click', '#remove_commission_category', function(){
			if(confirm('Are you sure, you want to remove this category?')){
				$('#row_'+$(this).attr('data-id')+'').remove();
			}
		});
	//Remove Categories For Commission By Click Button End

	//initialize ck_editor
    var ckeditor_url = '/assets/ckeditor';

	//Select2 Inputs Start
		$('.select_2').select2();
	//Select2 Inputs End
	
	//Datepicker Input Start
		$(document).on('click', '.datepicker', function(){
			$(this).datepicker({ 
					autoclose: true,
					format: 'dd-MM-yy',
				    changeMonth: true,
		   	}).datepicker('show');
		});

		$(document).on('click', '.advertise_datepicker', function(){
			$(this).datepicker({ 
					autoclose: true,
					format: 'yy-mm-dd',
				    changeMonth: true,
		    	 	minDate: new Date(),
		    	 	startDate: new Date(),
	    	}).datepicker('show');
		});

		$(document).on('click', '.datetime_picker', function(){
			$(this).datetimepicker({ 
					autoclose: true,
					dateFormat: 'yy-mm-dd',
        			timeFormat: 'HH:mm:ss',
				    changeMonth: true,
		    	 	minDate: new Date(),
		    	 	startDate: new Date(),
	    	}).datetimepicker('show');
		});
	//Datepicker Input End
});