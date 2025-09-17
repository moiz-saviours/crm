<?php

namespace App\Http\Controllers\Admin\Customer;

use App\Http\Controllers\Controller;
use App\Models\CustomerNote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NoteController extends Controller
{

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'note' => 'required',
            'cus_contact_key' => 'nullable|integer|exists:customer_contacts,special_key',

        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        CustomerNote::create([
            'cus_contact_key' => $request->cus_contact_key,
            'note' => $request->note,
            'creator_id' => auth()->id(),
            'creator_type' => get_class(auth()->user()),
        ]);

        return redirect()->back()->with('success', 'Note added successfully!');
    }

    public function update(Request $request, CustomerNote $note)
    {
        $validator = Validator::make($request->all(), [
            'note' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $note->update([
            'note' => $request->note,
        ]);

        return redirect()->back()->with('success', 'Note updated successfully!');
    }

    public function delete($id)
    {
        $note = CustomerNote::find($id);

        if (!$note) {
            return redirect()->back()->with('error', 'Note not found.');
        }

        $note->delete();

        return redirect()->back()->with('success', 'Note deleted successfully!');
    }


}
