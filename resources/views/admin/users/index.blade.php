@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Users</h1>

    <!-- Display success messages -->
    @if(session('success'))
      <div class="alert alert-success">
          {{ session('success') }}
      </div>
    @endif

    <!-- Link to create a new user -->
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">Create New User</a>

    <table class="table table-striped mt-3">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
      @foreach($users as $user)
        <tr>
          <td>{{ $user->id }}</td>
          <td>{{ $user->name }}</td>
          <td>{{ $user->email }}</td>
          <td>
              <!-- Edit Button -->
              <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning">Edit</a>

              <!-- Delete Button -->
              @if($user->is_admin && !Auth::user()->is_super_admin)
                  <button class="btn btn-danger" disabled title="Only super admins can delete admin accounts">Delete</button>
              @else
                  <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline;">
                      {{ csrf_field() }}
                      {{ method_field('DELETE') }}
                      <button type="submit" class="btn btn-danger" 
                          onclick="return confirm('Are you sure you want to delete this user?');">
                          Delete
                      </button>
                  </form>
              @endif
          </td>
        </tr>
      @endforeach
      </tbody>
    </table>
</div>
@endsection

