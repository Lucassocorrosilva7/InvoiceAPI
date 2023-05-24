<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Invoice;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\V1\InvoiceResource;

class InvoiceController extends Controller
{
    use HttpResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return InvoiceResource::collection(Invoice::with('user')->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'type' => 'required|max:1',
            'paid' => 'required|numeric|between:0,1',
            'payment_date' => 'nullable',
            'value' => 'required|numeric|between:1,9999,99'
        ]);

        if ($validator->fails()) {
            return $this->error('Data Invalid', 422, $validator->errors());
        }

        $created = Invoice::create($validator->validated());

        if ($created) {
            return $this->sucess('Invoice created', 200, new InvoiceResource($created->load('user')));
        }
        return $this->error('Invoice not created', 400);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'type' => 'required|max:1',
            'paid' => 'required|numeric|between:0,1',
            'value' => 'required|numeric',
            'payment_date' => 'nullable|date_format:Y-m-d H:i:s'
        ]);

        if ($validator->fails()) {
            return $this->error('Validation failed', 422, $validator->errors());
        }

        $validated = $validator->validated();

        $invoice = Invoice::find($id);

        $updated = $invoice->update([
            'user_id' => $validated['user_id'],
            'type' => $validated['type'],
            'paid' => $validated['paid'],
            'value' => $validated['value'],
            'payment_date' => $validated['paid'] ? $validated['payment_date'] : null
        ]);

        if ($updated) {
            return $this->sucess('Invoice updated', 200, new InvoiceResource($invoice->load('user')));
        }

        return $this->error('Invoice not updated', 400);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
