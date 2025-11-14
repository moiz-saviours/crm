<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentTransactionLog;
use Illuminate\Http\Request;

class PaymentTransactionLogController extends Controller
{
    public function getLogs(Request $request)
    {
        try {

            $code = [
                'edp' => [
                    'result_codes' => ['100' => 'Transaction was approved.',
                        '200' => 'Transaction was declined by processor.',
                        '201' => 'Do not honor.',
                        '202' => 'Insufficient funds.',
                        '203' => 'Over limit.',
                        '204' => 'Transaction not allowed.',
                        '220' => 'Incorrect payment information.',
                        '221' => 'No such card issuer.',
                        '222' => 'No card number on file with issuer.',
                        '223' => 'Expired card.',
                        '224' => 'Invalid expiration date.',
                        '225' => 'Invalid card security code.',
                        '226' => 'Invalid PIN.',
                        '240' => 'Call issuer for further information.',
                        '250' => 'Pick up card.',
                        '251' => 'Lost card.',
                        '252' => 'Stolen card.',
                        '253' => 'Fraudulent card.',
                        '260' => 'Declined with further instructions available. (See response text)',
                        '261' => 'Declined-Stop all recurring payments.',
                        '262' => 'Declined-Stop this recurring program.',
                        '263' => 'Declined-Update cardholder data available.',
                        '264' => 'Declined-Retry in a few days.',
                        '300' => 'Transaction was rejected by gateway.',
                        '400' => 'Transaction error returned by processor.',
                        '410' => 'Invalid merchant configuration.',
                        '411' => 'Merchant account is inactive.',
                        '420' => 'Communication error.',
                        '421' => 'Communication error with issuer.',
                        '430' => 'Duplicate transaction at processor.',
                        '440' => 'Processor format error.',
                        '441' => 'Invalid transaction information.',
                        '460' => 'Processor feature not available.',
                        '461' => 'Unsupported card type.'
                    ],
                    'cvv_response_codes' => [
                        'M' => 'CVV2/CVC2 match',
                        'N' => 'CVV2/CVC2 no match',
                        'P' => 'Not processed',
                        'S' => 'Merchant has indicated that CVV2/CVC2 is not present on card',
                        'U' => 'Issuer is not certified and/or has not provided Visa encryption keys',
                    ],
                    'avs_response_codes' => [
                        'X' => 'Exact match, 9-character numeric ZIP',
                        'Y' => 'Exact match, 5-character numeric ZIP',
                        'D' => 'Exact match, 5-character numeric ZIP',
                        'M' => 'Exact match, 5-character numeric ZIP',
                        '2' => 'Exact match, 5-character numeric ZIP, customer name',
                        '6' => 'Exact match, 5-character numeric ZIP, customer name',
                        'A' => 'Address match only',
                        '3' => 'Address, customer name match only',
                        '7' => 'Address, customer name match only',
                        'W' => '9-character numeric ZIP match only',
                        'Z' => '5-character ZIP match only',
                        'P' => '5-character ZIP match only',
                        'L' => '5-character ZIP match only',
                        '1' => '5-character ZIP, customer name match only',
                        '5' => '5-character ZIP, customer name match only',
                        'N' => 'No address or ZIP match only',
                        'C' => 'No address or ZIP match only',
                        '4' => 'No address or ZIP or customer name match only',
                        '8' => 'No address or ZIP or customer name match only',
                        'U' => 'Address unavailable',
                        'G' => 'Non-U.S. issuer does not participate',
                        'I' => 'Non-U.S. issuer does not participate',
                        'R' => 'Issuer system unavailable',
                        'E' => 'Not a mail/phone order',
                        'S' => 'Service not supported',
                        '0' => 'AVS not available',
                        'O' => 'AVS not available',
                        'B' => 'AVS not available',
                    ],
                ],
                'authorize' => [
                    'response_codes' => [
                        '1' => 'This transaction has been approved.',
                        '2' => 'This transaction has been declined. General bank decline',
                        '3' => 'This transaction has been declined. Referral to voice authorization',
                        '4' => 'Held for Review',
                        '35' => 'An error occurred during processing.Call Merchant Service Provider.	Unknown error occurred during processing',
                    ],
                    'cvv_result_codes' => [
                        'M' => 'Successful Match',
                        'N' => 'Does NOT Match',
                        'P' => 'CVV was not processed.',
                        'S' => 'CVV should be on card, but is not indicated',
                        'U' => 'The issuer was unable to process the CVV check.',
                    ],
                    'avs_result_codes' => [
                        'A' => 'The street address matched, but the postal code did not.',
                        'B' => 'No address information was provided.',
                        'E' => 'AVS data provided is invalid or AVS is not allowed for the card type that was used.',
                        'G' => 'The card issuing bank is of non-U.S. origin and does not support AVS.',
                        'N' => 'Neither the street address nor postal code matched.',
                        'P' => 'AVS is not applicable for this transaction.',
                        'R' => 'The AVS system was unavailable at the time of processing.',
                        'S' => 'AVS is not supported by card issuer.',
                        'U' => 'The address information for the cardholder is unavailable.',
                        'W' => 'The US ZIP+4 code matches, but the street address does not.',
                        'X' => 'Both the street address and the US ZIP+4 code matched.',
                        'Y' => 'The street address and postal code matched.',
                        'Z' => 'The postal code matched, but the street address did not.',
                    ],
                    'cavv_result_codes' => [
                        '0' => 'CAVV was not validated because erroneous data was submitted.',
                        '1' => 'CAVV failed validation.',
                        '2' => 'CAVV passed validation.',
                        '3' => 'CAVV validation could not be performed; issuer attempt incomplete.',
                        '4' => 'CAVV validation could not be performed; issuer system error.',
                        '5' => 'Reserved for future use.',
                        '6' => 'Reserved for future use.',
                        '7' => 'CAVV failed validation, but the issuer is available. Valid for U.S.-issued card submitted to non-U.S acquirer.',
                        '8' => 'CAVV passed validation and the issuer is available. Valid for U.S.-issued card submitted to non-U.S. acquirer.',
                        '9' => 'CAVV failed validation and the issuer is unavailable. Valid for U.S.-issued card submitted to non-U.S acquirer.',
                        'A' => 'CAVV passed validation but the issuer unavailable. Valid for U.S.-issued card submitted to non-U.S acquirer.',
                        'B' => 'CAVV passed validation, information only, no liability shift.',
                    ]
                ]
            ];
            $logs = PaymentTransactionLog::select(['merchant_id', 'gateway', 'transaction_id', 'response', 'transaction_response', 'response_code', 'last_4', 'amount', 'status', 'response_message', 'error_message', 'created_at'])->where('invoice_key', $request->input('invoice_key'))
                ->orderBy('created_at', 'desc')
                ->with('payment_merchant:name,id')
                ->get()
                ->map(function ($log) use ($code) {
                    if ($log->gateway == 'Edp') {
                        $responseData = json_decode($log->response, true);
                        if ($responseData['response_code'] && isset($code['edp']['result_codes'][(string)$responseData['response_code']])) {
                            $log->response_code_message = "Code ({$log->response_code}): " . $code['edp']['result_codes'][(string)$responseData['response_code']];
                        }
                        if ($responseData['avsresponse'] && isset($code['edp']['avs_response_codes'][(string)$responseData['avsresponse']])) {
                            $log->avs_message = "AVS ({$responseData['avsresponse']}): " . $code['edp']['avs_response_codes'][(string)$responseData['avsresponse']];
                        }
                        if ($responseData['cvvresponse'] && isset($code['edp']['cvv_response_codes'][(string)$responseData['cvvresponse']])) {
                            $log->cvv_message = "CVV ({$responseData['cvvresponse']}): " . $code['edp']['cvv_response_codes'][(string)$responseData['cvvresponse']];
                        }
                    } elseif ($log->gateway == 'Authorize.net') {
                        $responseData = json_decode($log->transaction_response, true);
                        $responseCode = null;
                        if (isset($responseData['responseCode'])) {
                            $responseCode = $responseData['responseCode'];
                        } elseif (isset($responseData['messages']['message'][0]['code'])) {
                            $responseCode = $responseData['messages']['message'][0]['code'];
                        }
                        if ($responseCode && isset($code['authorize']['response_codes'][(string)$responseCode])) {
                            $log->response_code_message = "Code ({$responseCode}): " . $code['authorize']['response_codes'][(string)$responseCode];
                        }
                        if (isset($responseData['avsResultCode']) && isset($code['authorize']['avs_result_codes'][$responseData['avsResultCode']])) {
                            $log->avs_message = "AVS ({$responseData['avsResultCode']}): " . $code['authorize']['avs_result_codes'][$responseData['avsResultCode']];
                        }
                        if (isset($responseData['cvvResultCode']) && isset($code['authorize']['cvv_result_codes'][$responseData['cvvResultCode']])) {
                            $log->cvv_message = "CVV ({$responseData['cvvResultCode']}): " . $code['authorize']['cvv_result_codes'][$responseData['cvvResultCode']];
                        }
                        if (isset($responseData['cavvResultCode']) && isset($code['authorize']['cavv_result_codes'][$responseData['cavvResultCode']])) {
                            $log->cavv_message = "CAVV ({$responseData['cavvResultCode']}): " . $code['authorize']['cavv_result_codes'][$responseData['cavvResultCode']];
                        }
                    }
                    $log->response = null;
                    $log->transaction_response = null;
                    $log->merchant = $log->payment_merchant->name ?? null;
                    return $log;
                });
            return response()->json(['status' => 'success', 'logs' => $logs]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage(), 'line' => $e->getLine()]);
        }
    }
}
