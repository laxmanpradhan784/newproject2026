@extends('admin.layouts.app')
@section('content')

<h3>All Users</h3>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered table-striped">
<tr>
<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Phone</th>
<th>Registered</th>
<th>Action</th>
</tr>

@foreach($users as $u)
<tr>
<td>{{ $u->id }}</td>
<td>{{ $u->name }}</td>
<td>{{ $u->email }}</td>
<td>{{ $u->phone }}</td>
<td>{{ $u->created_at->format('d M Y') }}</td>
<td>
<a href="{{ route('admin.users.delete',$u->id) }}" class="btn btn-danger btn-sm"
   onclick="return confirm('Delete this user?')">
   Delete
</a>
</td>
</tr>
@endforeach

</table>

@endsection
