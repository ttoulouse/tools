<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Mail\feistockpo;

class InquiryController extends Controller
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

    public function finditem()
    {
        return view('inquiry.finditem');
    }

    public function itemsales()
    {
        return view('inquiry.itemsales');
    }
    
    public function findvendor()
    {
        return view('inquiry.findvendor');
    }
    
    public function pofindvendor()
    {
        return view('inquiry.pofindvendor');
    }

    public function returnitemsales(Request $request)
    {

	$searchterm = $request->input('ProductCode');

    $orderdetails = \DB::select( \DB::raw("SELECT orderdetails.ProductCode, orderdetails.OrderID, orderdetails.Quantity, poinfo.CreatedDate 
					from orderdetails join poinfo on orderdetails.OrderID = poinfo.OrderID where orderdetails.ProductCode like '%$searchterm%'") );


    return view('inquiry.returnitemsales',compact('orderdetails'));
    }

    public function returnitem(Request $request)
    {

	$searchterm = $request->input('ProductCode');

	$vendorrules =  \DB::select( \DB::raw("select * from (SELECT vendorrules.ProductCode, vendorrules.ProductName, vendorrules.ProductPrice, vendorrules.Cost, vendorrules.IsPrimary, inventory.stock
					from vendorrules left join inventory on vendorrules.ProductCode = inventory.ProductCode where vendorrules.ProductCode like '%$searchterm%'
					order by vendorrules.IsPrimary DESC) as sub  group by ProductCode") );

	$inventory =  \DB::select( \DB::raw("SELECT inventory.ProductCode, inventory.ProductName, inventory.ProductPrice, inventory.UnitCost, inventory.stock
					from inventory left join vendorrules on vendorrules.ProductCode = inventory.ProductCode where inventory.ProductCode like '%$searchterm%'") );

        return view('inquiry.itemlist',compact('vendorrules','inventory'));
    }
    
    public function returnvendor(Request $request)
    {

	$searchterm = $request->input('VendorName');

	$vendors = \DB::table('vendors')->where('VendorName', 'like', '%'.$searchterm.'%')->get();

        return view('inquiry.vendorlist',compact('vendors'));
    }

    public function poreturnvendor(Request $request)
    {

	$searchterm = $request->input('VendorName');

	$vendors = \DB::table('poinfo')->where('vendor', 'like', '%'.$searchterm.'%')->get();

    return view('inquiry.povendorlist',compact('vendors'));
    }
    
  public function showitem($id) {

	$items = \DB::table('vendorrules')->where('ProductCode',$id)->get();

	return view('inquiry.showitem', compact('items','id'));
 }

}
