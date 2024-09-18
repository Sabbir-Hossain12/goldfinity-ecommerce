
@forelse ($subcategoryproducts as $product)
    <div class="m-auto mb-4 col-lg-2 col-5" style="background-color: #fff;padding: 0px;box-shadow: 0px 1px 12px 4px #efefef;border-radius: 6px;">
        <a style="padding: 0px;overflow: hidden;"
            class="img-hover col-sm-12 padding-zero image_thum"
            href="{{ url('product/' . $product->ProductSlug) }}" id="374">
            <img class="img-fluid" style="margin: 0 auto;padding:5px; height: 175px"
                    src="{{ asset($product->ViewProductImage) }}">
        </a>
        <div class="product__item" style="border-radius:0px 0px 6px 6px">
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
    <h2 class="p-4 text-center"><b>No Products found...</b></h2>
@endforelse

