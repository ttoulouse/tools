<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class ProductController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function findvendor()
    {
        return view('product.findvendor');
    }
    
    public function returnvendor(Request $request)
    {

	    $searchterm = $request->input('VendorName');
    	$vendors = \DB::table('vendors')->where('VendorName', 'like', '%'.$searchterm.'%')->get();

        return view('product.vendorlist',compact('vendors','active'));
    }
    
    public function vendor($vendor)
    {
    	$products = \DB::table('vendorrules')->where('VendorName', $vendor)->get();
        return view('product.vendorproductlist',compact('products','vendor'));
    }

    public function updatevendor(Request $request, $vendor)
    {

        $active=$request->input('button');

        if($active == 'active') {
        	$products = \DB::table('vendorrules')->where('VendorName', $vendor)->where('active','1')->get();

            return view('product.vendorproductlist',compact('products','vendor'));
        }
        for ($i = 0; $i < sizeof($request->input('productcode')); $i++) {

            $oldprice = Input::get('oldprice.'.$i);
            $oldcost =  Input::get('oldcost.'.$i);
            $oldmsrp =  Input::get('oldmsrp.'.$i);

            $price = Input::get('price.'.$i);
            $cost =  Input::get('cost.'.$i);
            $msrp =  Input::get('msrp.'.$i);
            $productcode = Input::get('productcode.'.$i);

            if($oldprice != $price || $oldcost != $cost || $oldmsrp != $msrp) {
                $dt = Carbon::now();

                \DB::table('vendorrules')->where('VendorName',$vendor)->where('ProductCode',$productcode)->update(
	                ['ProductPrice' => $price,
	                'Cost' => $cost,
	                'msrp' => $msrp,
	                'lastupdate' => $dt->toDateString()
	                ]);
            }
        }

    	$products = \DB::table('vendorrules')->where('VendorName', $vendor)->get();
        return view('product.vendorproductlist',compact('products','vendor'));
    }
    
    public function bulkdiscontinue()
    {
        return view('product.bulkdiscontinue');
    }
    
}
