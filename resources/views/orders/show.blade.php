@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><a href="{{ url('/') }}/orders"><- Back to All Orders</a></div>

                <div class="panel-body">

<form method="POST" action="/orders/{{ $orderinfo ->OrderID}}/po">
<table id="payment">
<tr><td width="175"><strong>OrderID:</strong></td><td><strong>{{ $orderinfo ->OrderID}}</strong></td></tr>
</table>
<br />
<table class="table table-condensed">
<tr><th>Info</th><th>Billing</th><th>Shipping 

@if($orderinfo ->issue==0)
<button type="submit" style="float: right;" class="btn btn-primary btn-xs" name="button" value="issue">Create Issue</button>
@endif

@if($orderinfo ->issue==1)
<button type="submit" style="float: right;" class="btn btn-success btn-xs" name="button" value="resolved">Resolved</button>
@endif

</th></tr>
<tr><td><strong>Company Name</strong></td><td>{{ $orderinfo ->BillingCompanyName}}</td><td>{{ $orderinfo ->ShippingCompanyName}}</td></tr>
<tr><td><strong>First Name</strong></td><td>{{ $orderinfo ->BillingFirstName}}</td><td>{{ $orderinfo ->ShippingFirstName}}</td></tr>
<tr><td><strong>Last Name</strong></td><td>{{ $orderinfo ->BillingLastName}}</td><td>{{ $orderinfo ->ShippingLastName}}</td></tr>
<tr><td><strong>Address1</strong></td><td>{{ $orderinfo ->BillingAddress1}}</td><td>{{ $orderinfo ->ShippingAddress1}}</td></tr>
<tr><td><strong>Address2</strong></td><td>{{ $orderinfo ->BillingAddress2}}</td><td>{{ $orderinfo ->ShippingAddress2}}</td></tr>
<tr><td><strong>City</strong></td><td>{{ $orderinfo ->BillingCity}}</td><td>{{ $orderinfo ->ShippingCity}}</td></tr>
<tr><td><strong>State</strong></td><td>{{ $orderinfo ->BillingState}}</td><td>{{ $orderinfo ->ShippingState}}</td></tr>
<tr><td><strong>PostalCode</strong></td><td>{{ $orderinfo ->BillingPostalCode}}</td><td>{{ $orderinfo ->ShippingPostalCode}}</td></tr>
<tr><td><strong>Country</strong></td><td>{{ $orderinfo ->BillingCountry}}</td><td>{{ $orderinfo ->ShippingCountry}}</td></tr>
<tr><td><b>Fax Number</b></td><td>{{ $orderinfo ->BillingFaxNumber}}</td><td>{{ $orderinfo ->ShippingFaxNumber}}</td></tr>
<tr><td><b>Phone Number</b></td><td>{{ $orderinfo ->BillingPhoneNumber}}</td><td>{{ $orderinfo ->ShippingPhoneNumber}}</td></tr>
</table>

<br />
<table class="table table-condensed">
<tr><td width="175"><strong>Shipping Method:</strong></td><td><strong>{{$orderinfo -> ShippingMethod}} </strong></td></tr>
</table>

<br />

<table class="table table-condensed">
<tr><td width="175"><strong>Public Notes:</strong></td><td><strong>{{$orderinfo->OrderComments}} </strong></td></tr>
</table>

<br />

<table class="table table-condensed">
<tr><td width="175"><strong>Private Notes:</strong></td><td><strong>{{$orderinfo->OrderNotes}} </strong></td></tr>
</table>

<br />

<table class="table table-condensed">
<tr><th>Code</th><th>Description</th><th>Quantity</th><th>Price</th><th>Options</th></tr>

<input type="hidden" name="_token" value="{{ csrf_token() }}">

                        @foreach ( $orderdetails as $orderdet)

<tr><td>{{ $orderdet ->ProductCode}}</td><td>{{ $orderdet ->ProductName}}</td><td>{{ $orderdet ->Quantity}}</td><td>{{ $orderdet ->TotalPrice}}</td><td>{{ $orderdet ->Options}}</td>
<td>
 <select name="{{ $orderdet ->ProductCode}}">

@foreach ($inventory as $inv)
@if(str_is($inv -> ProductCode,$orderdet -> ProductCode))
    <option value="Inventory">Inventory | {{$inv -> Stock}}</option>
@endif
@endforeach

@foreach ($vendorrules as $vendor)

@if(str_is($vendor -> ProductCode,$orderdet -> ProductCode))
    <option value="{{$vendor -> VendorName}}"><strong>{{$vendor -> IsPrimary}}</strong> {{$vendor -> VendorName}} | ${{$vendor -> Cost}}</option>
@endif
@endforeach

  </select>
</tr>

                        @endforeach
</table>
@if($po == 0) 
<div class=text-right>
<button type="submit" class="btn btn-primary">Generate POs</button>
</div>
@endif

@if($po == 1)
<div class=text-right>

<button type="submit" class="btn btn-primary" name="button" value="view">View POs</button>
<br><br>
<button type="submit" class="btn btn-danger" name="button" value="regenerate">Regenerate POs<br>(Warning Purges Old POs!)</button>
</div>
@endif

</form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

