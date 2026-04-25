<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Library\BasicLibrary;
use App\Library\Commission_increment;
use App\Library\GetcommissionLibrary;
use App\Models\Api;
use App\Models\Apiresponse;
use App\Models\Balance;
use App\Models\Gatewayorder;
use App\Models\Member;
use App\Models\Provider;
use App\Models\Report;
use App\Models\Traceurl;
use App\Models\User;
use Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use QrCode;
use Validator;

class PayinNineController extends Controller
{
    private $api_id;
    private $provider_id;
    private $min_amount;
    private $max_amount;
    private $base_url;
    private $strategy;
    private $email;
    private $password;
    private $user_token;

    public function __construct()
    {
        $this->api_id = 16;
        $this->provider_id = 340;

        $provider = Provider::find($this->provider_id);
        $this->min_amount = isset($provider->min_amount) ? $provider->min_amount : 10;
        $this->max_amount = isset($provider->max_amount) ? $provider->max_amount : 50000;

        $credentials = json_decode(optional(Api::find($this->api_id))->credentials);
        $this->base_url = rtrim($credentials->base_url ?? '', '/');
        $this->strategy = $credentials->strategy ?? 'local';
        $this->email = $credentials->email ?? '';
        $this->password = $credentials->password ?? '';
        $this->user_token = $credentials->user_token ?? '';
    }

    private function generateToken()
    {
        if (empty($this->base_url) || empty($this->email) || empty($this->password)) {
            Log::error('Payin9 generateToken: missing credentials');
            return '';
        }

        $url = $this->base_url . '/authentication';
        $headers = [
            'Content-Type: application/json',
            'accept: application/json',
        ];
        $payload = [
            'strategy' => $this->strategy,
            'email' => $this->email,
            'password' => $this->password,
        ];

        $response = Helpers::pay_curl_post($url, $headers, json_encode($payload), 'POST');
        Apiresponse::insertGetId([
            'message' => $response,
            'api_type' => 1,
            'created_at' => now(),
            'ip_address' => request()->ip(),
        ]);

        $decoded = json_decode($response, true);
        return (string)($decoded['response']['accessUserToken'] ?? '');
    }

    public function welcome()
    {
        $user_id = Auth::id();
        $library = new BasicLibrary();
        $activeService = $library->getActiveService($this->provider_id, $user_id);
        if (($activeService['status_id'] ?? 0) == 1) {
            return view('agent.add-money.payin9')->with([
                'page_title' => 'Payin 9',
                'min_amount' => $this->min_amount,
                'max_amount' => $this->max_amount,
            ]);
        }
        return redirect()->back();
    }

    public function createOrderWeb(Request $request)
    {
        $rules = ['amount' => 'required|numeric|between:' . $this->min_amount . ',' . $this->max_amount];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['status' => 'failure', 'message' => $validator->messages()->first()]);
        }

        return $this->createOrderMiddle(
            $request->amount,
            Auth::id(),
            'WEB',
            '',
            '',
            Auth::user()->name,
            Auth::user()->email,
            Auth::user()->mobile
        );
    }

    public function createOrderApi(Request $request)
    {
        $rules = [
            'amount' => 'required|numeric|between:' . $this->min_amount . ',' . $this->max_amount,
            'client_id' => 'required',
            'callback_url' => 'required|url',
            'customer_name' => 'required|string|max:255',
            'mobile_number' => 'required|digits:10',
            'email' => 'required|email|max:255',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['status' => 'failure', 'message' => $validator->messages()->first()]);
        }

        return $this->createOrderMiddle(
            $request->amount,
            Auth::id(),
            'API',
            $request->callback_url,
            $request->client_id,
            $request->customer_name,
            $request->email,
            $request->mobile_number
        );
    }

    private function createOrderMiddle($amount, $user_id, $mode, $callback_url, $client_id, $name, $email, $mobile)
    {
        $library = new BasicLibrary();
        $activeService = $library->getActiveService($this->provider_id, $user_id);
        if (($activeService['status_id'] ?? 0) != 1) {
            return response()->json(['status' => 'failure', 'message' => 'Service not active!']);
        }

        $jwt = $this->generateToken();
        if (empty($jwt)) {
            return response()->json(['status' => 'failure', 'message' => 'Unable to generate token']);
        }
        if (empty($this->user_token)) {
            return response()->json(['status' => 'failure', 'message' => 'User token missing in API credentials']);
        }

        $ctime = now();
        $member = Member::where('user_id', $user_id)->first();
        $gatewayOrderId = Gatewayorder::insertGetId([
            'user_id' => $user_id,
            'purpose' => 'Add Money',
            'amount' => $amount,
            'email' => $email,
            'ip_address' => request()->ip(),
            'created_at' => $ctime,
            'status_id' => 3,
            'api_id' => $this->api_id,
            'callback_url' => $callback_url,
            'payoutcallbackurl' => $member->payoutcallbackurl ?? '',
            'client_id' => $client_id,
            'mode' => $mode,
            'order_token' => 'P9TMP' . time() . rand(1000, 9999),
        ]);

        $refId = 'P9' . $gatewayOrderId . time();
        Gatewayorder::where('id', $gatewayOrderId)->update(['order_token' => $refId]);
        if ($mode === 'WEB' || empty($client_id)) {
            Gatewayorder::where('id', $gatewayOrderId)->update(['client_id' => $refId]);
        }

        $splitName = preg_split('/\s+/', trim((string)$name));
        $firstName = $splitName[0] ?? 'Customer';
        $lastName = isset($splitName[1]) ? implode(' ', array_slice($splitName, 1)) : 'User';
        $payload = [
            'userTransactionId' => $refId,
            'amount' => (float)$amount,
            'userToken' => $this->user_token,
            'customer_details' => [
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => (string)$email,
                'phone' => (string)$mobile,
            ],
            'billing_address' => [
                'address' => 'N/A',
                'street' => 'N/A',
                'city' => 'N/A',
                'state' => 'N/A',
                'country' => 'IN',
                'pincode' => '000000',
            ],
        ];

        $url = $this->base_url . '/api/v1/collection';
        $headers = [
            'Authorization: Bearer ' . $jwt,
            'Content-Type: application/json',
            'accept: application/json',
        ];
        $response = Helpers::pay_curl_post($url, $headers, json_encode($payload), 'POST');
        Apiresponse::insertGetId([
            'message' => $response,
            'api_type' => 1,
            'created_at' => now(),
            'ip_address' => request()->ip(),
        ]);

        $res = json_decode($response, true);
        if (!is_array($res)) {
            return response()->json(['status' => 'failure', 'message' => 'Invalid provider response']);
        }

        $statusMsg = strtolower((string)($res['statusMsg'] ?? ''));
        $upiIntent = (string)($res['upiIntentStr'] ?? '');
        $base64Qr = (string)($res['base64Qr'] ?? '');
        $acquirerRef = (string)($res['acquirerRef'] ?? '');
        $providerRef = (string)($res['referenceId'] ?? $refId);
        $code = (int)($res['code'] ?? 0);

        Gatewayorder::where('id', $gatewayOrderId)->update([
            'remark' => $acquirerRef ?: $providerRef,
        ]);

        if ($code !== 200 && empty($upiIntent) && empty($base64Qr)) {
            return response()->json([
                'status' => 'failure',
                'message' => $res['messageString'] ?? $res['statusMsg'] ?? 'Failed to create order',
            ]);
        }

        $data = [
            'txnid' => $gatewayOrderId,
            'order_token' => $refId,
            'transaction_id' => $acquirerRef,
            'reference_id' => $providerRef,
            'qrString' => $upiIntent,
            'base64Qr' => $base64Qr,
            'status' => $statusMsg ?: 'pending',
        ];

        return response()->json([
            'status' => 'success',
            'message' => 'Order created successfully',
            'data' => $data,
        ]);
    }

    public function viewQrcode(Request $request)
    {
        return response(QrCode::size(300)->generate($request->upi_string), 200)
            ->header('Content-Type', 'image/svg+xml');
    }

    public function webOrderStatus(Request $request)
    {
        $rules = ['txnid' => 'required|integer'];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['ok' => false, 'message' => $validator->messages()->first()]);
        }

        $gatewayOrder = Gatewayorder::where('id', (int)$request->txnid)
            ->where('user_id', Auth::id())
            ->where('api_id', $this->api_id)
            ->first();
        if (!$gatewayOrder) {
            return response()->json(['ok' => false, 'message' => 'Order not found']);
        }

        $sid = (int)$gatewayOrder->status_id;
        if ($sid === 1) {
            return response()->json([
                'ok' => true,
                'payment_status' => 'success',
                'data' => ['utr' => (string)$gatewayOrder->remark, 'amount' => (float)$gatewayOrder->amount],
            ]);
        }
        if ($sid === 2) {
            return response()->json(['ok' => true, 'payment_status' => 'failed', 'message' => 'Payment failed']);
        }
        return response()->json(['ok' => true, 'payment_status' => 'pending']);
    }

    private function forwardMemberCallback($userId, $status, $clientId, $amount, $utr, $txnid, $ctime)
    {
        $member = Member::where('user_id', $userId)->first();
        if (empty($member->call_back_url)) {
            return;
        }
        $user = User::find($userId);
        if (!$user || empty($user->api_token)) {
            return;
        }

        $queryParams = [
            'status' => $status,
            'client_id' => $clientId,
            'amount' => $amount,
            'utr' => $utr,
            'txnid' => $txnid,
        ];
        $signatureString = http_build_query($queryParams);
        $queryParams['signature'] = hash_hmac('sha256', $signatureString, $user->api_token);
        $url = $member->call_back_url . '?' . http_build_query($queryParams);
        $response = Helpers::pay_curl_get($url);
        Traceurl::insertGetId([
            'user_id' => $userId,
            'url' => $url,
            'number' => $user->mobile,
            'response_message' => $response,
            'created_at' => $ctime,
        ]);
    }

    public function callbackUrl(Request $request)
    {
        $ctime = now();
        $rawPayload = $request->all();
        Apiresponse::insertGetId([
            'message' => json_encode($rawPayload),
            'api_type' => 1,
            'created_at' => $ctime,
            'ip_address' => request()->ip(),
        ]);

        $event = (string)($request->input('event') ?? '');
        $data = $request->input('data', []);
        if (!is_array($data)) {
            $data = [];
        }

        $clientId = (string)($data['userTransactionId'] ?? '');
        $status = strtolower((string)($data['status'] ?? ''));
        $statusCode = (int)($data['statusCode'] ?? -1);
        $utr = (string)($data['utr'] ?? $data['bankId'] ?? '');
        $transactionId = (string)($data['transactionId'] ?? '');

        if (empty($clientId)) {
            return response()->json(['status' => 'failure', 'message' => 'Missing userTransactionId'], 400);
        }

        return DB::transaction(function () use ($ctime, $event, $status, $statusCode, $clientId, $utr, $transactionId) {
            $gatewayOrder = Gatewayorder::where('client_id', $clientId)->lockForUpdate()->first();
            if (!$gatewayOrder) {
                $gatewayOrder = Gatewayorder::where('order_token', $clientId)->lockForUpdate()->first();
            }
            if (!$gatewayOrder) {
                return response()->json(['status' => 'failure', 'message' => 'Order not found'], 404);
            }

            $isSuccess = $event === 'PAYIN_SUCCESS' || $status === 'success' || $statusCode === 1;
            $isFailed = in_array($event, ['PAYIN_FAILED', 'PAYIN_EXPIRED'], true) || in_array($status, ['failed', 'expired'], true) || in_array($statusCode, [0, 2], true);

            if ($isFailed) {
                Gatewayorder::where('id', $gatewayOrder->id)->update([
                    'status_id' => 2,
                    'remark' => $utr ?: $transactionId,
                ]);
                $this->forwardMemberCallback(
                    $gatewayOrder->user_id,
                    'failed',
                    $gatewayOrder->client_id ?: $gatewayOrder->order_token,
                    (float)$gatewayOrder->amount,
                    $utr,
                    $gatewayOrder->id,
                    $ctime
                );
                return response()->json(['status' => 'success', 'message' => 'Failed webhook accepted']);
            }

            if (!$isSuccess) {
                return response()->json(['status' => 'success', 'message' => 'Ignored non-payin event']);
            }

            if ((int)$gatewayOrder->status_id === 1) {
                return response()->json(['status' => 'success', 'message' => 'Already processed']);
            }

            if (!empty($utr) && Report::where('txnid', $utr)->exists()) {
                return response()->json(['status' => 'failure', 'message' => 'Duplicate transaction']);
            }

            Gatewayorder::where('id', $gatewayOrder->id)->update(['status_id' => 9]);

            $user = User::find($gatewayOrder->user_id);
            if (!$user) {
                return response()->json(['status' => 'failure', 'message' => 'User not found']);
            }

            $openingBalance = $user->balance->aeps_balance ?? 0;
            $commissionLib = new GetcommissionLibrary();
            $commission = $commissionLib->get_commission($user->scheme_id, $this->provider_id, $gatewayOrder->amount);

            $retailer = $commission['retailer'] ?? 0;
            $d = $commission['distributor'] ?? 0;
            $sd = $commission['sdistributor'] ?? 0;
            $st = $commission['sales_team'] ?? 0;
            $rf = $commission['referral'] ?? 0;
            $creditAmount = (float)$gatewayOrder->amount - (float)$retailer;

            Balance::where('user_id', $user->id)->increment('aeps_balance', $creditAmount);
            $newBalance = Balance::where('user_id', $user->id)->value('aeps_balance');

            $reportId = Report::insertGetId([
                'number' => $user->mobile,
                'provider_id' => $this->provider_id,
                'amount' => $gatewayOrder->amount,
                'api_id' => $this->api_id,
                'status_id' => 6,
                'created_at' => $ctime,
                'user_id' => $user->id,
                'profit' => '-' . $retailer,
                'mode' => $gatewayOrder->mode,
                'txnid' => $utr ?: ($transactionId ?: $gatewayOrder->order_token),
                'ip_address' => $gatewayOrder->ip_address,
                'description' => 'Add Money via Payin 9',
                'opening_balance' => $openingBalance,
                'total_balance' => $newBalance,
                'credit_by' => $user->id,
                'wallet_type' => 2,
                'client_id' => $gatewayOrder->client_id ?? '',
            ]);

            if ($gatewayOrder->mode !== 'API') {
                Report::where('id', $reportId)->update(['client_id' => $reportId]);
            }

            Gatewayorder::where('id', $gatewayOrder->id)->update([
                'status_id' => 1,
                'report_id' => $reportId,
                'remark' => $utr ?: $transactionId,
            ]);

            try {
                $parentCommission = new Commission_increment();
                $parentCommission->parent_recharge_commission(
                    $user->id,
                    $user->mobile,
                    $reportId,
                    $this->provider_id,
                    $gatewayOrder->amount,
                    $this->api_id,
                    $retailer,
                    $d,
                    $sd,
                    $st,
                    $rf
                );
            } catch (\Exception $e) {
                Log::error('Payin9 callback: commission error', ['error' => $e->getMessage()]);
            }

            if (!empty($gatewayOrder->callback_url)) {
                $queryParams = [
                    'status' => 'credit',
                    'client_id' => $gatewayOrder->client_id,
                    'amount' => (float)$gatewayOrder->amount,
                    'utr' => $utr,
                    'txnid' => $gatewayOrder->id,
                ];
                $signatureString = http_build_query($queryParams);
                $queryParams['signature'] = hash_hmac('sha256', $signatureString, $user->api_token);
                $cbUrl = $gatewayOrder->callback_url . '?' . http_build_query($queryParams);
                $cbResponse = Helpers::pay_curl_get($cbUrl);
                Traceurl::insertGetId([
                    'user_id' => $user->id,
                    'url' => $cbUrl,
                    'number' => $user->mobile,
                    'response_message' => $cbResponse,
                    'created_at' => $ctime,
                ]);
            }

            $this->forwardMemberCallback(
                $user->id,
                'credit',
                $gatewayOrder->client_id ?: $gatewayOrder->order_token,
                (float)$gatewayOrder->amount,
                $utr,
                $gatewayOrder->id,
                $ctime
            );

            return response()->json(['status' => 'success', 'message' => 'Transaction successful']);
        });
    }

    public function statusEnquiryApi(Request $request)
    {
        $rules = ['client_id' => 'required|exists:gatewayorders,client_id'];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['status' => 'failure', 'message' => $validator->messages()->first()]);
        }

        $gatewayOrder = Gatewayorder::where('client_id', $request->client_id)
            ->where('user_id', Auth::id())
            ->orderBy('id', 'DESC')
            ->first();
        if (!$gatewayOrder) {
            return response()->json(['status' => false, 'message' => 'No matching report found!']);
        }

        $report = Report::find($gatewayOrder->report_id);
        if (!$report) {
            return response()->json(['status' => false, 'message' => 'No matching report found!']);
        }

        return response()->json([
            'status' => true,
            'message' => 'Transaction record found successfully!',
            'data' => [
                'client_id' => $request->client_id,
                'report_id' => $report->id,
                'amount' => $report->amount,
                'utr' => $report->txnid,
                'status' => 'credit',
            ],
        ]);
    }
}

