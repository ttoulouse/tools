<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportsController extends Controller
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
    public function open()
    {
        
        $url='http://shop.factory-express.com/net/WebService.aspx?Login=webmaster@factory-express.com&EncryptedPassword=101A2B2BD2D2DD087764EB10B6EFE42F59C41C696E1B1097AE3F126B5C059EBB&EDI_Name=Generic\ordersreport';
    	$xml = simplexml_load_file(rawurlencode($url));
		
		$count=0;
		
		foreach($xml->Table as $order) {
		   if(\DB::table('orderinfo')->where('OrderID',$order->OrderID)->exists()) {
		       $orderexists[$count]=1;
		   }
		   else {
		       $orderexists[$count]=0;
		   }
		   $count=$count+1;
		}
		
        return view('reports.open',compact('xml','orderexists'));
    }

    public function tax(Request $request)
    {
        
        $url='http://shop.factory-express.com/net/WebService.aspx?Login=webmaster@factory-express.com&EncryptedPassword=101A2B2BD2D2DD087764EB10B6EFE42F59C41C696E1B1097AE3F126B5C059EBB&EDI_Name=Generic\salestaxreport';
    	$xml = simplexml_load_file(rawurlencode($url));
    	
		foreach ($xml as $order) {
            if ($order->Pay_AuthDate >= $request->input('startdate') && $order->Pay_AuthDate <= $request->input('enddate')) {
                $taxreport[] = $order;
            }
		}

	    return view('reports.tax',compact('taxreport'));
    }
    
    public function taxdate()
    {
        
	    return view('reports.taxdate');
    }
}
