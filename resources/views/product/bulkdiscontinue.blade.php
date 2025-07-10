@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Bulk Discontinue</div>
		<div class="panel-body">

                        <form method="POST" action="/product/bulkdiscontinue">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <input type="file" name="FileName"/ placeholder="File Name"><br>
                        <button type="submit" class="btn btn-primary btn-xs">Upload</button>
                        </form>

		</div>
            </div>
        </div>
    </div>
</div>
@endsection

