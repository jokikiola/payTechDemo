<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RechargeController extends Controller
{
    public const API_KEY = 'Token de6b5779995c4967002410a9ad9b4f0169823e86';

    //
    public function index()
    {
        return view('project.recharge.index');
    }

    public function fetchTransactions(): JsonResponse
    {
        $transactions = Transaction::with('plan.product.service')->get();
        return response()->json([
            'data' => $transactions,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $this->validateRequest($request);
        $status = $this->apiCall($request);
        $this->createTransaction($request, $status);
        return response()->json([
            'message' => 'Recharge successful'
        ]);
    }

    private function validateRequest($request)
    {
        $request->validate([
            'service' => 'required',
            'product' => 'required',
            'plan' => 'required',
            'amount' => 'required',
            'telephone' => 'required',
        ], [
            'service.required' => 'Select a service',
            'product.required' => 'Select a product',
            'plan.required' => 'Select Plan',
            'telephone' => 'Enter decoder number or telephone number'
        ]);
    }

    private function createTransaction($request, $status)
    {
        $transaction = new Transaction();
        $transaction->create([
            'plan_id' => $request['plan'],
            'user_id' => 1,
            'amount' => $request['amount'],
            'digit' => $request['telephone'],
            'other_charges' => 0.00,
            'status' => $status,
            'transaction_date' => date('Y-m-d'),
        ]);
    }

    private function apiCall($request)
    {

        return $status = 1;
    }

    /**
     * Fetch plan
     * @param Product $product
     * @return JsonResponse
     */
    public function fetchPlan(Product $product): JsonResponse
    {
        $host = 'https://www.vtukonnect.com/api/user/';
        $refer = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $api = self::API_KEY;
        $data = array(
            'api' => $api,
        );

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $host,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_ENCODING => "",
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_REFERER => $refer,
            CURLOPT_HTTPHEADER => array("Authorization: $api"),
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_POSTREDIR => 3,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
        ));
        $r = curl_exec($curl);
        curl_close($curl);
        //dd(json_decode($r,true));

        $apiresponse = json_decode($r, true);
        $plans = $product->plan()->get();
        return response()->json([
            'data' => $plans,
            'networks' => $apiresponse['data plans'],

        ]);

    }

    /**
     * fetch plan information such as price
     * @param Plan $plan
     * @return JsonResponse
     */
    public function fetchPrice(Plan $plan): JsonResponse
    {
        return response()->json([
            'data' => $plan
        ]);
    }
}
