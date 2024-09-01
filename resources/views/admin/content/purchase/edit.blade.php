@extends('admin.master')

@section('maincontent')
    @section('subcss')
        <link rel="stylesheet" type="text/css"
              href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.0-alpha1/css/bootstrap.min.css">
        <link rel="stylesheet"
              href="https://cdn.jsdelivr.net/npm/jquery-datatables-checkboxes@1.2.13/css/dataTables.checkboxes.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    @endsection

    <main id="main" class="main">

        <div class="pagetitle row">
            <div class="col-6">
                <h1><a href="{{url('/admindashboard')}}">Purchases</a></h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/admindashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Orders</li>
                    </ol>
                </nav>
            </div>
        </div><!-- End Page Title -->

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <strong>Supplier Info</strong>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="supplierList">Supplier Name</label>
                                    <select id="supplierList" class="form-control" required>
{{--                                        @foreach($suppliers as $supplier)--}}
                                            <option value="{{$supplier->supplierName}}" readonly="">{{$supplier->supplierName}}</option>
{{--                                        @endforeach--}}
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="invoiceID">Invoice Number</label>
                                    <input type="text" readonly class="form-control" style="cursor: not-allowed;"
                                           id="invoiceID" value="{{$purchase->invoiceID}}">
                                </div>
                            </div>

                        </div>
                        <br>
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                                {{--                                <div class="form-group mb-2">--}}
                                {{--                                    <label>Payment</label>--}}
                                {{--                                    <select id="paymentTypeID" class="form-control select2">--}}
                                {{--                                        <option value="">Select payment Type</option>--}}
                                {{--                                    </select>--}}
                                {{--                                </div>--}}

                                {{--                                <div class="form-group mb-2 paymentAgentNumber">--}}
                                {{--                                    <input type="text" class="form-control" id="paymentAgentNumber"--}}
                                {{--                                           placeholder="Enter Bkash Agent Number">--}}
                                {{--                                </div>--}}
                                <div class="form-group mb-2 hide">
                                    <label for="note">Note (if any)</label>
                                    <textarea type="text" class="form-control" id="note" readonly> {{$purchase->note}}</textarea>
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="fname" class="col-sm-4 text-right control-label col-form-label">Sub
                                        Total</label>
                                    <div class="col-sm-8">
                                        <span class="form-control" id="subtotal" style="cursor: not-allowed;">{{$purchase->discount_amount + $purchase->totalAmount}}</span>
                                    </div>
                                </div>


                                {{--                                <div class="form-group row paymentAmount">--}}
                                {{--                                    <label for="fname"--}}
                                {{--                                           class="col-sm-4 text-right control-label col-form-label">Payment</label>--}}
                                {{--                                    <div class="col-sm-8">--}}
                                {{--                                        <input type="number" value="0" min="0" class="form-control" id="paymentAmount">--}}
                                {{--                                    </div>--}}
                                {{--                                </div>--}}

                                <div class="form-group row DiscountAmount">
                                    <label for="fname"
                                           class="col-sm-4 text-right control-label col-form-label">Discount Amount</label>
                                    <div class="col-sm-8">
                                        <input type="number" value="{{$purchase->discount_amount}}" min="0" class="form-control" id="discountAmount" readonly>
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label for="fname"
                                           class="col-sm-4 text-right control-label col-form-label">Total</label>
                                    <div class="col-sm-8">
                                        <span class="form-control" id="total" style="cursor: not-allowed;">{{$purchase->totalAmount}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <strong>Product Info</strong>
                    </div>
                    <div class="card-body">
                        <table id="productTable" style="width: 100% !important;"
                               class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Weight</th>
{{--                                <th>Code</th>--}}
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($products as $product) 
                            <tr> 
                                <td style="display: none"> <input type="text" class="weightID" style="width:80px;" value="{{$product->weight_id}}" readonly/> </td> 
                                <td><input type="text" name="weight" id="productWeight" value="{{$product->weight}}" style="max-width: 40px;" readonly></td>
{{--                                <td><span class="productCode"> </span></td>--}}
                                <td><span class="productName">{{$product->product_name}} </span></td>
                                <td><input type="number" class="productQuantity form-control" style="width:80px;" value="{{$product->quantity}}" min="1" readonly></td>
                                <td><span class="productPrice">{{$product->product_price}} </span></td>
                                
                            </tr>

                            @endforeach
                            
                            </tbody>
                            <tfoot>
{{--                            <tr>--}}
{{--                                <td colspan="5">--}}
{{--                                    <select id="productID" style="width: 100%;">--}}
{{--                                        <option value="">Select Product</option>--}}
{{--                                    </select>--}}
{{--                                </td>--}}
{{--                            </tr>--}}
                            </tfoot>

                        </table>

                    </div>
{{--                    <div class="card-footer">--}}
{{--                        <button type="button" id="submit" class="btn btn-primary btn-block" data-style="expand-left">--}}
{{--                            Save--}}
{{--                        </button>--}}
{{--                    </div>--}}
                </div>
            </div>
        </div>

    </main>

    @section('subscript')
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/select/1.3.4/js/dataTables.select.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/jquery-datatables-checkboxes@1.2.13/js/dataTables.checkboxes.min.js"></script>

    @endsection



@endsection
