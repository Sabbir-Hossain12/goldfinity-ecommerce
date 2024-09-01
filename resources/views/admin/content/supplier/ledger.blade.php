@extends('admin.master')

@section('maincontent')
    @section('subcss')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>

        <link rel="stylesheet"
              href="https://cdn.jsdelivr.net/npm/jquery-datatables-checkboxes@1.2.13/css/dataTables.checkboxes.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css">

    @endsection
    <style>
        .select2-container--open {
            z-index: 9999 !important;
        }

        .select2-dropdown {
            z-index: 9999;
        }
    </style>

    <main id="main" class="main">

        <div class="pagetitle row">
            <div class="col-6">
                <h1><a href="{{url('/admindashboard')}}">Dashboard</a></h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/admindashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Purchases</li>
                        <li class="breadcrumb-item active">Ledger</li>
                    </ol>
                </nav>
            </div>

        </div><!-- End Page Title -->


        {{-- //popup modal for Add Payment --}}
        <div class="modal fade" id="mainPurchese" tabindex="-1" data-bs-backdrop="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Payments</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <form name="form" method="post" action="{{route('supply.payment.store')}}">
                            @csrf
                            
                            <input type="text" name="supplier_id" value="{{$supplier->id}}" hidden>

                            <div class="form-group">
                                <label for="date">Date</label>
                                <input type="text" name="date" class="form-control" id="date" value="{{today()}}">
                            </div>
                            
                            <div class="form-group pb-2">
                                <label for="trx_id">Trx ID</label>
                                <input type="text" name="trx_id" class="form-control" id="trx_id" required>
                            </div>

                            <div class="form-group pb-2">
                                <label for="amount">Amount</label>
                                <input type="number" name="amount" class="form-control" id="amount" min="1" max="{{$supplier->supplierDueAmount}}" required>
                                <script>
                                    document.getElementById('amount').addEventListener('input', function () {
                                        let max = {{ $supplier->supplierDueAmount }};
                                        if (this.value > max) {
                                            this.value = max;
                                        }
                                    });
                                </script>
                            </div>
                            
                            

                            <div class="form-group pb-2">
                                <label for="payment_type_id">Payment Type</label>

                                <select name="payment_type_id" class="form-control" id="payment_type_id" required>
                                <option disabled selected>Select Payment Type</option>
                                    @foreach($paymentTypes as $paymentType)

                                        <option value="{{$paymentType->id}}">{{$paymentType->paymentTypeName}}</option>

                                    @endforeach

                                </select>
                            </div>
                            


                            <div class="form-group pb-2">
                                <label for="comments">Comments (Optional)</label>
                                <textarea name="comments" class="form-control" id="comments"></textarea>
                            </div>

                            <div class="form-group" style="text-align: right">
                                <div class="submitBtnSCourse">
                                    <button type="submit" name="btn" class="btn btn-primary  btn-block">
                                        Save
                                    </button>
                                </div>
                            </div>
                            
                            
                        </form>

                    </div>

                </div>
            </div>
        </div><!-- End popup Modal-->

        {{--      purchase/Supplier Ledger--}}

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <h2 class="text-center pb-3">Supplier info</h2>
                    <div class="card">
                        <div class="card-body pt-4 d-flex justify-content-between">
                            
                            <div>
                                <div><span><span
                                                class="fw-bold"> Supplier Name:</span> {{ $supplier->supplierName}}</span>
                                </div>
                                <div><span><span
                                                class="fw-bold"> Supplier Phone:</span> {{ $supplier->supplierPhone  }}</span>
                                </div>
                                <div><span><span
                                                class="fw-bold"> Supplier Email:</span> {{ $supplier->supplierEmail }}</span>
                                </div>
                                <div><span><span
                                                class="fw-bold"> Supplier Address:</span> {{ $supplier->supplierAddress }}</span>
                                </div>
                                <div><span><span
                                                class="fw-bold"> Company Name:</span> {{ $supplier->supplierCompanyName  }}</span>
                                </div>
                            </div>

                            <div>
                               
                                <div><span><span
                                                class="fw-bold"> Total Amount:</span> {{ $supplier->supplierTotalAmount }}</span>
                                </div>
                                <div><span><span
                                                class="fw-bold"> Paid Amount:</span> {{ $supplier->supplierPaidAmount   }}</span>
                                </div>
                                <div><span><span
                                                class="fw-bold"> Due Amount:</span> {{ $supplier->supplierDueAmount  }}</span>
                                </div>

                            </div>


                            <div class="" style="text-align: right">
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#mainPurchese"><span style="font-weight: bold;">+</span> Add
                                    Payment
                                </button>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </section>


        {{-- //table section for category --}}
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <h2 class="text-center pb-3">Supplier Ledger</h2>
                    <div class="card">
                        <div class="card-body pt-4">
                            @if(\Session::has('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <i class="bi bi-check-circle me-1"></i>
                                    {{ \Session::get('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                </div>
                            @endif

                            <!-- Table with stripped rows -->
                            <div class="table-responsive">
                                <table class="table table-centered table-borderless table-hover mb-0"
                                       id="supplierLedgerTable" width="100%">
                                    <thead class="thead-light">
                                    <tr>
                                        <th>Invoice ID</th>
                                        <th>Date</th>
                                        <th>A/C Title</th>
                                        <th>Debit</th>
                                        <th>Credit</th>
                                        <th>Due</th>
                                        <th>Notes</th>
                                        <th>Admin</th>


                                    </tr>
                                    
                                    </thead>

                                    <tbody>
                                    @php
                                        $balance=0;
                                        $due=0;
                                        $price=0;
                                    @endphp
                                    @forelse ($purchases as $purchase)
                                        @php
                                            $price=$balance+$purchase->totalAmount;
                                        @endphp
                                        <tr class="">
                                            <td>{{ $purchase->invoiceID }}</td>
                                            <td>{{ $purchase->date }}</td>
                                            <td>Sale</td>
                                            <td> </td>
                                            <td>{{ $purchase->totalAmount }}</td>
                                            <td>{{ $price }}</td>
                                            <td></td>
                                            <td>
                                                {{App\Models\Admin::where('id',$purchase->admin_id)->first()->name}}
                                            </td>
                                        </tr>

                                        @forelse(App\Models\SupplierPayment::where('purchase_id',$purchase->id)->get() as $payment)
                                            @php
                                                $balance=$price-$payment->paid_amount;
                                                $due=$price-$payment->paid_amount;
                                                $price=$due;
                                            @endphp
                                            <tr class="">
                                                <td></td>
                                                <td>{{ $payment->date }}</td>
                                                <td>{{App\Models\Paymenttype::where('id',$payment->payment_type_id)->first()->paymentTypeName }} Receive For- #{{ $purchase->invoiceID }}</td>
                                                <td>{{ $payment->paid_amount }}</td>
                                                <td></td>
                                                <td>{{ $due }}</td>
                                                <td>{{$payment->comments}}</td>
                                                <td>
                                                    {{App\Models\Admin::where('id',$payment->admin_id)->first()->name}}
                                                </td>
                                            </tr>

                                        @empty
                                            @php
                                                $balance=$price;
                                            @endphp
                                        @endforelse
                                    @empty

                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                       
                        </div>
                    </div>

                </div>
            </div>
        </section>


    </main>



    <script>
        
        $('#supplierLedgerTable').DataTable();

        {{--   Dynamic Product List     --}}
        // $(document).ready(function () {
        //     $('.js-example-basic-multiple').select2(
        //         {
        //             templateResult: formatState,
        //             dropdownParent: $("#mainPurchese")
        //
        //         }
        //     );
        //
        // });
        //
        // function formatState(state) {
        //     if (!state.id) {
        //         return state.text;
        //     }
        //     var $state = $(
        //         '<span><img src="' + state.element.getAttribute('data-img-src') + '" style="width: 30px;" /> ' + state.text + '</span>'
        //     );
        //     return $state;
        // }
        //
        //
        // // Datatable
        //
        // $(document).ready(function () {
        //
        //
        //     //edit city
        //
        //     $(document).on('click', '#editPurchaseBtn', function () {
        //         let purcheseId = $(this).data('id');
        //
        //         $.ajax({
        //             type: 'GET',
        //             url: 'purchases/' + purcheseId + '/edit',
        //
        //             success: function (data) {
        //                 $('#EditPurchase').find('#editdate').val(data.date);
        //                 $('#EditPurchase').find('#editinvoiceID').val(data.invoiceID);
        //                 $('#EditPurchase').find('#editproduct_id').val(data.product_id);
        //                 $('#EditPurchase').find('#editsupplier_id').val(data.supplier_id);
        //                 $('#EditPurchase').find('#editquantity').val(data.quantity);
        //                 $('#EditPurchase').find('#idhidden').val(data.id);
        //                 $('#EditPurchase').attr('data-id', data.id);
        //             },
        //             error: function (error) {
        //                 console.log('error');
        //             }
        //
        //         });
        //     });
        //
        //     //update city
        //     $('#EditPurchase').submit(function (e) {
        //         e.preventDefault();
        //         let purcheseId = $('#idhidden').val();
        //
        //         $.ajax({
        //             type: 'POST',
        //             url: 'purchase/' + purcheseId,
        //             processData: false,
        //             contentType: false,
        //             data: new FormData(this),
        //
        //             success: function (data) {
        //                 $('#editdate').val('');
        //                 $('#editinvoiceID').val('');
        //                 $('#editproduct_id').val('');
        //                 $('#editsupplier_id').val('');
        //                 $('#editquantity').val('');
        //
        //
        //                 swal({
        //                     title: "Purchase update successfully !",
        //                     icon: "success",
        //                     showCancelButton: true,
        //                     focusConfirm: false,
        //                     confirmButtonColor: "#DD6B55",
        //                     confirmButtonText: "Yes",
        //                     cancelButtonText: "No",
        //                 });
        //                 supplierLedgerTable.ajax.reload();
        //             },
        //             error: function (error) {
        //                 console.log('error');
        //             }
        //         });
        //     });
        //
        // });

    </script>

    @section('subscript')
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/select/1.3.4/js/dataTables.select.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/jquery-datatables-checkboxes@1.2.13/js/dataTables.checkboxes.min.js"></script>



        <script>
            flatpickr("#date", {});
            flatpickr("#editdate", {});
        </script>

    @endsection

@endsection
