@extends('admin.layouts.app')
@section('content')

<h3>Products</h3>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<!-- ADD PRODUCT -->
<form method="POST" action="{{ route('admin.products.store') }}">
@csrf
<div class="row">
    <div class="col">
        <input name="name" placeholder="Product Name" class="form-control">
    </div>
    <div class="col">
        <select name="category_id" class="form-control">
            @foreach($categories as $c)
            <option value="{{ $c->id }}">{{ $c->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col">
        <input name="price" placeholder="Price" class="form-control">
    </div>
    <div class="col">
        <input name="stock" placeholder="Stock" class="form-control">
    </div>
    <div class="col">
        <button class="btn btn-success">Add</button>
    </div>
</div>
</form>

<hr>

<!-- PRODUCTS TABLE -->
<table class="table table-bordered">
<tr>
<th>Name</th><th>Category</th><th>Price</th><th>Stock</th><th>Status</th><th>Action</th>
</tr>

@foreach($products as $p)
<form method="POST" action="{{ route('admin.products.update') }}">
@csrf
<input type="hidden" name="id" value="{{ $p->id }}">

<tr>
<td><input name="name" value="{{ $p->name }}" class="form-control"></td>
<td>
<select name="category_id" class="form-control">
@foreach($categories as $c)
<option value="{{ $c->id }}" {{ $p->category_id==$c->id?'selected':'' }}>
{{ $c->name }}
</option>
@endforeach
</select>
</td>
<td><input name="price" value="{{ $p->price }}" class="form-control"></td>
<td><input name="stock" value="{{ $p->stock }}" class="form-control"></td>
<td>
<select name="status" class="form-control">
<option value="active" {{ $p->status=='active'?'selected':'' }}>Active</option>
<option value="inactive" {{ $p->status=='inactive'?'selected':'' }}>Inactive</option>
</select>
</td>
<td>
<button class="btn btn-primary btn-sm">Update</button>
<a href="{{ route('admin.products.delete',$p->id) }}" class="btn btn-danger btn-sm">Delete</a>
</td>
</tr>
</form>
@endforeach
</table>

@endsection
