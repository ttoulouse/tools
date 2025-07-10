@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">PO Lookup</div>

                <div class="panel-body">

			<form method="POST" action="/po/find/search">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">

			<input type="text" name="PONum"/ placeholder="PO Number">
			<button type="submit" class="btn btn-primary">Search</button>
			</form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

