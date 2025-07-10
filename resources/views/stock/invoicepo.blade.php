@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><a href="{{ url('/') }}/orders"><- Back to All Orders</a></div>

                <div class="panel-body">


</table><br><b>Vendor: </b>{{$stockpoinfo[0]->Vendor}} <b>PO #: </b>{{$stockpoinfo[0]->PONum}}<br>
<form method="POST" action="{{ url('/') }}/stock/{{$stockpoinfo[0]->PONum}}">
<input type="hidden" name="_token" value="{{ csrf_token() }}">
<input type="hidden" name="Vendor" value="{{ $stockpoinfo[0]->Vendor }}">
<input type="hidden" name="PONum" value="{{ $stockpoinfo[0]->PONum }}">

<div class=text-right>
<button type="submit" name="button" value="save" class="btn btn-primary btn-xs">Save</button>

</div>

<table class="table table-sm">
<tr><th>Product Code</th><th>Product Name</th><th>Options</th><th>Quantity</th><th>Cost</th><th>Received</th><th>Received Date</th><th>Invoiced</th></tr>
@php $count=0 @endphp
@foreach ( $stockpodetails as $podet)
<tr><td>{{$podet->VendorProductCode}}</td><td>{{$podet->ProductName}}</td><td>{{$podet->Options}}</td><td>{{$podet->Quantity}}</td><td>{{$podet->Cost}}</td>
<td><input type="texts" name="Received{{$count}}" size="4" value="{{$podet->Recieved}}"></td><td><input type="date" name="Receiveddate{{$count}}" value="{{$podet->RecievedDate}}"></td>
<td><input type="texts" name="Invoiced{{$count}}" size="4" value="{{$podet->Invoiced}}"></td></tr>
@php $count = $count+1; @endphp
@endforeach
</table>
</form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

