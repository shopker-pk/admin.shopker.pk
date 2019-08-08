@include('admin.layouts.header')
<div class="content-body">
    @if(!empty(session::get('role') == 0))
        <!-- First Colunm Start -->
        <div class="row">
            <a href="{{ route('manage_products') }}">
                <div class="col-xl-3 col-lg-6 col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="media align-items-stretch">
                                <div class="p-2 text-center bg-primary bg-darken-2">
                                    <i class="icon-camera font-large-2 white"></i>
                                </div>
                                <div class="p-2 bg-gradient-x-primary white media-body">
                                    <h5>Products</h5>
                                    <h5 class="text-bold-400 mb-0"><i class="ft-plus"></i> @if(!empty($total_products->total_products)) {{ $total_products->total_products }} @else 0 @endif</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            <a href="{{ route('manage_customers') }}">
                <div class="col-xl-3 col-lg-6 col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="media align-items-stretch">
                                <div class="p-2 text-center bg-danger bg-darken-2">
                                    <i class="icon-user font-large-2 white"></i>
                                </div>
                                <div class="p-2 bg-gradient-x-danger white media-body">
                                    <h5>Customers</h5>
                                    <h5 class="text-bold-400 mb-0"><i class="ft-plus"></i> @if(!empty($total_users->total_users)) {{ $total_users->total_users }} @else 0 @endif</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            <a href="{{ route('manage_seller_orders') }}">
                <div class="col-xl-3 col-lg-6 col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="media align-items-stretch">
                                <div class="p-2 text-center bg-warning bg-darken-2">
                                    <i class="icon-basket-loaded font-large-2 white"></i>
                                </div>
                                <div class="p-2 bg-gradient-x-warning white media-body">
                                    <h5>New Orders</h5>
                                    <h5 class="text-bold-400 mb-0"><i class="ft-arrow-up"></i> @if(!empty($total_new_orders->new_orders)) {{ $total_new_orders->new_orders }} @else 0 @endif</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            <a href="{{ route('manage_admin_invoices') }}">
                <div class="col-xl-3 col-lg-6 col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="media align-items-stretch">
                                <div class="p-2 text-center bg-success bg-darken-2">
                                    <i class="icon-wallet font-large-2 white"></i>
                                </div>
                                <div class="p-2 bg-gradient-x-success white media-body">
                                    <h5>Total Earning</h5>
                                    <h5 class="text-bold-400 mb-0"><i class="ft-arrow-up"></i> @if(!empty($total_earning->total_earning)) {{ $total_earning->total_earning }} @else 0 @endif</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <!-- First Colunm End -->

        <!-- Revenue Chart & Recent Buyers Start -->
        <div class="row match-height">
            <div class="col-xl-8 col-lg-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body sales-growth-chart">
                            <div id="monthly-sales" class="height-250"></div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="chart-title mb-1 text-center">
                            <h6>Monthly Revenues</h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Recent Buyers</h4>
                        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                    </div>
                    <div class="card-content px-1">
                        <div id="recent-buyers" class="media-list height-300 position-relative">
                            @if(!empty($recent_customers))
                                @foreach($recent_customers as $row)
                            <a href="javascript::void(0);" class="media border-0">
                                <div class="media-left pr-1">
                                    <span class="avatar avatar-md avatar-online">
                                        <img class="media-object rounded-circle" src="{{ asset('public/assets/admin/images/profile_images/'.$row->image) }}" alt="User Image">
                                    </span>
                                </div>
                                <div class="media-body w-100">
                                    <h6 class="list-group-item-heading">
                                        {{ $row->first_name.' '.$row->last_name }}<br><br> 
                                        Total Bill : {{ $row->total }}
                                    </h6>
                                </div>
                            </a>
                                @endforeach
                            @else
                            No recent buyers found !!
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Revenue Chart & Recent Buyers End -->
    @endif
</div>
@include('admin.layouts.footer')