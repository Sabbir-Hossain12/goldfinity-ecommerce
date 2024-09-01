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
        
        ul
        {
            list-style-type: none;  /* Removes the bullet points */
            padding-left: 0;        /* Removes the left padding */
            margin: 0;
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
                    </ol>
                </nav>
            </div>
            <div class="col-6" style="text-align: right">
                <a href="{{route('purchases.create')}}" class="btn btn-primary btn-sm" ><span style="font-weight: bold;">+</span> Add New Purchese
                </a>
            </div>
        </div><!-- End Page Title -->


        {{-- //popup modal for create user --}}
        <div class="modal fade" id="mainPurchese" tabindex="-1" data-bs-backdrop="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Purchase</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <form name="form" id="AddPurchese" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="date">Date</label>
                                <input type="text" name="date" class="form-control" id="date" value="{{date('d-m-Y')}}">
                            </div>
                            <div class="form-group pb-2">
                                <label for="invoiceID">Invoice ID</label>
                                <input type="text" name="invoiceID" class="form-control" id="invoiceID">
                            </div>
                            <div class="form-group pb-2">
                                <label for="product_id">Product Name</label>
                                <select name="product_id" id="product_id" class="js-example-basic-multiple form-select"
                                        style="width: 100%;">
                                    <option value="" disabled>Select a Product</option>
                                    @forelse ($weights as $weight)
                                        <option value="{{$weight->id}}" data-img-src="{{$weight->product->ProductImage }}"
                                                style="padding:10px">{{$weight->product->ProductName}} ({{$weight->weight_name}})</option>
                                    @empty

                                    @endforelse
                                </select>
                            </div>
                            <div class="form-group pb-2">
                                <label for="productID">Supplier Name</label>
                                <select name="supplier_id" id="supplier_id" class="form-control" style="width: 100%" required>
                                    <option value="">Select a Supplier</option>
                                    @forelse ($suppliers as $supplier)
                                        <option value="{{$supplier->id}}"
                                                style="padding:10px">{{$supplier->supplierName}}</option>
                                    @empty

                                    @endforelse
                                </select>
                            </div>
                            
                            <div class="form-group pb-2">
                                <label for="quantity">Quantity</label>
                                <input type="number" name="quantity" class="form-control" id="quantity">
                            </div>

                            <div class="form-group pb-2">
                                <label for="totalAmount">Total Amount</label>
                                <input type="number" name="totalAmount" class="form-control" id="totalAmount">
                            </div>

                            <div class="form-group" style="text-align: right">
                                <div class="submitBtnSCourse">
                                    <button type="submit" name="btn" class="btn btn-primary AddPurcheseBtn btn-block">
                                        Save
                                    </button>
                                </div>
                            </div>
                        </form>

                    </div>

                </div>
            </div>
        </div><!-- End popup Modal-->

        {{-- //table section for category --}}
        <section class="section">
            <div class="row">
                <div class="col-lg-12">

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
                                       id="purcheseinfotbl" width="100%">
                                    <thead class="thead-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Purchase Date</th>
                                        <th>Invoice ID</th>
                                        <th>Supplier Name</th>
                                        <th>Product Name</th>
                                        <th>Quantity</th>
                                        <th>Total Amount</th>
                                        <th>Discount Amount</th>
{{--                                        <th>Payed Amount</th>--}}
                                        <th>Status</th>
                                        <th style="width: 55px">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                            <!-- End Table with stripped rows -->

                        </div>
                    </div>

                </div>
            </div>
        </section>

        {{-- //popup modal for edit user --}}
        <div class="modal fade" id="editmainPurchase" tabindex="-1" data-bs-backdrop="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Purchase</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <form name="form" id="EditPurchase" enctype="multipart/form-data">
                            @csrf
                            <div class="successSMS"></div>

                            <div class="form-group">
                                <label for="date">Date</label>
                                <input type="text" name="date" class="form-control" id="editdate">
                            </div>
                            <div class="form-group pb-2">
                                <label for="invoiceID">Invoice ID</label>
                                <input type="text" name="invoiceID" class="form-control" id="editinvoiceID">
                            </div>
                            <div class="form-group pb-2">
                                <label for="productID">Product Name</label>
                                <select name="product_id" id="editproduct_id" class="form-control" style="width: 100%">
                                    <option value="">Select a Product</option>
                                    @forelse ($weights as $weight)
                                        <option value="{{$weight->id}}"
                                                style="padding:10px">{{$weight->product->ProductName}}</option>
                                    @empty

                                    @endforelse
                                </select>
                            </div>
                            <div class="form-group pb-2">
                                <label for="productID">Supplier Name</label>
                                <select name="supplier_id" id="editsupplier_id" class="form-control"
                                        style="width: 100%">
                                    <option value="">Select a Supplier</option>
                                    @forelse ($suppliers as $supplier)
                                        <option value="{{$supplier->id}}"
                                                style="padding:10px">{{$supplier->supplierName}}</option>
                                    @empty

                                    @endforelse
                                </select>
                            </div>
                            <div class="form-group pb-2">
                                <label for="quantity">Quantity</label>
                                <input type="text" name="quantity" class="form-control" id="editquantity">
                            </div>

                            <div class="form-group pb-2">
                                <label for="totalAmount">Total Amount</label>
                                <input type="number" name="totalAmount" class="form-control" id="totalAmount">
                            </div>
                            <input type="text" name="id" id="idhidden" hidden>
                            <div class="form-group" style="text-align: right">
                                <div class="submitBtnSCourse">
                                    <button type="submit" name="btn" class="btn btn-primary btn-block">Update</button>
                                </div>
                            </div>
                        </form>

                    </div>

                </div>
            </div>
        </div><!-- End popup Modal-->

    </main>



    <script>

        {{--   Dynamic Product List     --}}
        $(document).ready(function () {
            $('.js-example-basic-multiple').select2(
                {
                    templateResult: formatState,
                    dropdownParent: $("#mainPurchese")

                }
            );

        });

        function formatState(state) {
            if (!state.id) {
                return state.text;
            }
            var $state = $(
                '<span><img src="' + state.element.getAttribute('data-img-src') + '" style="width: 30px;" /> ' + state.text + '</span>'
            );
            return $state;
        }
        
        // Datatable

        $(document).ready(function () {

            var purcheseinfotbl = $('#purcheseinfotbl').DataTable({
                order: [[0, 'desc']],
                processing: true,
                serverSide: true,
                ajax: '{!! route('purchese.info') !!}',
                columns: [
                    {data: 'id'},
                    {data: 'date'},
                    {data: 'invoiceID'},
                    {
                        data: 'suppliers.supplierName',
                        name: "Supplier Name"
                    },
                    
                    {
                        data: 'productsData',
                        render: function(data) {
                            var productList = '<ul>';
                            data.forEach(function(product) {
                                productList += '<li>' + product + '</li>';
                            });
                            productList += '</ul>';
                            return productList;
                        },
                        orderable: false,
                        searchable: false

                    },
                  
                    { 
                        data: 'productsQty',
                        render: function (data) {

                            var productList = '<ul>';
                            data.forEach(function(qty) {
                                productList += '<li>' + qty + '</li>';
                            });
                            productList += '</ul>';
                            return productList;
                        }
                    
                    },
                    {
                        data: 'totalAmount',
                        name:'Total Amount',
                    }, 
                    {
                        data: 'discount_amount',
                        
                    },
                    
                    // {
                    //     data: 'payed_amount',
                    //    
                    // },
                    {
                        data:'status',
                        render:function (data) {
                            if (data === 'Due') {
                             return '<button class="btn btn-warning btn-sm">Due</button>';   
                            }
                            else 
                                return '<span class="badge bg-success badge-lg">Paid</span>';
                        }
                    },
                    {data: 'action', name: 'action', orderable: false, searchable: false},

                ]
            });


           

           

            //edit city

            $(document).on('click', '#editPurchaseBtn', function () {
                let purcheseId = $(this).data('id');

                console.log()

                $.ajax({
                    type: 'GET',
                    url: 'purchases/' + purcheseId + '/edit',

                    success: function (data) {
                        $('#EditPurchase').find('#editdate').val(data.date);
                        $('#EditPurchase').find('#editinvoiceID').val(data.invoiceID);
                        $('#EditPurchase').find('#editproduct_id').val(data.product_id);
                        $('#EditPurchase').find('#editsupplier_id').val(data.supplier_id);
                        $('#EditPurchase').find('#editquantity').val(data.quantity);
                        $('#EditPurchase').find('#totalAmount').val(data.totalAmount);
                        $('#EditPurchase').find('#idhidden').val(data.id);
                        $('#EditPurchase').attr('data-id', data.id);

                        // console.log(data);
                    },
                    error: function (error) {
                        console.log('error');
                    }

                });
            });

            //update city
            $('#EditPurchase').submit(function (e) {
                e.preventDefault();
                let purcheseId = $('#idhidden').val();

                $.ajax({
                    type: 'POST',
                    url: 'purchase/' + purcheseId,
                    processData: false,
                    contentType: false,
                    data: new FormData(this),

                    success: function (data) {
                        $('#editdate').val('');
                        $('#editinvoiceID').val('');
                        $('#editproduct_id').val('');
                        $('#editsupplier_id').val('');
                        $('#editquantity').val('');


                        swal({
                            title: "Purchase update successfully !",
                            icon: "success",
                            showCancelButton: true,
                            focusConfirm: false,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "Yes",
                            cancelButtonText: "No",
                        });
                        
                        purcheseinfotbl.ajax.reload();
                    },
                    error: function (error) {
                        console.log('error');
                    }
                });
            });

            //deleteuser

            $(document).on('click', '#deletePurchaseBtn', function () {
                let purcheseId = $(this).data('id');
                swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this !",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                type: 'DELETE',
                                url: 'purchases/' + purcheseId,

                                success: function (data) {
                                    swal("Poof! Your purchase has been deleted!", {
                                        icon: "success",
                                    });
                                    purcheseinfotbl.ajax.reload();
                                },
                                error: function (error) {
                                    console.log('error');
                                }

                            });


                        } else {
                            swal("Your data is safe!");
                        }
                    });

            });


        });

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