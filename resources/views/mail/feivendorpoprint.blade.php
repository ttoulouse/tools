<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<title>Factory Express Purchase Order</title>

</head>

<body onload="window.print()">

<img src="http://tools.factory-express.com/feilogo.jpg" />
<br>
<table><tr><td>
Factory Express, Inc.<br>
8201 E Pacific Pl, Ste 603-604<br>
Denver, CO 80231<br>
(505) 247-3232
</td><td><pre>&#09</pre></td><td><pre>&#09</pre></td><td>
<h3>Sales Order: {{$OrderID}}<br>
Purchase Order: {{$PONum}}<br>
Created Date: {{$poinfo[0]->CreatedDate}}</h3>
</td></tr></table>
<br>
<hr>
<table><tr>
<th align="left">Vendor:</th><th></th><th></th><th></th><th align="left">Ship To:</th></tr><td>
@php
if($poinfo[0]->Vendor != 'Inventory') {
echo($vendorinfo[0]->VendorName.'<br>'.$vendorinfo[0]->Address1.'<br>'.$vendorinfo[0]->Address2.'<br>'.$vendorinfo[0]->City.' '.$vendorinfo[0]->State.' '.$vendorinfo[0]->PostalCode.'<br>'.$vendorinfo[0]->PhoneNumber);
}
@endphp
</td><td><pre>&#09</pre></td><td><pre>&#09</pre></td><td><pre>&#09</pre></td><td>

{{ $poinfo[0]->ShippingCompanyName }}<br>
{{ $poinfo[0]->ShippingFirstName }} {{ $poinfo[0]->ShippingLastName }}<br>
{{ $poinfo[0]->ShippingAddress1 }}<br>
{{ $poinfo[0]->ShippingAddress2 }}<br>
{{ $poinfo[0]->ShippingCity }} {{ $poinfo[0]->ShippingState }} {{ $poinfo[0]->ShippingPostalCode }} {{ $poinfo[0]->ShippingCountry }}<br>
{{ $poinfo[0]->ShippingPhoneNumber }}<br>
{{ $email }}

</td></tr>
</table>
<hr>
<b>Ship Via:</b> <font color="red">{{ $poinfo[0]->ShippingMethod }}<br></font>
<br>
<table cellpadding="5px" style="font-size:12px;">
@php $TotalCost=0;

if($poinfo[0]->Vendor=="Inventory") {
echo('<tr><th>Product Code</th><th>Description</th><th>Quantity</th><th>Price</th><th>Options</th><th>Shipped</th><th>Backordered</th><th>Sub Total</th></tr>');
}
else{
echo('<tr><th>Product Code</th><th>Description</th><th>Quantity</th><th>Price</th><th>Options</th><th>Sub Total</th></tr>');
}
@endphp
@foreach ( $podetails as $podet)
@php
$TotalCost=$TotalCost+($podet->Quantity*$podet->Cost);

if($poinfo[0]->Vendor=="Inventory") {
echo('
<tr>
<td>'.$podet ->ProductCode.'</td>
<td>'.$podet ->ProductName.'</td>
<td>'.$podet ->Quantity.'</td>
<td>'.$podet ->Cost.'</td>
<td>'.$podet ->Options.'</td>
<td>______</td><td>______</td>
<td>'.'$'.$podet->Quantity*$podet->Cost.'
</tr>'
);
}

else {
echo('
<tr>
<td>'.$podet ->ProductCode.'</td>
<td>'.$podet ->ProductName.'</td>
<td>'.$podet ->Quantity.'</td>
<td>'.$podet ->Cost.'</td>
<td>'.$podet ->Options.'</td>
<td>'.'$'.$podet->Quantity*$podet->Cost.'
</tr>'
);
}

@endphp

                        @endforeach
@php
$TotalCost=$TotalCost+($poinfo[0]->ShippingCost+$poinfo[0]->Fees);
@endphp

<tr><td></td><td></td><td></td><td></td><td><b>Shipping Cost:</b></td><td>${{$poinfo[0]->ShippingCost}}</td></tr>
<tr><td></td><td></td><td></td><td></td><td><b>Fees:</b></td><td>${{$poinfo[0]->Fees}}</td></tr>
<tr><td></td><td></td><td></td><td></td><td><b>Grand Total:</b></td><td>${{$TotalCost}}</td></tr>
</table>

<table cellspacing="25" class="table table-condensed">

@php
echo($poinfo[0]->Comments);

if(($poinfo[0]->ShippingMethod=="In-Store Pickup") || ($poinfo[0]->ShippingMethod=="Delivery")) {
echo('
<table><tr>
<td><b>Print Name:</b></td><td></td><td>____________________</td></tr><tr><br>
<td><b>Date:</b></td><td></td><td>____________________</td></tr><tr><br>
<td><b>Signature:</b></td><td></td><td>____________________</td></tr>
</table>
');
}
else{

if($poinfo[0]->Vendor=="Inventory"){
}

else{

echo('
<br><br><br>

You must get prior approval from our Purchasing department to authorize any changes to pricing or special
instructions on this PO prior to processing the order. If shipping by a method other than that listed on this PO,
contact Factory Express for approval. If prior approval is not obtained, we will only honor the amount on the
original PO.

</td></tr></table>');
}}
@endphp

</body>
</html>


