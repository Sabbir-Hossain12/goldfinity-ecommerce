<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseProduct;
use App\Models\Stock;
use App\Models\Supplier;
use App\Models\SupplierPayment;
use App\Models\Weight;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

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
        return view('admin.content.purchase.purchase', ['weights' => $weights, 'suppliers' => $suppliers]);
    }


    public function purchasedata()
    {
        $purchases = Purchase::with(['purchaseProducts', 'weights', 'suppliers'])->get();
        return Datatables::of($purchases)
            ->addIndexColumn()
            ->addColumn('productsData', function ($purchases) {
                $products = [];
                foreach ($purchases->purchaseProducts as $key => $value) {
                    $products[] = $value->product_name.'<br>';
                }
                return $products;
            })
            ->addColumn('productsQty', function ($purchases) {
                $products = [];
                foreach ($purchases->purchaseProducts as $key => $value) {
                    $products[] = $value->quantity.'<br>';
                }
                return $products;
            })
            ->addColumn('action', function ($purchases) {
                return '<a href="'.route('supply.ledger', $purchases->suppliers->id).'"  id="supplyLedgerBtn" class="btn btn-primary btn-sm"><i class="bi bi-cash-coin" ></i></a>
                        <a href="'.route('purchases.edit', $purchases->id).'" type="button" id="editPurchaseBtn" class="btn btn-primary btn-sm" ><i class="bi bi-eye" ></i></a>';
                
            })
            ->escapeColumns([])
            ->make(true);
    }

    public function create()
    {
        $purchaseInvoice = $this->uniqueIDforPurchase();
        $suppliers = Supplier::get();

        return view('admin.content.purchase.create', compact('purchaseInvoice', 'suppliers'));
    }

    public function uniqueIDforPurchase()
    {
        $lastPurchase = Purchase::latest('id')->first();
        if ($lastPurchase) {
            $orderID = $lastPurchase->id + 1;
        } else {
            $orderID = 1;
        }

        return 'PG77'.$orderID;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): JsonResponse
    {
        $purchase = new Purchase();
        $purchase->invoiceID = $this->uniqueIDforPurchase();
        $purchase->supplier_id = $request['data']['supplierId'];
        $purchase->totalAmount = $request['data']['total'];
        $purchase->discount_amount= $request['data']['discountAmount'];
//      $purchase->payed_amount = $request['data']['payedAmount'];
//      $purchase->payment_type_id = $request['data']['paymentTypeID'];
        $purchase->date = today();
//      $purchase->paymentAgentNumber = $request['data']['paymentAgentNumber'];
        $purchase->note = $request['data']['note'];
        $purchase->admin_id = Auth::guard('admin')->user()->id;
        $purchase->save();

        $products = $request['data']['products'];

        if ($purchase) {
            foreach ($products as $product) {
//              Save Purchase Product       
                $purchaseProduct = new PurchaseProduct();
                $purchaseProduct->purchase_id = $purchase->id;
                $purchaseProduct->weight_id = $product['weightID'];
                $purchaseProduct->weight = $product['productWeight'];

                $purchaseProduct->product_name = $product['productName'];
                $purchaseProduct->product_price = $product['productPrice'];
                $purchaseProduct->quantity = $product['productQuantity'];

                $purchaseProduct->save();
            }
            
//          Update Supplier  
            $supplier = Supplier::where('id', $purchase->supplier_id)->first();
            $supplier->supplierTotalAmount += $request['data']['total'];
//            $supplier->supplierPaidAmount += $request['data']['payedAmount'];
            $supplier->supplierDueAmount += $request['data']['total'] ;
//                - $request['data']['payedAmount']);

            $supplier->save();


//              Update Stock
            foreach ($products as $product) {
                
                $weightPro = Weight::find($product['weightID']);

                $stock = new Stock();
                $stock->purchase_id = $purchase->id;
                $stock->weight_id = $product['weightID'];
                $stock->supplier_id = $supplier->id;
                $stock->product_name = $product['productName'];
                $stock->supplier_name = $supplier->supplierName;
                $stock->purchase_qty = $product['productQuantity'];
                $stock->new_stock = $weightPro->available_qty + $product['productQuantity'];
                $stock->old_stock = $weightPro->available_qty;

                $stock->save();


//              $weightProduct = Weight::find($product['weightID']);

                if ($weightPro) {
//              Update the Weight Product Quantity
                $weightPro->total_qty += $product['productQuantity'];
                $weightPro->available_qty += $product['productQuantity'];
                $weightPro->update();
                }
            }

//            if (!empty($request['data']['paymentTypeID']) && $request['data']['payedAmount'] > 0) {
//                $payment = new Payment();
//                $payment->payment_type_id = $request['data']['paymentTypeID'];
//                $payment->paymentNumber = $request['data']['paymentAgentNumber'] ?? null;
//
//                // Save the payment to the database if needed
//                $payment->save();
//                
//                $supplyPayment=new SupplierPayment();
//                $supplyPayment->supplier_id=$purchase->supplier_id;
//                $supplyPayment->payment_id=$payment->id;
//                $supplyPayment->payment_type_id=$request['data']['paymentTypeID'];
//                $supplyPayment->paid_amount=$request['data']['payedAmount'];
//                $supplyPayment->old_due_amount=$supplier->supplierDueAmount - $request['data']['payedAmount'];
//                $supplyPayment->new_due_amount	= $supplier->supplierDueAmount ;
//                
//                $supplyPayment->trx_id= uniqid();
//                $supplyPayment->date=today();
//                $supplyPayment->comments=$request['data']['note'];
//                
//                $supplyPayment->save();
//            }
            
            
        }

        return response()->json(['message' => 'Purchase Created Successfully'], 200);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function edit($id):View
    {
        $purchase = Purchase::findOrfail($id);
        $products = PurchaseProduct::where('purchase_id', $id)->get();
        
        $supplier = Supplier::where('id', $purchase->supplier_id)->first();
        
        return view('admin.content.purchase.edit', compact('purchase','products','supplier'));
        
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