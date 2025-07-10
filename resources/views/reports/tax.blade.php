@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Sales Tax Report</div>

                <div class="panel-body">
					@php $totaltax=0; @endphp
					<table class="table">
					<tr><th>Order ID</th><th>Order Status</th><th>Total</th><th>Payment Amount</th><th>Payment Date</th><th>Sales Tax</th></tr>
					@foreach ( $taxreport as $order)
						<tr>
							<td><a href="{{ url('/') }}/orders/{{$order->OrderID}}">{{$order->OrderID}}</a></td>
							<td>{{$order->OrderStatus}}</td>
							<td>{{$order->paymentamount}}</td>
							<td>{{$order->Pay_Amount}}</td>
							<td>{{$order->Pay_AuthDate}}</td>
							<td>@php 
							echo number_format((float)$order->salestax1+(float)$order->salestax3, 2, '.', '');@endphp</td>
						</tr>
						@php $totaltax=(float)$totaltax+(float)$order->salestax1+(float)$order->salestax3; @endphp
					@endforeach
						<tr><td></td><td></td><td></td><td></td><td></td><td><b>{{$totaltax}}</b></td></tr>
					</table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

