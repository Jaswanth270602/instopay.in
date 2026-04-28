@extends('agent.layout.header')
@section('content')
<div class="main-content-body d-flex justify-content-center align-items-center" style="min-height:100vh;">
    <div class="col-md-5">
        <div class="card p-4" style="border-radius:14px;">
            <h3 class="mb-1">Payin 9</h3>
            <p class="text-muted mb-3">Generate UPI intent and scan QR to complete payment.</p>

            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">
                <label>Enter Amount ({{ $min_amount ?? 10 }} to {{ $max_amount ?? 50000 }})</label>
                <input type="number" id="amount" class="form-control" oninput="toggleBtn()">
                <small class="text-danger" id="amount_errors"></small>
            </div>

            <button class="btn btn-primary mt-2" id="generateBtn" onclick="createOrder()" disabled>Generate Link</button>
            <button class="btn btn-light mt-2" type="button" onclick="window.history.back()">Close</button>
        </div>
    </div>
</div>

<div class="modal show" id="view-qrcode-model" data-toggle="modal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title" id="payin9-modal-title">Scan & Pay</h6>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">x</span></button>
            </div>
            <div class="modal-body text-center">
                <div id="payin9-qr-section">
                    <h5>Open any UPI app and scan this QR</h5>
                    <img src="" class="img-fluid mt-2" id="qrCodeUrl" style="max-width:220px;display:none;">
                    <p id="qrFallbackMsg" style="display:none;">QR image unavailable, use the button below.</p>
                    <p id="payin9-status-pending"><i class="fa fa-spinner fa-spin"></i> Waiting for payment...</p>
                    <a class="btn btn-primary btn-lg btn-block mt-2" href="" role="button" id="qrStringBtn">
                        Pay <span id="amountString"></span> Using App
                    </a>
                </div>
                <div id="payin9-result-success" style="display:none;" class="alert alert-success mt-2">
                    <strong>Payment successful</strong>
                    <p class="mb-0 mt-1" id="payin9-success-utr"></p>
                </div>
                <div id="payin9-result-failure" style="display:none;" class="alert alert-danger mt-2">
                    <strong>Payment failed</strong>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const MIN_AMOUNT = {{ $min_amount ?? 10 }};
    const MAX_AMOUNT = {{ $max_amount ?? 50000 }};
    let payin9PollInterval = null;
    let payin9CurrentTxnid = null;
    let payin9PollCount = 0;
    const PAYIN9_POLL_MS = 8000;
    const PAYIN9_MAX_POLLS = 112;

    function toggleBtn() {
        let amount = parseFloat(document.getElementById("amount").value.trim());
        let btn = document.getElementById("generateBtn");
        let errorField = document.getElementById("amount_errors");
        if (!isNaN(amount) && amount >= MIN_AMOUNT && amount <= MAX_AMOUNT) {
            btn.disabled = false;
            errorField.textContent = "";
        } else {
            btn.disabled = true;
            errorField.textContent = amount ? "Enter amount between " + MIN_AMOUNT + " and " + MAX_AMOUNT : "";
        }
    }

    function resetPayin9Ui() {
        $('#payin9-modal-title').text('Scan & Pay');
        $('#payin9-qr-section').show();
        $('#payin9-result-success').hide();
        $('#payin9-result-failure').hide();
    }

    function stopPayin9Polling() {
        if (payin9PollInterval) {
            clearInterval(payin9PollInterval);
            payin9PollInterval = null;
        }
        payin9PollCount = 0;
    }

    function startPayin9Polling(txnid) {
        stopPayin9Polling();
        payin9CurrentTxnid = txnid;
        payin9PollInterval = setInterval(function () {
            payin9PollCount++;
            if (payin9PollCount >= PAYIN9_MAX_POLLS) {
                stopPayin9Polling();
                return;
            }
            pollPayin9OrderStatus();
        }, PAYIN9_POLL_MS);
        pollPayin9OrderStatus();
    }

    function pollPayin9OrderStatus() {
        if (!payin9CurrentTxnid) return;
        $.ajax({
            type: 'POST',
            url: "{{ url('agent/add-money/v9/order-status') }}",
            data: { _token: $("input[name=_token]").val(), txnid: payin9CurrentTxnid },
            success: function (res) {
                if (!res || res.ok === false) return;
                if (res.payment_status === 'success') {
                    stopPayin9Polling();
                    $('#payin9-modal-title').text('Payment successful');
                    $('#payin9-qr-section').hide();
                    $('#payin9-success-utr').text((res.data && res.data.utr) ? ('UTR: ' + res.data.utr) : '');
                    $('#payin9-result-success').show();
                } else if (res.payment_status === 'failed') {
                    stopPayin9Polling();
                    $('#payin9-modal-title').text('Payment failed');
                    $('#payin9-qr-section').hide();
                    $('#payin9-result-failure').show();
                }
            }
        });
    }

    $('#view-qrcode-model').on('hidden.bs.modal', function () {
        stopPayin9Polling();
        payin9CurrentTxnid = null;
        resetPayin9Ui();
    });

    function createOrder() {
        var token = $("input[name=_token]").val();
        var amount = $("#amount").val();
        $.ajax({
            type: "POST",
            url: "{{ url('agent/add-money/v9/create-order') }}",
            data: { amount: amount, _token: token },
            success: function(msg) {
                if (msg.status === 'success') {
                    resetPayin9Ui();
                    if (msg.data.base64Qr && msg.data.base64Qr.indexOf('data:image') === 0) {
                        $("#qrCodeUrl").attr('src', msg.data.base64Qr).show();
                        $("#qrFallbackMsg").hide();
                    } else {
                        $("#qrCodeUrl").attr('src', '').hide();
                        $("#qrFallbackMsg").show();
                    }
                    $("#qrStringBtn").attr('href', msg.data.qrString || '#');
                    $("#amountString").text(amount);
                    $("#view-qrcode-model").modal('show');
                    if (msg.data.txnid) {
                        startPayin9Polling(msg.data.txnid);
                    }
                } else {
                    alert(msg.message || 'Failed to create order');
                }
            },
            error: function(xhr) {
                let errMsg = 'Network or server error. Please try again.';
                if (xhr && xhr.responseJSON && xhr.responseJSON.message) {
                    errMsg = xhr.responseJSON.message;
                } else if (xhr && xhr.responseText) {
                    try {
                        const parsed = JSON.parse(xhr.responseText);
                        if (parsed && parsed.message) errMsg = parsed.message;
                    } catch (e) {}
                }
                alert(errMsg);
            }
        });
    }
</script>
@endsection

