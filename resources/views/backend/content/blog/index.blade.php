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
                                <th>Image</th>
                                <th>Title</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            
                            @foreach($data as $key => $value) 
                                
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td><img src="{{asset($value->main_img)}}" alt="" style="width: 80px;height: 80px"></td>
                                    <td>{{$value->title}}</td>
                                    <td>{{$value->created_at->format('d M Y h:i A')}}</td>
                                    <td>
                                        <a href="{{route('admin.blogs.edit',$value->id)}}" class="btn btn-info">Edit</a>
                                        
                                        <button type="submit" form="blogDelete" class="btn btn-danger" >Delete</button>
                                        <form id="blogDelete" action="{{route('admin.blogs.destroy',$value->id)}}" method="post">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                
                                
                            @endforeach
                       
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


        </div>
    </div>
    <script src="{{asset('https://cdn.jsdelivr.net/npm/sweetalert2@11')}}"></script>
    <script>
        $(document).ready( function () {
            $('#roleinfo').DataTable();
        } );

        $('#blogDelete').on('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                    )
                    // $(this).submit();
                    $('#blogDelete').off('submit').submit();
                }
            })
        })
        
    </script>

@endsection
