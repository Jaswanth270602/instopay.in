@extends('agent.layout.header')
@section('content')

<div class="main-content-body">
    <div class="row row-sm">
        @include('agent.developer.left_side')

        <div class="col-lg-8 col-xl-9">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title mb-1">Payin 9 - Create Order</h6>
                    <hr>
                    <table class="table main-table-reference mt-0 mb-0">
                        <tr><th>Parameter</th><th>Type</th><th>Description</th><th>Required</th></tr>
                        <tr><td><code>api_token</code></td><td>string</td><td>Bearer token of merchant API user.</td><td>Yes</td></tr>
                        <tr><td><code>amount</code></td><td>numeric</td><td>Amount between configured min and max limits.</td><td>Yes</td></tr>
                        <tr><td><code>client_id</code></td><td>string</td><td>Merchant transaction reference.</td><td>Yes</td></tr>
                        <tr><td><code>callback_url</code></td><td>string</td><td>Merchant callback endpoint URL.</td><td>Yes</td></tr>
                        <tr><td><code>customer_name</code></td><td>string</td><td>Customer full name.</td><td>Yes</td></tr>
                        <tr><td><code>mobile_number</code></td><td>string</td><td>Customer mobile number (10 digits).</td><td>Yes</td></tr>
                        <tr><td><code>email</code></td><td>string</td><td>Customer email.</td><td>Yes</td></tr>
                    </table>
                </div>
                <div class="card-footer">
<pre>POST: {{ url('api/add-money/v9/createOrder') }}</pre>
<hr>
<pre style="color:#0ba360;">Success Response:
{
  "status": "success",
  "message": "Order created successfully",
  "data": {
    "txnid": 12345,
    "order_token": "P912345...",
    "transaction_id": "PG1777024186858B295A541",
    "reference_id": "ewcwvwdb1015hbxw25",
    "qrString": "upi://pay?...",
    "base64Qr": "data:image/png;base64,...",
    "status": "pending"
  }
}</pre>
                </div>
            </div>

            <hr>
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title mb-1">Status Enquiry</h6>
                    <hr>
                    <table class="table main-table-reference mt-0 mb-0">
                        <tr><th>Parameter</th><th>Type</th><th>Description</th><th>Required</th></tr>
                        <tr><td><code>api_token</code></td><td>string</td><td>Bearer token of merchant API user.</td><td>Yes</td></tr>
                        <tr><td><code>client_id</code></td><td>string</td><td>Same client id used during order creation.</td><td>Yes</td></tr>
                    </table>
                </div>
                <div class="card-footer">
<pre>POST: {{ url('api/add-money/v9/status-enquiry') }}</pre>
<hr>
<pre style="color:#0ba360;">Success Response:
{
  "status": true,
  "message": "Transaction record found successfully!",
  "data": {
    "client_id": "merchant-ref-1001",
    "report_id": 99887,
    "amount": 100.00,
    "utr": "748554562",
    "status": "credit"
  }
}</pre>
                </div>
            </div>

            <hr>
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title mb-1">Provider Webhook</h6>
                    <hr>
                    <p>Configure webhook on provider panel to call this endpoint:</p>
<pre>{{ url('api/call-back/payin9-payin') }}</pre>
                    <p class="mb-2">Supported events: <code>PAYIN_SUCCESS</code>, <code>PAYIN_FAILED</code>, <code>PAYIN_EXPIRED</code>.</p>
                </div>
                <div class="card-footer">
<pre>Sample Payload:
{
  "event": "PAYIN_SUCCESS",
  "timestamp": "2024-08-15T14:30:00Z",
  "data": {
    "userTransactionId": "pay_123456789",
    "status": "success",
    "statusCode": 1,
    "utr": "748554562",
    "transactionId": 123
  }
}</pre>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

