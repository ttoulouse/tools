@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Stock Lookup</div>

                <div class="panel-body">

			<form method="POST" action="/stock/find/search">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">

			<input type="text" name="ProductCode"/ placeholder="Product Code">
			<button type="submit" class="btn btn-primary">Search</button>
			</form>
			@php
				if($exists == 1) {
					echo('<table class="table"><tr><th>Product</th><th>Stock</th></tr><tr><td>'.$inventory[0]->ProductCode.'</td><td>'.$inventory[0]->Stock.'</td></tr></table>');
				}
				else {
					echo('<table class="table"><tr><th>Product</th><th>Stock</th></tr><tr><td>Product not found!</td></tr></table>');
				}
			@endphp
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

