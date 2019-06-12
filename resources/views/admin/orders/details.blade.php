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
                                        <h4 class="form-section">Cart Details</h4>
                                    </div>
                                    <div class="table-responsive">          
  										<table class="table">
											<thead>
			                                    <tr>
                                                    <th>Product Image</th>
                                                    <th>Product Name</th>
                                                    <th>Product Retail Price</th>
			                                        <th>Product Price</th>
                                                    <th>Additional Info</th>
			                                    </tr>
			                                </thead>
			                                <tbody>
                                                @if(!empty($cart_details))
    			                                    @foreach($cart_details as $row)
                                                        <tr>
                                                            <td><img src="{{ asset('public/assets/admin/images/ecommerce/products/'.$row->featured_image) }}" alt="Product Featured Image" style="width: 200px; height: 150px;"></td>
                                                            <td>{{ $row->name }}</td>
                                                            <td>{{ $row->regural_price }}</td>
                                                            <td>{{ $row->product_amount }}</td>
        				                                    <td>
                                                                <span>SKU Code : {{ $row->sku_code }}</span><br>
                                                                <span>Product Quantity : {{ $row->quantity }}</span><br><span>Product Type : @if($row->type == 0) Sale @else Normal @endif</span>       
                                                            </td>
        				                                </tr>
                                                    @endforeach
                                                @endif
			                               	</tbody>
										</table>
									</div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-content collpase show">
                            <div class="card-body">
                                <form class="form form-horizontal form-bordered">
                                    <div class="form-body">
                                        <h4 class="form-section">Customer Details</h4>
                                    </div>
                                    @if(!empty($customer_details))
                                        <span>Full Name : {{ $customer_details->first_name.' '.$customer_details->last_name }} </span><br>
                                        <span>Contact No# : {{ $customer_details->phone_no }}</span><br>
                                        <span>Email : {{ $customer_details->email }}</span><br>
                                        <span>Address : {{ $customer_details->address }}</span><br>
                                        <span>City : {{ $customer_details->city_name }}</span><br>
                                        <span>Country : {{ $customer_details->country_name }}</span><br><br>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-content collpase show">
                            <div class="card-body">
                                <form class="form form-horizontal form-bordered">
                                    <div class="form-body">
                                        <h4 class="form-section">Shipping Details</h4>
                                    </div>
                                    @if(!empty($shipping_details))
                                        <span>Full Name : {{ $shipping_details->first_name.' '.$shipping_details->last_name }}</span><br>
                                        <span>Contact No# : {{ $shipping_details->phone_no }}</span><br>
                                        <span>Email : {{ $shipping_details->email }}</span><br>
                                        <span>Address : {{ $shipping_details->address }}</span><br>
                                        <span>City : {{ $shipping_details->city_name }}</span><br>
                                        <span>Country : {{ $shipping_details->country_name }}</span><br>
                                        <span>Area : @foreach($areas as $row) @if($row['area_id'] == $shipping_details->area_id) {{ $row['area_name'] }} @endif @endforeach</span>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-content collpase show">
                            <div class="card-body">
                                <form class="form form-horizontal form-bordered">
                                    <div class="form-body">
                                        <h4 class="form-section">Order Summary</h4>
                                    </div>
                                    @if(!empty($order_summary))
                                        <span>Order No# : {{ $order_summary->order_no }}</span><br>
                                        <span>Subtotal : {{ $order_summary->sub_total }}</span><br>
                                        <span>Discount Fee : </span><br>
                                        <span>Shipping Fee : {{ $order_summary->charges }}</span><br>
                                        <span>Total : {{ $order_summary->total }}</span><br>
                                        <span></span><br>
                                        <span></span>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@include('admin.layouts.footer')