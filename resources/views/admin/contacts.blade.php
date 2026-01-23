@extends('admin.layouts.app')
@section('content')

<h3>Contact Messages</h3>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered table-striped">
<tr>
<th>Name</th>
<th>Email</th>
<th>Subject</th>
<th>Message</th>
<th>Date</th>
<th>Action</th>
</tr>

@foreach($contacts as $c)
<tr>
<td>{{ $c->name }}</td>
<td>{{ $c->email }}</td>
<td>{{ $c->subject }}</td>
<td style="max-width:300px">{{ $c->message }}</td>
<td>{{ $c->created_at->format('d M Y') }}</td>
<td>
<a href="{{ route('admin.contacts.delete',$c->id) }}" class="btn btn-danger btn-sm"
   onclick="return confirm('Delete this message?')">
   Delete
</a>
</td>
</tr>
@endforeach

</table>

@endsection
