@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><a href="{{ url('/') }}/orders/{{$poinfo[0]->OrderID}}"><- Back to Order</a></div>

                <div class="panel-body">
			@php
				$lastpo = 0;
				$count = 0;
			@endphp

                        @foreach ( $podetails as $podet)
				@php
					if ($podet->PONum != $lastpo) {
						echo('</table><br>
<table class="table"><tr><th>Vendor</th><th>E-mail</th><th>PO Num</th><th>Created Date</th><th>Created By</th></tr><tr>
<td>'.$poinfo[$count]->Vendor.'</td><td>'.$vendorinfo[$count]->Email.'</td><td>'.$podet->PONum.'</td><td>'.$poinfo[0]->CreatedDate.'</td><td>'.$poinfo[0]->createdby.'</td>
</tr></table>');



						echo('
<form method="POST" action="/orders/'.$poinfo[$count]->OrderID.'/'.$podet->PONum.'/edit">
<input type="hidden" name="_token" value="');echo e(csrf_token());echo('">
<div class=text-right>
<button type="submit" name="button" value="edit" class="btn btn-primary btn-xs">Edit</button> ');

if($poinfo[$count]->sent == 1) {
echo('<button type="submit" name="button" value="send" class="btn btn-danger btn-xs">Resend</button>');
}
else {
echo('<button type="submit" name="button" value="send" class="btn btn-primary btn-xs">Send</button>');
}

if($poinfo[$count]->printed == 1) {
echo('<button type="submit" name="button" value="print" class="btn btn-danger btn-xs">RePrint</button>');
}
else {
echo('<button type="submit" name="button" value="print" class="btn btn-primary btn-xs">Print</button>');
}

echo('
</div>
</form>

<table class="table table-condensed">
<tr><th>Info</th><th>Billing</th><th>Shipping</th></tr>
<tr><td><strong>Company Name</strong></td><td> FactoryExpress </td><td>'. $poinfo[$count] ->ShippingCompanyName.'</td></tr>
<tr><td><strong>First Name</strong></td><td> Accounts </td><td>'. $poinfo[$count] ->ShippingFirstName.'</td></tr>
<tr><td><strong>Last Name</strong></td><td> Payable </td><td>'. $poinfo[$count] ->ShippingLastName.'</td></tr>
<tr><td><strong>Address1</strong></td><td> 8201 E Pacific Pl, Ste 603-604 </td><td>'. $poinfo[$count] ->ShippingAddress1.'</td></tr>
<tr><td><strong>Address2</strong></td><td></td><td>'. $poinfo[$count] ->ShippingAddress2.'</td></tr>
<tr><td><strong>City</strong></td><td> Denver </td><td>'. $poinfo[$count] ->ShippingCity.'</td></tr>
<tr><td><strong>State</strong></td><td> Colorado </td><td>'. $poinfo[$count] ->ShippingState.'</td></tr>
<tr><td><strong>PostalCode</strong></td><td> 80231 </td><td>'. $poinfo[$count] ->ShippingPostalCode.'</td></tr>
<tr><td><strong>Country</strong></td><td> USA </td><td>'. $poinfo[$count] ->ShippingCountry.'</td></tr>
<tr><td><b>Phone Number</b></td><td> 505-247-3232 </td><td>'. $poinfo[$count] ->ShippingPhoneNumber.'</td></tr>
</table>
<b>Comments:</b><br>'.$poinfo[$count] ->Comments.'
<br><br>
<table class="table table-condensed">
<tr><td width="175"><strong>Shipping Method:</strong></td><td><strong>'.$poinfo[$count]-> ShippingMethod.'</strong></td></tr>
<tr><td><b>Shipping Cost:</b></td><td>'.$poinfo[$count]->ShippingCost.'</td></tr>
<tr><td><b>Fees:</b></td><td>'.$poinfo[$count]->Fees.'</td></tr>

</table>
<table class="table table-condensed">
<tr><th>Product Code</th><th>Description</th><th>Quantity</th><th>Price</th><th>Options</th></tr>
');
					$count = $count +1;

					}
				@endphp

<tr><td>{{ $podet ->ProductCode}}</td><td>{{ $podet ->ProductName}}</td><td>{{ $podet ->Quantity}}</td><td>{{ $podet ->Cost}}</td><td>{{ $podet ->Options}}</td>
			@php

			$lastpo = $podet->PONum;

			@endphp
			@endforeach

		</tr>
		</table>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection

