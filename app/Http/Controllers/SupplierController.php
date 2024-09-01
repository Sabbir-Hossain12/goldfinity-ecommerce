<?php

namespace App\Http\Controllers;

use App\Models\Paymenttype;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\SupplierPayment;
use Illuminate\Http\Request;
use DataTables;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.content.supplier.supplier');
    }


    public function supplierdata()
    {
        $suppliers = Supplier::all();
        
        
        return Datatables::of($suppliers)
            ->addColumn('action', function ($suppliers) {
                return '<a href="'. route('supply.ledger', $suppliers->id).'" type="button" id="editSupplierBtn"  class="btn btn-primary btn-sm mx-2"><i class="bi bi-cash-coin" ></i>
                        <a href="#" type="button" id="editSupplierBtn" data-id="' . $suppliers->id . '" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editmainSupplier" ><i class="bi bi-pencil-square" ></i></a>';
//         <a href="#" type="button" id="deleteSupplierBtn" data-id="' . $suppliers->id . '" class="btn btn-danger btn-sm"><i class="bi bi-archive"></i></a>
            })

            ->make(true);
    }
   public function supplierlist()
    {
        $suppliers = Supplier::all();
        
        return response()->json($suppliers, 200);

    }
    

    
     
    public function store(Request $request)
    {
//      $supplier = Supplier::create($request->all());
        
        $supplier = new Supplier();
        $supplier->supplierName = $request->supplierName;
        $supplier->supplierPhone = $request->supplierPhone;
        $supplier->supplierEmail = $request->supplierEmail;
        $supplier->supplierAddress = $request->supplierAddress;
        $supplier->supplierCompanyName = $request->supplierCompanyName;
//        $supplier->supplierInitialAmount = $request->supplierInitialAmount;
        $supplier->supplierTotalAmount = $request->supplierTotalAmount;
        $supplier->supplierPaidAmount = $request->supplierPaidAmount;
        $supplier->supplierDueAmount = $request->supplierDueAmount;
        
        $supplier->save();
        
        
        return response()->json($supplier, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $supplier = Supplier::findOrfail($id);
        return response()->json($supplier, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $supplier = Supplier::where('id', $id)->first();
        $supplier->supplierName = $request->supplierName;
        $supplier->supplierPhone = $request->supplierPhone;

        $supplier->supplierEmail = $request->supplierEmail;
        $supplier->supplierAddress = $request->supplierAddress;
        $supplier->supplierCompanyName = $request->supplierCompanyName;
//        $supplier->supplierInitialAmount = $request->supplierInitialAmount;
//        $supplier->supplierTotalAmount = $request->supplierTotalAmount;
//        $supplier->supplierPaidAmount = $request->supplierPaidAmount;
//        $supplier->supplierDueAmount = $request->supplierDueAmount;
        $supplier->save();
        return response()->json($supplier, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $supplier = Supplier::where('id', $id)->first();
        $supplier->delete();
        return response()->json('delete success');
    }

    public function updatestatus(Request $request)
    {

        $supplier = Supplier::Where('id', $request->supplier_id)->first();
        $supplier->status = $request->status;
        $supplier->save();

        return response()->json($supplier, 200);
    }


    public function supplierLedger(string $id)
    {
        $supplier=Supplier::findOrfail($id);
        $supplierPayments=SupplierPayment::where('supplier_id',$id)->get();
        $purchases=Purchase::where('supplier_id',$id)->get();
        $paymentTypes=PaymentType::all();
        
        return view('admin.content.supplier.ledger',compact('supplier','supplierPayments','purchases','paymentTypes'));
    }









}