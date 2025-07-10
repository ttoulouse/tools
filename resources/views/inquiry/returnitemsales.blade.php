@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><a href="{{ url('/') }}/inquiry/find/item"><-Item Lookup</a></div>
		<div class="panel-body">
                        <table class="table">
                        <tr><th>Order ID</th><th>Product Code</th><th>Quantity</th><th>Created Date</th></tr>
                        @foreach ( $orderdetails as $order)
                                <tr>
                                <td>{{ $order -> OrderID}}</a></td>
                                <td>{{ $order -> ProductCode}}</td>
                                <td>{{ $order -> Quantity}}</td>
                                <td>{{ $order -> CreatedDate}}</td>
                                </tr>
                        @endforeach
                        </table>
		</div>
            </div>
        </div>
    </div>
</div>
@endsection

