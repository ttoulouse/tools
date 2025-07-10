@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Missing Orders</div>

                <div class="panel-body">

					<table class="table">
					<tr><th>Order ID</th><th>Order Status</th><th>Order Date</th></tr>
					@php $count=0; @endphp 
					@foreach ( $xml->Table as $order)
								@php
								if($orderexists[$count]==0) {
									echo('<tr><td><a href="'.url('/').'/orders/'.$order->OrderID.'"><font color="RED">'.$order->OrderID.'</font></a></td>
										 <td>'.$order->OrderStatus.'</td>
										 <td>'.$order->OrderDate.'</td></tr>'
									);
								}
								$count=$count+1;
								@endphp
					@endforeach
					</table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

