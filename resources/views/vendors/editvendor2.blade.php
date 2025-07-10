@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Create New Vendor Rule</div>
									    
			<form method="POST" action="/vendor/savevendor/{{$vendordb[0]->VendorName}}"><br>
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<table class="table"><tr>
			<td>Vendor Name:</td><td><input type="text" name="VendorName" value="{{$vendordb[0]->VendorName}}"></td></tr><tr>
			<td>Email:</td><td><input type="text" name="Email" value="{{$vendordb[0]->Email}}"></td></tr><tr>
			<td>CCEmail:</td><td><input type="text" name="CCEmail" value="{{$vendordb[0]->CCEmail}}"></td></tr><tr>
			<td>Address1:</td><td><input type="text" name="Address1" value="{{$vendordb[0]->Address1}}"></td></tr><tr>
			<td>Address2:</td><td><input type="text" name="Address2" value="{{$vendordb[0]->Address2}}"></td></tr><tr>
			<td>City:</td><td><input type="text" name="City" value="{{$vendordb[0]->City}}"></td></tr><tr>
			<td>State:</td><td><input type="text" name="State" value="{{$vendordb[0]->State}}"></td></tr><tr>
			<td>PostalCode:</td><td><input type="text" name="PostalCode" value="{{$vendordb[0]->PostalCode}}"></td></tr><tr>
			<td>Country:</td><td><input type="text" name="Country" value="{{$vendordb[0]->Country}}"></td></tr><tr>
			<td>FaxNumber:</td><td><input type="text" name="FaxNumber" value="{{$vendordb[0]->FaxNumber}}"></td></tr><tr>
			<td>PhoneNumber:</td><td><input type="text" name="PhoneNumber" value="{{$vendordb[0]->PhoneNumber}}"></td></tr><tr>
			<td>AccountNum:</td><td><input type="text" name="AccountNum" value="{{$vendordb[0]->AccountNum}}"></td></tr><tr>
			<td>Comments:</td><td><textarea name="Comments" rows="4" cols="50">{{$vendordb[0]->Comments}}</textarea></td></tr><tr>
			<td></td><td><button type="submit" class="btn btn-primary" name="button" value="update">Save</button></td></tr>
			</table>

                <div class="panel-body">

                </div>
            </div>
        </div>
    </div>
</div>
@endsection


