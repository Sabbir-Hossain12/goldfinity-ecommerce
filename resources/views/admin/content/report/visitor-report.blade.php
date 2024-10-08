@extends('admin.master')

@section('maincontent')
    @section('subcss')
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.0-alpha1/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jquery-datatables-checkboxes@1.2.13/css/dataTables.checkboxes.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endsection

    <main id="main" class="main">

        <div class="pagetitle row">
            <div class="col-6">
                <h1><a href="{{url('/admindashboard')}}">Dashboard</a></h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/admindashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Product-Report</li>
                    </ol>
                </nav>
            </div>
        </div><!-- End Page Title -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-lg-12">
                                <div class="form-row">
                                    <div class="form-group col-md-2 p-2">
                                        <label for="inputCity" class="col-form-label">Start Date</label>
                                        <input type="text" class="form-control datepicker" id="startDate"  value="<?php echo date('Y-m-d')?>" placeholder="Select Date">
                                    </div>
                                    <div class="form-group col-md-2 p-2">
                                        <label for="inputCity" class="col-form-label">End Date</label>
                                        <input type="text" class="form-control datepicker" id="endDate" value="<?php echo date('Y-m-d')?>" placeholder="Select Date">
                                    </div>
                                  
                                   
                                    <div class="form-group col-md-1 pt-2">
                                        <label for="" class="col-form-label" style=" ">Print</label>
                                        <button class="btn btn-info btn-print-courieruserreport"><i class="fas fa-print"></i> Print</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table id="webreportTable" class="table table-centered table-nowrap mb-0" style="width: 100%">
                                <thead class="thead-light" >
                                <tr>
                                    <th>ID</th>
                                    <th>IP Address</th>
                                    <th>Client/Browser</th>
                                    <th>Visited Date</th>
                                    <th>Visited Month</th>
                                    <th>Visited Year</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @section('subscript')
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/select/1.3.4/js/dataTables.select.min.js"></script>

        <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>

    @endsection

    <script>

        $(document).ready(function() {
            //token
            var token = $("input[name='_token']").val();
            //date picker
            $(".datepicker").flatpickr();

            var table = $("#webreportTable").DataTable({
                type: "GET",
                ajax: {
                    url: "{{url('admin/visitor/report/data')}}",
                    data: {
                        startDate: function() { return $('#startDate').val() },
                        endDate: function() { return $('#endDate').val() },
                      
                    }
                },
                ordering: false,
                pageLength: 50,
                columns: [
                    {data: "id"},
                    {data: "ip_address"},
                    {data: "browser"},
                    {data: "visited_date"},
                    {data: "month"},
                    {data: "year"},
                ],
                search:false,
                dom: '<"row"<"col-sm-6"Bl><"col-sm-6"f>>' +
                    '<"row"<"col-sm-12"<"table-responsive"tr>>>' +
                    '<"row"<"col-sm-5"i><"col-sm-7"p>>',
                buttons: {
                    buttons: [{
                        extend: 'print',
                        text: 'Print',
                        footer: true ,
                        title: function(){
                            return 'Visitor Report';
                        },
                        customize: function (win) {
                            $(win.document.body).find('h1').css('text-align','center');
                            $(win.document.body).find('h1').after('<p style="text-align: center">'+$('#startDate').val()+' to '+$('#endDate').val()+'</p>');

                        }
                    }]
                },
                language: {
                    paginate: {
                        previous: "<i class='fas fa-chevron-left'>",
                        next: "<i class='fas fa-chevron-right'>"
                    }
                },
                drawCallback: function () {
                    $(".dataTables_paginate > .pagination").addClass("pagination-sm");
                    $('.dt-buttons').hide();
                },

            });

            $(document).on('click', '.btn-print-courieruserreport', function(){
                $(".buttons-print")[0].click();
            });
        

           
            $(document).on('change', '#startDate', function(){
                table.ajax.reload();
            });
            $(document).on('change', '#endDate', function(){
                table.ajax.reload();
            });
          


        });





    </script>



    <style>
        .card-box {
            background-color: #fff;
            padding: 1.5rem;
            -webkit-box-shadow: 0 1px 4px 0 rgb(0 0 0 / 10%);
            box-shadow: 0 1px 4px 0 rgb(0 0 0 / 10%);
            margin-bottom: 24px;
            border-radius: 0.25rem;
        }
        a {
            text-decoration: none;
        }


        .form-row {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            margin-right: -5px;
            margin-left: -5px;
        }
        .select2-container--default .select2-selection--single {
            display: block;
            width: 100%;
            height: calc(1.5em + 0.9rem + 2px);
            padding: 0.3rem 0.9rem;
            font-size: .875rem;
            font-weight: 400;
            line-height: 1.5;
            color: #383b3d;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            border-radius: 0.2rem;
        }
        span.select2-selection__arrow {
            margin-top: 5px;
        }
    </style>



@endsection
