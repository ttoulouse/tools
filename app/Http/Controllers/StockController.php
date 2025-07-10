<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Mail\feistockpo;

class StockController extends Controller
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

    public function openpos()
    {

	$podetails = \DB::table('stockpoinfo')->select(\DB::raw('stockpodetails.PONum, stockpoinfo.Vendor'))->join('stockpodetails','stockpoinfo.PONum', '=', 'stockpodetails.PONum')->distinct()->whereraw('stockpodetails.Quantity-stockpodetails.Invoiced > 0')->get();

        return view('stock.openpos',compact('podetails'));
    }
    
    public function update()
    {
        return view('stock.update');
    }

    public function change(Request $request)
    {
	$stockchange=$request->get('StockChange');
        if (\DB::table('inventory')->where('ProductCode',$request->input('ProductCode'))->exists()) {
	        \DB::table('inventory')->where('ProductCode',$request->input('ProductCode'))->update(['Stock' => $request->get('StockChange')]);
	}
	else{
	\DB::table('inventory')->insert(
		['ProductCode' => $request->input('ProductCode'), 'Stock' => $request->input('StockChange')]
        );
	}
	$inventory=\DB::table('inventory')->where('ProductCode',$request->input('ProductCode'))->get();
        return view('stock.update',compact('inventory'));
    }

    public function find()
    {
        return view('stock.find');
    }

    public function findvendor()
    {
        return view('stock.findvendor');
    }

    public function findpo()
    {
        return view('stock.findpo');
    }

    public function returnstock(Request $request)
    {
        return redirect('stock/returnstock/'.$request->input('ProductCode'));
    }

    public function returnvendor(Request $request)
    {
        $vendor=\DB::table('vendors')->where('VendorName',$request->input('Vendor'))->get();

	return view('stock.createpo',compact('vendor'));
    }

    public function returnpo(Request $request)
    {
        $stockpoinfo=\DB::table('stockpoinfo')->where('PONum',$request->input('PONum'))->get();
        $stockpodetails=\DB::table('stockpodetails')->where('PONum',$request->input('PONum'))->get();

	return view('stock.editpo',compact('stockpoinfo','stockpodetails'));
    }

    public function createpo(Request $request)
    {

$ponum = \DB::table('stockpoinfo')->orderby('PONum','desc')->first()->PONum;
$dt = Carbon::now();

$vendorrules = \DB::table('vendorrules')->where('VendorName',$request->input('Vendor'))->where('ProductCode', $request->input('ProductCode'))->get();

\DB::table('stockpodetails')->insert(
[
'ProductCode' => $request->input('ProductCode'),
'ProductName' => $vendorrules[0]->ProductName,
'VendorProductCode' => $vendorrules[0]->VendorProductCode,
'Quantity' => $request->input('Quantity'),
'Options' => $request->input('Options'),
'PONum' => $ponum+1,
'Cost' => $vendorrules[0]->Cost
]);

\DB::table('stockpoinfo')->insert(
['PONum' => $ponum+1,
'BillingCompanyName' => $request->input('BillingCompanyName'),
'BillingFirstName' => $request->input('BillingFirstName'),
'BillingLastName' => $request->input('BillingLastName'),
'BillingAddress' => $request->input('BillingAddress'),
'BillingCity' => $request->input('BillingCity'),
'BillingState' => $request->input('BillingState'),
'BillingPostalCode' => $request->input('BillingPostalCode'),
'BillingCountry' => $request->input('BillingCountry'),
'BillingPhoneNumber' => $request->input('BillingPhoneNumber'),
'ShippingCompanyName' => $request->input('ShippingCompanyName'),
'ShippingFirstName' => $request->input('ShippingFirstName'),
'ShippingLastName' => $request->input('ShippingLastName'),
'ShippingAddress' => $request->input('ShippingAddress'),
'ShippingCity' => $request->input('ShippingCity'),
'ShippingState' => $request->input('ShippingState'),
'ShippingPostalCode' => $request->input('ShippingPostalCode'),
'ShippingCountry' => $request->input('ShippingCountry'),
'ShippingPhoneNumber' => $request->input('ShippingPhoneNumber'),
'ShippingMethod' => $request->input('ShippingMethod'),
'Vendor' => $request->input('Vendor'),
'Comments' => 'Please notify us of backorders!',
'CreatedDate'=>$dt->toDateString()]);

$stockpoinfo = \DB::table('stockpoinfo')->where('PONUM',$ponum+1)->get();
$stockpodetails = \DB::table('stockpodetails')->where('PONUM',$ponum+1)->get();

return view('stock.editpo',compact('stockpoinfo','stockpodetails'));

    }

    public function editpo(Request $request)
    {

$ponum = $request->input('PONum');
$dt = Carbon::now();

$vendorrules = \DB::table('vendorrules')->where('VendorName',$request->input('Vendor'))->where('ProductCode', $request->input('ProductCode'))->get();
$productname = \DB::table('namelookup')->where('ProductCode',$request->input('ProductCode'))->get();
$stockpoinfo = \DB::table('stockpoinfo')->where('PONum',$ponum)->get();

if($request->input('quickbooks')) {

    $stockpoinfo = \DB::table('stockpoinfo')->where('PONUM',$ponum)->get();
    $stockpodetails = \DB::table('stockpodetails')->where('PONUM',$ponum)->get();
	$vendorinfo = $request->input('Vendor');

return view('stock.quickbooksstockpo',compact('stockpoinfo','stockpodetails','ponum','vendorinfo'));

//	return view('stock.editpo',compact('stockpoinfo','stockpodetails'));
}

        if($request->input('button')=='send') {

		$vendorinfo = \DB::table('vendors')->where('VendorName',$request->input('Vendor'))->get();
		$stockpoinfo = \DB::table('stockpoinfo')->where('PONum',$ponum)->get();
		$stockpodetails = \DB::table('stockpodetails')->where('PONum',$ponum)->get();

                if($vendorinfo[0]->CCEmail) {

                        \Config::set('services.mailgun.domain', 'factory-express.com');
                        \Config::set('services.mailgun.secret', 'key-69748ac1f479af654aa6aa5caacc3cd2');

                        \Mail::to($vendorinfo[0]->Email)->cc($vendorinfo[0]->CCEmail)->send(new feistockpo($stockpoinfo,$stockpodetails,$ponum,$vendorinfo));
                        \Mail::to('poconfirm@factory-express.com')->send(new feistockpo($stockpoinfo,$stockpodetails,$ponum,$vendorinfo));
                }

                else{
                        \Config::set('services.mailgun.domain', 'factory-express.com');
                        \Config::set('services.mailgun.secret', 'key-69748ac1f479af654aa6aa5caacc3cd2');
                        /*\Mail::to($vendorinfo[0]->Email)->cc('poconfirm@factory-express.com')->send(new feistockpo($poinfo,$podetails,$OrderID,$ponum,$vendorinfo));*/
                        \Mail::to($vendorinfo[0]->Email)->cc('poconfirm@factory-express.com')->send(new feistockpo($stockpoinfo,$stockpodetails,$ponum,$vendorinfo));

                }

                \DB::table('stockpoinfo')->where('PONum',$ponum)->update([ 'sent' => '1']);

		$stockpoinfo = \DB::table('stockpoinfo')->where('PONUM',$ponum)->get();
		$stockpodetails = \DB::table('stockpodetails')->where('PONUM',$ponum)->get();

		return view('stock.editpo',compact('stockpoinfo','stockpodetails'));
        }
$stockpodetails = \DB::table('stockpodetails')->where('PONUM',$ponum)->get();
$count = 0;
    
    foreach($stockpodetails as $stockpodetail) {

        \DB::table('stockpodetails')->where('PONum',$ponum)->where('ProductCode', $stockpodetail->ProductCode)->update(
	    ['Quantity' => $request->input('Quantity'.$count),'Cost' => $request->input('Cost'.$count)
        ]);

    $count = $count +1;
    }
    
if($request->input('button')=='add') {

\DB::table('stockpodetails')->insert(
[
'ProductCode' => $request->input('ProductCode'),
'ProductName' => $vendorrules[0]->ProductName,
'VendorProductCode' => $vendorrules[0]->VendorProductCode,
'Quantity' => $request->input('Quantity'),
'Options' => $request->input('Options'),
'PONum' => $ponum,
'Cost' => $vendorrules[0]->Cost
]);
}
\DB::table('stockpoinfo')->where('PONum',$ponum)->update(
['PONum' => $ponum,
'BillingCompanyName' => $request->input('BillingCompanyName'),
'BillingFirstName' => $request->input('BillingFirstName'),
'BillingLastName' => $request->input('BillingLastName'),
'BillingAddress' => $request->input('BillingAddress'),
'BillingCity' => $request->input('BillingCity'),
'BillingState' => $request->input('BillingState'),
'BillingPostalCode' => $request->input('BillingPostalCode'),
'BillingCountry' => $request->input('BillingCountry'),
'BillingPhoneNumber' => $request->input('BillingPhoneNumber'),
'ShippingCompanyName' => $request->input('ShippingCompanyName'),
'ShippingFirstName' => $request->input('ShippingFirstName'),
'ShippingLastName' => $request->input('ShippingLastName'),
'ShippingAddress' => $request->input('ShippingAddress'),
'ShippingCity' => $request->input('ShippingCity'),
'ShippingState' => $request->input('ShippingState'),
'ShippingPostalCode' => $request->input('ShippingPostalCode'),
'ShippingCountry' => $request->input('ShippingCountry'),
'ShippingPhoneNumber' => $request->input('ShippingPhoneNumber'),
'Comments' => $request->input('Comments'),
'ShippingMethod' => $request->input('ShippingMethod')]);

if($request->input('remove')) {

\DB::table('stockpodetails')->where('ProductCode',$request->input('remove'))->delete();

}

$stockpoinfo = \DB::table('stockpoinfo')->where('PONUM',$ponum)->get();
$stockpodetails = \DB::table('stockpodetails')->where('PONUM',$ponum)->get();

return view('stock.editpo',compact('stockpoinfo','stockpodetails'));

    }

    public function show($id)
    {

        $inventory=\DB::table('inventory')->where('ProductCode',$id)->get();

        if (empty($inventory[0])) {
		$exists = 0;
                return view('stock.display',compact('inventory','exists'));

        }
        else {
		$exists = 1;
                return view('stock.display',compact('inventory','exists'));
        }

    }

    public function invoiceitem($id)
    {

		$stockpoinfo = \DB::table('stockpoinfo')->where('PONUM',$id)->get();
		$stockpodetails = \DB::table('stockpodetails')->where('PONUM',$id)->get();

		return view('stock.invoicepo',compact('stockpoinfo','stockpodetails'));
    }

    public function saveinvoice(Request $request, $id)
    {
		$stockpodetails = \DB::table('stockpodetails')->where('PONUM',$id)->get();
        $count = 0;
        
        foreach($stockpodetails as $stockpodetail) {

            \DB::table('stockpodetails')->where('PONum',$id)->where('ProductCode', $stockpodetail->ProductCode)->update(
    	    ['Recieved' => $request->input('Received'.$count),'Invoiced' => $request->input('Invoiced'.$count),'RecievedDate' => $request->input('Receiveddate'.$count)
	        ]);

           if (\DB::table('inventory')->where('ProductCode',$stockpodetail->ProductCode)->exists()) {
	            \DB::table('inventory')->where('ProductCode',$stockpodetail->ProductCode)->increment('Stock', ($request->input('Received'.$count)-$stockpodetail->Recieved));
	        }
	    
	    else{
	        \DB::table('inventory')->insert(
            ['ProductCode' => $stockpodetail->ProductCode, 'Stock' =>  $request->input('Received'.$count)]
            );
	    }
            $count = $count + 1;
        }

		$stockpoinfo = \DB::table('stockpoinfo')->where('PONUM',$id)->get();
		$stockpodetails = \DB::table('stockpodetails')->where('PONUM',$id)->get();


		return view('stock.invoicepo',compact('stockpoinfo','stockpodetails'));
    }
}
