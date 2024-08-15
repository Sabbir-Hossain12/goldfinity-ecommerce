@extends('backend.master')

@section('maincontent')
    @section('title')
        {{ env('APP_NAME') }}- Admins
    @endsection
    <style>
        div#roleinfo_length {
            color: red;
        }
        div#roleinfo_filter {
            color: red;
        }
        div#roleinfo_info {
            color: red;
        }
    </style>

    <div class="container-fluid pt-4 px-4">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-xl-12">
                <div class="h-100 bg-secondary rounded p-4 pb-0">
                    <div class="d-flex align-items-center justify-content-between"  style="width: 50%;float:left;">
                        <h6 class="mb-0">Blog List</h6>
                    </div>
                    <div class="" style="width: 50%;float:left;">
                        <a href="{{route('admin.blogs.create')}}" class="btn btn-dark" style="color:red;float: right"> + Create Blogs</a>
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-md-12 col-xl-12">
                <div class="bg-secondary rounded h-100 p-4">
                    <div class="data-tables">
                        <table class="table table-dark" id="roleinfo" width="100%"  style="text-align: center;">
                            <thead class="thead-light">
                            <tr>
                                <th>SL</th>
                                <th>Admin</th>
                                <th>Email</th>
                                <th>Roles</th>
                                <th>Action</th>
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

    <script>
        $(document).ready( function () {
            $('#roleinfo').DataTable();
        } );
    </script>

@endsection
