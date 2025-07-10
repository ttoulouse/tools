@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><a href="{{ url('/') }}/inquiry/find/vendor"><-Vendor Lookup</a></div>
		<div class="panel-body">
                        <table class="table">
                        <tr><th>Vendor</th><th>PO Number</th><th>Date</th></tr>
                        @foreach ( $vendors as $vendor)
                                <tr>
                                <td>{{ $vendor -> Vendor}}</td>
                                <td><a href="{{url('/')}}/po/find/search/{{ $vendor -> PONum}}">{{ $vendor -> PONum}}</a></td>
                                <td>{{ $vendor -> CreatedDate}}</td>
                                </tr>
                        @endforeach
                        </table>
		</div>
            </div>
        </div>
    </div>
</div>
@endsection

