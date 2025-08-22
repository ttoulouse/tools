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
                        <tr>
                            <th><a href="{{ url('/') }}/product/vendor/{{$vendor}}?sort=ProductCode&direction={{ ($sort == 'ProductCode' && $direction == 'asc') ? 'desc' : 'asc' }}">Product Code</a></th>
                            <th><a href="{{ url('/') }}/product/vendor/{{$vendor}}?sort=VendorProductCode&direction={{ ($sort == 'VendorProductCode' && $direction == 'asc') ? 'desc' : 'asc' }}">Vendor Product Code</a></th>
                            <th><a href="{{ url('/') }}/product/vendor/{{$vendor}}?sort=ProductName&direction={{ ($sort == 'ProductName' && $direction == 'asc') ? 'desc' : 'asc' }}">Product Name</a></th>
                            <th><a href="{{ url('/') }}/product/vendor/{{$vendor}}?sort=Cost&direction={{ ($sort == 'Cost' && $direction == 'asc') ? 'desc' : 'asc' }}">Cost</a></th>
                            <th><a href="{{ url('/') }}/product/vendor/{{$vendor}}?sort=ProductPrice&direction={{ ($sort == 'ProductPrice' && $direction == 'asc') ? 'desc' : 'asc' }}">Price</a></th>
                            <th><a href="{{ url('/') }}/product/vendor/{{$vendor}}?sort=msrp&direction={{ ($sort == 'msrp' && $direction == 'asc') ? 'desc' : 'asc' }}">MSRP</a></th>
                            <th><a href="{{ url('/') }}/product/vendor/{{$vendor}}?sort=lastupdate&direction={{ ($sort == 'lastupdate' && $direction == 'asc') ? 'desc' : 'asc' }}">Last Updated</a></th>
                        </tr>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="sort" value="{{ $sort }}">
                        <input type="hidden" name="direction" value="{{ $direction }}">
                        
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

