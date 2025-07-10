<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VendorController extends Controller
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
    public function createrule($vendor)
    {
        return view('vendors.create',compact('vendor'));
    }

    public function createvendor()
    {
        return view('vendors.createvendor');
    }
    
    public function editvendor()
    {
        return view('vendors.editvendor');
    }
    
    public function search()
    {
        return view('vendors.search');
    }
        
    public function findvendor()
    {
        return view('vendors.find');
    }
    
    public function returnvendorlist(Request $request)
    {

	    $searchterm = $request->input('VendorName');
        $vendortag = $request->input('button');
    	$vendors = \DB::table('vendors')->where('VendorName', 'like', '%'.$searchterm.'%')->get();

        return view('vendors.vendorlist',compact('vendors','vendortag'));
    }
    
    public function returnvendor(Request $request)
    {
	$vendor=\DB::table('vendorrules')->where('ProductCode',$request->input('ProductCode'))->where('VendorName',$request->input('VendorName'))->get();

        return view('vendors.edit',compact('vendor'));


    }

    public function saverule(Request $request)
    {

	$primary = '';

	if($request->input('IsPrimary') == 'on') {
		$primary = '*';
	}

	\DB::table('vendorrules')->insert(
	['ProductCode' => $request->input('ProductCode'),'VendorName' => $request->input('VendorName'),'VendorProductCode' => $request->input('VendorProductCode'),
	'Cost' => $request->input('Cost'), 'IsPrimary' => $primary, 'ProductName' => $request->input('ProductName')]);

	$vendor=\DB::table('vendorrules')->where('ProductCode',$request->input('ProductCode'))->where('VendorName',$request->input('VendorName'))->get();
	return view('vendors.edit',compact('vendor'));
    }

    public function savevendor(Request $request)
    {

    	\DB::table('vendors')->insert(
	    ['VendorName' => $request->input('VendorName'),'Email' => $request->input('Email'),'CCEmail' => $request->input('CCEmail'),'Address1' => $request->input('Address1'),
	    'Address2' => $request->input('Address2'),'City' => $request->input('City'),'State' => $request->input('State'),'PostalCode' => $request->input('PostalCode'),
	    'Country' => $request->input('Country'),'FaxNumber' => $request->input('FaxNumber'),'PhoneNumber' => $request->input('PhoneNumber'),
	    'AccountNum' => $request->input('AccountNum'),'Comments' =>  $request->input('Comments')
	    ]);

        return view('vendors.createvendor');
    
    
    }
    
    public function savevendor2(Request $request, $vendor)
    {

    	\DB::table('vendors')->where('VendorName',$vendor)->update(
	    ['VendorName' => $request->input('VendorName'),'Email' => $request->input('Email'),'CCEmail' => $request->input('CCEmail'),'Address1' => $request->input('Address1'),
	    'Address2' => $request->input('Address2'),'City' => $request->input('City'),'State' => $request->input('State'),'PostalCode' => $request->input('PostalCode'),
	    'Country' => $request->input('Country'),'FaxNumber' => $request->input('FaxNumber'),'PhoneNumber' => $request->input('PhoneNumber'),
	    'AccountNum' => $request->input('AccountNum'), 'Comments' =>  $request->input('Comments')
	    ]);
        
        $vendordb=\DB::table('vendors')->where('VendorName',$request->input('VendorName'))->get();
        return view('vendors.editvendor2',compact('vendordb'));
    
    
    }
    
    public function editrule(Request $request)
    {

	$primary = '';

	if($request->input('IsPrimary') == 'on') {
		$primary = '*';
	}

	\DB::table('vendorrules')->where('ProductCode',$request->input('OldProductCode'))->where('VendorName',$request->input('OldVendorName'))->update(
	['ProductCode' => $request->input('ProductCode'),'VendorName' => $request->input('VendorName'),'VendorProductCode' => $request->input('VendorProductCode'),
	'Cost' => $request->input('Cost'), 'IsPrimary' => $primary, 'ProductName' => $request->input('ProductName')]);

	$vendor=\DB::table('vendorrules')->where('ProductCode',$request->input('ProductCode'))->where('VendorName',$request->input('VendorName'))->get();

        return view('vendors.edit',compact('vendor'));
    }

    public function editvendor2($vendor)
    {

	$vendordb=\DB::table('vendors')->where('VendorName',$vendor)->get();
    return view('vendors.editvendor2',compact('vendordb'));
    }
}
