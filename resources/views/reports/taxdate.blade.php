@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Sales Tax Report</div>
		<div class="panel-body">

                        <form method="POST" action="/reports/tax">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
						Start Date:<input type="date" name="startdate"> End Date:<input type="date" name="enddate">
                        <button type="submit" class="btn btn-primary">Search</button>
                        </form>

		</div>
            </div>
        </div>
    </div>
</div>
@endsection
