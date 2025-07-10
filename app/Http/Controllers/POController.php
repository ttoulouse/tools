<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Mail\feicustomerinvoice;
use Auth;
use App\Models\PurchaseOrder;

class POController extends Controller
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

    public function archive($ponum)
    {
        $podetails = \DB::table('poinfo')->join('podetails','poinfo.PONum', '=', 'podetails.PONum')->distinct()->whereraw('podetails.Quantity-podetails.Shipped > 0')->get();

        \DB::table('podetails')->where('PONum',$ponum)->update(['archived' => 1]);

	return view('po.partialinv',compact('podetails'));
   }


    public function mailview()
    {
        return view('mail.feivendorpo');
    }

    public function noinv()
    {
        return view('po.noinv');
    }

    public function partialinv()
    {

	$podetails = \DB::table('poinfo')->join('podetails','poinfo.PONum', '=', 'podetails.PONum')->distinct()->whereraw('podetails.Quantity-podetails.Shipped > 0')->get();
        return view('po.partialinv',compact('podetails'));
    }

    public function find()
    {
        return view('po.find');
    }

    public function cusfind()
    {
        return view('po.cusfind');
    }
    
    public function salesfind()
    {
        return view('po.salesfind');
    }
    
    public function findvendor()
    {
        return view('po.findvendor');
    }

    public function returnvendor(Request $request)
    {
	$podetails = \DB::table('poinfo')->join('podetails','poinfo.PONum', '=', 'podetails.PONum')->distinct()->whereraw('podetails.Quantity-podetails.Shipped > 0 and poinfo.Vendor like "%'.
			$request->input('Vendor').'%"')->get();
        return view('po.partialinv',compact('podetails'));
    }

    public function returnpo(Request $request)
    {

	$poinfo    = \DB::table('poinfo')->where('PONum',$request->input('PONum'))->get();
	$podetails = \DB::table('podetails')->where('PONum',$request->input('PONum'))->get();
	$vendorinfo = \DB::table('vendors')->where('VendorName',$poinfo[0]->Vendor)->get();
	$poshipped = \DB::table('poshipped')->where('PONum',$request->input('PONum'))->get();

	return view('po.showpo',compact('poinfo','podetails','vendorinfo','poshipped'));
    }

    public function cusreturnpo(Request $request)
    {

	$poshipped = \DB::table('poshipped')->where('invoicenum',$request->input('PONum'))->get();

	$PONum = $poshipped[0]->PONum;
	
	$poinfo    = \DB::table('poinfo')->where('PONum',$PONum)->get();
	$podetails = \DB::table('podetails')->where('PONum',$PONum)->get();
	$vendorinfo = \DB::table('vendors')->where('VendorName',$poinfo[0]->Vendor)->get();

	return view('po.showpo',compact('poinfo','podetails','vendorinfo','poshipped'));
    }
    
    public function salesreturnpo(Request $request)
    {

	$poshipped = \DB::table('poshipped')->where('OrderID',$request->input('PONum'))->get();

	$PONum = $poshipped[0]->PONum;
	
	$poinfo    = \DB::table('poinfo')->where('PONum',$PONum)->get();
	$podetails = \DB::table('podetails')->where('PONum',$PONum)->get();
	$vendorinfo = \DB::table('vendors')->where('VendorName',$poinfo[0]->Vendor)->get();

	return view('po.showpo',compact('poinfo','podetails','vendorinfo','poshipped'));
    }
    
    public function returnpoget($id)
    {

	$poinfo    = \DB::table('poinfo')->where('PONum',$id)->get();
	$podetails = \DB::table('podetails')->where('PONum',$id)->get();
	$vendorinfo = \DB::table('vendors')->where('VendorName',$poinfo[0]->Vendor)->get();
	$poshipped = \DB::table('poshipped')->where('PONum',$id)->get();

	return view('po.showpo',compact('poinfo','podetails','vendorinfo','poshipped'));
    }

    public function shipped(Request $request, $id)
    {

	$poinfo    = \DB::table('poinfo')->where('PONum',$id)->get();
	$vendorinfo = \DB::table('vendors')->where('VendorName',$poinfo[0]->Vendor)->get();

	$podetails = \DB::table('podetails')->where('PONum',$id)->get();
	$invoicenum = \DB::table('poshipped')->orderby('invoicenum','desc')->first()->invoicenum;
	$lastdate = '';
	$dropship = 'Y';
    $dt = Carbon::now();
	$OrderID = $poinfo[0]->OrderID;
	$index = 0;
	foreach($podetails as $podet) {
		$index = $index + 1;
		$productcode =str_replace('.','_',$podet->ProductCode);
		$code = $index.'shipped';
		$shipped = $request->input($code);
		$shippeddate = $index.'shippeddate';
		$difference = $shipped;

	if($request->input('update')) {
		$shippeddate = $request->input('invoicenum').$request->input('update').'shippeddate';
		\DB::table('poshipped')->where('ProductCode', $request->input('update'))->where('invoicenum', $request->input('invoicenum'))->update(['ShippedDate' => $request->input($shippeddate)]);
		$poinfo    = \DB::table('poinfo')->where('PONum',$request->input('ponum'))->get();
		$vendorinfo = \DB::table('vendors')->where('VendorName',$poinfo[0]->Vendor)->get();
		$podetails = \DB::table('podetails')->where('PONum',$request->input('ponum'))->get();
		$poshipped = \DB::table('poshipped')->where('PONum',$request->input('ponum'))->get();
		return view('po.showpo',compact('poinfo','podetails','vendorinfo','poshipped'));
	}

	if($request->input('quickbooks')) {
		
		$orderinfo = \DB::table('orderinfo')->where('OrderID',$podet->OrderID)->get();
		$id = $orderinfo[0]->CustomerID; 
		$url='http://shop.factory-express.com/net/WebService.aspx?Login=webmaster@factory-express.com&EncryptedPassword=101A2B2BD2D2DD087764EB10B6EFE42F59C41C696E1B1097AE3F126B5C059EBB&EDI_Name=Generic\Customers&SELECT_Columns=CustomerID,EmailAddress,PaysStateTax&WHERE_Column=CustomerID&WHERE_Value='.$id;
		$xml = simplexml_load_file(rawurlencode($url));
		$invoicenum = $request->input('quickbooks');
		$email=$xml->Customers->EmailAddress; 
		$tax=$xml->Customers->PaysStateTax; 

		$url='http://shop.factory-express.com/net/WebService.aspx?Login=webmaster@factory-express.com&EncryptedPassword=101A2B2BD2D2DD087764EB10B6EFE42F59C41C696E1B1097AE3F126B5C059EBB&EDI_Name=Generic\Orders&SELECT_Columns=o.OrderID,o.PONum&WHERE_Column=o.OrderID&WHERE_Value='.$podet->OrderID;
		$xml = simplexml_load_file(rawurlencode($url));

		$cusponum=$xml->Orders->PONum;
		
		$checkshippingchargedb = \DB::select( \DB::raw("select invoicenum from poshipped where OrderID={$OrderID} order by invoicenum asc limit 1"));

		if($checkshippingchargedb[0]->invoicenum==$invoicenum) {
			$checkshippingcharge=1;
		}
		else {
			$checkshippingcharge=0;
		}

		if(($tax == 'N') || ($poinfo[0]->ShippingState != 'NM')) {
			$taxable='N';
		}
		else {
			$taxable='Y';
		}

		$poshipped = \DB::table('poshipped')->where('invoicenum',$invoicenum)->get();

		$unitcosts =  \DB::select( \DB::raw("select t2.ProductCode, t2.ProductName, t1.Quantity, t2.Options, t2.TotalPrice/t2.Quantity as unitcost from poshipped t1 join orderdetails t2 on t1.OrderID = t2.OrderID and t1.ProductCode=t2.ProductCode where t1.invoicenum={$invoicenum}") );		

		if($poshipped[0]->DropShip == 'Y' | ($poshipped[0]->ShippedDate < Carbon::createFromDate(2017,04,30,'GMT'))) {
			return view('po.quickbooksdrop', compact('orderinfo','poinfo','poshipped','invoicenum','vendorinfo','unitcosts','taxable','checkshippingcharge','cusponum'));
	
		}
		else {
			return view('po.quickbooksinv', compact('orderinfo','poinfo','poshipped','invoicenum','vendorinfo','unitcosts','taxable','checkshippingcharge','cusponum'));
		}

	}	
	if($request->input('button') != 'inventory' && $request->input('button') != 'dropshipped') {

		$orderinfo = \DB::table('orderinfo')->where('OrderID',$podet->OrderID)->get();
		$id = $orderinfo[0]->CustomerID; 
		$url='http://shop.factory-express.com/net/WebService.aspx?Login=webmaster@factory-express.com&EncryptedPassword=101A2B2BD2D2DD087764EB10B6EFE42F59C41C696E1B1097AE3F126B5C059EBB&EDI_Name=Generic\Customers&SELECT_Columns=CustomerID,EmailAddress,PaysStateTax&WHERE_Column=CustomerID&WHERE_Value='.$id;
		$xml = simplexml_load_file(rawurlencode($url));
		$invoicenum = $request->input('button');
		$email=$xml->Customers->EmailAddress; 
		$tax=$xml->Customers->PaysStateTax; 

		$url='http://shop.factory-express.com/net/WebService.aspx?Login=webmaster@factory-express.com&EncryptedPassword=101A2B2BD2D2DD087764EB10B6EFE42F59C41C696E1B1097AE3F126B5C059EBB&EDI_Name=Generic\Orders&SELECT_Columns=o.OrderID,o.PONum&WHERE_Column=o.OrderID&WHERE_Value='.$podet->OrderID;
		$xml = simplexml_load_file(rawurlencode($url));

		$cusponum=$xml->Orders->PONum;
		
			if($request->input('print')) {
			$invoicenum = $request->input('print');
		}

		$checkshippingchargedb = \DB::select( \DB::raw("select invoicenum from poshipped where OrderID={$OrderID} order by invoicenum asc limit 1"));

		if($checkshippingchargedb[0]->invoicenum==$invoicenum) {
			$checkshippingcharge=1;
		}
		else {
			$checkshippingcharge=0;
		}

		if(($tax == 'N') || ($poinfo[0]->ShippingState != 'NM')) {
			$taxable='N';
		}
		else {
			$taxable='Y';
		}

		$poshipped = \DB::table('poshipped')->where('invoicenum',$invoicenum)->get();

		$unitcosts =  \DB::select( \DB::raw("select t2.ProductCode, t2.ProductName, t1.Quantity, t2.Options, t2.TotalPrice/t2.Quantity as unitcost from poshipped t1 join orderdetails t2 on t1.OrderID = t2.OrderID and t1.ProductName=t2.ProductName where t1.invoicenum={$invoicenum}") );		


		$invoice = \PDF::loadView('mail.feicustomerinvoiceprint', compact('orderinfo','poinfo','poshipped','invoicenum','vendorinfo','unitcosts','taxable','checkshippingcharge','cusponum'));

		$data = array(
    		'name' => 'Trent'   
		);
		\Config::set('services.mailgun.domain', 'factory-express.com');
        \Config::set('services.mailgun.secret', 'key-69748ac1f479af654aa6aa5caacc3cd2');
        
		\Mail::send('mail.simplecustomerinvoice', $data, function($message) use($invoice, $invoicenum, $email)
		{
    		$message->from('poconfirm@factory-express.com', 'Factory Express');

		    $message->to($email->__toString())->subject('Invoice #'.$invoicenum);
//		    $message->to('trentt@factory-express.com')->subject('Invoice #'.$invoicenum);
		    
		    $message->cc('poconfirm@factory-express.com');

		    $message->attachData($invoice->output(), "invoice.pdf");
		});

//		\Config::set('services.mailgun.domain', 'factory-express.com');
//        \Config::set('services.mailgun.secret', 'key-69748ac1f479af654aa6aa5caacc3cd2');
       // \Mail::to('ttoulouse@gmail.com')->cc('poconfirm@factory-express.com')->send(new feicustomerinvoice($orderinfo,$poinfo,$poshipped,$invoicenum,$vendorinfo,$unitcosts));

//		\Mail::to($email->__toString())->cc('poconfirm@factory-express.com')->send(new feicustomerinvoice($orderinfo,$poinfo,$poshipped,$invoicenum,$vendorinfo,$unitcosts,$taxable,$checkshippingcharge));

		\DB::table('poshipped')->where('invoicenum',$invoicenum)->update([ 'sent' => '1']);

		$poinfo    = \DB::table('poinfo')->where('PONum',$request->input('ponum'))->get();
		$vendorinfo = \DB::table('vendors')->where('VendorName',$poinfo[0]->Vendor)->get();
		$podetails = \DB::table('podetails')->where('PONum',$request->input('ponum'))->get();
		$poshipped = \DB::table('poshipped')->where('PONum',$request->input('ponum'))->get();
		return view('po.showpo',compact('poinfo','podetails','vendorinfo','poshipped'));
	}

		if($podet->Shipped != 0) {
			$difference = $shipped-$podet->Shipped;
		}

		if($shipped > $podet->Quantity) {
		}
		else{

		\DB::table('podetails')->where('PONum',$id)->where('ProductName',$podet->ProductName)->update(['Shipped' => $shipped]);

		if($difference != 0) {

		if($lastdate != $request->input($shippeddate)) { $invoicenum=$invoicenum+1; } 
		if($request->input('button') == 'inventory') { $dropship = 'N'; }
		\DB::table('poshipped')->insert([
                        'OrderID' => $podet->OrderID,
                        'ProductCode' => $productcode,
                        'ProductName' => $podet->ProductName,
                        'Options' => $podet->Options,
                        'Quantity' => $difference,
                        'PONum' => $id,
                        'DropShip' => $dropship,
                        'invoicenum' => $invoicenum,
                        'ShippedDate' => $request->input($shippeddate),
                        'createdby' => Auth::user()->name]);
		$lastdate = $request->input($shippeddate);
		}

		if($request->input('button') == 'inventory') {

			if($productcode == 'POCU301' || $productcode == 'POUC309') {
				\DB::table('inventory')->where('ProductCode','POUC309')->decrement('Stock',$difference);
				\DB::table('inventory')->where('ProductCode','POUC301')->decrement('Stock',$difference);
			}

			else {
				$productcode =str_replace('_','.',$podet->ProductCode);

				\DB::table('inventory')->where('ProductCode',$productcode)->decrement('Stock',$difference);
			}
		}
		}
	}

	$podetails = \DB::table('podetails')->where('PONum',$id)->get();
	$poshipped = \DB::table('poshipped')->where('PONum',$id)->get();
	return view('po.showpo',compact('poinfo','podetails','vendorinfo','poshipped'));
    }
}
