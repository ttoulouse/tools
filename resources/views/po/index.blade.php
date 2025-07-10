@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Orders without PO</div>

                <div class="panel-body">
			<table class="table">
			<tr><th>Order ID&nbsp</th><th>Billing First&nbsp</th><th>Billing Last</th></tr>
			@foreach ( $orders as $order)
				<tr>
				<td><a href="{{ url('/') }}/orders/{{ $order -> OrderID }}">{{ $order -> OrderID }}</a></td>
				<td>{{ $order -> BillingFirstName}}</td>
				<td>{{ $order -> BillingLastName}}</td>
				</tr>
			@endforeach
			</table>
		
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

