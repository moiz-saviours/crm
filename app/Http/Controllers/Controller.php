<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class Controller
{
    use AuthorizesRequests, ValidatesRequests;

    function getCardType($cardNumber)
    {
        $cardNumber = preg_replace('/\D/', '', $cardNumber);
        $cardTypes = [
            'Visa' => '/^4[0-9]{12}(?:[0-9]{3})?$/',
            'MasterCard' => '/^(?:5[1-5][0-9]{14}|2(?:2[2-9][0-9]{12}|[3-6][0-9]{13}|7[01][0-9]{12}|720[0-9]{12}))$/',
            'American Express' => '/^3[47][0-9]{13}$/',
            'Discover' => '/^6(?:011|5[0-9]{2}|4[4-9][0-9]|22(?:12[6-9]|[3-9][0-9]{2}|[2-9][0-9]))[0-9]{12}$/',
            'Diners Club' => '/^3(?:0[0-5]|[68][0-9])[0-9]{11}$/',
            'JCB' => '/^(?:2131|1800|35\d{3})\d{11}$/',
        ];
        foreach ($cardTypes as $type => $pattern) {
            if (preg_match($pattern, $cardNumber)) {
                return $type;
            }
        }
        return 'Unknown';
    }

    protected function smartResponse($request, $data = [], $routeName = null, $successMessage = 'Operation successful.',$key='data')
    {
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $successMessage,
                $key => $data
            ]);
        }
        return redirect()->route($routeName)->with('success', $successMessage);
    }

    protected function smartError($request, \Throwable $exception, $status = 500)
    {
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => false,
                'error' => 'Something went wrong',
                'message' => $exception->getMessage(),
                'line' => $exception->getLine()
            ], $status);
        }
        return redirect()->back()->withErrors(['error' => $exception->getMessage()]);
    }

    public function newGlobalFunction(string $functionName, array $values = []): mixed
    {
        if (!function_exists($functionName)) {
            return $functionName(function (...$params) {
                return null;
            }, $values);
        }
        return $functionName(...$values);
    }
}
