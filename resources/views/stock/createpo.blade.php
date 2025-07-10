@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><a href="{{ url('/') }}/orders"><- Back to All Orders</a></div>

                <div class="panel-body">


</table><br><b>Vendor: </b>{{$vendor[0]->VendorName}}
<form method="POST" action="{{ url('/') }}/stock/createpo">
<input type="hidden" name="_token" value="{{ csrf_token() }}">
<input type="hidden" name="Vendor" value="{{ $vendor[0]->VendorName }}">

<div class=text-right>
<button type="submit" name="button" value="save" class="btn btn-primary btn-xs">Save</button>
</div>

<table class="table table-condensed">
<tr><th></th><th>Billing</th><th>Shipping</th></tr>
<tr><td><strong>Company Name</strong></td><td><input type="text" name="BillingCompanyName" value="FactoryExpress"/></td><td><input type="text" name="ShippingCompanyName" value="FactoryExpress"/></td></tr>
<tr><td><strong>First Name</strong></td><td><input type="text" name="BillingFirstName" value="Accounts"/></td><td><input type="text" name="ShippingFirstName" value="Accounts"/></td></tr>
<tr><td><strong>Last Name</strong></td><td><input type="text" name="BillingLastName" value="Payable"/></td><td><input type="text" name="ShippingLastName" value="Payable"/></td></tr>
<tr><td><strong>Address1</strong></td><td><input type="text" name="BillingAddress" value="8201 E Pacific Pl, Ste 603-604"/></td><td><input type="text" name="ShippingAddress" value="8201 E Pacific Pl, Ste 603-604"/></td></tr>
<tr><td><strong>City</strong></td><td><input type="text" name="BillingCity" value="Denver"/></td><td><input type="text" name="ShippingCity" value="Denver"/></td></tr>
<tr><td><strong>State</strong></td><td><input type="text" name="BillingState" value="Colorado"/></td><td><input type="text" name="ShippingState" value="Colorado"/></td></tr>
<tr><td><strong>PostalCode</strong></td><td><input type="text" name="BillingPostalCode" value="80231"/></td><td><input type="text" name="ShippingPostalCode" value="80231"/></td></tr>
<tr><td><strong>Country</strong></td><td><input type="text" name="BillingCountry" value="USA"/></td><td><input type="text" name="ShippingCountry" value="USA"/></td></tr>
<tr><td><b>Phone Number</b></td><td><input type="text" name="BillingPhoneNumber" value="505-247-3232"/></td><td><input type="text" name="ShippingPhoneNumber" value="505-247-3232"/></td></tr>
</table>
<table class="table table-condensed">
<tr><td><strong>Shipping Method:</strong></td>
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
<tr><th>Product Code</th><th>Quantity</th><th>Options</th></tr>
<tr><td><input type="text" name="ProductCode"></td><td><input type="texts" name="Quantity" size="4"></td><td><input type="text" name="Options"></td></tr>
<tr><td><button type="submit" class="btn btn-primary btn-xs" value="add">Add Product</button></td><tr>
</form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

