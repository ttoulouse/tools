@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><a href="{{ url('/') }}/orders"><- Back to All Orders</a></div>

                <div class="panel-body">


</table><br><b>Vendor: </b>{{$stockpoinfo[0]->Vendor}} <b>PO #: </b>{{$stockpoinfo[0]->PONum}}<br>
<form method="POST" action="{{ url('/') }}/stock/editpo">
<input type="hidden" name="_token" value="{{ csrf_token() }}">
<input type="hidden" name="Vendor" value="{{ $stockpoinfo[0]->Vendor }}">
<input type="hidden" name="PONum" value="{{ $stockpoinfo[0]->PONum }}">

<div class=text-right>
<button type="submit" name="button" value="save" class="btn btn-primary btn-xs">Save</button>
@php
if($stockpoinfo[0]->Sent == 1) {
echo('<button type="submit" name="button" value="send" class="btn btn-danger btn-xs">Resend</button>');
}
else {
echo('<button type="submit" name="button" value="send" class="btn btn-primary btn-xs">Send</button>');
}
@endphp
</div>

<table class="table table-condensed">
<tr><th></th><th>Billing</th><th>Shipping</th></tr>
<tr><td><strong>Company Name</strong></td><td><input type="text" name="BillingCompanyName" value="{{$stockpoinfo[0]->BillingCompanyName}}"/></td><td><input type="text" name="ShippingCompanyName" value="{{$stockpoinfo[0]->ShippingCompanyName}}"/></td></tr>
<tr><td><strong>First Name</strong></td><td><input type="text" name="BillingFirstName" value="{{$stockpoinfo[0]->BillingFirstName}}"/></td><td><input type="text" name="ShippingFirstName" value="{{$stockpoinfo[0]->ShippingFirstName}}"/></td></tr>
<tr><td><strong>Last Name</strong></td><td><input type="text" name="BillingLastName" value="{{$stockpoinfo[0]->BillingLastName}}"/></td><td><input type="text" name="ShippingLastName" value="{{$stockpoinfo[0]->ShippingLastName}}"/></td></tr>
<tr><td><strong>Address1</strong></td><td><input type="text" name="BillingAddress" value="{{$stockpoinfo[0]->BillingAddress}}"/></td><td><input type="text" name="ShippingAddress" value="{{$stockpoinfo[0]->ShippingAddress}}"/></td></tr>
<tr><td><strong>City</strong></td><td><input type="text" name="BillingCity" value="{{$stockpoinfo[0]->BillingCity}}"/></td><td><input type="text" name="ShippingCity" value="{{$stockpoinfo[0]->ShippingCity}}"/></td></tr>
<tr><td><strong>State</strong></td><td><input type="text" name="BillingState" value="{{$stockpoinfo[0]->BillingState}}"/></td><td><input type="text" name="ShippingState" value="{{$stockpoinfo[0]->ShippingState}}"/></td></tr>
<tr><td><strong>PostalCode</strong></td><td><input type="text" name="BillingPostalCode" value="{{$stockpoinfo[0]->BillingPostalCode}}"/></td><td><input type="text" name="ShippingPostalCode" value="{{$stockpoinfo[0]->ShippingPostalCode}}"/></td></tr>
<tr><td><strong>Country</strong></td><td><input type="text" name="BillingCountry" value="{{$stockpoinfo[0]->BillingCountry}}"/></td><td><input type="text" name="ShippingCountry" value="{{$stockpoinfo[0]->ShippingCountry}}"/></td></tr>
<tr><td><b>Phone Number</b></td><td><input type="text" name="BillingPhoneNumber" value="{{$stockpoinfo[0]->BillingPhoneNumber}}"/></td><td><input type="text" name="ShippingPhoneNumber" value="{{$stockpoinfo[0]->ShippingPhoneNumber}}"/></td></tr>
</table>
<table class="table table-condensed">
<tr><td><strong>Shipping Method: {{$stockpoinfo[0]->ShippingMethod}}</strong></td></tr>
<tr><td>Change Shipping Method:</td></tr>
<tr>
<td>
<select name="ShippingMethod">
<option selected="selected">Free Shipping</option>
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
</select>
</td></tr>
</table>

<table class="table table-sm">
<tr><th>Product Code</th><th>Product Name</th><th>Options</th><th>Quantity</th><th>Cost</th><th><button type="submit" name="quickbooks" value="{{$stockpoinfo[0]->PONum}}" class="btn btn-primary btn-xs">QB</button></th></tr>
@php $count=0; $totalcost=0; @endphp
@foreach ( $stockpodetails as $podet)
<tr><td>{{$podet->ProductCode}}</td><td>{{$podet->ProductName}}</td><td>{{$podet->Options}}</td><td><input type="texts" name="Quantity{{$count}}" size="4" value="{{$podet->Quantity}}"></td><td><input type="texts" name="Cost{{$count}}" size="4" value="{{$podet->Cost}}"></td>
<td><button type="submit" class="btn btn-danger btn-xs" name="remove" value="{{$podet->ProductCode}}"><span class="glyphicon glyphicon-remove"></span></button></td></tr>
@php $count = $count+1; $totalcost=($podet->Cost*$podet->Quantity)+$totalcost; @endphp
@endforeach
<td></td><td></td><td></td><td><b>Total:</b></b></td><Td>{{$totalcost}}</Td>
</table>

<table class="table table-sm">
<tr><th>Product Code</th><th>Quantity</th><th>Options</th></tr>
<tr><td><input type="text" name="ProductCode"></td><td><input type="texts" name="Quantity" size="4"></td><td><input type="text" name="Options"></td></tr>
<tr><td><button type="submit" class="btn btn-primary btn-xs" name="button" value="add">Add Product</button></td></tr>
<tr><td>
<strong>Comments:</strong></td></tr><tr><td>
<textarea name="Comments" rows="5" cols="50">{{$stockpoinfo[0]->Comments}}</textarea>
</td></tr>
</table>
</form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

