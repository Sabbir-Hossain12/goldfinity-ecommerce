@extends('webview.master')

@section('maincontent')
@section('title')
    {{ env('APP_NAME') }}-{{ $categorysingle->category_name }}
@endsection

<style>
    #featureimageCt {
        height: 180px;
        width: auto;
        padding: 2px;
        padding-top: 0;
    }
    @media only screen and (max-width: 600px) {
       #featureimageCt {
           height: 180px;
            width: auto;
            padding: 2px;
            padding-top: 0;
        }
    }

    @media screen and (max-width: 480px) {
        .cat__bg .col-xs-3 {
            width: 20% !important;
        }
    }

    .col-xs-3 {
        width: 20%;
    }

    .cat__img {
        border-radius: 50%;
        margin-bottom: 5px;
    }

    /*   Featured Product */
    .image_thum {
        width: 183px;
        height: 183px;
    }

    .image_thum img {
        width: 100%;
        height: 100%;
        min-height: 140px;
        object-fit: contain;
    }

    .product__item {
        padding: 0;
        padding-top: 0px;
        background: #dedede;
    }

    @media screen and (max-width: 480px) {
        #productName374 {
            height: 18px;
        }
    }

    #productName374 {
        padding: 0;
        padding-bottom: 0px;
        display: block;
        line-height: 26px;
        color: #000;
        font-size: 12px;
        height: 20px;
        overflow: hidden;
    }

    #productPrice374 {
        padding: 0;
        padding-bottom: 10px;
        display: block;
        height: 28px;
        line-height: 28px;
        color: #000;
        font-size: 14px;
        font-weight: bold;
    }

    .product_form {
        padding: 0;
        display: block;
        height: 21px;
        font-size: 12px;
        font-weight: bold !important;
    }

    /*    Button*/
    button, input, select, textarea {
        font-family: inherit;
        font-size: inherit;
        line-height: inherit;
    }

    button, html input[type=button], input[type=reset], input[type=submit] {
        -webkit-appearance: button;
        cursor: pointer;
    }

    button, select {
        text-transform: none;
    }

    button {
        overflow: visible;
    }

    button, input, optgroup, select, textarea {
        margin: 0;
        font: inherit;
        color: inherit;
    }

    .col-xs-12 {
        width: 100%;
    }
</style>



{{-- category slug --}}
<input type="hidden" name="category" id="categoryslug" value="{{ $categorysingle->slug }}">

<!-- /.breadcrumb -->
<div class="body-content outer-top-xs">
    <div class="pt-2 breadcrumb">
        <div class="container p-0">
            <div class="row">
                <div class="col-12">
                    <div class="p-0 breadcrumb-inner">
                        <ul class="mb-0 list-inline list-unstyled">
                            <li><a href="#"
                                    style="text-transform: capitalize !important;color: #888;padding-right: 12px;font-size: 12px;">Home
                                    > category > <span class="active"></span>{{ $categorysingle->category_name }}</span>
                                </a></li>
                        </ul>
                    </div>
                </div>
                <!-- /.breadcrumb-inner -->
            </div>
        </div>
        <!-- /.container -->
    </div>


    <div class="container">
        <div class="row" id="viewCategoryProduct">

        </div>

        <!-- ============================================== BRANDS CAROUSEL : END ============================================== -->
    </div>
    <!-- /.container -->

</div>



{{-- csrf --}}
<input type="hidden" name="_token" value="{{ csrf_token() }}" />

<script>
    var token = $("input[name='_token']").val();

    $(document).ready(function() {

        var category = $('#categoryslug').val();
        $('#processing').modal('show');

        $.ajax({
            type: 'GET',
            url: '{{ url('get/products/by-category') }}',
            data: {
                _token: token,
                category: category,
            },

            success: function(response) {
                $('#processing').modal('hide');
                $('#viewCategoryProduct').empty().append(response);
            },
            error: function(error) {
                console.log('error');
            }
        });

    });

    function shownowpro() {
        $('#processing').modal('show');
        var pricerange = $('.price-slider').val();
        var categorynow = $('#categoryslug').val();
        $.ajax({
            type: 'GET',
            url: '{{ url('get/products/by-category') }}',
            data: {
                _token: token,
                category: categorynow,
                price_range: pricerange
            },

            success: function(response) {
                $('#processing').modal('hide');
                $('#viewCategoryProduct').empty().append(response);
            },
            error: function(error) {
                console.log('error');
            }
        });
    }


    function viewcategoryproduct(categoryslug) {
        $('#processing').modal('show');

        $.ajax({
            type: 'GET',
            url: '{{ url('get/products/by-category') }}',
            data: {
                _token: token,
                category: categoryslug,
            },

            success: function(response) {
                $('#processing').modal('hide');
                $('#viewCategoryProduct').empty().append(response);
            },
            error: function(error) {
                console.log('error');
            }
        });
    }

    function shownow() {
        $('#processing').modal('show');
        var pricerange = $('.price-slider').val();
        var categoryslg = $('#categoryslug').val();
        $.ajax({
            type: 'GET',
            url: '{{ url('get/products/by-category') }}',
            data: {
                _token: token,
                category: categoryslg,
                price_range: pricerange
            },

            success: function(response) {
                $('#processing').modal('hide');
                $('#viewCategoryProduct').empty().append(response);
            },
            error: function(error) {
                console.log('error');
            }
        });
    }

    function viewsubcategoryproduct(subcategoryslug) {
        $('#processing').modal('show');
        var pricerange = $('.price-slider').val();

        $.ajax({
            type: 'GET',
            url: '{{ url('get/products/by-subcategory') }}',
            data: {
                _token: token,
                subcategory: subcategoryslug,
                price_range: pricerange
            },

            success: function(response) {
                $('#processing').modal('hide');
                $('#viewCategoryProduct').empty().append(response);
            },
            error: function(error) {
                console.log('error');
            }
        });
    }

    function viewcategoryproduct(categoryslug) {
        $('#processing').modal('show');

        $.ajax({
            type: 'GET',
            url: '{{ url('get/products/by-category') }}',
            data: {
                _token: token,
                category: categoryslug,
            },

            success: function(response) {
                $('#processing').modal('hide');
                $('#viewCategoryProduct').empty().append(response);
            },
            error: function(error) {
                console.log('error');
            }
        });
    }
</script>

<style>
    @media only screen and (max-width: 768px) {
        #cateoryProSidebar {
            padding-right: 0;
        }

        #cateoryPro {
            padding-left: 0;
        }
    }

    #cateoryProSidebar {
        padding-left: 0;
    }

    #cateoryPro {
        padding-right: 0px;
    }

    .sidebar-widget .sidebar-widget-body .accordion .accordion-group .accordion-heading .accordion-toggle.collapsed:after {
        color: #636363;
        content: "\f067";
        font-family: fontawesome;
        font-weight: normal;
    }

    .sidebar .sidebar-module-container .sidebar-widget .sidebar-widget-body .accordion .accordion-group .accordion-heading .accordion-toggle:after {
        content: "\f068";
        float: right;
        font-family: fontawesome;
    }

    .widget-title {
        font-size: 16px;
        text-align: center;
        border-bottom: 1px solid #e9e9e9;
        padding-bottom: 10px;
        margin: 0;
    }

    .list {
        list-style: none;
    }

    #liaside {
        color: #858585;
        font-weight: bold;
    }

    .breadcrumb {
        padding: 5px 0;
        border-bottom: 1px solid #e9e9e9;
        background-color: #fafafa;
    }
</style>

@endsection
