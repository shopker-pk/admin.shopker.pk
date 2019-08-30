<?php

	//Admin Panel Routes Start
		//Admin Auth Routes Start
			Route::get('/', 'Admin\Auth\AuthController@index')->name('admin_sign_in');
			Route::get('/forget-password', 'Admin\Auth\AuthController@forget_password')->name('forget_password');
			Route::post('/sent-password', 'Admin\Auth\AuthController@sent_password')->name('sent_password');
			Route::get('/user/sign-out', 'Admin\Auth\AuthController@sign_out')->name('sign_out');
			Route::post('/user/admin/validating-credentials', 'Admin\Auth\AuthController@validating_admin_credentials')->name('admin_credentials_validation');
		//Admin Auth Routes End

		//Dashboard Route Start
			Route::get('/user/admin/dashboard', 'Admin\Dashboard\DashboardController@index')->name('admin_dashboard');
			Route::get('/user/admin/dashboard/monthly-sales', 'Admin\Dashboard\DashboardController@monthly_sales');
		//Dashboard Route End

		//Ecommerce Routes Start
			//Categories Routes Start
				//Parent Categories Routes Start
					Route::get('/user/admin/ecommerce/categories/parent/manage', 'Admin\Ecommerce\CategoriesController@view_parent_categories')->name('manage_parent_categories')->middleware('validate_admin_permissions:0');
					Route::get('/user/admin/ecommerce/categories/parent/add', 'Admin\Ecommerce\CategoriesController@add_parent_categories')->name('add_parent_categories')->middleware('validate_admin_permissions:0');
					Route::post('/user/admin/ecommerce/categories/parent/insert', 'Admin\Ecommerce\CategoriesController@insert_parent_categories')->name('insert_parent_categories')->middleware('validate_admin_permissions:0');
					Route::get('/user/admin/ecommerce/categories/parent/ajax/update-status/{id}/{status}', 'Admin\Ecommerce\CategoriesController@ajax_update_parent_status')->name('ajax_update_parent_status')->middleware('validate_admin_permissions:0');
					Route::get('/user/admin/ecommerce/categories/parent/edit/{id}', 'Admin\Ecommerce\CategoriesController@edit_parent_categories')->name('edit_parent_categories')->middleware('validate_admin_permissions:0');
					Route::post('/user/admin/ecommerce/categories/parent/update/{id}', 'Admin\Ecommerce\CategoriesController@update_parent_categories')->name('update_parent_categories')->middleware('validate_admin_permissions:0');
					Route::get('/user/admin/ecommerce/categories/parent/delete/{id}', 'Admin\Ecommerce\CategoriesController@delete_parent_categories')->name('delete_parent_categories')->middleware('validate_admin_permissions:0');
					Route::get('/user/admin/ecommerce/categories/parent/search', 'Admin\Ecommerce\CategoriesController@search_parent_categories')->name('search_parent_categories')->middleware('validate_admin_permissions:0');
				//Parent Categories Routes End

				//Child Categories Routes Start
					Route::get('/user/admin/ecommerce/categories/child/manage', 'Admin\Ecommerce\CategoriesController@view_child_categories')->name('manage_child_categories')->middleware('validate_admin_permissions:1');
					Route::get('/user/admin/ecommerce/categories/child/add', 'Admin\Ecommerce\CategoriesController@add_child_categories')->name('add_child_categories')->middleware('validate_admin_permissions:1');
					Route::post('/user/admin/ecommerce/categories/child/insert', 'Admin\Ecommerce\CategoriesController@insert_child_categories')->name('insert_child_categories')->middleware('validate_admin_permissions:1');
					Route::get('/user/admin/ecommerce/categories/child/ajax/update-status/{id}/{status}', 'Admin\Ecommerce\CategoriesController@ajax_update_child_status')->name('ajax_update_child_status')->middleware('validate_admin_permissions:1');
					Route::get('/user/admin/ecommerce/categories/child/edit/{id}', 'Admin\Ecommerce\CategoriesController@edit_child_categories')->name('edit_child_categories')->middleware('validate_admin_permissions:1');
					Route::post('/user/admin/ecommerce/categories/child/update/{id}', 'Admin\Ecommerce\CategoriesController@update_child_categories')->name('update_child_categories')->middleware('validate_admin_permissions:1');
					Route::get('/user/admin/ecommerce/categories/child/delete/{id}', 'Admin\Ecommerce\CategoriesController@delete_child_categories')->name('delete_child_categories')->middleware('validate_admin_permissions:1');
					Route::get('/user/admin/ecommerce/categories/child/search', 'Admin\Ecommerce\CategoriesController@search_child_categories')->name('search_child_categories')->middleware('validate_admin_permissions:1');
				//Child Categories Routes End

				//Sub Child Categories Routes Start
					Route::get('/user/admin/ecommerce/categories/sub-child/manage', 'Admin\Ecommerce\CategoriesController@view_sub_child_categories')->name('manage_sub_child_categories')->middleware('validate_admin_permissions:2');
					Route::get('/user/admin/ecommerce/categories/sub-child/add', 'Admin\Ecommerce\CategoriesController@add_sub_child_categories')->name('add_sub_child_categories')->middleware('validate_admin_permissions:2');
					Route::get('/user/admin/ecommerce/categories/ajax-get-child-categories/{id}', 'Admin\Ecommerce\CategoriesController@get_child_categories')->middleware('validate_admin_permissions:2');
					Route::post('/user/admin/ecommerce/categories/sub-child/insert', 'Admin\Ecommerce\CategoriesController@insert_sub_child_categories')->name('insert_sub_child_categories')->middleware('validate_admin_permissions:2');
					Route::get('/user/admin/ecommerce/categories/sub-child/ajax/update-status/{id}/{status}', 'Admin\Ecommerce\CategoriesController@ajax_update_sub_child_status')->name('ajax_update_sub_child_status')->middleware('validate_admin_permissions:2');
					Route::get('/user/admin/ecommerce/categories/sub-child/edit/{id}', 'Admin\Ecommerce\CategoriesController@edit_sub_child_categories')->name('edit_sub_child_categories')->middleware('validate_admin_permissions:2');
					Route::post('/user/admin/ecommerce/categories/sub-child/update/{id}', 'Admin\Ecommerce\CategoriesController@update_sub_child_categories')->name('update_sub_child_categories')->middleware('validate_admin_permissions:2');
					Route::get('/user/admin/ecommerce/categories/sub-child/delete/{id}', 'Admin\Ecommerce\CategoriesController@delete_sub_child_categories')->name('delete_sub_child_categories')->middleware('validate_admin_permissions:2');
					Route::get('/user/admin/ecommerce/categories/sub-child/search', 'Admin\Ecommerce\CategoriesController@search_sub_child_categories')->name('search_sub_child_categories')->middleware('validate_admin_permissions:2');
				//Sub Child Categories Routes End
			//Categories Routes End
			
			//Brands Routes Start
				Route::get('/user/admin/ecommerce/brands/manage', 'Admin\Ecommerce\BrandsController@index')->name('manage_brands')->middleware('validate_admin_permissions:3');
				Route::get('/user/admin/ecommerce/brands/add', 'Admin\Ecommerce\BrandsController@add')->name('add_brands')->middleware('validate_admin_permissions:3');
				Route::post('/user/admin/ecommerce/brands/insert', 'Admin\Ecommerce\BrandsController@insert')->name('insert_brands')->middleware('validate_admin_permissions:3');
				Route::get('/user/admin/ecommerce/brands/ajax/update-status/{id}/{status}', 'Admin\Ecommerce\BrandsController@ajax_update_status')->name('ajax_update_brand_status')->middleware('validate_admin_permissions:3');
				Route::get('/user/admin/ecommerce/brands/edit/{id}', 'Admin\Ecommerce\BrandsController@edit')->name('edit_brands')->middleware('validate_admin_permissions:3');
				Route::post('/user/admin/ecommerce/brands/update/{id}', 'Admin\Ecommerce\BrandsController@update')->name('update_brands')->middleware('validate_admin_permissions:3');
				Route::get('/user/admin/ecommerce/brands/delete/{id}', 'Admin\Ecommerce\BrandsController@delete')->name('delete_brands')->middleware('validate_admin_permissions:3');
				Route::get('/user/admin/ecommerce/brands/search', 'Admin\Ecommerce\BrandsController@search')->name('search_brands')->middleware('validate_admin_permissions:3');
			//Brands Routes End

			//Variations Routes Start
				Route::get('/user/admin/ecommerce/variations/manage', 'Admin\Ecommerce\VariationsController@index')->name('manage_variations')->middleware('validate_admin_permissions:4');
				Route::get('/user/admin/ecommerce/variations/add', 'Admin\Ecommerce\VariationsController@add')->name('add_variations')->middleware('validate_admin_permissions:4');
				Route::post('/user/admin/ecommerce/variations/insert', 'Admin\Ecommerce\VariationsController@insert')->name('insert_variations')->middleware('validate_admin_permissions:4');
				Route::get('/user/admin/ecommerce/variations/ajax/update-status/{id}/{status}', 'Admin\Ecommerce\VariationsController@ajax_update_status')->name('ajax_update_variation_status')->middleware('validate_admin_permissions:4');
				Route::get('/user/admin/ecommerce/variations/edit/{id}', 'Admin\Ecommerce\VariationsController@edit')->name('edit_variations')->middleware('validate_admin_permissions:4');
				Route::post('/user/admin/ecommerce/variations/update/{id}', 'Admin\Ecommerce\VariationsController@update')->name('update_variations')->middleware('validate_admin_permissions:4');
				Route::get('/user/admin/ecommerce/variations/delete/{id}', 'Admin\Ecommerce\VariationsController@delete')->name('delete_variations')->middleware('validate_admin_permissions:4');
				Route::get('/user/admin/ecommerce/variations/search', 'Admin\Ecommerce\VariationsController@search')->name('search_variations')->middleware('validate_admin_permissions:4');
				Route::post('/user/admin/ecommerce/variations/import', 'Admin\Ecommerce\VariationsController@import')->name('import_variations')->middleware('validate_admin_permissions:4');
				Route::post('/user/admin/ecommerce/variations/export', 'Admin\Ecommerce\VariationsController@export')->name('export_variations')->middleware('validate_admin_permissions:4');
			//Variations Routes End

			//Products Routes Start
				Route::get('/user/admin/ecommerce/products/manage', 'Admin\Ecommerce\ProductsController@index')->name('manage_products')->middleware('validate_admin_permissions:10');
				Route::get('/user/admin/ecommerce/products/variations/ajax-variation-labels', 'Admin\Ecommerce\ProductsController@variation_labels')->name('variation_labels')->middleware('validate_admin_permissions:10');
				Route::get('/user/admin/ecommerce/products/get-child-categories/{id}', 'Admin\Ecommerce\ProductsController@get_child_categories')->middleware('validate_admin_permissions:10');
				Route::get('/user/admin/ecommerce/products/get-sub-child-categories/{id}', 'Admin\Ecommerce\ProductsController@get_sub_child_categories')->middleware('validate_admin_permissions:10');
				Route::get('/user/admin/ecommerce/products/add', 'Admin\Ecommerce\ProductsController@add')->name('add_products')->middleware('validate_admin_permissions:10');
				Route::post('/user/admin/ecommerce/products/insert', 'Admin\Ecommerce\ProductsController@insert')->name('insert_products')->middleware('validate_admin_permissions:10');
				Route::get('/user/admin/ecommerce/products/ajax/update-status/{id}/{status}', 'Admin\Ecommerce\ProductsController@ajax_update_status')->name('ajax_update_product_status')->middleware('validate_admin_permissions:10');
				Route::post('/user/admin/ecommerce/products/ajax/update-cost-price/{id}', 'Admin\Ecommerce\ProductsController@ajax_update_cost_price')->name('ajax_update_cost_price')->middleware('validate_admin_permissions:10');
				Route::post('/user/admin/ecommerce/products/ajax/update-sale-price/{id}', 'Admin\Ecommerce\ProductsController@ajax_update_sale_price')->name('ajax_update_sale_price')->middleware('validate_admin_permissions:10');
				Route::post('/user/admin/ecommerce/products/ajax/update-quantity/{id}', 'Admin\Ecommerce\ProductsController@ajax_update_quantity')->name('ajax_update_quantity')->middleware('validate_admin_permissions:10');
				Route::get('/user/admin/ecommerce/products/edit/{id}', 'Admin\Ecommerce\ProductsController@edit')->name('edit_products')->middleware('validate_admin_permissions:5');
				Route::get('/user/admin/ecommerce/products/images/ajax-delete-image/{id}', 'Admin\Ecommerce\ProductsController@delete_images')->middleware('validate_admin_permissions:10');
				Route::post('/user/admin/ecommerce/products/update/{id}', 'Admin\Ecommerce\ProductsController@update')->name('update_products')->middleware('validate_admin_permissions:5');
				Route::get('/user/admin/ecommerce/products/delete/{id}', 'Admin\Ecommerce\ProductsController@delete')->name('delete_products')->middleware('validate_admin_permissions:6');
				Route::get('/user/admin/ecommerce/products/search', 'Admin\Ecommerce\ProductsController@search')->name('search_products')->middleware('validate_admin_permissions:10');
				Route::get('/user/admin/ecommerce/products/copy-listing/{id}', 'Admin\Ecommerce\ProductsController@copy_product')->name('copy_product')->middleware('validate_admin_permissions:7');
				Route::post('/user/admin/ecommerce/products/insert-copy-listing', 'Admin\Ecommerce\ProductsController@insert_copy_product')->name('insert_copy_product')->middleware('validate_admin_permissions:7');
				Route::post('/user/admin/ecommerce/products/export-products', 'Admin\Ecommerce\ProductsController@export')->name('export_products')->middleware('validate_admin_permissions:9');
				Route::post('/user/admin/ecommerce/products/import-products', 'Admin\Ecommerce\ProductsController@import')->name('import_products')->middleware('validate_admin_permissions:8');
				Route::get('/user/admin/ecommerce/products/ajax/update-visibility/{id}/{status}', 'Admin\Ecommerce\ProductsController@update_visibility')->name('update_visibility')->middleware('validate_admin_permissions:10');
			//Products Routes End
		//Ecommerce Routes End

		//Order Routes Start
			Route::get('/user/admin/orders/manage', 'Admin\Orders\OrdersController@view_orders')->name('manage_seller_orders')->middleware('validate_admin_permissions:11');
			Route::get('/user/admin/orders/details/{order_no}', 'Admin\Orders\OrdersController@details')->name('order_details_seller')->middleware('validate_admin_permissions:11');
			Route::get('/user/admin/orders/search', 'Admin\Orders\OrdersController@search')->name('search_seller_orders')->middleware('validate_admin_permissions:11');
			Route::post('/user/admin/orders/export', 'Admin\Orders\OrdersController@export')->name('export_orders')->middleware('validate_admin_permissions:11');
			//Update Order Status Route
			Route::post('/user/admin/orders/update-order-status/{order_no}', 'Admin\Orders\OrdersController@update_order_status')->name('update_seller_order_status')->middleware('validate_admin_permissions:11');
			//Update Payment Status Route
			Route::post('/user/admin/orders/update-payment-status/{order_no}', 'Admin\Orders\OrdersController@update_payment_status')->name('update_seller_payment_status')->middleware('validate_admin_permissions:11');
		//Order Routes End

		//Invoices Routes Start
			Route::get('/user/admin/payments/invoices/manage', 'Admin\Payments\InvoicesController@index')->name('manage_admin_invoices')->middleware('validate_admin_permissions:13');
			Route::get('/user/admin/payments/invoices/details/{order_no}', 'Admin\Payments\InvoicesController@details')->name('manage_admin_invoices_details')->middleware('validate_admin_permissions:13');
			Route::get('/user/admin/payments/invoices/download-pdf/{order_no}', 'Admin\Payments\InvoicesController@download_pdf')->name('admin_invoice_download_pdf')->middleware('validate_admin_permissions:13');
			Route::get('/user/admin/payments/invoices/search', 'Admin\Payments\InvoicesController@search')->name('search_admin_invoices')->middleware('validate_admin_permissions:13');
		//Invoices Routes End

		//Setting Routes Start
			//Profile Settings Routes Start
				Route::get('/user/admin/settings/profile/edit', 'Admin\Settings\ProfileController@edit')->name('admin_profile_settings');
				Route::post('/user/admin/settings/profile/update', 'Admin\Settings\ProfileController@update')->name('update_admin_profile_settings');
			//Profile Settings Routes End

			//Store Settings Routes Start
				Route::get('/user/admin/settings/store/edit', 'Admin\Settings\StoreController@edit')->name('edit_store_setting')->middleware('validate_admin_permissions:18');
				Route::get('/user/admin/settings/store/countries-list', 'Admin\Settings\StoreController@countries_list')->name('countries_list')->middleware('validate_admin_permissions:18');
				Route::post('/user/admin/settings/store/update', 'Admin\Settings\StoreController@update')->name('update_store_setting')->middleware('validate_admin_permissions:18');
			//Store Settings Routes End
		//Setting Routes End

		//Advertisement Routes Start
			//Banners Routes Start
				Route::get('/user/admin/advertisements/banners/manage', 'Admin\Advertisements\BannersController@index')->name('manage_banner_advertisements')->middleware('validate_admin_permissions:12');
				Route::get('/user/admin/advertisements/banners/add', 'Admin\Advertisements\BannersController@add')->name('add_banner_advertisements')->middleware('validate_admin_permissions:12');
				Route::post('/user/admin/advertisements/banners/insert', 'Admin\Advertisements\BannersController@insert')->name('insert_banner_advertisements')->middleware('validate_admin_permissions:12');
				Route::get('/user/admin/advertisements/banners/edit/{id}', 'Admin\Advertisements\BannersController@edit')->name('edit_banner_advertisements')->middleware('validate_admin_permissions:12');
				Route::post('/user/admin/advertisements/banners/update/{id}', 'Admin\Advertisements\BannersController@update')->name('update_banner_advertisements')->middleware('validate_admin_permissions:12');
				Route::get('/user/admin/advertisements/banners/delete/{id}', 'Admin\Advertisements\BannersController@delete')->name('delete_banner_advertisements')->middleware('validate_admin_permissions:12');
				Route::get('/user/admin/advertisements/banners/search', 'Admin\Advertisements\BannersController@search')->name('search_banner_advertisements')->middleware('validate_admin_permissions:12');
			//Banners Routes End
				
			//Coupons Routes Start
				Route::get('/user/admin/advertisements/coupons/manage', 'Admin\Advertisements\CouponsController@index')->name('manage_coupons')->middleware('validate_admin_permissions:12');
				Route::get('/user/admin/advertisements/coupons/add', 'Admin\Advertisements\CouponsController@add')->name('add_coupon')->middleware('validate_admin_permissions:12');
				Route::post('/user/admin/advertisements/coupons/insert', 'Admin\Advertisements\CouponsController@insert')->name('insert_coupon')->middleware('validate_admin_permissions:12');
				Route::get('/user/admin/advertisements/coupons/edit/{id}', 'Admin\Advertisements\CouponsController@edit')->name('edit_coupon')->middleware('validate_admin_permissions:12');
				Route::post('/user/admin/advertisements/coupons/update/{id}', 'Admin\Advertisements\CouponsController@update')->name('update_coupon')->middleware('validate_admin_permissions:12');
				Route::get('/user/admin/advertisements/coupons/delete/{id}', 'Admin\Advertisements\CouponsController@delete')->name('delete_coupon')->middleware('validate_admin_permissions:12');
				Route::get('/user/admin/advertisements/coupons/search', 'Admin\Advertisements\CouponsController@search')->name('search_coupons')->middleware('validate_admin_permissions:12');
				Route::get('/user/admin/advertisements/coupons/update-status/{id}/{status}', 'Admin\Advertisements\CouponsController@ajax_update_status')->middleware('validate_admin_permissions:12');
			//Coupons Routes End

			//Daily Deals Routes Start
				Route::get('/user/admin/advertisements/daily-deals/manage', 'Admin\Advertisements\DailyDealsController@index')->name('manage_daily_deals')->middleware('validate_admin_permissions:12');
				Route::get('/user/admin/advertisements/daily-deals/search', 'Admin\Advertisements\DailyDealsController@search')->name('search_daily_deals')->middleware('validate_admin_permissions:12');
				Route::post('/user/admin/advertisements/daily-deals/insert/{id}', 'Admin\Advertisements\DailyDealsController@add_daily_deals')->name('insert_daily_deals')->middleware('validate_admin_permissions:12');
			//Daily Deals Routes End
		//Advertisement Routes End

		//CRM Routes Start
			//Customers Routes Start
				Route::get('/user/admin/crm/customers/manage', 'Admin\CRM\CustomersController@index')->name('manage_customers')->middleware('validate_admin_permissions:14');
				Route::post('/user/admin/crm/customers/update/{id}', 'Admin\CRM\CustomersController@update')->name('update_customers')->middleware('validate_admin_permissions:14');
				Route::get('/user/admin/crm/customers/update-status/{id}/{status}', 'Admin\CRM\CustomersController@ajax_update_status')->middleware('validate_admin_permissions:14');
				Route::get('/user/admin/crm/customers/search', 'Admin\CRM\CustomersController@search')->name('search_customers')->middleware('validate_admin_permissions:14');
				Route::post('/user/admin/crm/customers/export-customers', 'Admin\CRM\CustomersController@export')->name('export_customers')->middleware('validate_admin_permissions:14');
			//Customers Routes End

			//Vendors Routes Start
				Route::get('/user/admin/crm/vendors/manage', 'Admin\CRM\VendorsController@index')->name('manage_vendors')->middleware('validate_admin_permissions:15');
				Route::post('/user/admin/crm/vendors/update/{id}', 'Admin\CRM\VendorsController@update')->name('update_vendors')->middleware('validate_admin_permissions:15');
				Route::get('/user/admin/crm/vendors/update-status/{id}/{status}', 'Admin\CRM\VendorsController@ajax_update_status')->middleware('validate_admin_permissions:15');
				Route::post('/user/admin/crm/vendors/add-commission/{id}', 'Admin\CRM\VendorsController@add_commission')->name('add_commission')->middleware('validate_admin_permissions:15');
				Route::get('/user/admin/crm/vendors/search', 'Admin\CRM\VendorsController@search')->name('search_vendors')->middleware('validate_admin_permissions:15');
				Route::post('/user/admin/crm/vendors/export-vendors', 'Admin\CRM\VendorsController@export')->name('export_vendors')->middleware('validate_admin_permissions:15');
			//Vendors Routes End

			//Admin Routes Start
				Route::get('/user/admin/crm/admin/manage', 'Admin\CRM\AdminsController@index')->name('manage_admins')->middleware('validate_admin_permissions:16');
				Route::get('/user/admin/crm/admin/add', 'Admin\CRM\AdminsController@add')->name('add_admins')->middleware('validate_admin_permissions:16');
				Route::post('/user/admin/crm/admin/insert', 'Admin\CRM\AdminsController@insert')->name('insert_admins')->middleware('validate_admin_permissions:16');
				Route::get('/user/admincrm/admin/edit/{id}', 'Admin\CRM\AdminsController@edit')->name('edit_admins')->middleware('validate_admin_permissions:16');
				Route::post('/user/admin/crm/admin/update/{id}', 'Admin\CRM\AdminsController@update')->name('update_admins')->middleware('validate_admin_permissions:16');
				Route::get('/user/admin/crm/admin/delete/{id}', 'Admin\CRM\AdminsController@delete')->name('delete_admins')->middleware('validate_admin_permissions:16');
				Route::get('/user/admin/crm/admin/search', 'Admin\CRM\AdminsController@search')->name('search_admins')->middleware('validate_admin_permissions:16');
				Route::get('/user/admin/crm/admins/update-status/{id}/{status}', 'Admin\CRM\VendorsController@ajax_update_status')->middleware('validate_admin_permissions:16');
			//Admin Routes End
		//CRM Routes End

		//CMS Routes Start
			Route::get('/user/admin/cms/pages/manage', 'Admin\CMS\PagesController@index')->name('manage_pages')->middleware('validate_admin_permissions:17');
			Route::get('/user/admin/cms/pages/add', 'Admin\CMS\PagesController@add')->name('add_pages')->middleware('validate_admin_permissions:17');
			Route::post('/user/admin/cms/pages/insert', 'Admin\CMS\PagesController@insert')->name('insert_pages')->middleware('validate_admin_permissions:17');
			Route::get('/user/admin/cms/pages/edit/{id}', 'Admin\CMS\PagesController@edit')->name('edit_pages')->middleware('validate_admin_permissions:17');
			Route::post('/user/admin/cms/pages/update/{id}', 'Admin\CMS\PagesController@update')->name('update_pages')->middleware('validate_admin_permissions:17');
			Route::get('/user/admin/cms/pages/delete/{id}', 'Admin\CMS\PagesController@delete')->name('delete_pages')->middleware('validate_admin_permissions:17');
			Route::get('/user/admin/cms/pages/search', 'Admin\CMS\PagesController@search')->name('search_pages')->middleware('validate_admin_permissions:17');
			Route::get('/user/admin/cms/pages/update-status/{id}/{status}', 'Admin\CMS\PagesController@ajax_update_status')->middleware('validate_admin_permissions:17');
		//CMS Routes End

		//Finance Routes Start
			//Account Statement Routes Start
				Route::get('/user/admin/finance/account-statement/manage', 'Admin\Finance\AccountsController@manage')->name('manage_account_statement')->middleware('validate_admin_permissions:50');
				Route::get('/user/admin/finance/account-statement/search', 'Admin\Finance\AccountsController@search')->name('search_account_statement')->middleware('validate_admin_permissions:50');
				Route::post('/user/admin/finance/account-statement/export', 'Admin\Finance\AccountsController@export')->name('export_account_statement')->middleware('validate_admin_permissions:50');
				Route::get('/user/admin/finance/account-statement/download-pdf', 'Admin\Finance\AccountsController@pdf')->middleware('validate_admin_permissions:50');
			//Account Statement Routes End

			//Orders Overview Routes Start
				Route::get('/user/admin/finance/orders-overview/manage', 'Admin\Finance\OrdersController@manage')->name('manage_orders_overview')->middleware('validate_admin_permissions:50');
				Route::get('/user/admin/finance/orders-overview/search', 'Admin\Finance\OrdersController@search')->name('search_orders_overview')->middleware('validate_admin_permissions:50');
				Route::post('/user/admin/finance/orders-overview/export', 'Admin\Finance\OrdersController@export')->name('export_orders_overview')->middleware('validate_admin_permissions:50');
			//Orders Overview Routes End
		//Finance Routes End

		//Reviews Routes Start
			//Product Routes Start
				Route::get('/user/admin/reviews/products/manage', 'Admin\Reviews\ProductsController@manage')->name('manage_product_reviews');
				Route::post('/user/admin/reviews/products/reply/{id}', 'Admin\Reviews\ProductsController@reply')->name('reply_product_reviews');
				Route::get('/user/admin/reviews/products/search', 'Admin\Reviews\ProductsController@search')->name('search_product_reviews');
			//Product Routes End

			//Orders Routes Start
				Route::get('/user/admin/reviews/orders/manage', 'Admin\Reviews\OrdersController@manage')->name('manage_order_reviews');
				Route::post('/user/admin/reviews/orders/reply/{order_no}', 'Admin\Reviews\OrdersController@reply')->name('reply_order_reviews');
				Route::get('/user/admin/reviews/orders/search', 'Admin\Reviews\OrdersController@search')->name('search_order_reviews');
			//Orders Routes End
		//Reviews Routes End

		//Common Routes Start
			Route::get('/user/admin/common/cities/{id}', 'Admin\Common\CommonController@get_ajax_cities_list');
			Route::get('/user/admin/common/parent-categories', 'Admin\Common\CommonController@get_parent_categories');
			Route::get('/user/admin/common/products', 'Admin\Common\CommonController@get_products');
		//Common Routes End
	//Admin Panel Routes End