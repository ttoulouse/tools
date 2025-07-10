<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\orderinfo;
use App\orderdetails;
use App\Mail\feivendorpo;
use App\Mail\abqvendorpo;
use Carbon\Carbon;
use Auth; 
class OrdersController extends Controller
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
    public function index()
    {
	$deactivate=\DB::table('orderdetails')->where('ProductCode','shipping')->get();
	$deactivate1=\DB::table('orderdetails')->where('ProductCode','shipping1')->get();

	if($deactivate->count()) {
        	\DB::table('orderdetails')->where('OrderID',$deactivate[0]->OrderID)->delete();
        	\DB::table('orderinfo')->where('OrderID',$deactivate[0]->OrderID)->delete();
	}

	if($deactivate1->count()) {
        	\DB::table('orderdetails')->where('OrderID',$deactivate1[0]->OrderID)->where('ProductCode','shipping1')->delete();
	}

	$orders =
	\DB::table('orderinfo AS t1')
	->select('t1.*')
	->where('t1.OrderID', '>', 228402)
	->leftJoin('poinfo AS t2','t2.OrderID','=','t1.OrderID')
	->whereNull('t2.OrderID')->get();
	$temp = '';
	foreach ($orders as $order) {

		if($order->OrderID < 22800) {

			$url='http://shop.factory-express.com/net/WebService.aspx?Login=webmaster@factory-express.com&EncryptedPassword=101A2B2BD2D2DD087764EB10B6EFE42F59C41C696E1B1097AE3F126B5C059EBB&EDI_Name=Generic\Orders&SELECT_Columns=o.OrderID,o.OrderStatus&WHERE_Column=o.OrderID&WHERE_Value='.$order->OrderID;
			$xml = simplexml_load_file(rawurlencode($url));
			
			$status=$xml->Orders->OrderStatus;

			if($status == 'Cancelled') {
			        \DB::table('orderdetails')->where('OrderID',$order->OrderID)->delete();
                	\DB::table('orderinfo')->where('OrderID',$order->OrderID)->delete();
			}
		}

		else {

			$url_new='http://shop.factory-express.com/net/WebService.aspx?Login=webmaster@factory-express.com&EncryptedPassword=101A2B2BD2D2DD087764EB10B6EFE42F59C41C696E1B1097AE3F126B5C059EBB&EDI_Name=Generic\Orders&SELECT_Columns=o.OrderID,o.OrderStatus&WHERE_Column=o.OrderID&WHERE_Value='.$order->OrderID;
			$xml = simplexml_load_file(rawurlencode($url_new));

			$status=$xml->Orders->OrderStatus;

			if($status == 'Cancelled') {
		        \DB::table('orderdetails')->where('OrderID',$order->OrderID)->delete();
               	\DB::table('orderinfo')->where('OrderID',$order->OrderID)->delete();
			}
		}
	}
        return view('orders.index',compact('orders'));

    }

    public function find()
    {
        return view('orders.find');
    }

	public function issues() 
	{
		$orders = \DB::table('orderinfo')->where('issue','1')->get();
		
		return view('orders.issues', compact('orders'));
	}
    public function returnorder(Request $request)
    {
	return redirect('orders/'.$request->input('OrderID'));
    }

    public function show($id)
    {
	$orderdetails = \DB::table('orderdetails')->where('OrderID',$id)->get();
	$orderinfo = orderinfo::find($id);
	$vendorrules = \DB::table('vendorrules')->join('orderdetails','vendorrules.ProductCode','=','orderdetails.ProductCode')->where('orderdetails.OrderID',$id)->orderby('IsPrimary','desc')->get();
	$inventory = \DB::table('inventory')->join('orderdetails','inventory.ProductCode','=','orderdetails.ProductCode')->where('orderdetails.OrderID',$id)->get();

	\DB::table('orderdetails')->where('ProductCode','like','DSC%')->delete();

        if (\DB::table('poinfo')->where('OrderID',$id)->exists()) {
		$po=1;
	}
	else {
		$po=0;
	}

	return view('orders.show',compact('orderdetails','orderinfo','vendorrules','inventory','po'));
    }

    public function createpo(Request $request, $OrderID) 
    {

    $orderdetails = \DB::table('orderdetails')->where('OrderID',$OrderID)->get();
	$vendors = $request->all();
	$orderinfo = orderinfo::find($OrderID);
	$update = 0;
	$totalcost = 0;
	$dt = Carbon::now();

	if($request->input('button') == 'issue'){
		\DB::table('orderinfo')->where('OrderID',$OrderID)->update(['issue' => 1]);
		
		$orders = \DB::table('orderinfo')->where('issue','1')->get();
		
		return view('orders.issues', compact('orders'));
	}
	
	if($request->input('button') == 'resolved'){
		\DB::table('orderinfo')->where('OrderID',$OrderID)->update(['issue' => 0]);
		
		$orders = \DB::table('orderinfo')->where('issue','1')->get();
		
		return view('orders.issues', compact('orders'));
	}
	
	if (\DB::table('poinfo')->where('OrderID',$OrderID)->exists()) {

		if($request->input('button') == 'view') {
		        $poinfo    = \DB::table('poinfo')->where('OrderID',$OrderID)->get();
		        $podetails = \DB::table('podetails')->where('OrderID',$OrderID)->orderBy('PONum')->get();
				$vendorinfo = \DB::select( \DB::raw("select vendors.Email from vendors join poinfo on vendors.vendorname = poinfo.vendor where orderid={$OrderID}") );

		        return view('orders.po',compact('poinfo','podetails','vendorinfo'));
		}

		else {

		\DB::table('poinfo')->where('OrderID',$OrderID)->delete();
		\DB::table('podetails')->where('OrderID',$OrderID)->delete();
		$update=1;

		}

	}

	$ponum = \DB::table('poinfo')->orderby('PONum','desc')->first()->PONum;

	foreach ($orderdetails as $orderdet) {
		$vendor=$request->input(str_replace('.','_',$orderdet->ProductCode));
		\DB::table('orderdetails')->where('OrderID',$OrderID)->where('ProductCode',$orderdet->ProductCode)->update(['VendorPick' => $vendor]);
	}

    $orderdetails = \DB::table('orderdetails')->where('OrderID',$OrderID)->orderBy('VendorPick')->get();

    $lastvend = 'placeholder';
    
    foreach ( $orderdetails as $orderdet) {

		if ($orderdet->VendorPick != $lastvend) {

			if($totalcost > 100) {
	        	$comments = $comments."<br>Please use insurance on all orders over $100";
	            \DB::table('poinfo')->where('OrderID',$OrderID)->where('PONum',$ponum)->update(['Comments' => $comments]);
			}
			
    		$ponum = $ponum+1;
			$totalcost = 0; 
			
	        $vendordb=\DB::table('vendors')->where('VendorName',$orderdet->VendorPick)->get();

			\DB::table('poinfo')->insert(
    		 ['PONum' => $ponum, 'OrderID' => $orderinfo->OrderID, 'ShippingCompanyName' => $orderinfo->ShippingCompanyName, 'ShippingFirstName' => $orderinfo->ShippingFirstName,
			 'ShippingLastName' => $orderinfo->ShippingLastName, 'ShippingAddress1' => $orderinfo->ShippingAddress1, 'ShippingAddress2' => $orderinfo->ShippingAddress2, 'ShippingCity' => $orderinfo->ShippingCity,
			 'ShippingState' => $orderinfo->ShippingState, 'ShippingPostalCode' => $orderinfo->ShippingPostalCode, 'ShippingCountry' => $orderinfo->ShippingCountry, 'ShippingFaxNumber' => $orderinfo->ShippingFaxNumber, 
			 'ShippingPhoneNumber' => $orderinfo->ShippingPhoneNumber, 'ShippingMethod' => $orderinfo->ShippingMethod, 'Vendor' => $orderdet->VendorPick, 'PaymentMethod' => $orderinfo->PaymentMethod, 'CreatedDate'=>$dt->toDateString(),
			 'createdby' => Auth::user()->name]);

			 $comments= $orderinfo->OrderComments.'<br>Ship via Factory Express UPS Acct 8XX718. Please.<br>Put our PO# in your shipper ref #2 on UPS.<br>Notify us of all backorders!<br>Please email tracking info when shipped: <b>tracking@factory-express.com</b><br>Please email or fax Order Acknowledgement: <b>POconfirm@factory-express.com / 505-891-4641</b><br>';
			 $comments = $comments.$vendordb->first()->Comments;

			if($orderdet->VendorPick=='Spiral Binding Co' || $orderdet->VendorPick=='SOUTHWEST PLASTIC BINDING' ||  $orderdet->VendorPick=='BankSupplies Inc.' ||  $orderdet->VendorPick=='Whitaker Brothers') {
                $comments = $comments."<br>Please drop ship BLIND!";
			}
			
            \DB::table('poinfo')->where('OrderID',$OrderID)->where('PONum',$ponum)->update(['Comments' => $comments]);
   	    }

        $vendorcode = \DB::table('vendorrules')->where('ProductCode',$orderdet->ProductCode)->where('VendorName',$orderdet->VendorPick)->value('VendorProductCode');
   		$vendorcost = \DB::table('vendorrules')->where('ProductCode',$orderdet->ProductCode)->where('VendorName',$orderdet->VendorPick)->value('Cost');

        if($orderdet->VendorPick == 'Inventory') {

	        \DB::table('poinfo')->where('OrderID',$OrderID)->where('PONum',$ponum)->update(['Comments' => $orderinfo->OrderComments]);

			$inventory = \DB::table('inventory')->join('orderdetails','inventory.ProductCode','=','orderdetails.ProductCode')->where('orderdetails.OrderID',$orderinfo->OrderID)->get();

            \DB::table('podetails')->insert(
		     ['PONum' => $ponum, 'OrderID' => $orderinfo->OrderID, 'Quantity' => $orderdet->Quantity, 'ProductCode' => $orderdet->ProductCode, 'ProductName' => $orderdet->ProductName, 'Options' => $orderdet->Options, 'Cost' => round($orderdet->TotalPrice/$orderdet->Quantity,2)]);
		}

		else{
            \DB::table('podetails')->insert(
			['PONum' => $ponum, 'OrderID' => $orderinfo->OrderID, 'Quantity' => $orderdet->Quantity, 'ProductCode' => $vendorcode, 'ProductName' => $orderdet->ProductName, 'Options' => $orderdet->Options, 'Cost' => $vendorcost]);
		}

        $lastvend = $orderdet->VendorPick;

		$totalcost = $totalcost + ($orderdet->Quantity*$vendorcost);

		}

	if($totalcost > 100) {
		$comments = $comments."<br>Please use insurance on all orders over $100";
	    \DB::table('poinfo')->where('OrderID',$OrderID)->where('PONum',$ponum)->update(['Comments' => $comments]);
	}
			
    $poinfo    = \DB::table('poinfo')->where('OrderID',$OrderID)->get();
    $podetails = \DB::table('podetails')->where('OrderID',$OrderID)->orderBy('PONum')->get();
	$vendorinfo = \DB::select( \DB::raw("select vendors.Email from vendors join poinfo on vendors.vendorname = poinfo.vendor where orderid={$OrderID}") );

	return view('orders.po',compact('poinfo','podetails','vendorinfo'));
}

    public function editpo($OrderID, $PONum, Request $request)
    {

        $poinfo    = \DB::table('poinfo')->where('OrderID',$OrderID)->where('PONum',$PONum)->get();
        $podetails = \DB::table('podetails')->where('OrderID',$OrderID)->where('PONum',$PONum)->get();
	$vendorinfo = \DB::table('vendors')->where('VendorName',$poinfo[0]->Vendor)->get();

	if($request->input('button')=='send') {

		if($vendorinfo[0]->CCEmail) {

		        \Config::set('services.mailgun.domain', 'factory-express.com');
        		\Config::set('services.mailgun.secret', 'key-69748ac1f479af654aa6aa5caacc3cd2');

		        \Mail::to($vendorinfo[0]->Email)->cc($vendorinfo[0]->CCEmail)->send(new feivendorpo($poinfo,$podetails,$OrderID,$PONum,$vendorinfo));
		        \Mail::to('fei.poconfirm@gmail.com')->send(new feivendorpo($poinfo,$podetails,$OrderID,$PONum,$vendorinfo));
		}

		else{
		        \Config::set('services.mailgun.domain', 'factory-express.com');
        		\Config::set('services.mailgun.secret', 'key-69748ac1f479af654aa6aa5caacc3cd2');
		        \Mail::to($vendorinfo[0]->Email)->cc('fei.poconfirm@gmail.com')->send(new feivendorpo($poinfo,$podetails,$OrderID,$PONum,$vendorinfo));
		}

		\DB::table('poinfo')->where('PONum',$PONum)->update([ 'sent' => '1']);
	        $poinfo    = \DB::table('poinfo')->where('OrderID',$OrderID)->get();
	        $podetails = \DB::table('podetails')->where('OrderID',$OrderID)->get();
			$vendorinfo = \DB::select( \DB::raw("select vendors.Email from vendors join poinfo on vendors.vendorname = poinfo.vendor where orderid={$OrderID}") );

		return view('orders.po',compact('poinfo','podetails','vendorinfo'));
	}

	elseif($request->input('button')=='print') {
			$orderinfo = \DB::table('orderinfo')->where('OrderID',$OrderID)->get();
			$id = $orderinfo[0]->CustomerID; 
			$url='http://shop.factory-express.com/net/WebService.aspx?Login=webmaster@factory-express.com&EncryptedPassword=101A2B2BD2D2DD087764EB10B6EFE42F59C41C696E1B1097AE3F126B5C059EBB&EDI_Name=Generic\Customers&SELECT_Columns=CustomerID,EmailAddress&WHERE_Column=CustomerID&WHERE_Value='.$id;
			$xml = simplexml_load_file(rawurlencode($url));
			
			$email=$xml->Customers->EmailAddress; 

			\DB::table('poinfo')->where('PONum',$PONum)->update([ 'printed' => '1']);

		return view('mail.feivendorpoprint',compact('poinfo','podetails','OrderID','PONum','vendorinfo','email'));
	}

	$vendors = \DB::table('vendors')->get();

	return view('orders.edit',compact('poinfo','podetails','vendors'));
    }

    public function updatepo(Request $request, $OrderID, $PONum)
    {
        $poinfo    = \DB::table('poinfo')->where('OrderID',$OrderID)->where('PONum',$PONum)->get();
        $podetails = \DB::table('podetails')->where('OrderID',$OrderID)->where('PONum',$PONum)->get();
	$namecount = 0;
	foreach ($podetails as $podet) {
		$ProductCode=$request->input($podet->ProductCode."_Code".$namecount);
		$ProductName=$request->input("Name".$namecount);
		$Quantity=$request->input("Quantity".$namecount);
		$Cost=$request->input("Cost".$namecount);
		$Options=$request->input("Options".$namecount);

		if(empty($ProductName)){
			\DB::table('podetails')->where('OrderID',$OrderID)->where('PONum',$PONum)->where('ProductCode',$podet->ProductCode)->update(
			[
 				'PONum' => $request->input('PONum'),
 				'ProductCode' => $ProductCode,
 				'ProductName' => $ProductName,
 				'Quantity' => $Quantity,
 				'Cost' => $Cost,
 				'Options' => $Options
			]);
			$namecount = $namecount +1;
		}

		else {
			\DB::table('podetails')->where('OrderID',$OrderID)->where('PONum',$PONum)->where('ProductName',$podet->ProductName)->update(
			[
 				'PONum' => $request->input('PONum'),
 				'ProductCode' => $ProductCode,
 				'ProductName' => $ProductName,
 				'Quantity' => $Quantity,
 				'Cost' => $Cost,
 				'Options' => $Options
			]);
			$namecount = $namecount +1;
		}


}

		\DB::table('poinfo')->where('OrderID',$OrderID)->where('PONum',$PONum)->update(
[
 'PONum' => $request->input('PONum'),
 'ShippingCompanyName' => $request->input('ShippingCompanyName'),
 'ShippingFirstName' => $request->input('ShippingFirstName'),
 'ShippingLastName' => $request->input('ShippingLastName'),
 'ShippingAddress1' => $request->input('ShippingAddress1'),
 'ShippingAddress2' => $request->input('ShippingAddress2'),
 'ShippingCity' => $request->input('ShippingCity'),
 'ShippingState' => $request->input('ShippingState'),
 'ShippingPostalCode' => $request->input('ShippingPostalCode'),
 'ShippingCountry' => $request->input('ShippingCountry'),
 'ShippingPhoneNumber' => $request->input('ShippingPhoneNumber'),
 'ShippingMethod' => $request->input('ShippingMethod'),
 'ShippingCost' => $request->input('ShippingCost'),
 'Vendor' => $request->input('Vendor'),
 'Fees' => $request->input('Fees'),
 'Comments' => $request->input('Comments')
]);

        $poinfo    = \DB::table('poinfo')->where('OrderID',$OrderID)->get();
        $podetails = \DB::table('podetails')->where('OrderID',$OrderID)->orderBy('PONum')->get();

		$vendorinfo = \DB::select( \DB::raw("select vendors.Email from vendors join poinfo on vendors.vendorname = poinfo.vendor where orderid={$OrderID}") );

        return view('orders.po',compact('poinfo','podetails','vendorinfo'));
    }

}

