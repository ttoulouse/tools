@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{$id}}</div>
		<div class="panel-body">
                        <table class="table">
                        <tr><th>Product Name</th><th>Vendor Name</th><th>Vendor Product Code</th><th>Cost</th><th>Is Primary?</th></tr>
                        @foreach ( $items as $item)
                                <tr>
                                <td>{{ $item -> ProductName}}</td>
                                <td>{{ $item -> VendorName}}</td>
                                <td>{{ $item -> VendorProductCode}}</td>
                                <td>{{ $item -> Cost}}</td>
                                <td>{{ $item -> IsPrimary}}</td>
                                </tr>
                        @endforeach
                        </table>
		</div>
            </div>
        </div>
    </div>
</div>
@endsection

