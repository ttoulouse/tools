@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Create New Vendor Rule</div>

			<form method="POST" action="/vendor/createrule"><br>
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<table class="table"><tr>
			<td>Product Code:</td><td><input type="text" name="ProductCode"></td></tr><tr>
			<td>Vendor Name:</td><td><input type="text" name="VendorName" value="{{$vendor}}"> <input type="checkbox" name="IsPrimary">Primary</td></tr><tr>
			<td>Vendor Product Code:</td><td><input type="text" name="VendorProductCode"></td></tr><tr>
			<td>Product Name:</td><td><input type="text" name="ProductName"></td></tr><tr>
			<td>Cost:</td><td><input type="text" name="Cost"></td></tr><tr>
			<td></td><td><button type="submit" class="btn btn-primary">Save</button></td></tr>
			</table>

                <div class="panel-body">

                </div>
            </div>
        </div>
    </div>
</div>
@endsection


