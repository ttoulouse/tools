@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit User</h1>

    <!-- Display validation errors, if any -->
    @if ($errors->any())
      <div class="alert alert-danger">
          <ul>
          @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
          @endforeach
          </ul>
      </div>
    @endif

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
      {{ csrf_field() }}
      {{ method_field('PUT') }}

      <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" name="name" id="name" value="{{ $user->name }}" required>
      </div>

      <div class="form-group">
        <label for="email">Email address</label>
        <input type="email" class="form-control" name="email" id="email" value="{{ $user->email }}" required>
      </div>

      <div class="form-group">
        <label for="password">Password (leave blank if not changing)</label>
        <input type="password" class="form-control" name="password" id="password">
      </div>

      <div class="form-group">
        <label for="password_confirmation">Confirm Password</label>
        <input type="password" class="form-control" name="password_confirmation" id="password_confirmation">
      </div>

      <!-- Only show the admin option if the current user is a super admin -->
      @if(Auth::user()->is_super_admin)
          <div class="form-group">
              <label for="is_admin">
                  <input type="checkbox" name="is_admin" id="is_admin" value="1" {{ $user->is_admin ? 'checked' : '' }}>
                  Make this user an admin
              </label>
          </div>
      @endif
 <a href="{{ route('admin.users.index') }}" class="btn btn-default" style="margin-right: 10px;">
        <span class="glyphicon glyphicon-arrow-left"></span> Back
    </a>
      <button type="submit" class="btn btn-primary">Update User</button>
    </form>
</div>
@endsection

