<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseProduct;
use App\Models\Supplier;
use App\Models\Weight;
use Illuminate\Http\JsonResponse;
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
        $purchases = Purchase::with(['purchaseProducts','weights', 'suppliers'])->get();
        return Datatables::of($purchases)
            ->addIndexColumn()
            ->addColumn('productsData', function ($purchases) {
                $products=[];
                foreach ($purchases->purchaseProducts as $key => $value) {
                    $products[] = $value->product_name.'<br>' ;
                }
                return $products;
                
            })

            ->addColumn('productsQty', function ($purchases) {
                $products=[];
                foreach ($purchases->purchaseProducts as $key => $value) {
                    $products[] = $value->quantity.'<br>' ;
                }
                return $products;

            })

            ->addColumn('action', function ($purchases) {
                return '<a href="#" type="button" id="editPurchaseBtn" data-id="' . $purchases->id . '" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editmainPurchase" ><i class="bi bi-pencil-square" ></i></a>
                <a href="#" type="button" id="deletePurchaseBtn" data-id="' . $purchases->id . '" class="btn btn-danger btn-sm"><i class="bi bi-archive"></i></a>';
            })
            
            ->escapeColumns([])
            ->make(true);
    }

    public function create()
    {
    $purchaseInvoice=  $this->uniqueIDforPurchase();
    $suppliers = Supplier::where('status', 'Active')->get();
        
        return view('admin.content.purchase.create',compact('purchaseInvoice','suppliers'));

    }

    public function uniqueIDforPurchase()
    {
        $lastPurchase = Purchase::latest('id')->first();
        if ($lastPurchase) {
            $orderID = $lastPurchase->id + 1;
        } else {
            $orderID = 1;
        }

        return 'PG77' . $orderID;
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request):JsonResponse
    {
//        $purchase = Purchase::create($request->all());

        $purchase = new Purchase();
        $purchase->invoiceID = $this->uniqueIDforPurchase();
        $purchase->supplier_id= $request['data']['supplierId'];
        $purchase->totalAmount= $request['data']['total'];
        $purchase->payed_amount= $request['data']['payedAmount'];
        $purchase->payment_type_id= $request['data']['paymentTypeID'];
        $purchase->date = today();
        
        $purchase->paymentAgentNumber = $request['data']['paymentAgentNumber'];
        $purchase->note = $request['data']['note'];
        
        $purchase->save();
        
        $products= $request['data']['products'];
        
        if ($purchase) {
            
            foreach ($products as $product) {

                $purchaseProduct = new PurchaseProduct();
                $purchaseProduct->purchase_id = $purchase->id;
                $purchaseProduct->weight_id = $product['weightID'];
                $purchaseProduct->weight = $product['productWeight'];
                
                $purchaseProduct->product_name = $product['productName'];
                $purchaseProduct->product_price = $product['productPrice'];
                $purchaseProduct->quantity = $product['productQuantity'];
               
                $purchaseProduct->save();
                

            }
            
            $supplier = Supplier::where('id', $purchase->supplier_id)->first();
            $supplier->supplierTotalAmount += $request['data']['total'];
            $supplier->supplierPaidAmount += $request['data']['payedAmount'];
            $supplier->supplierDueAmount += $supplier->supplierTotalAmount - $supplier->supplierPaidAmount;
            
            $supplier->save();

            if (!empty($request['data']['paymentTypeID'])) {
                $payment = new Payment();
                $payment->payment_type_id = $request['data']['paymentTypeID'];
                $payment->paymentNumber = $request['data']['paymentAgentNumber'] ?? null;

                // Save the payment to the database if needed
                $payment->save();
            }
            
   
        }
        
        
        return response()->json(['message'=> 'Purchase Created Successfully'] , 200);
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