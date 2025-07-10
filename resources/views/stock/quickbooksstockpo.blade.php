@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Invoice Details to be Pushed</div>

                <div class="panel-body">
<form method="POST" action="http://quickbooks.factory-express.com/reviewstockpo.php" target="_blank">
@php
$TotalCost=0; 
@endphp

<table class="table">
<tr><th>Product Code</th><th>Product Name</th><th>Quantity</th><th>UnitCost</th></tr>

@foreach ($stockpodetails as $podet)

    @php
        $TotalCost=$TotalCost+($podet->Quantity*$podet->Cost);
    @endphp

    <tr><td>{{ $podet ->ProductCode}}</td><td>{{ $podet ->ProductName}}</td><td>{{ $podet ->Quantity}}</td><td>{{ $podet->Cost}}</td></tr>

<input type="hidden" name="ProductCode[]" value="{{$podet ->ProductCode}}">
<input type="hidden" name="ProductName[]" value="{{$podet ->ProductName}}">
<input type="hidden" name="Quantity[]" value="{{$podet ->Quantity}}">
<input type="hidden" name="UnitCost[]" value="{{$podet ->Cost}}">
    
@endforeach

    <tr><td>Total Cost:</td><td>{{$TotalCost}}</td></tr>
</table>
<input type="hidden" name="invoicenum" value="{{$stockpoinfo[0]->PONum}}">
<input type="hidden" name="TotalCost" value="{{$TotalCost}}">
<input type="hidden" name="ShippedDate" value="{{$stockpoinfo[0]->CreatedDate}}">
<input type="hidden" name="Vendor" value="{{$vendorinfo}}">

<button type="submit" class="btn btn-primary">Push to QB</button>
</form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

