<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\SupplierPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupplierPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $orders = Purchase::where('supplier_id', $request->supplier_id)->where('status', 'Due')->get();
        $blance = $request->amount;
        foreach ($orders as $order) 
        {
            $thisdue = $order->totalAmount - $order->paid_amount;
            if ($blance > 0) {
                if ($thisdue >= $blance) {
                    $supplierPayment = new SupplierPayment();
                    $supplierPayment->supplier_id = $request->supplier_id;
                    $supplierPayment->purchase_id = $order->id;
                    $supplierPayment->date = $request->date;
                    $supplierPayment->paid_amount = $blance;
                    $supplierPayment->trx_id = $request->trx_id;
                    $supplierPayment->payment_type_id = $request->payment_type_id;
                    $supplierPayment->admin_id = Auth::guard('admin')->user()->id;
                    $supplierPayment->comments = $request->comments;
                    $supplierPayment->save();

                    $order->paid_amount = $order->paid_amount + $blance;
                    if ($order->paid_amount >= $order->totalAmount) {
                        $order->status = 'Paid';
                    } else {
                        $order->status = 'Due';
                    }
                    $order->update();
                    $blance = 0;
                } else {
                    $supplierPayment = new SupplierPayment();
                    $supplierPayment->supplier_id = $request->supplier_id;
                    $supplierPayment->purchase_id = $order->id;
                    $supplierPayment->date = $request->date;
                    $supplierPayment->paid_amount = $thisdue;
                    $supplierPayment->trx_id = $request->trx_id;
                    $supplierPayment->payment_type_id = $request->payment_type_id;
                    $supplierPayment->admin_id = Auth::guard('admin')->user()->id;
                    $supplierPayment->comments = $request->comments;
                    $supplierPayment->save();

                    $order->paid_amount = $order->paid_amount + $thisdue;
                    if ($order->paid_amount >= $order->totalAmount) {
                        $order->status = 'Paid';
                    } else {
                        $order->status = 'Due';
                    }
                    $order->update();
                    $blance = $blance - $thisdue;
                }
            }
        }

        $supplier = Supplier::find($request->supplier_id);
        $supplier->supplierPaidAmount += $request->amount;
        $supplier->supplierDueAmount -= $request->amount;
        $result = $supplier->update();

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SupplierPayment  $supplierPayment
     * @return \Illuminate\Http\Response
     */
    public function show(SupplierPayment $supplierPayment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SupplierPayment  $supplierPayment
     * @return \Illuminate\Http\Response
     */
    public function edit(SupplierPayment $supplierPayment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SupplierPayment  $supplierPayment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SupplierPayment $supplierPayment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SupplierPayment  $supplierPayment
     * @return \Illuminate\Http\Response
     */
    public function destroy(SupplierPayment $supplierPayment)
    {
        //
    }
}
