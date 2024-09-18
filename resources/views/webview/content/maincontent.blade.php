@extends('webview.master')

@section('maincontent')
    @section('title')
        {{ env('APP_NAME') }}-Best online shop in Bangladesh
    @endsection

    @section('meta')
        <meta name="description"
              content="Online shopping in Bangladesh for beauty products, men, women, kids, fashion items, clothes, electronics, home appliances, gadgets, watch, many more.">
        <meta name="keywords"
              content="smartbaking, online store bd, online shop bd, Organic fruits, Thai, UK, Korea, China, cosmetics, Jewellery, bags, dress, mobile, accessories, automation Products,">


        <meta itemprop="name" content="Best Online Shopping in Bangladesh | smartbaking">
        <meta itemprop="description"
              content="Best online shopping in Bangladesh for beauty products, men, women, kids, fashion items, clothes, electronics, home appliances, gadgets, watch, many more.">
        <meta itemprop="image" content="https://smartbaking.com/{{\App\Models\Basicinfo::first()->logo}}">

        <meta property="og:url" content="https://smartbaking.com/">
        <meta property="og:type" content="website">
        <meta property="og:title" content="Best Online Shopping in Bangladesh | smartbaking">
        <meta property="og:description"
              content="Online shopping in BD for beauty products, men, women, kids, fashion items, clothes, electronics, home appliances, gadgets, watch, many more.">
        <meta property="og:image" content="https://smartbaking.com/{{\App\Models\Basicinfo::first()->logo}}">
        <meta property="image" content="https://smartbaking.com/{{\App\Models\Basicinfo::first()->logo}}"/>
        <meta property="url" content="https://smartbaking.com/">
        <meta itemprop="image" content="https://smartbaking.com/{{\App\Models\Basicinfo::first()->logo}}">
        <meta property="twitter:card" content="https://smartbaking.com/{{\App\Models\Basicinfo::first()->logo}}"/>
        <meta property="twitter:title" content="Best Online Shopping in Bangladesh | smartbaking"/>
        <meta property="twitter:url" content="https://smartbaking.com/">
        <meta name="twitter:image" content="https://smartbaking.com/{{\App\Models\Basicinfo::first()->logo}}">
    @endsection
    <style>
        .owl-carousel .owl-item img {
            display: inline;
            width: 100%;
            height: 508px;
        }


        .product {
            margin-top: 4px !important;

        }

        #featureimagess {
            width: 100%;
            padding: 2px;
            padding-top: 0;
            max-height: 200px;
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

        #lgid {
            width: 50px;
        }
        #lhidh4 {
            font-size: 18px;
            font-weight: bold;
        }
        #lhidp {
            font-size: 12px;
            font-weight: bold;
        }
        #adsinfo{
            border-radius: 0px 6px 6px 0px;
        }


        @media only screen and (max-width: 600px) {
           .owl-carousel .owl-item img {
                display: inline;
                width: 100%;
                height: 260px;
                margin-bottom: 10px;
            }
            #lhidh4 {
                font-size: 12px;
                font-weight: bold;
            }
            #lhidp {
                font-size: 8px;
                font-weight: bold;
            }
            #lgid {
                width: 34px;
            }

            #adsinfo{
                border-radius: 6px;
            }

        }

    </style>

    <div class="p-0 m-0 mb-lg-3 container-fluid">
        <div class="bg-white row">
            <div class="col-lg-7 col-12 ps-0" id="mainslider">

                <div class="col-12">
                    <div class="owl-carousel owl-theme" id="slider">
                        @forelse ($sliders as $slider)
                            <div class="item" style="margin:0 !important;">
                                <img src="{{ asset($slider->slider_image) }}"
                                     alt="{{ $slider->slider_title }}">
                            </div>
                        @empty
                        @endforelse
                    </div>

                </div>
            </div>
            <div class="p-0 col-lg-5 col-12">
                <div class="m-0 row">
                    @if (count($adds) == '2')
                        @forelse ($adds as $add)
                            <div class="p-0 mb-2 col-lg-12 col-6">
                                <div class="mb-1 media-banner mb-lg-0">
                                    <a href="{{ $add->add_link }}" target="_blank" class="banner-container">
                                        <img src="{{ asset($add->add_image) }}" alt="{{ env('APP_NAME') }}"
                                            class="img-fluid ls-is-cached lazyloaded">
                                    </a>
                                </div>
                            </div>
                        @empty
                        @endforelse
                    @else
                        @forelse ($adds as $add)
                            <div class="p-0 col-lg-12 col-12">
                                <div class="mb-1 media-banner mb-lg-0">
                                    <a href="{{ $add->add_link }}" target="_blank" class="banner-container">
                                        <img src="{{ asset($add->add_image) }}" alt="{{ env('APP_NAME') }}"
                                            class="img-fluid ls-is-cached lazyloaded">
                                    </a>
                                </div>
                            </div>
                        @empty
                        @endforelse
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="container p-0 pb-2">
        <div clas="row" >
            <div class="col-12">
                <div class="row">
                    <div class="mb-3 col-lg-3 col-6">
                    <div class="d-flex">
                        <img src="{{asset('/')}}/public/box.png" id="lgid">
                        <div class="infotext ps-2">
                            <h4 class="m-0" id="lhidh4">Discount</h4>
                            <p class="p-0 m-0" id="lhidp">Every week new sales</p>
                        </div>
                    </div>
                </div>
                <div class="mb-3 col-lg-3 col-6">
                    <div class="d-flex">
                        <img src="{{asset('/')}}/public/delivery-truck.png" id="lgid">
                        <div class="infotext ps-2">
                            <h4 class="m-0" id="lhidh4">Free Delivery</h4>
                            <p class="p-0 m-0" id="lhidp">100% free delivery on campaign</p>
                        </div>
                    </div>
                </div>
                <div class="mb-3 col-lg-3 col-6">
                    <div class="d-flex">
                        <img src="{{asset('/')}}/public/24-hours.png" id="lgid">
                        <div class="infotext ps-2">
                            <h4 class="m-0" id="lhidh4">Get Support 24/7</h4>
                            <p class="p-0 m-0" id="lhidp">We care your experiences</p>
                        </div>
                    </div>
                </div>
                <div class="mb-3 col-lg-3 col-6">
                    <div class="d-flex">
                        <img src="{{asset('/')}}/public/security.png" id="lgid">
                        <div class="infotext ps-2">
                            <h4 class="m-0" id="lhidh4">Secure Payment</h4>
                            <p class="p-0 m-0" id="lhidp">100% secure payment methood</p>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>



    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 style="    margin: 0;font-size: 24px;text-align: center;padding: 16px;font-weight: bold;padding-top: 0;">Shop By Category</h2>
            </div>
            @forelse ($categories as $category)
                <div class="col-lg-2 col-4" style="margin-bottom:10px">
                    <a href="{{ url('products/category/' . $category->slug) }}">
                        <div id="" class="">
                            <div class="">
                                <img src="{{ asset($category->category_icon) }}" id="catimg">
                            </div>
                            <p id="catp">{{ $category->category_name }}</p>

                        </div>
                    </a>
                </div>
            @empty

            @endforelse

        </div>
    </div>

    <div class="p-0 container-fluid">
        <div class="row">
            <div class="p-0 mb-2 col-lg-12">
                <div class="mb-1 media-banner mb-lg-0">
                    <a href="{{ $addbottoms->add_link }}" target="_blank" class="banner-container">
                        <img src="{{ asset($addbottoms->add_image) }}"  class="img-fluid ls-is-cached lazyloaded">
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if(count($featuredproducts)>0)
    <div class="p-0 pt-4 container-fluid">
        <div class="row">
            <div class="p-0 mb-2 col-lg-4 col-12">
                <div class="mb-1 media-banner mb-lg-0">
                    <a href="{{ $addbottoms2->add_link }}" target="_blank" class="banner-container">
                        <img src="{{ asset($addbottoms2->add_image) }}"  class="img-fluid ls-is-cached lazyloaded" id="adsinfo">
                    </a>
                </div>
            </div>
            <div class="col-lg-8 col-12">
                <div class="owl-carousel " id="featuredProductSlide">
                    @forelse ($featuredproducts as $featuredproduct)
                        <div class="item">
                            @forelse ($featuredproduct as $promotional)
                                <div class="mb-2 col-sm-12 col-xs-12 padding-zero product-hover-effect"
                                        style="background-color: #fff;padding: 0px;box-shadow: 0px 1px 12px 4px #efefef;border-radius: 6px;">
                                    <a style="padding: 0px;overflow: hidden;"
                                        class="img-hover col-sm-12 padding-zero image_thum"
                                        href="{{ url('product/' . $promotional->ProductSlug) }}" id="374">
                                        <img class="img-fluid" style="margin: 0 auto;padding:5px; height: 175px"
                                                src="{{ asset($promotional->ViewProductImage) }}">
                                    </a>
                                    <div class="col-sm-12 col-xs-12 product__item" style="border-radius:0px 0px 6px 6px">
                                        <span id="productName374"
                                                class="text-center col-sm-12">{{$promotional->ProductName}}</span>
                                        @if(count($promotional->weights)>0)

                                            <span id="productPrice374" class="text-center col-sm-12 col-xs-12" style="">
                                                    Tk. {{ round($promotional->weights[0]->productSalePrice) }}   </span>
                                        @else
                                            <span id="productPrice374" class="text-center col-sm-12 col-xs-12" style="">
                                                    Tk. {{round($promotional->ProductSalePrice)}}   </span>

                                        @endif

                                    </div>
                                </div>
                            @empty
                            @endforelse
                        </div>
                    @empty
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    @else
        <div class="p-0 container-fluid">
            <div class="row">
                <div class="p-0 mb-2 col-lg-4 col-12">
                    <div class="mb-1 media-banner mb-lg-0">
                        <a href="{{ $addbottoms2->add_link }}" target="_blank" class="banner-container">
                            <img src="{{ asset($addbottoms2->add_image) }}"  class="img-fluid ls-is-cached lazyloaded" style="border-radius: 6px;">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @forelse ($categoryproducts as $key=>$categoryproduct)
        @if (count($categoryproduct->products) > 0)
            <!-- Category Products -->
            <div class="container pt-0 pb-4">
                <div class="pb-0 bg-white row">
                    <div class="col-12"
                         style="padding-left: 0;display: flex;justify-content: space-between;">
                        <div class="px-2 pt-0 p-md-3 d-flex justify-content-between"
                             style="padding-bottom:4px !important;padding-top: 8px !important;">
                            <h4 class="m-0"><b>{{ $categoryproduct->category_name }}</b></h4>
                        </div>
                        <a href="{{url('products/category/'.$categoryproduct->slug)}}"
                           class="mb-0 btn btn-danger btn-sm"
                           style="padding: 6px;height: 22px;color: white;font-weight: bold;margin-top: 10px;background: #000;font-size: 10px;border: 1px solid #000;padding-top: 4px;">VIEW
                            ALL</a>
                    </div>


                    <div class="mt-2 owl-carousel bestsellingproductSlide" >
                        @forelse ($categoryproduct->products->take(12) as $product)
                            <div class="mb-2 col-sm-12 col-xs-12 padding-zero product-hover-effect"
                                    style="background-color: #fff;padding: 0px;box-shadow: 0px 1px 12px 4px #efefef;border-radius: 6px;">
                                <a style="padding: 0px;overflow: hidden;"
                                    class="img-hover col-sm-12 padding-zero image_thum"
                                    href="{{ url('product/' . $product->ProductSlug) }}" id="374">
                                    <img class="img-fluid" style="margin: 0 auto;padding:5px; height: 175px"
                                            src="{{ asset($product->ViewProductImage) }}">
                                </a>
                                <div class="col-sm-12 col-xs-12 product__item" style="border-radius:0px 0px 6px 6px">
                                    <span id="productName374"
                                            class="text-center col-sm-12">{{$product->ProductName}}</span>
                                    @if(count($product->weights)>0)

                                        <span id="productPrice374" class="text-center col-sm-12 col-xs-12" style="">
                                                Tk. {{ round($product->weights[0]->productSalePrice) }}   </span>
                                    @else
                                        <span id="productPrice374" class="text-center col-sm-12 col-xs-12" style="">
                                                Tk. {{round($product->ProductSalePrice)}}   </span>

                                    @endif

                                </div>
                            </div>
                        @empty
                        @endforelse
                    </div>

                </div>
            </div>

        @else
        @endif

    @empty
    @endforelse

@endsection
