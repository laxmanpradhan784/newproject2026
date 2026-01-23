@extends('admin.layouts.app')
@section('content')

<h3>Home Page Sliders</h3>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<!-- ADD SLIDER -->
<form method="POST" action="{{ route('admin.sliders.store') }}" enctype="multipart/form-data">
@csrf
<div class="row mb-3">
    <div class="col"><input name="title" placeholder="Title" class="form-control"></div>
    <div class="col"><input name="subtitle" placeholder="Subtitle" class="form-control"></div>
    <div class="col"><input type="file" name="image" class="form-control"></div>
    <div class="col"><input name="button_text" placeholder="Button Text" class="form-control"></div>
    <div class="col"><input name="button_link" placeholder="Button Link" class="form-control"></div>
    <div class="col">
        <select name="status" class="form-control">
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
        </select>
    </div>
    <div class="col"><button class="btn btn-success">Add</button></div>
</div>
</form>

<!-- SLIDERS LIST -->
<table class="table table-bordered">
<tr>
<th>Image</th><th>Title</th><th>Subtitle</th><th>Button</th><th>Status</th><th>Action</th>
</tr>

@foreach($sliders as $s)
<form method="POST" action="{{ route('admin.sliders.update') }}" enctype="multipart/form-data">
@csrf
<input type="hidden" name="id" value="{{ $s->id }}">

<tr>
<td>
<img src="{{ asset('uploads/sliders/'.$s->image) }}" width="80">
<input type="file" name="image" class="form-control mt-1">
</td>

<td><input name="title" value="{{ $s->title }}" class="form-control"></td>
<td><input name="subtitle" value="{{ $s->subtitle }}" class="form-control"></td>
<td>
<input name="button_text" value="{{ $s->button_text }}" class="form-control">
<input name="button_link" value="{{ $s->button_link }}" class="form-control mt-1">
</td>
<td>
<select name="status" class="form-control">
<option value="active" {{ $s->status=='active'?'selected':'' }}>Active</option>
<option value="inactive" {{ $s->status=='inactive'?'selected':'' }}>Inactive</option>
</select>
</td>
<td>
<button class="btn btn-primary btn-sm">Update</button>
<a href="{{ route('admin.sliders.delete',$s->id) }}" class="btn btn-danger btn-sm">Delete</a>
</td>
</tr>
</form>
@endforeach
</table>

@endsection
