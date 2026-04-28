<?php

namespace App\library {

    use App\Models\Api;
    use App\Models\Apiresponse;
    use Helpers;

    class PayinNineLibrary
    {
        public function __construct()
        {
            $this->api_id = 16;
            $credentials = json_decode(optional(Api::find($this->api_id))->credentials);
            $this->base_url = rtrim($credentials->base_url ?? '', '/');
            $this->strategy = $credentials->strategy ?? 'local';
            $this->username = $credentials->username ?? '';
            $this->email = $credentials->email ?? ($credentials->username ?? '');
            $this->password = $credentials->password ?? '';
            $this->user_token = $credentials->user_token ?? '';
            $this->api_access_id = $credentials->{'api-access-id'} ?? ($credentials->api_access_id ?? '');
            $this->api_access_secret = $credentials->{'api-access-secret'} ?? ($credentials->api_access_secret ?? '');
            $this->auth_endpoint = $credentials->auth_endpoint ?? '/Auth/1.0/getAuthToken';
            $this->disbursement_endpoint = $credentials->disbursement_endpoint ?? '/api/v1/disbursement';
        }

        public function transferNow($user_id, $mobile_number, $amount, $beneficiary_name, $account_number, $ifsc_code, $insert_id)
        {
            $jwt = $this->generateToken($insert_id);
            if (empty($jwt)) {
                return ['status_id' => 2, 'txnid' => 'Authentication failed', 'payid' => ''];
            }

            $nameParts = preg_split('/\s+/', trim((string)$beneficiary_name));
            $beneName = $beneficiary_name ?: 'Beneficiary';
            $payload = [
                'userTransactionId' => (string)$insert_id,
                'amount' => (float)$amount,
                'payeeDetails' => [
                    'accountType' => 'savings',
                    'ifsc' => (string)$ifsc_code,
                    'branch' => '',
                    'accountNumber' => (string)$account_number,
                    'bene_name' => (string)$beneName,
                    'bene_address' => '',
                    'bene_bankName' => '',
                    'bene_email' => '',
                    'bene_mobile' => (string)$mobile_number,
                    'latitude' => '0',
                    'longitude' => '0',
                ],
            ];
            if (!empty($this->user_token)) {
                $payload['token'] = $this->user_token;
            }

            $url = $this->base_url . $this->disbursement_endpoint;
            $headers = [
                'Authorization: Bearer ' . $jwt,
                'api-access-id: ' . $this->api_access_id,
                'api-access-secret: ' . $this->api_access_secret,
                'Content-Type: application/json',
                'accept: application/json',
            ];
            $requestBody = json_encode($payload);
            $response = Helpers::pay_curl_post($url, $headers, $requestBody, 'POST');

            Apiresponse::insertGetId([
                'message' => $response,
                'api_type' => $this->api_id,
                'report_id' => $insert_id,
                'request_message' => $url . '?' . $requestBody,
            ]);

            $res = json_decode($response, true);
            if (!is_array($res)) {
                return ['status_id' => 3, 'txnid' => 'Invalid response', 'payid' => ''];
            }

            $status = strtolower((string)($res['status'] ?? 'pending'));
            $utr = (string)($res['utr'] ?? $res['bankTransactionId'] ?? '');
            $payid = (string)($res['txn_id'] ?? $res['id'] ?? '');
            $message = (string)($res['messageString'] ?? $res['message'] ?? '');

            if ($status === 'success') {
                return ['status_id' => 1, 'txnid' => $utr, 'payid' => $payid];
            }
            if ($status === 'failed' || $status === 'failure') {
                return ['status_id' => 2, 'txnid' => ($message ?: 'Transaction failed'), 'payid' => $payid];
            }

            return ['status_id' => 3, 'txnid' => '', 'payid' => $payid];
        }

        private function generateToken($insert_id)
        {
            if (empty($this->base_url)) {
                return '';
            }

            if (empty($this->password) || (empty($this->username) && empty($this->email))) {
                return '';
            }
            $url = $this->base_url . $this->auth_endpoint;
            $username = $this->username ?: $this->email;
            $payload = [
                'strategy' => $this->strategy,
                'username' => $username,
                'password' => $this->password,
            ];
            $headers = [
                'api-access-id: ' . $this->api_access_id,
                'api-access-secret: ' . $this->api_access_secret,
                'Content-Type: application/json',
                'accept: application/json',
            ];
            $requestBody = json_encode($payload);
            $response = Helpers::pay_curl_post($url, $headers, $requestBody, 'POST');

            Apiresponse::insertGetId([
                'message' => $response,
                'api_type' => $this->api_id,
                'report_id' => $insert_id,
                'request_message' => $url . '?' . $requestBody,
            ]);

            $res = json_decode($response, true);
            if (!is_array($res)) {
                return '';
            }
            return (string)(
                $res['response']['accessUserToken']
                    ?? $res['accessUserToken']
                    ?? $res['response']['token']
                    ?? $res['token']
                    ?? $res['accessToken']
                    ?? $res['token']
                    ?? ''
            );
        }
    }
}

