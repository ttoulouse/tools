@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Invoice Details to be Pushed</div>

                <div class="panel-body">
<form method="POST" action="http://quickbooks.factory-express.com/reviewinv.php" target="_blank">
@php
$ShippingCost = ($orderinfo[0]->TotalShippingCost)*$checkshippingcharge;
$TotalCost=0; 
@endphp

<table class="table">
<tr><th>Product Code</th><th>Product Name</th><th>Quantity</th><th>UnitCost</th></tr>

@foreach ( $unitcosts as $podet)
    @php
        $unitcost=round($podet->unitcost,2);
        $TotalCost=$TotalCost+($podet->Quantity*$unitcost);
    @endphp

@endforeach

<tr><td>Sales</td><td>{{$orderinfo[0]->OrderID}}</td><td>1</td><td>{{$TotalCost}}</td></tr>

<input type="hidden" name="ProductCode[]" value="Sales">
<input type="hidden" name="ProductName[]" value="{{$orderinfo[0]->OrderID}}">
<input type="hidden" name="OrderID" value="{{$orderinfo[0]->OrderID}}">
<input type="hidden" name="Quantity[]" value="1">
<input type="hidden" name="UnitCost[]" value="{{$TotalCost}}">
    

    <tr><td>Total Cost:</td><td>{{$TotalCost}}</td></tr>
    <tr><td>Shipping:</td><td>{{$ShippingCost}}</td></tr>
</table>
<input type="hidden" name="invoicenum" value="{{$invoicenum}}">
<input type="hidden" name="TotalCost" value="{{$TotalCost}}">
<input type="hidden" name="ShippingCost" value="{{$ShippingCost}}">
<input type="hidden" name="ShippedDate" value="{{$poshipped[0]->ShippedDate}}">
<input type="hidden" name="OrderID" value="{{$orderinfo[0]->OrderID}}">
<input type="hidden" name="Taxable" value="{{$taxable}}">
<input type="hidden" name="PaymentMethod" value="{{$poinfo[0]->PaymentMethod}}">

<button type="submit" class="btn btn-primary">Push to QB</button>
</form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

