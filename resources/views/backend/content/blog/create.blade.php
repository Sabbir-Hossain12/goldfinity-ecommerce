@extends('backend.master')

@section('maincontent')
    @section('title')
        {{ env('APP_NAME') }}- Products
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
        .ck-editor__editable {
            min-height: 300px;
        }
    </style>
    {{-- summernote --}}
{{--    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">--}}
    <script src="{{asset('https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js')}}"></script>

    <div class="container-fluid pt-4 px-4 pb-4">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-xl-12">
                <div class="h-100 bg-secondary rounded p-4">
                    <div class="d-flex align-items-center justify-content-center">
                        <h4 class="mb-0 mt-0 p-3 text-center">Add New Blog</h4>
                    </div>
                </div>
            </div>






            <div class="container p-4">
                <form name="form" action="{{route('admin.blogs.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12">
                            <h5 class="text-uppercase bg-light p-2 mt-0 mb-3">General</h5>

                            <div class="form-group mb-3">
                                <label for="ProductName">Blog Title <span class="text-danger"></span></label>
                                <input type="text" name="title" id="ProductName" class="form-control"
                                       required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="ProductName">Author Name <span class="text-danger">*</span></label>
                                <input type="text" name="author" id="ProductName" class="form-control"
                                       value="{{\Illuminate\Support\Facades\Auth::user()->name ?? ''}}">
                            </div>

                            <div class="form-group mb-3">
                                <label for="ProductRegularPrice">Blog Short Description <span
                                            class="text-danger">*</span></label>
                                <textarea class="form-control" name="short_desc" rows="2"></textarea>
                            </div>

                            <div class="form-group mb-3">
                                <label for="ProductDetailsss">Blog Long Description <span
                                            class="text-danger">*</span></label>
                                <textarea class="form-control" id="blogLongDesc" name="long_desc" rows="10"></textarea>
                            </div>
                            <script type="text/javascript">
                                $(document).ready(function() {
                                    // $('#ProductDetails').summernote();

                                    ClassicEditor
                                        .create(document.querySelector('#blogLongDesc')
                                            ,{

                                                ckfinder:
                                                    {
                                                        uploadUrl: "{{route('admin.ckeditor.upload', ['_token' => csrf_token() ])}}",
                                                    }


                                            })
                                        
                                        .then(newEditor => {
                                            jReq = newEditor;
                                        })
                                        .catch(error => {
                                            console.error(error);
                                        });
                                });
                            </script>

                        </div>

                        <div class="col-lg-12">


                            <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">Blog Images</h5>

                            <div class="row">
                               
                                <div class="col-12">
                                    <div class="form-group mb-3">
                                        <label for="ProductDetails">Blog Main Image <span
                                                    class="text-danger">*</span></label>
                                        <button type="button" class="btn btn-danger d-block mb-2"
                                                style="background: red">
                                            <input type="file" name="main_img" id="ProductImage"
                                                   oninput="mainImg.src=window.URL.createObjectURL(this.files[0])">
                                        </button>
                                        <img id="mainImg" style="height:100px;width:200px" />
                                      
                                    </div>
                                </div>

                                <div class="col-12 mb-4">
                                    <div class="form-group"
                                         style="padding: 10px;padding-top: 3px;margin:0;padding-bottom:3px;width:96%;margin-left: 8px;border-radius: 8px;padding-left: 0;margin-left: -0;">
                                        <label class="fileContainer">
                                                    <span style="font-size: 20px;">Blog Images (Multiple)</span>
                                        </label>
                                        <br>
                                        <button type="button" class="btn btn-danger d-block mb-2"
                                                style="background: red">
                                            <input type="file" id="multiple_img_input"
                                                   name="multiple_img[]"  multiple>
                                        </button>
                                        <div id="imagePreviewContainer" style="display: flex; flex-wrap: wrap;"></div>                                    </div>
                                   
                                </div>
                            </div>

                        

                        </div>

                        <div class="col-lg-12">


                            <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">Meta Information's</h5>

                            <div class="row">
                                <div class="form-group mb-3">
                                    <label for="ProductName">Meta Title <span class="text-danger"></span></label>
                                    <input type="text" name="meta_title" id="ProductName" class="form-control"
                                           required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="ProductRegularPrice">Meta Description <span
                                                class="text-danger"></span></label>
                                    <textarea class="form-control" name="meta_desc" rows="2"></textarea>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="ProductRegularPrice">Meta Keywords <span
                                                class="text-danger"></span></label>
                                    <textarea class="form-control" name="meta_keyword" rows="2"></textarea>
                                </div>
                                

                                <div class="col-12">
                                    <div class="form-group mb-3">
                                        <label for="ProductDetails">Meta Image<span
                                                    class="text-danger">*</span></label>
                                        <button type="button" class="btn btn-danger d-block mb-2"
                                                style="background: red">
                                            <input type="file" name="meta_image" id="ProductImage"
                                                   oninput="metaImg.src=window.URL.createObjectURL(this.files[0])" >
                                        </button>
                                        <img id="metaImg" style="height:100px;width:200px" />
                                      
                                    </div>
                                </div>

                                
                            </div>



                        </div>

                     

                    </div>
                    <br>
                    <div class="form-group mt-2" style="text-align: right">
                        <div class="submitBtnSCourse">

                            <button type="submit" name="btn"
                                    class="btn btn-primary btn-block">Save</button>
                        </div>
                    </div>
                </form>
            </div>
            {{-- Create New Product Modal Ends --}}



        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

    <script>
        const inputElement = document.getElementById('multiple_img_input');
        const imagePreviewContainer = document.getElementById('imagePreviewContainer');

        inputElement.addEventListener('change', function() {
            imagePreviewContainer.innerHTML = ''; // Clear any existing previews

            const files = this.files;
            if (files) {
                Array.from(files).forEach(file => {
                    const imgElement = document.createElement('img');
                    imgElement.src = URL.createObjectURL(file);
                    imgElement.style.height = '100px';
                    imgElement.style.width = '200px';
                    imgElement.style.margin = '5px';
                    imgElement.onload = () => {
                        URL.revokeObjectURL(imgElement.src); // Free memory
                    };
                    imagePreviewContainer.appendChild(imgElement);
                });
            }
        });
    </script>

@endsection
