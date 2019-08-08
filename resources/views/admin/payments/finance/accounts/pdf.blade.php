<!DOCTYPE html>
<html>
<head>
    <title></title>
    <link rel="apple-touch-icon" href="{{ asset('public/assets/admin/images/ico/apple-icon-120.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('public/assets/admin/images/ico/favicon.ico') }}">
    <link href="{{ asset('public/assets/admin/fonts/css.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/admin/css/vendors.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/admin/vendors/css/extensions/unslider.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/admin/vendors/css/weather-icons/climacons.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/admin/fonts/meteocons/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/admin/vendors/css/charts/morris.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/admin/css/app.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/admin/css/core/menu/menu-types/vertical-menu-modern.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/admin/css/core/colors/palette-gradient.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/admin/fonts/simple-line-icons/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/admin/css/core/colors/palette-gradient.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/admin/css/pages/timeline.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/admin/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/admin/css/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/admin/css/custom.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/admin/css/image_upload.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/admin/css/jquery-ui.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/admin/css/bootstrap-datetimepicker.min.css') }}">
</head>
<body>
    <div class="content-body">
        <section id="basic-form-layouts">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-content collpase show">
                            <div class="card-body">
                                <form class="form form-horizontal form-bordered">
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
                                                                <span class="price1">{{ $query['total_earning'] }} PKR</span><br/>
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
                                                                    <span class="price1">- {{ $query['total_commission'] }} PKR</span><br/>
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
                                                                <span class="price1">{{ $query['sub_total'] }} PKR</span>   
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
                                                        <span class="price1">{{ $query['sub_total'] }} PKR</span>
                                                    </div>
                                                </div>
                                            </div>
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
</body>
<script src="{{ asset('public/assets/admin/vendors/js/vendors.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/assets/admin/vendors/js/charts/raphael-min.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/assets/admin/vendors/js/charts/morris.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/assets/admin/vendors/js/extensions/unslider-min.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/assets/admin/vendors/js/timeline/horizontal-timeline.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/assets/admin/js/core/app-menu.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/assets/admin/js/core/app.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/assets/admin/js/scripts/customizer.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/assets/admin/js/scripts/pages/dashboard-ecommerce.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/assets/admin/js/select2.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/assets/admin/js/custom.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/assets/admin/ckeditor/ckeditor.js') }}" type="text/javascript"></script> 
<script src="{{ asset('public/assets/admin/js/jquery.nestable.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/assets/admin/js/star_ratings.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/assets/admin/js/image_upload.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/assets/admin/js/jquery-ui.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/assets/admin/js/multi_images_upload.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/assets/admin/js/single_image_upload.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/assets/admin/js/bootstrap-datetimepicker.js') }}" type="text/javascript"></script>
</html>