<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<title>Factory Express Customer Invoice</title>

</head>

<body onload="window.print()">

<img src="http://tools.factory-express.com/feilogo.jpg" />
<br>
Factory Express, Inc.<br>
8201 E Pacific Pl, Ste 603-604<br>
Denver, CO 80231<br>
(505) 247-3232
<h3>
Sales Order: {{$poshipped[0]->OrderID}}<br>
PO Number: {{$cusponum}} <br>
Invoice Number: {{$invoicenum}}<br>
Invoice Date: {{$poshipped[0]->ShippedDate}}<br>
Due Date: @php echo date('Y-m-d', strtotime($poshipped[0]->ShippedDate . " +30 days")); @endphp
</h3>
<br>
<hr>
<table class="table"><tr><th>Billing</th><th>&nbsp;</th><th>Shipping</th></tr>
<tr><td>{{ $orderinfo[0]->CompanyName }}</td><td>&nbsp;</td><td>{{ $poinfo[0]->ShippingCompanyName }}</td></tr>
<tr><td>{{ $orderinfo[0]->BillingFirstName }} {{ $orderinfo[0]->BillingLastName }}</td><td>&nbsp;</td><td>{{ $poinfo[0]->ShippingFirstName }} {{ $poinfo[0]->ShippingLastName }}</td></tr>
<tr><td>{{ $orderinfo[0]->BillingAddress1 }}</td><td>&nbsp;</td><td>{{ $poinfo[0]->ShippingAddress1 }}</td></tr>
<tr><td>{{ $orderinfo[0]->BillingAddress2 }}</td><td>&nbsp;</td></t><td>{{ $poinfo[0]->ShippingAddress2 }}</td></tr>
<tr><td>{{ $orderinfo[0]->BillingCity }} {{ $orderinfo[0]->BillingState }} {{ $orderinfo[0]->BillingPostalCode }} {{ $orderinfo[0]->BillingCountry }}</td><td>&nbsp;</td><td>{{ $poinfo[0]->ShippingCity }} {{ $poinfo[0]->ShippingState }} {{ $poinfo[0]->ShippingPostalCode }} {{ $poinfo[0]->ShippingCountry }}</td></tr>
<tr><td>{{ $orderinfo[0]->BillingPhoneNumber }}</td><td>&nbsp;</td><td>{{ $poinfo[0]->ShippingPhoneNumber }}</td></tr>
</table>
<hr>
<br>
<table cellpadding="10px">
<tr><th>Product Code</th><th>Description</th><th>Quantity</th><th>Price</th><th>Options</th><th>Sub Total</th></tr>
@php $TotalCost=0; @endphp
@foreach ( $unitcosts as $podet)
@php
$unitcost=round($podet->unitcost,2);
$TotalCost=$TotalCost+($podet->Quantity*$unitcost);
@endphp
<tr>
<td>{{ $podet ->ProductCode}}</td>
<td>{{ $podet ->ProductName}}</td>
<td>{{ $podet ->Quantity}}</td>
<td>{{ $unitcost}}</td>
<td>{{ $podet ->Options}}</td>
<td>@php echo('$'.round($podet->Quantity*$unitcost,2));@endphp
</tr>
                        @endforeach

@php
$ShippingCost = ($orderinfo[0]->TotalShippingCost)*$checkshippingcharge;
$TotalCost=$TotalCost+(($orderinfo[0]->TotalShippingCost)*$checkshippingcharge);

if($taxable == 'Y') {
    $tax=round($TotalCost*0.07313,2);
}
else {
    $tax=0;
}

$GrandTotal = round($TotalCost + $tax,2);    
@endphp

<tr><td></td><td></td><td></td><td></td><td><b>Shipping Cost:</b></td><td>${{$ShippingCost}}</td></tr>
<tr><td></td><td></td><td></td><td></td><td><b>Tax:</b></td><td>{{$tax}}</td></tr>
<tr><td></td><td></td><td></td><td></td><td><b>Grand Total:</b></td><td>${{$GrandTotal}}</td></tr>
</table>
</body>
</html>
