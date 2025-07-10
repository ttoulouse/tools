@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><a href="{{ url('/') }}/orders"><- Back to All Orders</a></div>

                <div class="panel-body">

		@php

echo('
<form method="POST" action="/orders/'.$poinfo[0]->OrderID.'/'.$poinfo[0]->PONum.'/update">
</table><br><b>Vendor:</b><input type="text" name="Vendor" value="'.$poinfo[0]->Vendor.'"/> <b>PO Num:</b> <input type="text" name="PONum" value="'.$poinfo[0]->PONum.'"/>
<table class="table table-condensed">
<tr><th>Info</th><th>Billing</th><th>Shipping</th></tr>
<tr><td><strong>Company Name</strong></td><td>FactoryExpress</td><td><input type="text" name="ShippingCompanyName" value="'. $poinfo[0] ->ShippingCompanyName.'"/></td></tr>
<tr><td><strong>First Name</strong></td><td>Accounts</td><td><input type="text" name="ShippingFirstName" value="'. $poinfo[0] ->ShippingFirstName.'"/></td></tr>
<tr><td><strong>Last Name</strong></td><td>Payable</td><td><input type="text" name="ShippingLastName" value="'. $poinfo[0] ->ShippingLastName.'"/></td></tr>
<tr><td><strong>Address1</strong></td><td>8201 E Pacific Pl, Ste 603-604</td><td><input type="text" name="ShippingAddress1" value="'. $poinfo[0] ->ShippingAddress1.'"/></td></tr>
<tr><td><strong>Address2</strong></td><td></td><td><input type="text" name="ShippingAddress2" value="'. $poinfo[0] ->ShippingAddress2.'"/></td></tr>
<tr><td><strong>City</strong></td><td>Denver</td><td><input type="text" name="ShippingCity" value="'. $poinfo[0] ->ShippingCity.'"/></td></tr>
<tr><td><strong>State</strong></td><td>Colorado</td><td><input type="text" name="ShippingState" value="'. $poinfo[0] ->ShippingState.'"/></td></tr>
<tr><td><strong>PostalCode</strong></td><td>80231</td><td><input type="text" name="ShippingPostalCode" value="'. $poinfo[0] ->ShippingPostalCode.'"/></td></tr>
<tr><td><strong>Country</strong></td><td>USA</td><td><input type="text" name="ShippingCountry" value="'. $poinfo[0] ->ShippingCountry.'"/></td></tr>
<tr><td><b>Phone Number</b></td><td> 505-247-3232</td><td><input type="text" name="ShippingPhoneNumber" value="'. $poinfo[0] ->ShippingPhoneNumber.'"/></td></tr>
</table>
<table class="table table-condensed">
<tr><td width="175"><strong>Shipping Method:</strong></td><td><strong>'.$poinfo[0]-> ShippingMethod.'</strong></td></tr>
<tr><td><strong>Change Shipping Method:</strong></td>
<td>
<select name="ShippingMethod">
<option selected="selected" value="'.$poinfo[0]-> ShippingMethod.'">No Change</option>
<option>Free Shipping</option>
<option>UPS Ground</option>
<option>UPS 3Day Select</option>
<option>UPS 2nd Day Air</option>
<option>UPS Next Day Air Saver</option>
<option>UPS Next Day Air</option>
<option>UPS Next Day Air Early A.M.</option>
<option>FedEx Ground</option>
<option>FedEx Overnight</option>
<option>FedEx 2Day</option>
<option>FedEx Express Saver</option>
<option>FedEx Home Delivery</option>
<option>Delivery</option>
<option>Ship on Customer Account</option>
<option>Freight</option>
</select>
</td></tr><tr>
<td><strong>Comments:</strong></td><td>
<textarea name="Comments" rows="5" cols="50">'.$poinfo[0] ->Comments.'</textarea>
</td></tr>
</table>
<table class="table table-condensed">
<tr><th>Product Code</th><th>Description</th><th>Quantity</th><th>Price</th><th>Options</th></tr>
');
		@endphp
@php $count=0; @endphp

                        @foreach ( $podetails as $podet)
<tr>
<td><input type="text" name="{{ $podet ->ProductCode}}_Code{{$count}}" value="{{ $podet ->ProductCode}}"/></td>
<td><input type="text" name="Name{{$count}}" value="{{ $podet ->ProductName}}"/></td>
<td><input type="text" name="Quantity{{$count}}" value="{{ $podet ->Quantity}}"/></td>
<td><input type="text" name="Cost{{$count}}" value="{{ $podet ->Cost}}"/></td>
<td><input type="text" name="Options{{$count}}" value="{{ $podet ->Options}}"/></td>
@php $count=$count+1; @endphp
			@endforeach
</tr>
<tr><td></td><td></td><td><b>Shipping Cost:</b></td><td><input type="text" name="ShippingCost" value="{{$poinfo[0]->ShippingCost}}"/></td></tr>
<tr><td></td><td></td><td><b>Fees:</b></td><td><input type="text" name="Fees" value="{{$poinfo[0]->Fees}}"/></td></tr>
</table>
<input type="hidden" name="_token" value="{{ csrf_token() }}">
<div class=text-right>
<button type="submit" class="btn btn-primary btn-xs">Save</button>
</div>
</form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

