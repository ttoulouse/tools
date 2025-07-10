<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<title>Factory Express Purchase Order</title>

</head>

<body>

<img src="http://tools.factory-express.com/feilogo.jpg" />
<br>
<table><tr><td>
Factory Express, Inc.<br>
8201 E Pacific Pl, Ste 603-604
Denver, CO 80231<br>
(505) 247-3232
</td><td><pre>&#09</pre></td><td><pre>&#09</pre></td><td>
<h3>Purchase Order: {{$PONum}}<br>
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
@php
if(($poinfo[0]->Vendor != 'Spiral Binding Co') && ($poinfo[0]->Vendor != 'SOUTHWEST PLASTIC BINDING') && ($poinfo[0]->Vendor !='BankSupplies Inc.')){
echo($poinfo[0]->ShippingPhoneNumber);
}
@endphp

</td></tr>
</table>
<hr>
<b>Ship Via:</b> <font color="red">{{ $poinfo[0]->ShippingMethod }}</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sales Order: {{$OrderID}}<br>
<br>
<table cellpadding="10px">
<tr><th>Product Code</th><th>Description</th><th>Quantity</th><th>Price</th><th>Options</th><th>Sub Total</th></tr>
@php $TotalCost=0; @endphp
@foreach ( $podetails as $podet)
@php
$TotalCost=$TotalCost+($podet->Quantity*$podet->Cost);
@endphp
<tr>
<td>{{ $podet ->ProductCode}}</td>
<td>{{ $podet ->ProductName}}</td>
<td>{{ $podet ->Quantity}}</td>
<td>{{ $podet ->Cost}}</td>
<td>{{ $podet ->Options}}</td>
<td>@php echo('$'.$podet->Quantity*$podet->Cost);@endphp
</tr>
                        @endforeach

@php
$TotalCost=$TotalCost+($poinfo[0]->ShippingCost+$poinfo[0]->Fees);
@endphp

<tr><td></td><td></td><td></td><td></td><td><b>Shipping Cost:</b></td><td>${{$poinfo[0]->ShippingCost}}</td></tr>
<tr><td></td><td></td><td></td><td></td><td><b>Fees:</b></td><td>${{$poinfo[0]->Fees}}</td></tr>
<tr><td></td><td></td><td></td><td></td><td><b>Grand Total:</b></td><td>${{$TotalCost}}</td></tr>
</table>

<table class="table table-condensed">
@php
echo($poinfo[0]->Comments)
@endphp

<br><br><br>

You must get prior approval from our Purchasing department to authorize any changes to pricing or special
instructions on this PO prior to processing the order. If shipping by a method other than that listed on this PO,
contact Factory Express for approval. If prior approval is not obtained, we will only honor the amount on the
original PO.

</td></tr></table>
</body>
</html>


