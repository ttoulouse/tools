@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><a href="{{ url('/') }}/inquiry/find/item"><-Item Lookup</a></div>
		<div class="panel-body">
                        <table class="table">
                        <tr><th>Product Code</th><th>Product Name</th><th>Price</th><th>Cost*</th><th>Stock</th></tr><tr><td><h3>Vendor Rules</h3></td></tr>
                        @foreach ( $vendorrules as $item)
                                <tr>
                                <td><a href="{{ url('/') }}/inquiry/find/item/{{ $item -> ProductCode }}">{{ $item -> ProductCode }}</a></td>
                                <td>{{ $item -> ProductName}}</td>
                                <td>{{ $item -> ProductPrice}}</td>
                                <td>{{ $item -> Cost}}</td>
                                <td>{{ $item -> stock}}</td>
                                </tr>
                        @endforeach
                        <tr><td><h3>Inventory</h3></td></tr>
                        @foreach ( $inventory as $item)
                                <tr>
                                <td>{{ $item -> ProductCode }}</a></td>
                                <td>{{ $item -> ProductName}}</td>
                                <td>{{ $item -> ProductPrice}}</td>
                                <td>{{ $item -> UnitCost}}</td>
                                <td>{{ $item -> stock}}</td>
                                </tr>
                        @endforeach
                        </table>
		</div>
            </div>
        </div>
    </div>
</div>
@endsection

