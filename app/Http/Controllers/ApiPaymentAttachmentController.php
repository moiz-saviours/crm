<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\PaymentAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ApiPaymentAttachmentController extends Controller
{
    public function upload_attachment(Request $request)
    {
        $invoice = Invoice::where('invoice_key', $request->input('invoice_number'))->first();
        if (!$invoice) {
            return response()->json(['error' => 'Invoice not found.'], 404);
        }
        $existingAttachmentCount = $invoice->payment_attachments ? $invoice->payment_attachments
            ->flatMap(function ($attachment) {
                return json_decode($attachment->attachments, true) ?: [];
            })
            ->count() : 0;
        $maxLimit = 5;
        if ($existingAttachmentCount >= $maxLimit) {
            return response()->json(['error' => 'Oop! Invoice maximum attachment limit reached.', 'current_count' => $existingAttachmentCount,], 404);
        }
        $validator = Validator::make($request->all(), [
            'invoice_number' => 'required|numeric|exists:invoices,invoice_key',
            'email' => 'required|email',
            'transaction_id' => 'required|string|max:255',
            'payment_method' => [
                'nullable',
                'string',
                'max:255',
                Rule::in($invoice->invoice_merchants->sortBy('merchant_type')->pluck('merchant_type')->toArray())
            ],
            'files' => 'required|array|min:1',
            'files.*' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ], [
            'files.required' => 'At least one file is required.',
            'files.min' => 'At least one file is required.',
            'files.*.required' => 'Each file is required.',
            'files.*.mimes' => 'File must be a PDF, JPG, JPEG, or PNG.',
            'files.*.max' => 'File may not be greater than 10MB.',
            'payment_method.in' => 'The selected payment method is invalid.',
            'invoice_number.exists' => 'The invoice number could not be found.',
        ]);
        if ($validator->fails()) {
            $fileIndexMap = [];
            foreach ($request->file('files', []) as $index => $file) {
                $fileIndexMap[$index] = [
                    'name' => $file->getClientOriginalName(),
                    'type' => $file->getClientMimeType()
                ];
            }
            $errors = collect($validator->errors())->map(function ($error, $key) use ($fileIndexMap) {
                if (str_contains($key, 'files.')) {
                    $index = explode('.', $key)[1];
                    $fileNumber = (int)$index + 1;
                    $fileName = $fileIndexMap[$index]['name'] ?? "File $fileNumber";
                    $fileType = $fileIndexMap[$index]['type'] ?? 'unknown type';
                    return str_replace(
                        ["files.{$index}", 'File must be a PDF, JPG, JPEG, or PNG.'],
                        ["{$fileName} (type: {$fileType})", 'Invalid file type. Allowed: PDF, JPG, JPEG, PNG.'],
                        $error[0]
                    );
                }
                return $error[0];
            })->all();
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $errors,
                'file_details' => $fileIndexMap
            ], 422);
        }
        try {
            $uploadedFiles = $filesData = $skippedFiles = [];
            $attachment_id = null;
            foreach ($request->file('files') as $file) {
                if ($existingAttachmentCount >= $maxLimit) {
                    $skippedFiles[] = [
                        'name' => $file->getClientOriginalName(),
                        'type' => $file->getClientMimeType(),
                        'size' => $file->getSize(),
                    ];
                    continue;
                }
                $fileName = 'payment_' . time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                $publicPath = 'assets/payment-attachments';
                $storagePath = public_path($publicPath);
                if (!File::exists($storagePath)) {
                    File::makeDirectory($storagePath, 0755, true);
                }
                $id = rand(11111, 99999) . 5;
                $attachment_id .= $id;
                $fileData = [
                    'id' => $id,
                    'original_name' => $file->getClientOriginalName(),
                    'file_name' => $fileName,
                    'file_path' => $publicPath . '/' . $fileName,
                    'mime_type' => $file->getClientMimeType(),
                    'file_size' => $file->getSize(),
                    'extension' => $file->getClientOriginalExtension()
                ];
                $file->move($storagePath, $fileName);
                $uploadedFiles[] = $fileData;
                unset($fileData['file_path']);
                $filesData[] = $fileData;
                $existingAttachmentCount++;
            }
            PaymentAttachment::create([
                'invoice_key' => $request->invoice_number,
                'email' => $request->email,
                'transaction_reference' => $request->transaction_id,
                'payment_method' => $request->has('payment_method') ? $request->payment_method : null,
                'attachments' => json_encode($uploadedFiles),
                'ip_address' => $request->ip()
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Files uploaded successfully',
                'reference_id' => 'PAY-' . $attachment_id,
                'attachments' => $filesData,
                'attachments_count' => $existingAttachmentCount,
                'skipped_files' => $skippedFiles,
                'metadata' => [
                    'email' => $request->email,
                    'transaction_id' => $request->transaction_id,
                    'payment_method' => $request->payment_method
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'File upload failed',
                'error' => $e->getMessage(),
                'trace' => config('app.debug') ? $e->getTrace() : null
            ], 500);
        }
    }
}
