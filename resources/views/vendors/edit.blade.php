@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Edit Vendor Rule</div>

			<form method="POST" action="/vendor/editrule"><br>
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<input type="hidden" name="OldProductCode" value="{{$vendor[0]->ProductCode}}">
			<input type="hidden" name="OldVendorName" value="{{$vendor[0]->VendorName}}">
			<table class="table"><tr>
			<td>Product Code:</td><td><input type="text" name="ProductCode" value="{{$vendor[0]->ProductCode}}"></td></tr><tr>
			<td>Product Name:</td><td><input type="text" name="ProductName" value="{{$vendor[0]->ProductName}}"></td></tr><tr>
			<td>Vendor Name:</td><td><input type="text" name="VendorName" value="{{$vendor[0]->VendorName}}"> <input type="checkbox" name="IsPrimary">Primary</td></tr><tr>
			<td>Vendor Product Code:</td><td><input type="text" name="VendorProductCode" value="{{$vendor[0]->VendorProductCode}}"></td></tr><tr>
			<td>Cost:</td><td><input type="text" name="Cost" value={{$vendor[0]->Cost}}></td></tr><tr>
			<td></td><td><button type="submit" class="btn btn-primary">Save</button></td></tr>
			</table>

                <div class="panel-body">

                </div>
            </div>
        </div>
    </div>
</div>
@endsection


