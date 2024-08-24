<?php

namespace App\Http\Controllers;

use App\Models\Weight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class WeightController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Weight  $weight
     * @return \Illuminate\Http\Response
     */
    public function show(Weight $weight)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Weight  $weight
     * @return \Illuminate\Http\Response
     */
    public function edit(Weight $weight)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Weight  $weight
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Weight $weight)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Weight  $weight
     * @return \Illuminate\Http\Response
     */
    public function destroy(Weight $weight)
    {
        //
    }

    public function weightWiseProduct()
    {
        if (isset($request['q'])) {
            $weightProducts = Weight::query()->where('ProductName', 'like', '%' . $request['q'] . '%')->get();
        } else {
            $weightProducts = Weight::with('product')->get();
        }

        $product = array();
        foreach ($weightProducts as $item) {
            if (App::environment('local')) {
                $item['ProductImage'] = url($item['product']['ProductImage']);
            } else {
                $item['ProductImage'] = url($item['product']['ProductImage']);
            }

            $product[] = array(
                "id" => $item['id'],
                "text" => $item['product']['ProductName'],
                "image" => $item['ProductImage'],
                "productCode" => $item['product']['ProductSku'],
                "productPrice" => $item['productSalePrice'],
                'weight'=> $item['weight_name']
                
            );
        }
        $data['data'] = $product;
        return json_encode($data);
       
    }
}
