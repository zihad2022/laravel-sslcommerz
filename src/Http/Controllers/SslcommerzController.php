<?php

namespace Devzihad\LaravelSslcommerz\Http\Controllers;

use App\Http\Controllers\Controller;
use Devzihad\LaravelSslcommerz\Services\SslCommerzService;
use Illuminate\Http\Request;

class SslCommerzController extends Controller
{
    protected $sslCommerzService;

    public function __construct(SslCommerzService $sslCommerzService)
    {
        $this->sslCommerzService = $sslCommerzService;
    }

    public function paymentInitiate(Request $request)
    {
        $data = [
            'total_amount' => $request->input('amount'),
            'currency' => 'BDT',
            'tran_id' => uniqid(),
            'success_url' => route('sslcommerz.callback'),
            'fail_url' => route('sslcommerz.callback'),
            'cancel_url' => route('sslcommerz.callback'),
        ];

        $response = $this->sslCommerzService->initiatePayment($data);

        if (isset($response['GatewayPageURL'])) {
            return redirect($response['GatewayPageURL']);
        }

        return response()->json(['error' => 'Unable to initiate payment'], 500);
    }

    public function paymentCallback(Request $request)
    {
        $validatedResponse = $this->sslCommerzService->validateTransaction($request->input('val_id'));

        if ($validatedResponse['status'] == 'VALID') {
            return response()->json(['message' => 'Payment successful']);
        }

        return response()->json(['error' => 'Payment validation failed'], 400);
    }
}
