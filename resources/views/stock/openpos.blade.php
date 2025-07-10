@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Open POs</div>

                <div class="panel-body">
                        <table class="table">
                        <tr><th>PO #</th><th>Vendor</th></tr>
                        @foreach ( $podetails as $order)
                        <tr>
						@php
							echo('<td><a href="'.url('/').'/stock/'.$order -> PONum.'">'.$order -> PONum.'</a></td><td>'.$order->Vendor.'</td></tr>');                     	
        				@endphp
                        @endforeach

                        </table>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

