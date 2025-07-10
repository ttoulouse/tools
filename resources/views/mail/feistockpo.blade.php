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
{{$vendorinfo[0]->VendorName}}<br>
{{$vendorinfo[0]->Address1}}<br>
{{$vendorinfo[0]->Address2}}<br>
{{$vendorinfo[0]->City}},{{$vendorinfo[0]->State}},{{$vendorinfo[0]->PostalCode}}<br>
{{$vendorinfo[0]->PhoneNumber}}
</td><td><pre>&#09</pre></td><td><pre>&#09</pre></td><td>
<h3>Purchase Order: {{$PONum}}<br>
Created Date: {{$stockpoinfo[0]->CreatedDate}}</h3>
</td></tr></table>
<br>
<hr>
<table><tr>
<th align="left">Bill To:</th><th></th><th></th><th></th><th align="left">Ship To:</th></tr><td>

{{ $stockpoinfo[0]->BillingCompanyName }}<br>
{{ $stockpoinfo[0]->BillingFirstName }} {{ $stockpoinfo[0]->BillingLastName }}<br>
{{ $stockpoinfo[0]->BillingAddress }}<br>
{{ $stockpoinfo[0]->BillingCity }} {{ $stockpoinfo[0]->BillingState }} {{ $stockpoinfo[0]->BillingPostalCode }} {{ $stockpoinfo[0]->BillingCountry }}<br>
{{ $stockpoinfo[0]->BillingPhoneNumber }}

</td><td><pre>&#09</pre></td><td><pre>&#09</pre></td><td><pre>&#09</pre></td><td>

{{ $stockpoinfo[0]->ShippingCompanyName }}<br>
{{ $stockpoinfo[0]->ShippingFirstName }} {{ $stockpoinfo[0]->ShippingLastName }}<br>
{{ $stockpoinfo[0]->ShippingAddress }}<br>
{{ $stockpoinfo[0]->ShippingCity }} {{ $stockpoinfo[0]->ShippingState }} {{ $stockpoinfo[0]->ShippingPostalCode }} {{ $stockpoinfo[0]->ShippingCountry }}<br>
{{ $stockpoinfo[0]->ShippingPhoneNumber }}

</td></tr>
</table>
<hr>
<b>Ship Via:</b> <font color="red">{{ $stockpoinfo[0]->ShippingMethod }}</font><br>
<br>
<table cellpadding="10px">
<tr><th>Product Code</th><th>Description</th><th>Quantity</th><th>Price</th><th>Options</th><th>Sub Total</th></tr>
@php $TotalCost=0; @endphp
@foreach ( $stockpodetails as $podet)
@php
$TotalCost=$TotalCost+($podet->Quantity*$podet->Cost);
@endphp
<tr>
<td>{{ $podet ->VendorProductCode}}</td>
<td>{{ $podet ->ProductName}}</td>
<td>{{ $podet ->Quantity}}</td>
<td>{{ $podet ->Cost}}</td>
<td>{{ $podet ->Options}}</td>
<td>@php echo('$'.$podet->Quantity*$podet->Cost);@endphp
</tr>
                        @endforeach

@php
$TotalCost=$TotalCost+($stockpoinfo[0]->ShippingCost);
@endphp

<tr><td></td><td></td><td></td><td></td><td><b>Shipping Cost:</b></td><td>${{$stockpoinfo[0]->ShippingCost}}</td></tr>
<tr><td></td><td></td><td></td><td></td><td><b>Grand Total:</b></td><td>${{$TotalCost}}</td></tr>
</table>

<table class="table table-condensed">
@php
echo($stockpoinfo[0]->Comments)
@endphp

<br><br><br>

You must get prior approval from our Purchasing department to authorize any changes to pricing or special
instructions on this PO prior to processing the order. If shipping by a method other than that listed on this PO,
contact Factory Express for approval. If prior approval is not obtained, we will only honor the amount on the
original PO.

</td></tr></table>
</body>
</html>


