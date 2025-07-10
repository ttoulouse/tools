@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Open POs</div>

                <div class="panel-body">
                    <table class="table">
                        <tr>
                            <th>PO #&nbsp</th>
                            <th>Created Date</th>
                            <th>Vendor</th>
                        </tr>
                        @php $lastpo = 0; @endphp
                        @foreach ($podetails as $order)
                            @if ($order->archived != 1 && $order->PONum != $lastpo)
                                <tr>
                                    <td><a href="{{ url('/po/find/search/' . $order->PONum) }}">{{ $order->PONum }}</a></td>
                                    <td>{{ $order->CreatedDate }}</td>
                                    <td>{{ $order->Vendor }}</td>
                                    @if ($order->PaymentMethod == 'Net30')
                                        <td>Net30</td>
                                    @endif
                                </tr>
                                @php $lastpo = $order->PONum; @endphp
                            @endif
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

