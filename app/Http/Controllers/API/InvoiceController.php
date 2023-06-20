<?php

namespace App\Http\Controllers\API;

use App\Models\Counter;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function get_all_invoice()
    {
        $invoices = Invoice::with('customer')->orderBy('id', 'DESC')->get();
        return response()->json([
            'invoices' => $invoices,
        ], 200);
    }

    public function search_invoice(Request $request)
    {
        $search = $request->get('s');

        if ($search != null) {
            $invoices = Invoice::with('customer')->where('number', 'LIKE', "$search%")->get();
            return response()->json([
                'invoices' => $invoices,
            ], 200);
        } else {
            return $this->get_all_invoice();
        }
    }

    public function create_invoice(Request $request)
    {
        $counter = Counter::where('key', 'invoice')->first();
        $random = Counter::where('key', 'invoice')->first();

        $invoice = Invoice::orderBy('id', 'DESC')->first();

        if ($invoice) {
            $invoice = $invoice->id + 1;
            $counters = $counter->value + $invoice;
        } else {
            $counters = $counter->value + 1;
        }

        $formData = [
            'number' => $counter->prefix . $counters,
            'customer_id' => null,
            'customer' => null,
            'date' => date('Y-m-d'),
            'due_date' => null,
            'reference' => null,
            'discount' => 0,
            'tems_and_conditions' => 'Default Terms and Conditions',
            'items' => [
                [
                    'product_id' => null,
                    'product' => null,
                    'unit_price' => 0,
                    'quantity' => 1,
                ]
            ],
            'sub_total' => 0,
            'total' => 0,
        ];

        return response()->json($formData);
    }

    public function store_invoice(Request $request)
    {
        $invoice_item = $request->input('invoice_items');

        $invoice_data['number'] = $request->input('number');
        $invoice_data['customer_id'] = $request->input('customer_id');
        $invoice_data['date'] = $request->input('date');
        $invoice_data['due_date'] = $request->input('due_date');
        $invoice_data['reference'] = $request->input('reference');
        $invoice_data['terms_and_conditions'] = $request->input('terms_and_conditions');
        $invoice_data['sub_total'] = $request->input('sub_total');
        $invoice_data['discount'] = $request->input('discount');
        $invoice_data['total'] = $request->input('total');

        $invoice = Invoice::create($invoice_data);

        foreach (json_decode($invoice_item) as $item) {
            $itemdata['invoice_id'] = $invoice->id;
            $itemdata['product_id'] = $item->id;
            $itemdata['unit_price'] = $item->unit_price;
            $itemdata['quantity'] = $item->quantity;

            InvoiceItem::create($itemdata);
        }
    }

    public function show_invoice($id)
    {
        $invoice = Invoice::with(['customer', 'invoice_items.product'])->find($id);
        return response()->json([
            'invoice' => $invoice,
        ], 200);
    }

    public function edit_invoice($id)
    {
        $invoice = Invoice::with(['customer', 'invoice_items.product'])->find($id);
        return response()->json([
            'invoice' => $invoice,
        ], 200);
    }

    public function update_invoice(Request $request, $id)
    {
        $invoice = Invoice::where('id', $id)->first();

        $invoice->sub_total = $request->sub_total;
        $invoice->discount = $request->discount;
        $invoice->total = $request->total;
        $invoice->customer_id = $request->customer_id;
        $invoice->number = $request->number;
        $invoice->date = $request->date;
        $invoice->due_date = $request->due_date;
        $invoice->reference = $request->reference;
        $invoice->terms_and_conditions = $request->terms_and_conditions;

        $invoice->update($request->all());

        $invoice_item = $request->input('invoice_items');
        $invoice->invoice_items()->delete();
        foreach (json_decode($invoice_item) as $item) {
            $itemdata['invoice_id'] = $invoice->id;
            $itemdata['product_id'] = $item->product_id;
            $itemdata['unit_price'] = $item->unit_price;
            $itemdata['quantity'] = $item->quantity;

            InvoiceItem::create($itemdata);
        }
    }

    public function delete_invoice($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->delete();
        $invoice->invoice_items()->delete();
    }

    public function delete_invoice_items($id)
    {
        $invoiceitem = InvoiceItem::findOrFail($id);
        $invoiceitem->delete();
    }
}
