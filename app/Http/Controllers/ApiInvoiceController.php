<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ApiInvoiceController extends Controller
{
    /**
     * Fetch the invoice details by the invoice key.
     *
     * @param string $invoice_key
     * @return JsonResponse
     */
    public function fetch_invoice($invoice_key)
    {
        try {
            $this->validateInvoiceKey($invoice_key);
            $invoice = Invoice::where('invoice_key', $invoice_key)->firstOrFail();
            $invoice->loadMissing('brand', 'team', 'customer_contact', 'agent');
            $brand = optional($invoice->brand);
            $customer = optional($invoice->customer_contact);
            $agent = optional($invoice->agent);

            isset($invoice->invoice_merchants) ? $invoice->invoice_merchants->sortBy('merchant_type')->pluck('merchant_type')->toArray() : [];
            $payment_methods = [];
            if (isset($invoice->invoice_merchants)) {
                foreach ($invoice->invoice_merchants->sortBy('merchant_type') as $invoice_merchant) {
                    $merchant = $invoice_merchant->merchant;
                    if ($merchant && $merchant->status == 'active' && $merchant->limit >= $invoice->total_amount && $merchant->hasSufficientLimitAndCapacity($merchant->id, $invoice->total_amount)->exists()) {
                        $payment_methods[] = $invoice_merchant->merchant_type;
                    }
                }
            }
            $data = [
                "id" => $invoice->id,
                "invoice_key" => $invoice->invoice_key,
                "invoice_number" => $invoice->invoice_number,
                "description" => $invoice->description,
                'currency' => $invoice->currency,
                'amount' => $invoice->amount,
                'taxable' => $invoice->taxable,
                'tax_type' => $invoice->tax_type,
                'tax_value' => $invoice->tax_value,
                'tax_amount' => $invoice->tax_amount,
                'total_amount' => $invoice->total_amount,
                "type" => $invoice->type,
                "created_at" => $invoice->created_at->format('jS F Y'),
                "due_date" => carbon::parse($invoice->due_date)->format('jS F Y'),
                "status" => $invoice->status,
                "brand" => [
                    "name" => $brand->name,
                    "url" => $brand->url,
                    "logo" => asset('assets/images/brand-logos/' . $brand->logo),
                    "email" => $brand->email,
                    "description" => $brand->description,
                ],
                'customer' => [
                    "name" => $customer->name,
                    "email" => $customer->email,
                    "phone" => $customer->phone,
                    "address" => $customer->address,
                    "city" => $customer->city,
                    "state" => $customer->state,
                    "zipcode" => $customer->zipcode,
                    "country" => $customer->country,
                ],
                'agent' => [
                    "name" => $agent->name,
                    "email" => $agent->email,
                ],
                'payment_methods' => $payment_methods,
            ];
            return response()->json(['success' => true, 'invoice' => $data, 'current_date' => Carbon::now()->format('jS F Y')]);
        } catch (ValidationException $exception) {
            return response()->json(['success' => false, 'error' => $exception->getMessage()], 422);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['success' => false, 'error' => 'Oops! Invoice not found.',], 404);
        } catch (\Exception $exception) {
            return response()->json(['success' => false, 'error' => 'Internal server error.', 'message' => $exception->getMessage(),], 500);
        }
    }

    /**
     * Validate the format of the invoice key (optional customization).
     *
     * @param string $invoice_key
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateInvoiceKey($invoice_key)
    {
        Validator::make(
            ['invoice_key' => $invoice_key],
            [
                'invoice_key' => [
                    'required',
                    'numeric',
                    'digits_between:6,20',
                    'exists:invoices,invoice_key',
                ],
            ],
            [
                'invoice_key.required' => 'The Invoice ID field is required.',
                'invoice_key.numeric' => 'The Invoice ID should be numeric.',
                'invoice_key.digits_between' => 'The Invoice ID must be between 6 and 20 digits.',
                'invoice_key.exists' => 'The Invoice ID does not exist.',
            ]
        )->validate();
    }
}
