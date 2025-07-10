@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><a href="{{ url('/') }}/vendor/findvendor"><-Vendor Lookup</a></div>
		<div class="panel-body">
                        <table class="table">
                        <tr><th>Name</th><th>Email</th><th>Phone Number</th><th>Fax Number</th></tr>
                        @foreach ( $vendors as $vendor)
                                <tr>
                                <td>
                                
                                @php
                                    if($vendortag == 'vendor') {
                                        echo('<a href="'.url('/').'/vendor/editvendor/'.$vendor -> VendorName.'">'.$vendor -> VendorName.'</a>');
                                    }
                                    
                                    else {
                                        echo('<a href="'.url('/').'/vendor/createrule/'.$vendor -> VendorName.'">'.$vendor -> VendorName.'</a>');
                                    }
                                @endphp
                                </td>
                                <td>{{ $vendor -> Email}}</td>
                                <td>{{ $vendor -> PhoneNumber}}</td>
                                <td>{{ $vendor -> FaxNumber}}</td></tr>
                                </tr>
                        @endforeach
                        </table>
		</div>
            </div>
        </div>
    </div>
</div>
@endsection

