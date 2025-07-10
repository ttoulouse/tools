@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Stock Update</div>

                <div class="panel-body">


                        <form method="POST" action="/stock/update/change" class="form-inline">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="form-group">
			<input type="text" class="form-control" name="ProductCode" id="ProdcutCode" placeholder="Prodcut Code">
			</div>
			<div class="form-group">
			<input type="text" class="form-control" name="StockChange" id="StockChange" placeholder="Stock Change">
			</div>
			<button type="submit" class="btn btn-primary">Update Stock</button>
			</form>
			@php
				if(isset($inventory)) {
					echo('<br><strong>Stock Updated!</strong> '.$inventory[0]->ProductCode.' now has '.$inventory[0]->Stock.' in stock');
				}
			@endphp
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

