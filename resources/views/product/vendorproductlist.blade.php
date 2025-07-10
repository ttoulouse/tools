@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <form method="POST" action="{{ url('/') }}/product/vendor/update/{{$vendor}}">
                <div class="panel-heading"><a href="{{ url('/') }}/product/findvendor"><-Vendor Lookup</a>
                    <button type="submit" class="btn btn-primary btn-xs" name="button" style="float: right;" value="update">Save</button>
                    <button type="submit" class="btn btn-primary btn-xs" name="button" style="float: right;" value="active">Active</button>
                </div>
		<div class="panel-body">
                        <table class="table">
                        <tr><th>Product Code</th><th>Vendor Product Code</th><th>Product Name</th><th>Cost</th><th>Price</th><th>MSRP</th><th>Last Updated</th></tr>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        
                        @foreach ( $products as $product)
                            <input type="hidden" name="productcode[]" value="{{$product->ProductCode}}">
                            <input type="hidden" name="oldprice[]" value="{{$product->ProductPrice}}">
                            <input type="hidden" name="oldcost[]" value="{{$product->Cost}}">
                            <input type="hidden" name="oldmsrp[]" value="{{$product->msrp}}">

                                <tr>
				@php
					if(($product->Cost/0.9)< $product->ProductPrice) {
						echo('<div style="color:red">');
					}
					else {
						echo('<div style="color"black">');
					}
				@endphp
                                <td>{{$product->ProductCode}}</td>
                                <td>{{$product->VendorProductCode}}</td>
                                <td>{{$product->ProductName}}</td>
                                <td><input type="text" name="cost[]" size="4" value="{{$product->Cost}}" /></td>
                                <td><input type="text" name="price[]" size=4" value="{{$product->ProductPrice}}" /></td>
                                <td><input type="text" name="msrp[]" size=4" value="{{$product->msrp}}"/></td>
                                <td>{{$product->lastupdate}}</td></div>
                                </tr>
                                </tr>
                        @endforeach
                        </table>
                        </form>
		</div>
            </div>
        </div>
    </div>
</div>
@endsection

