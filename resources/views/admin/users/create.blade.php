@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create New User</h1>

    <!-- Display validation errors -->
    @if ($errors->any())
      <div class="alert alert-danger">
          <ul>
          @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
          @endforeach
          </ul>
      </div>
    @endif

    <form action="{{ route('admin.users.store') }}" method="POST">
      {{ csrf_field() }}
      
      <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" name="name" id="name" placeholder="Enter name" required>
      </div>

      <div class="form-group">
        <label for="email">Email address</label>
        <input type="email" class="form-control" name="email" id="email" placeholder="Enter email" required>
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
      </div>

      <div class="form-group">
        <label for="password_confirmation">Confirm Password</label>
        <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password" required>
      </div>

      @if(Auth::user()->is_super_admin)
          <div class="form-group">
              <label for="is_admin">
                  <input type="checkbox" name="is_admin" id="is_admin" value="1">
                  Make this user an admin
              </label>
          </div>
      @endif

 <a href="{{ route('admin.users.index') }}" class="btn btn-default" style="margin-right: 10px;">
        <span class="glyphicon glyphicon-arrow-left"></span> Back
    </a>

      <button type="submit" class="btn btn-primary">Create User</button>
    </form>
</div>
@endsection

