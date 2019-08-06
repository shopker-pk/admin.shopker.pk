<!DOCTYPE html>
<html>
<head>
    <title></title>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/admin/css/invoice.css') }}">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
<div id="invoice">
    <div class="invoice overflow-auto">
        <div style="min-width: 600px">
            <header>
                <div class="row">
                    <div class="col company-details">
                        <h2 class="name">Company Details</h2>
                        <div>{{ $header_details->title }}</div>
                        <div>{{ $header_details->address }}</div>
                        <div>{{ $header_details->zip_code }}</div>
                        <div>{{ $header_details->city_name }}</div>
                        <div>{{ $header_details->country_name }}</div>
                    </div>
                    <div class="col logo">
                        <a target="_blank" href="#">
                            <img src="{{ asset('public/assets/admin/images/settings/logo/'.$site_logo->header_image) }}" height="100" data-holder-rendered="true" />
                        </a>
                    </div>
                </div>
            </header>
            <main>
                <div class="row contacts">
                    <div class="col invoice-to">
                        <h2>Customer Details</h2>
                        <div class="to">Name: {{ $invoice_and_customer_details->first_name }} {{ $invoice_and_customer_details->last_name }}</div>
                        <div class="address">Contact: {{ $invoice_and_customer_details->phone_no }}</div>
                        <div class="email"><a href="">Email: {{ $invoice_and_customer_details->email }}</a></div>
                    </div>
                    <div class="col invoice-details">
                        <h1 class="invoice-id">Invoice Details</h1>
                        <div class="date">Number: {{ $invoice_and_customer_details->order_no }}</div>
                        <div class="date">Date: {{ date('d-m-Y', strtotime($invoice_and_customer_details->order_date)) }}</div>
                        <div class="date">Transaction Id: {{ $invoice_and_customer_details->transaction_id }}</div>
                        <div class="date">Total Amount: {{ $invoice_and_customer_details->total }}</div>
                        <div class="date">Order Status: @if($invoice_and_customer_details->order_status == 0) Pending @elseif($invoice_and_customer_details->order_status == 1) In Process @elseif($invoice_and_customer_details->order_status == 2) Ready To Ship @elseif($invoice_and_customer_details->order_status == 3) Shipped @elseif($invoice_and_customer_details->order_status == 4) Delivered @elseif($invoice_and_customer_details->order_status == 5) Canceled @endif</div>
                        <div class="date">Payment Status: @if($invoice_and_customer_details->payment_status == 0)Paid @else Unpaid @endif</div>
                    </div>
                </div>
                <table border="0" cellspacing="0" cellpadding="0">
                    <thead>
                        <tr>
                            <th class="text-left">Product Name</th>
                            <th class="text-right">Product Type</th>
                            <th class="text-right">Product Quantity</th>
                            <th class="text-right">Product Amount</th>
                            <th class="text-right">Total Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!empty($order_details))
                            @foreach($order_details as $row)
                        <tr>
                            <td>{{ $row->product_name }}</td>
                            <td>@if($row->type == 0) On Sale @elseif($row->type == 1) Normal @endif</td>
                            <td>{{ $row->product_quantity }}</td>
                            <td>{{ $row->product_price }}</td>
                            <td>{{ $row->total_amount }}</td>
                        </tr>
                            @endforeach
                        @endif
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2"></td>
                            <td colspan="2">SUBTOTAL</td>
                            <td>Rs {{ $payment_details->sub_total }}</td>
                        </tr>
                        <tr>
                            <td colspan="2"></td>
                            <td colspan="2">Discount</td>
                            <td>Rs 0</td>
                        </tr>
                        <tr>
                            <td colspan="2"></td>
                            <td colspan="2">Shipping</td>
                            <td>Rs {{ $payment_details->charges }}</td>
                        </tr>
                        <tr>
                            <td colspan="2"></td>
                            <td colspan="2">GRAND TOTAL</td>
                            <td>Rs {{ $payment_details->total }}</td>
                        </tr>
                    </tfoot>
                </table>
                <div class="thanks">Thank you!</div>
            </main>
        </div>
        <div></div>
    </div>
</div>
</body>
</html>