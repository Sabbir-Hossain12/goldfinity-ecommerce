<header class="header-style-1">


    <!-- ============================================== TOP MENU ============================================== -->
    <div class="top-barhead animate-dropdown" style="background: #000000">
        <div class="container">
            <div class="header-top-inner">
                <div class="cnt-account">
                    <ul class="list-unstyled">
                        @if (Auth::id())
                            <li><a href="{{ url('user/dashboard') }}"><i class="icon fas fa-user"></i>Dashboard</a></li>
                        @else
                            <li><a href="{{ url('login') }}">Sign In</a></li>
                            <li><a href="javascript:void(0);">|</a></li>
                            <li><a href="{{ url('register') }}">Sign Up</a></li>
                        @endif
                    </ul>
                </div>
                <div class="cnt-account" style="float: left;">
                    <ul class="list-unstyled">
                        <li><a href="tel:+88{{$basicinfo->phone_one}}"><i class="icon fas fa-phone"></i>{{$basicinfo->phone_one}}</a></li>
                    </ul>
                </div>
                <!-- /.cnt-cart -->
                <div class="clearfix"></div>
            </div>
            <!-- /.header-top-inner -->
        </div>
        <!-- /.container -->
    </div>

    <div class="main-header" id="myHeader" style="background: #fff;border-bottom: 1px solid #e9e9e9;">
        <div class="container">
            <div class="row" style="margin: 0">
                <div class="col-9 col-sm-9 col-md-9 col-lg-3 logo-holder ps-0">
                    <!-- ============================================================= LOGO ============================================================= -->
                    <div class="logo">
                        <button type="button" onclick="openNav()" id="menubutton">
                            <img src="{{asset('public/menus.png')}}" style="width:40px">
                        </button>

                        <a href="{{ url('/') }}" id="logoimage">
                            <img src="{{ asset($basicinfo->logo) }}" alt="" id="logosm" style="width:58%;margin-left:15px;">
                        </a>
                    </div>
                    <!-- /.logo -->
                    <!-- ============================================================= LOGO : END ============================================================= -->
                </div>
                <!-- /.logo-holder -->

                <div class="col-2 col-sm-2 col-md-2 col-lg-6 top-search-holder" id="d-sm-none">
                    <div class="order-2 col-lg-12 position-static order-lg-0 d-none d-lg-block" >
                        <div id="menu">
                            <ul>
                                <li><a href="{{ url('/') }}">Home</a></li>
                                <li><a href="{{ url('venture/about_us') }}">About Us</a></li>
                                <li><a href="{{ url('venture/contact_us') }}">Contact Us</a></li>
                                <li><a href="{{ url('/blogs') }}">News Feed</a></li>
                                <li><a href="{{ url('/track-order') }}">Track</a></li>

                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /.top-search-holder -->

                <div class="p-0 col-3 col-sm-3 col-md-3 col-lg-3 animate-dropdown top-cart-row">
                    <!-- ============================================================= SHOPPING CART DROPDOWN ============================================================= -->


                    <div class=" dropdown-cart" style="padding-left: 14px;">
                        <a href="#" class="dropdown" onclick="checkcart(this)" data-bs-toggle="dropdown"
                            id="smcarticon">
                            <div class="items-cart-inner">
                                <div class="basket" style="padding: 0;padding-top: 2px;display:flex;">
                                    <i class="fa-solid fa-shopping-bag" style="color: #000;font-size: 28px;"></i>

                                </div>
                                <div class="nav-box-number" id="d-sm-none"><span
                                        class="count">{{ count(Cart::content()) }}</span></div>
                            </div>
                        </a>
                        <ul class="dropdown-menu">
                            <li id="checkcartview">
                            </li>
                        </ul>
                        <!-- /.dropdown-menu-->
                    </div>


                    <a type="button" class="search-button" data-bs-toggle="modal"
                        data-bs-target="#searchPopup" style="float: right;font-size: 23px; color: #b9b9b9;"
                        href="#" id="smsericon"> <i class="fas fa-search"
                            style="margin-top: 6px;margin-left: 7px;color:#000"></i></a>
                    <!-- ============================================================= SHOPPING CART DROPDOWN : END============================================================= -->
                </div>
                <!-- /.top-cart-row -->
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container -->

    </div>


    <!-- side bar panel start -->
    <div id="mySidepanel" class="sidepanel">
        <div class="side-menu-header ">
            <div class="side-menu-close" onclick="closeNav()">
                <i class="fas fa-close"></i>
            </div>
            <div class="px-3 pb-3 side-login" style="padding-top: 12px;padding-bottom: 15px; padding-left: 10px;">
                <a href=""></a>
                <a style="font-size: 16px" href="#">Categories</a>
            </div>
        </div>
        <ul class="level1-styles collapse show" id="id0">

            @forelse ($categories as $category)
                @if (count($category->subcategories) > 0)
                    <li>
                        <a href="{{ url('products/category/' . $category->slug) }}" class="collapsed"
                            data-bs-toggle="collapse"
                            data-bs-target="#id{{ $category->id }}">{{ $category->category_name }}<i
                                class="fas fa-plus" aria-hidden="true" id="plusicon"></i></a>
                        <ul class="collapse level2-styles" id="id{{ $category->id }}">
                            @foreach ($category->subcategories as $subcategory)
                                <li>
                                    <a
                                        href="{{ url('products/sub/category/' . $subcategory->slug) }}">{{ $subcategory->sub_category_name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @else
                    <li>
                        <a
                            href="{{ url('products/category/' . $category->slug) }}">{{ $category->category_name }}</a>
                    </li>
                @endif
            @empty
            @endforelse
        </ul>
    </div>
    <!-- side bar panel end -->
</header>

<!-- Search Popup Modal -->
<div class="modal fade" id="searchPopup" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border-radius: 0px !important">
            <div class="modal-body" style="padding: 0px;">
                <div class="modalsearch-area">
                    <div class="control-group d-flex justify-content-between">
                        <input class="mb-0 search-field" id="modalsearchinput" onkeyup="searchproduct()"
                            placeholder="Search here...">
                        <a class="search-button" data-bs-dismiss="modal" href="#"></a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div id="searchproductlist" style="background: white;margin: 10px;height: auto;overflow: scroll;">

    </div>
</div>

<style>
    .modalsearch-area .search-field {
        border: medium none;
        padding: 10px;
        border-right: none;
        float: left;
    }

    .modalsearch-area .search-button {
        display: inline-block;
        float: left;
        margin-top: -1px;
        padding: 6px 15px 7px;
        text-align: center;
        background-color: #e62e04;
        border: 1px solid #e62e04;
    }

    .modalsearch-area .search-button:after {
        color: #fff;
        content: "\f00d";
        font-family: fontawesome;
        font-size: 24px;
        line-height: 9px;
        vertical-align: middle;
    }
</style>
