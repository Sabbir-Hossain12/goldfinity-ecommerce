<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Weight;
use Illuminate\Http\Request;
use DataTables;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $weights = Weight::with('product')->get();
        $suppliers = Supplier::where('status', 'Active')->get();
        return view('admin.content.purchase.purchase',['weights'=>$weights, 'suppliers'=> $suppliers]);
    }


    public function purchasedata()
    {
        $purchases = Purchase::with(['weights', 'suppliers'])->get();
        return Datatables::of($purchases)
            ->addIndexColumn()
            ->addColumn('ProductName', function ($purchases) {
                return $purchases->weights->product->ProductName
                    .'<br>'. $purchases->weights->weight_name;
            })
            ->addColumn('action', function ($purchases) {
                return '<a href="#" type="button" id="editPurchaseBtn" data-id="' . $purchases->id . '" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editmainPurchase" ><i class="bi bi-pencil-square" ></i></a>
                <a href="#" type="button" id="deletePurchaseBtn" data-id="' . $purchases->id . '" class="btn btn-danger btn-sm"><i class="bi bi-archive"></i></a>';
            })
            
            ->escapeColumns([])
            ->make(true);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        $purchase = Purchase::create($request->all());

        $purchase = new Purchase();
        $purchase->invoiceID = $request->invoiceID;
        $purchase->date = $request->date;
        $purchase->product_id = $request->product_id;
        $purchase->supplier_id = $request->supplier_id;
        $purchase->quantity = $request->quantity;
        $purchase->totalAmount = $request->totalAmount;
        $purchase->save();
        return response()->json($purchase , 200);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $purchase = Purchase::findOrfail($id);
        return response()->json($purchase, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $purchase = Purchase::where('id', $id)->first();
        $purchase->invoiceID = $request->invoiceID;
        $purchase->date = $request->date;
        $purchase->product_id = $request->product_id;
        $purchase->supplier_id = $request->supplier_id;
        $purchase->quantity = $request->quantity;
        $purchase->totalAmount = $request->totalAmount;
        $purchase->save();
        
        return response()->json($purchase, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $purchase = Purchase::where('id', $id)->first();
        $purchase->delete();
        return response()->json('delete success');
    }
}