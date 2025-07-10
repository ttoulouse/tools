@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Create New Vendor Rule</div>

			<form method="POST" action="/vendor/createvendor"><br>
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<table class="table"><tr>
			<td>Vendor Name:</td><td><input type="text" name="VendorName"></td></tr><tr>
			<td>Email:</td><td><input type="text" name="Email"></td></tr><tr>
			<td>CCEmail:</td><td><input type="text" name="CCEmail"></td></tr><tr>
			<td>Address1:</td><td><input type="text" name="Address1"></td></tr><tr>
			<td>Address2:</td><td><input type="text" name="Address2"></td></tr><tr>
			<td>City:</td><td><input type="text" name="City"></td></tr><tr>
			<td>State:</td><td><input type="text" name="State"></td></tr><tr>
			<td>PostalCode:</td><td><input type="text" name="PostalCode"></td></tr><tr>
			<td>Country:</td><td><input type="text" name="Country"></td></tr><tr>
			<td>FaxNumber:</td><td><input type="text" name="FaxNumber"></td></tr><tr>
			<td>PhoneNumber:</td><td><input type="text" name="PhoneNumber"></td></tr><tr>
			<td>AccountNum:</td><td><input type="text" name="AccountNum"></td></tr><tr>
			<td></td><td><button type="submit" class="btn btn-primary">Save</button></td></tr>
			</table>

                <div class="panel-body">

                </div>
            </div>
        </div>
    </div>
</div>
@endsection


